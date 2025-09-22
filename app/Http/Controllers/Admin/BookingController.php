<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Room;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class BookingController extends Controller
{
    /**
     * Display a listing of bookings
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $query = Booking::with(['user', 'room', 'assignedRoom', 'payments']);
        
        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }
        
        if ($request->filled('date_from')) {
            $query->whereDate('check_in_date', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('check_in_date', '<=', $request->date_to);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%")
                              ->orWhere('email', 'like', "%{$search}%")
                              ->orWhere('phone', 'like', "%{$search}%");
                })
                ->orWhereHas('room', function($roomQuery) use ($search) {
                    $roomQuery->where('name', 'like', "%{$search}%");
                })
                ->orWhere('id', 'like', "%{$search}%");
            });
        }
        
        // Role-based filtering
        if ($user->role === 'client') {
            $query->whereHas('room', function($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        }
        
        $bookings = $query->latest()->paginate(25);
        
        // Get filter options
        $statuses = ['pending', 'confirmed', 'cancelled', 'completed'];
        $paymentStatuses = ['pending', 'advance', 'partial', 'full'];
        
        return view('admin.bookings.index', compact('bookings', 'statuses', 'paymentStatuses'));
    }

    /**
     * Show the form for creating a new booking
     */
    public function create()
    {
        // Get all available rooms
        $rooms = Room::where('is_available', true)->get();
        
        // Get all room types for filtering
        $roomTypes = Room::distinct()->pluck('room_type')->filter();
        
        return view('admin.bookings.create', compact('rooms', 'roomTypes'));
    }

    /**
     * Store a newly created booking
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:255',
            'room_id' => 'required|exists:rooms,id',
            'booking_type' => 'required|in:per_night,weekly,monthly',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'total_amount' => 'required|numeric|min:0.01',
            'payment_status' => 'required|in:pending,advance,partial,full',
            'advance_amount' => 'nullable|numeric|min:0',
            'nic_number' => [
                'required',
                'string',
                'max:15',
                'regex:/^[0-9]{5}-[0-9]{7}-[0-9]{1}$/'
            ],
            'nic_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'admin_notes' => 'nullable|string',
        ], [
            'nic_number.regex' => 'The NIC number must be in Pakistani format: XXXXX-XXXXXXX-X (5 digits, 7 digits, 1 digit)',
        ]);

        try {
            DB::beginTransaction();

            // Handle NIC image upload
            $nicImagePath = null;
            if ($request->hasFile('nic_image')) {
                $nicImage = $request->file('nic_image');
                $nicImageName = 'nic_' . time() . '_' . $nicImage->getClientOriginalName();
                
                // Create directory if it doesn't exist
                $uploadPath = public_path('uploads/nic_images');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }
                
                // Move file using move() function
                $nicImage->move($uploadPath, $nicImageName);
                $nicImagePath = 'uploads/nic_images/' . $nicImageName;
            }

            // Check if room is available for selected dates
            $conflictingBookings = Booking::where('room_id', $request->room_id)
                ->where('status', '!=', 'cancelled')
                ->where(function ($q) use ($request) {
                    $q->whereBetween('check_in_date', [$request->check_in_date, $request->check_out_date])
                      ->orWhereBetween('check_out_date', [$request->check_in_date, $request->check_out_date])
                      ->orWhere(function ($query) use ($request) {
                          $query->where('check_in_date', '<=', $request->check_in_date)
                                ->where('check_out_date', '>=', $request->check_out_date);
                      });
                })->exists();

            if ($conflictingBookings) {
                return back()->withErrors(['room_id' => 'Selected room is not available for the chosen dates.'])->withInput();
            }

            // Calculate number of nights
            $checkInDate = \Carbon\Carbon::parse($request->check_in_date);
            $checkOutDate = \Carbon\Carbon::parse($request->check_out_date);
            $numberOfNights = $checkInDate->diffInDays($checkOutDate);

            // Create or find user
            $user = User::firstOrCreate(
                ['email' => $request->customer_email],
                [
                    'name' => $request->customer_name,
                    'phone' => $request->customer_phone,
                    'role' => 'customer',
                    'password' => bcrypt(Str::random(10)), // Random password for walk-in customers
                ]
            );

            // Create booking with only guaranteed fields first
            $bookingData = [
                'user_id' => $user->id,
                'room_id' => $request->room_id,
                'check_in_date' => $request->check_in_date,
                'check_out_date' => $request->check_out_date,
                'number_of_nights' => $numberOfNights,
                'total_amount' => $request->total_amount,
                'status' => 'confirmed',
                'special_requests' => $request->admin_notes,
            ];

            // Add optional fields if they exist in the table
            if (Schema::hasColumn('bookings', 'customer_details')) {
                $bookingData['customer_details'] = [
                    'name' => $request->customer_name,
                    'email' => $request->customer_email,
                    'phone' => $request->customer_phone,
                ];
            }

            if (Schema::hasColumn('bookings', 'payment_status')) {
                $bookingData['payment_status'] = $request->payment_status;
            }

            if (Schema::hasColumn('bookings', 'admin_notes')) {
                $bookingData['admin_notes'] = $request->admin_notes;
            }

            if (Schema::hasColumn('bookings', 'booking_type')) {
                $bookingData['booking_type'] = $request->booking_type;
            }

            if (Schema::hasColumn('bookings', 'created_by')) {
                $bookingData['created_by'] = Auth::id();
            }

            if (Schema::hasColumn('bookings', 'nic_number')) {
                $bookingData['nic_number'] = $request->nic_number;
            }

            if (Schema::hasColumn('bookings', 'nic_image_path')) {
                $bookingData['nic_image_path'] = $nicImagePath;
            }

            $booking = Booking::create($bookingData);

            // Create payment record if advance amount is provided
            if ($request->filled('advance_amount') && $request->advance_amount > 0) {
                Payment::create([
                    'booking_id' => $booking->id,
                    'user_id' => Auth::id(), // Add the authenticated user's ID (hostel owner/admin)
                    'amount' => $request->advance_amount,
                    'payment_method' => 'cash',
                    'payment_type' => $request->payment_status,
                    'status' => 'completed',
                    'notes' => 'Advance payment for direct booking',
                ]);
            }

            DB::commit();

            return redirect()->route('admin.bookings.show', $booking)
                ->with('success', 'Booking created successfully! Customer can now check in.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to create booking: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified booking
     */
    public function show(Booking $booking)
    {
        $booking->load(['user', 'room', 'assignedRoom', 'payments']);
        
        // Get available rooms for reassignment if needed
        $availableRooms = $this->getAvailableRooms($booking);
        
        return view('admin.bookings.show', compact('booking', 'availableRooms'));
    }

    /**
     * Show the form for editing the specified booking
     */
    public function edit(Booking $booking)
    {
        $booking->load(['user', 'room', 'assignedRoom']);
        
        // Get all rooms for selection
        $rooms = Room::all();
        
        return view('admin.bookings.edit', compact('booking', 'rooms'));
    }

    /**
     * Update the specified booking
     */
    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'assigned_room_id' => 'required|exists:rooms,id',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
            'total_amount' => 'required|numeric|min:0.01',
            'status' => 'required|in:pending,confirmed,cancelled,completed',
            'admin_notes' => 'nullable|string',
        ]);

        // Check if the new room assignment conflicts with existing bookings
        if ($request->assigned_room_id != $booking->assigned_room_id) {
            $conflictingBookings = Booking::where('assigned_room_id', $request->assigned_room_id)
                ->where('id', '!=', $booking->id)
                ->where('status', '!=', 'cancelled')
                ->where(function ($query) use ($request) {
                    $query->whereBetween('check_in_date', [$request->check_in_date, $request->check_out_date])
                        ->orWhereBetween('check_out_date', [$request->check_in_date, $request->check_out_date])
                        ->orWhere(function ($q) use ($request) {
                            $q->where('check_in_date', '<=', $request->check_in_date)
                                ->where('check_out_date', '>=', $request->check_out_date);
                        });
                })->exists();

            if ($conflictingBookings) {
                return back()->withErrors(['assigned_room_id' => 'Selected room is not available for the specified dates.']);
            }
        }

        DB::beginTransaction();
        
        try {
            // Calculate number of nights
            $checkIn = Carbon::parse($request->check_in_date);
            $checkOut = Carbon::parse($request->check_out_date);
            $nights = $checkIn->diffInDays($checkOut);

            $booking->update([
                'assigned_room_id' => $request->assigned_room_id,
                'check_in_date' => $request->check_in_date,
                'check_out_date' => $request->check_out_date,
                'number_of_nights' => $nights,
                'total_amount' => $request->total_amount,
                'status' => $request->status,
                'admin_notes' => $request->admin_notes,
            ]);

            // Update outstanding balance
            $booking->calculateOutstandingBalance();
            
            DB::commit();

            return redirect()->route('admin.bookings.show', $booking)
                ->with('success', 'Booking updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to update booking. Please try again.']);
        }
    }

    /**
     * Update booking status
     */
    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed',
        ]);

        $booking->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Booking status updated successfully!'
        ]);
    }

    /**
     * Assign room to booking
     */
    public function assignRoom(Request $request, Booking $booking)
    {
        $request->validate([
            'assigned_room_id' => 'required|exists:rooms,id',
        ]);

        // Check room availability
        $conflictingBookings = Booking::where('assigned_room_id', $request->assigned_room_id)
            ->where('id', '!=', $booking->id)
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($booking) {
                $query->whereBetween('check_in_date', [$booking->check_in_date, $booking->check_out_date])
                    ->orWhereBetween('check_out_date', [$booking->check_in_date, $booking->check_out_date])
                    ->orWhere(function ($q) use ($booking) {
                        $q->where('check_in_date', '<=', $booking->check_in_date)
                            ->where('check_out_date', '>=', $booking->check_out_date);
                    });
            })->exists();

        if ($conflictingBookings) {
            return response()->json([
                'success' => false,
                'message' => 'Selected room is not available for the booking dates.'
            ], 422);
        }

        $booking->update(['assigned_room_id' => $request->assigned_room_id]);

        return response()->json([
            'success' => true,
            'message' => 'Room assigned successfully!'
        ]);
    }

    /**
     * Update admin notes
     */
    public function updateNotes(Request $request, Booking $booking)
    {
        $request->validate([
            'admin_notes' => 'required|string',
        ]);

        $booking->update(['admin_notes' => $request->admin_notes]);

        return response()->json([
            'success' => true,
            'message' => 'Notes updated successfully!'
        ]);
    }

    /**
     * Cancel booking
     */
    public function cancel(Request $request, Booking $booking)
    {
        $request->validate([
            'cancellation_reason' => 'required|string',
        ]);

        $booking->update([
            'status' => 'cancelled',
            'admin_notes' => ($booking->admin_notes ? $booking->admin_notes . "\n\n" : '') . 
                            "Cancelled: " . $request->cancellation_reason,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Booking cancelled successfully!'
        ]);
    }

    /**
     * Check room availability
     */
    public function checkAvailability(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
            'exclude_booking_id' => 'nullable|exists:bookings,id',
        ]);

        $room = Room::find($request->room_id);
        
        if (!$room) {
            return response()->json([
                'success' => false,
                'message' => 'Room not found.'
            ], 404);
        }

        // Check availability
        $query = Booking::where('assigned_room_id', $request->room_id)
            ->where('status', '!=', 'cancelled');

        if ($request->filled('exclude_booking_id')) {
            $query->where('id', '!=', $request->exclude_booking_id);
        }

        $conflictingBookings = $query->where(function ($query) use ($request) {
            $query->whereBetween('check_in_date', [$request->check_in_date, $request->check_out_date])
                ->orWhereBetween('check_out_date', [$request->check_in_date, $request->check_out_date])
                ->orWhere(function ($q) use ($request) {
                    $q->where('check_in_date', '<=', $request->check_in_date)
                        ->where('check_out_date', '>=', $request->check_out_date);
                });
        })->exists();

        $isAvailable = !$conflictingBookings;

        return response()->json([
            'success' => true,
            'is_available' => $isAvailable,
            'room' => [
                'id' => $room->id,
                'name' => $room->name,
                'price_per_night' => $room->price_per_night,
                'capacity' => $room->capacity,
                'room_type' => $room->room_type,
            ],
            'message' => $isAvailable ? 'Room is available for selected dates.' : 'Room is not available for selected dates.'
        ]);
    }

    /**
     * Generate booking report
     */
    public function report(Request $request)
    {
        $user = Auth::user();
        
        $query = Booking::with(['user', 'room', 'assignedRoom', 'payments']);
        
        // Apply filters
        if ($request->filled('date_from')) {
            $query->whereDate('check_in_date', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('check_in_date', '<=', $request->date_to);
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }
        
        if ($user->role === 'client') {
            $query->whereHas('room', function($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        }
        
        $bookings = $query->latest()->get();
        
        // Calculate totals
        $totalBookings = $bookings->count();
        $totalRevenue = $bookings->sum('total_amount');
        $totalOutstanding = $bookings->sum('outstanding_balance');
        $confirmedBookings = $bookings->where('status', 'confirmed')->count();
        $pendingBookings = $bookings->where('status', 'pending')->count();
        
        return view('admin.bookings.report', compact(
            'bookings', 'totalBookings', 'totalRevenue', 'totalOutstanding', 
            'confirmedBookings', 'pendingBookings'
        ));
    }

    /**
     * Export bookings to CSV
     */
    public function export(Request $request)
    {
        $user = Auth::user();
        
        $query = Booking::with(['user', 'room', 'assignedRoom']);
        
        if ($user->role === 'client') {
            $query->whereHas('room', function($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        }
        
        $bookings = $query->latest()->get();
        
        $filename = 'bookings_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($bookings) {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, [
                'ID', 'Customer', 'Room', 'Check In', 'Check Out', 'Nights', 
                'Total Amount', 'Outstanding', 'Status', 'Payment Status', 'Created Date'
            ]);
            
            // CSV data
            foreach ($bookings as $booking) {
                fputcsv($file, [
                    $booking->id,
                    $booking->user->name ?? 'N/A',
                    $booking->assignedRoom->name ?? $booking->room->name ?? 'N/A',
                    $booking->check_in_date->format('Y-m-d'),
                    $booking->check_out_date->format('Y-m-d'),
                    $booking->number_of_nights,
                    $booking->total_amount,
                    $booking->outstanding_balance,
                    ucfirst($booking->status),
                    ucfirst($booking->payment_status),
                    $booking->created_at->format('Y-m-d H:i:s'),
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }

    /**
     * Get available rooms for a booking
     */
    private function getAvailableRooms(Booking $booking)
    {
        return Room::whereDoesntHave('bookings', function ($query) use ($booking) {
            $query->where('status', '!=', 'cancelled')
                ->where('id', '!=', $booking->id)
                ->where(function ($q) use ($booking) {
                    $q->whereBetween('check_in_date', [$booking->check_in_date, $booking->check_out_date])
                        ->orWhereBetween('check_out_date', [$booking->check_in_date, $booking->check_out_date])
                        ->orWhere(function ($subQ) use ($booking) {
                            $subQ->where('check_in_date', '<=', $booking->check_in_date)
                                ->where('check_out_date', '>=', $booking->check_out_date);
                        });
                });
        })->orWhere('id', $booking->assigned_room_id)->get();
    }
}
