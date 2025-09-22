<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'message',
        'subject',
        'source',
        'status',
        'additional_data',
    ];

    protected $casts = [
        'additional_data' => 'array',
    ];

    /**
     * Get the room associated with this contact (if any)
     */
    public function room()
    {
        if (isset($this->additional_data['room_id'])) {
            return Room::find($this->additional_data['room_id']);
        }
        return null;
    }

    /**
     * Get the booking that was created from this contact (if any)
     */
    public function booking()
    {
        return $this->hasOne(Booking::class, 'customer_details->contact_id');
    }

    /**
     * Check if contact has been converted to booking
     */
    public function isConverted()
    {
        return $this->status === 'converted';
    }

    /**
     * Get check-in date from additional data
     */
    public function getCheckInDate()
    {
        return $this->additional_data['check_in_date'] ?? null;
    }

    /**
     * Get check-out date from additional data
     */
    public function getCheckOutDate()
    {
        return $this->additional_data['check_out_date'] ?? null;
    }

    /**
     * Get booking type from additional data
     */
    public function getBookingType()
    {
        return $this->additional_data['booking_type'] ?? 'daily';
    }
}
