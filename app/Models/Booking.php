<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'room_id',
        'assigned_room_id',
        'check_in_date',
        'check_out_date',
        'number_of_nights',
        'total_amount',
        'status',
        'payment_status',
        'outstanding_balance',
        'advance_amount',
        'special_requests',
        'admin_notes',
        'customer_details',
    ];

    protected $casts = [
        'check_in_date' => 'date',
        'check_out_date' => 'date',
        'total_amount' => 'decimal:2',
        'outstanding_balance' => 'decimal:2',
        'advance_amount' => 'decimal:2',
        'customer_details' => 'array',
    ];

    /**
     * Get the user that made the booking
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the room that was booked
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Get the room that was assigned by admin
     */
    public function assignedRoom()
    {
        return $this->belongsTo(Room::class, 'assigned_room_id');
    }

    /**
     * Get all payments for this booking
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get the contact that was converted to this booking
     */
    public function contact()
    {
        if ($this->customer_details && isset($this->customer_details['contact_id'])) {
            return Contact::find($this->customer_details['contact_id']);
        }
        return null;
    }

    /**
     * Calculate total amount based on nights and room price
     */
    public function calculateTotalAmount()
    {
        $nights = $this->check_in_date->diffInDays($this->check_out_date);
        $this->number_of_nights = $nights;
        $this->total_amount = $nights * $this->room->price_per_night;
        $this->outstanding_balance = $this->total_amount - $this->advance_amount;
        return $this->total_amount;
    }

    /**
     * Check if the assigned room is available for the booking dates
     */
    public function isAssignedRoomAvailable()
    {
        if (!$this->assigned_room_id) {
            return false;
        }

        $conflictingBookings = Booking::where('assigned_room_id', $this->assigned_room_id)
            ->where('id', '!=', $this->id)
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) {
                $query->whereBetween('check_in_date', [$this->check_in_date, $this->check_out_date])
                    ->orWhereBetween('check_out_date', [$this->check_in_date, $this->check_out_date])
                    ->orWhere(function ($q) {
                        $q->where('check_in_date', '<=', $this->check_in_date)
                            ->where('check_out_date', '>=', $this->check_out_date);
                    });
            })->exists();

        return !$conflictingBookings;
    }

    /**
     * Get available rooms for the booking dates
     */
    public function getAvailableRooms()
    {
        return Room::whereDoesntHave('bookings', function ($query) {
            $query->where('status', '!=', 'cancelled')
                ->where(function ($q) {
                    $q->whereBetween('check_in_date', [$this->check_in_date, $this->check_out_date])
                        ->orWhereBetween('check_out_date', [$this->check_in_date, $this->check_out_date])
                        ->orWhere(function ($subQ) {
                            $subQ->where('check_in_date', '<=', $this->check_in_date)
                                ->where('check_out_date', '>=', $this->check_out_date);
                        });
                });
        })->orWhere('id', $this->assigned_room_id)->get();
    }

    /**
     * Calculate outstanding balance
     */
    public function calculateOutstandingBalance()
    {
        $totalPaid = $this->payments()->completed()->sum('amount');
        $this->outstanding_balance = $this->total_amount - $totalPaid;
        $this->save();
        return $this->outstanding_balance;
    }

    /**
     * Update payment status based on payments
     */
    public function updatePaymentStatus()
    {
        $totalPaid = $this->payments()->completed()->sum('amount');
        
        if ($totalPaid >= $this->total_amount) {
            $this->payment_status = 'full';
        } elseif ($totalPaid > 0) {
            $this->payment_status = 'partial';
        } else {
            $this->payment_status = 'pending';
        }
        
        $this->advance_amount = $totalPaid;
        $this->outstanding_balance = $this->total_amount - $totalPaid;
        $this->save();
        
        return $this->payment_status;
    }

    /**
     * Check if booking is fully paid
     */
    public function isFullyPaid()
    {
        return $this->payment_status === 'full';
    }

    /**
     * Check if booking has partial payment
     */
    public function hasPartialPayment()
    {
        return $this->payment_status === 'partial';
    }
}
