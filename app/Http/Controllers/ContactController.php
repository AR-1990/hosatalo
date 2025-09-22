<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Booking;
use App\Models\User;
use App\Models\Room;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ContactController extends Controller
{
    /**
     * Store a new contact inquiry
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'message' => 'nullable|string',
            'subject' => 'nullable|string|max:255',
            'source' => 'nullable|string|max:100',
            'room_id' => 'nullable|exists:rooms,id',
            'check_in_date' => 'nullable|date',
            'check_out_date' => 'nullable|date',
            'booking_type' => 'nullable|in:daily,monthly,yearly',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $contact = Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
            'subject' => $request->subject ?: 'Room Inquiry',
            'source' => $request->source ?: 'room_inquiry',
            'status' => 'new',
            'additional_data' => [
                'room_id' => $request->room_id,
                'check_in_date' => $request->check_in_date,
                'check_out_date' => $request->check_out_date,
                'booking_type' => $request->booking_type,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Your inquiry has been submitted successfully! We will contact you soon.',
            'contact_id' => $contact->id
        ]);
    }

    /**
     * Store a general website contact form
     */
    public function storeGeneral(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'message' => 'required|string',
            'subject' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $contact = Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
            'subject' => $request->subject ?: 'General Inquiry',
            'source' => 'website',
            'status' => 'new',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Your message has been sent successfully! We will get back to you soon.',
            'contact_id' => $contact->id
        ]);
    }

    // Admin Methods
    public function adminIndex()
    {
        $leads = Contact::orderBy('created_at', 'desc')->paginate(25);
        $availableRooms = Room::where('is_available', true)->get();
        return view('admin.leads.index', compact('leads', 'availableRooms'));
    }

    public function adminShow(Contact $contact)
    {
        // Get available rooms for booking conversion
        $availableRooms = Room::where('is_available', true)->get();
        
        return view('admin.leads.show', compact('contact', 'availableRooms'));
    }

    public function adminEdit(Contact $contact)
    {
        return response()->json([
            'name' => $contact->name,
            'email' => $contact->email,
            'phone' => $contact->phone,
            'status' => $contact->status,
            'notes' => $contact->additional_data['notes'] ?? '',
        ]);
    }

    public function adminUpdate(Request $request, Contact $contact)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'status' => 'required|in:new,contacted,converted,closed',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $additionalData = $contact->additional_data ?? [];
        $additionalData['notes'] = $request->notes;

        $contact->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'status' => $request->status,
            'additional_data' => $additionalData,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Lead updated successfully!'
        ]);
    }

    public function updateStatus(Request $request, Contact $contact)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:new,contacted,converted,closed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $contact->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Lead status updated successfully!'
        ]);
    }

    /**
     * Approve booking from contact inquiry
     */
    public function approveBooking(Request $request, Contact $contact)
    {
        $validator = Validator::make($request->all(), [
            'assigned_room_id' => 'required|exists:rooms,id',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
            'total_amount' => 'required|numeric|min:0.01',
            'admin_notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Check if the selected room is available for the booking dates
        $room = Room::find($request->assigned_room_id);
        
        if (!$room) {
            return response()->json([
                'success' => false,
                'message' => 'Selected room not found.'
            ], 404);
        }

        // Check room availability
        $conflictingBookings = Booking::where('assigned_room_id', $request->assigned_room_id)
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
            return response()->json([
                'success' => false,
                'message' => 'Selected room is not available for the specified dates. Please choose different dates or another room.'
            ], 422);
        }

        DB::beginTransaction();
        
        try {
            // Create or find user account for the customer
            $user = User::where('email', $contact->email)->first();
            
            if (!$user) {
                // Create new user account
                $user = User::create([
                    'name' => $contact->name,
                    'email' => $contact->email,
                    'phone' => $contact->phone,
                    'password' => Hash::make(Str::random(12)), // Generate random password
                    'role' => 'customer',
                ]);
            }

            // Calculate number of nights
            $checkIn = \Carbon\Carbon::parse($request->check_in_date);
            $checkOut = \Carbon\Carbon::parse($request->check_out_date);
            $nights = $checkIn->diffInDays($checkOut);

            // Create booking
            $booking = Booking::create([
                'user_id' => $user->id,
                'room_id' => $contact->additional_data['room_id'] ?? $request->assigned_room_id,
                'assigned_room_id' => $request->assigned_room_id,
                'check_in_date' => $request->check_in_date,
                'check_out_date' => $request->check_out_date,
                'number_of_nights' => $nights,
                'total_amount' => $request->total_amount,
                'outstanding_balance' => $request->total_amount,
                'status' => 'confirmed',
                'payment_status' => 'pending',
                'admin_notes' => $request->admin_notes,
                'customer_details' => [
                    'contact_id' => $contact->id,
                    'name' => $contact->name,
                    'email' => $contact->email,
                    'phone' => $contact->phone,
                    'source' => $contact->source,
                    'original_message' => $contact->message,
                ],
            ]);

            // Update contact status to converted
            $contact->update([
                'status' => 'converted',
                'additional_data' => array_merge($contact->additional_data ?? [], [
                    'booking_id' => $booking->id,
                    'converted_at' => now(),
                    'admin_notes' => $request->admin_notes,
                ])
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Booking approved successfully! Contact has been converted to a confirmed booking.',
                'booking_id' => $booking->id,
                'user_id' => $user->id,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to approve booking. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Check room availability for specific dates
     */
    public function checkRoomAvailability(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'room_type' => 'required|string|max:100',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Find a room of the specified type
        $room = Room::where('room_type', $request->room_type)
                   ->where('is_available', true)
                   ->first();
        
        if (!$room) {
            return response()->json([
                'success' => false,
                'message' => 'No rooms of this type are currently available.'
            ], 404);
        }

        // Check availability for the selected dates
        $conflictingBookings = Booking::where('room_id', $room->id)
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($request) {
                $query->whereBetween('check_in_date', [$request->check_in_date, $request->check_out_date])
                    ->orWhereBetween('check_out_date', [$request->check_in_date, $request->check_out_date])
                    ->orWhere(function ($q) use ($request) {
                        $q->where('check_in_date', '<=', $request->check_in_date)
                            ->where('check_out_date', '>=', $request->check_out_date);
                    });
            })->exists();

        $isAvailable = !$conflictingBookings;

        // Get count of available rooms of this type
        $totalRoomsOfType = Room::where('room_type', $request->room_type)->count();
        $availableRoomsOfType = Room::where('room_type', $request->room_type)
                                   ->where('is_available', true)
                                   ->count();

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
            'check_in_date' => $request->check_in_date,
            'check_out_date' => $request->check_out_date,
            'total_rooms_of_type' => $totalRoomsOfType,
            'available_rooms_of_type' => $availableRoomsOfType,
            'message' => $isAvailable ? 'Room is available for selected dates.' : 'Room is not available for selected dates.'
        ]);
    }

    /**
     * Create a new lead from admin panel
     */
    public function adminCreate()
    {
        return view('admin.leads.create');
    }

    /**
     * Store a new lead from admin panel
     */
    public function adminStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'message' => 'nullable|string',
            'subject' => 'nullable|string|max:255',
            'source' => 'nullable|string|max:100',
            'room_type' => 'nullable|string|max:100',
            'check_in_date' => 'nullable|date',
            'check_out_date' => 'nullable|date',
            'booking_type' => 'nullable|in:daily,monthly,yearly',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $contact = Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
            'subject' => $request->subject ?: 'Room Inquiry',
            'source' => $request->source ?: 'admin_created',
            'status' => 'new',
            'additional_data' => [
                'room_type' => $request->room_type,
                'check_in_date' => $request->check_in_date,
                'check_out_date' => $request->check_out_date,
                'booking_type' => $request->booking_type,
                'admin_created' => true,
                'created_by' => auth()->id(),
            ],
        ]);

        return redirect()->route('admin.leads.index')->with('success', 'Lead created successfully!');
    }

    /**
     * Add a note to a contact
     */
    public function addNote(Request $request, Contact $contact)
    {
        $validator = Validator::make($request->all(), [
            'note' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $additionalData = $contact->additional_data ?? [];
        $notes = $additionalData['notes'] ?? [];
        $notes[] = [
            'note' => $request->note,
            'added_by' => auth()->id(),
            'added_at' => now()->toISOString(),
        ];

        $contact->update([
            'additional_data' => array_merge($additionalData, ['notes' => $notes])
        ]);

        return redirect()->back()->with('success', 'Note added successfully!');
    }

    /**
     * Test method to verify approval process
     */
    public function testApproval(Contact $contact)
    {
        return response()->json([
            'success' => true,
            'message' => 'Test approval method working!',
            'contact_id' => $contact->id,
            'contact_name' => $contact->name,
            'contact_email' => $contact->email,
            'status' => $contact->status,
            'additional_data' => $contact->additional_data
        ]);
    }

    /**
     * Approve a contact and convert it to a booking
     */
}
