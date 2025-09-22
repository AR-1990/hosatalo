<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Display a listing of bookings
     */
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role === 'admin') {
            $bookings = Booking::with(['user', 'room', 'assignedRoom'])->latest()->get();
        } elseif ($user->role === 'client') {
            $bookings = Booking::whereHas('room', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })->with(['user', 'room', 'assignedRoom'])->latest()->get();
        } else {
            $bookings = $user->bookings()->with(['room', 'assignedRoom'])->latest()->get();
        }
        
        return view('bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new booking
     */
    public function create(Room $room)
    {
        return view('bookings.create', compact('room'));
    }

    /**
     * Store a newly created booking
     */
    public function store(Request $request, Room $room)
    {
        $request->validate([
            'check_in_date' => 'required|date|after:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'special_requests' => 'nullable|string',
        ]);

        // Check if room is available for selected dates
        if (!$room->isAvailableForDates($request->check_in_date, $request->check_out_date)) {
            return redirect()->back()->withErrors(['dates' => 'Room is not available for selected dates.'])->withInput();
        }

        $checkIn = Carbon::parse($request->check_in_date);
        $checkOut = Carbon::parse($request->check_out_date);
        $nights = $checkIn->diffInDays($checkOut);
        $totalAmount = $nights * $room->price_per_night;

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'room_id' => $room->id,
            'check_in_date' => $request->check_in_date,
            'check_out_date' => $request->check_out_date,
            'number_of_nights' => $nights,
            'total_amount' => $totalAmount,
            'status' => 'pending',
            'special_requests' => $request->special_requests,
        ]);

        return redirect()->route('bookings.index')->with('success', 'Booking created successfully!');
    }

    /**
     * Display the specified booking
     */
    public function show(Booking $booking)
    {
        $availableRooms = $booking->getAvailableRooms();
        return view('bookings.show', compact('booking', 'availableRooms'));
    }

    /**
     * Update booking status (admin/client only)
     */
    public function updateStatus(Request $request, Booking $booking)
    {
        $user = Auth::user();
        
        if (!in_array($user->role, ['admin', 'client'])) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed',
        ]);

        $booking->update(['status' => $request->status]);

        return redirect()->route('bookings.index')->with('success', 'Booking status updated successfully!');
    }

    /**
     * Assign room to booking (admin only)
     */
    public function assignRoom(Request $request, Booking $booking)
    {
        $user = Auth::user();
        
        if ($user->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'assigned_room_id' => 'required|exists:rooms,id',
            'admin_notes' => 'nullable|string',
        ]);

        // Check if the assigned room is available for the booking dates
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
            return redirect()->back()->withErrors(['assigned_room_id' => 'Selected room is not available for the specified dates.'])->withInput();
        }

        $booking->update([
            'assigned_room_id' => $request->assigned_room_id,
            'admin_notes' => $request->admin_notes,
        ]);

        return redirect()->route('bookings.show', $booking)->with('success', 'Room assigned successfully!');
    }

    /**
     * Update admin notes (admin only)
     */
    public function updateNotes(Request $request, Booking $booking)
    {
        $user = Auth::user();
        
        if ($user->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'admin_notes' => 'nullable|string',
        ]);

        $booking->update(['admin_notes' => $request->admin_notes]);

        return redirect()->route('bookings.show', $booking)->with('success', 'Notes updated successfully!');
    }

    /**
     * Cancel booking (user only)
     */
    public function cancel(Booking $booking)
    {
        $user = Auth::user();
        
        if ($booking->user_id !== $user->id) {
            abort(403);
        }

        if ($booking->status === 'confirmed') {
            $booking->update(['status' => 'cancelled']);
            return redirect()->route('bookings.index')->with('success', 'Booking cancelled successfully!');
        }

        return redirect()->route('bookings.index')->with('error', 'Cannot cancel this booking.');
    }

    /**
     * Check room availability for specific dates
     */
    public function checkAvailability(Request $request)
    {
        $request->validate([
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
        ]);

        $availableRooms = Room::whereDoesntHave('bookings', function ($query) use ($request) {
            $query->where('status', '!=', 'cancelled')
                ->where(function ($q) use ($request) {
                    $q->whereBetween('check_in_date', [$request->check_in_date, $request->check_out_date])
                        ->orWhereBetween('check_out_date', [$request->check_in_date, $request->check_out_date])
                        ->orWhere(function ($subQ) use ($request) {
                            $subQ->where('check_in_date', '<=', $request->check_in_date)
                                ->where('check_out_date', '>=', $request->check_out_date);
                        });
                });
        })->get();

        return response()->json([
            'available_rooms' => $availableRooms,
            'count' => $availableRooms->count()
        ]);
    }
}
