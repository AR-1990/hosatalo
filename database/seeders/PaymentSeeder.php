<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payment;
use App\Models\Booking;
use App\Models\User;
use Carbon\Carbon;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bookings = Booking::all();
        
        if ($bookings->isEmpty()) {
            $this->command->error('No bookings found. Please run BookingSeeder first.');
            return;
        }

        $payments = [];

        foreach ($bookings as $booking) {
            if ($booking->status === 'completed' && $booking->payment_status === 'full') {
                // Full payment for completed booking
                $payments[] = [
                    'booking_id' => $booking->id,
                    'user_id' => $booking->user_id,
                    'amount' => $booking->total_amount,
                    'payment_type' => 'full',
                    'payment_method' => 'cash',
                    'transaction_id' => 'TXN' . str_pad($booking->id, 6, '0', STR_PAD_LEFT),
                    'notes' => 'Full payment received at check-in',
                    'status' => 'completed',
                    'paid_at' => $booking->check_in_date,
                ];
            } elseif ($booking->payment_status === 'partial') {
                // Advance payment
                $payments[] = [
                    'booking_id' => $booking->id,
                    'user_id' => $booking->user_id,
                    'amount' => $booking->advance_amount,
                    'payment_type' => 'advance',
                    'payment_method' => 'bank_transfer',
                    'transaction_id' => 'ADV' . str_pad($booking->id, 6, '0', STR_PAD_LEFT),
                    'notes' => 'Advance payment to confirm booking',
                    'status' => 'completed',
                    'paid_at' => Carbon::now()->subDays(rand(1, 10)),
                ];
            }
        }

        // Add some additional payment records
        $confirmedBookings = $bookings->where('status', 'confirmed');
        
        foreach ($confirmedBookings->take(2) as $booking) {
            if ($booking->outstanding_balance > 0) {
                // Partial payment towards outstanding balance
                $partialAmount = $booking->outstanding_balance * 0.5;
                $payments[] = [
                    'booking_id' => $booking->id,
                    'user_id' => $booking->user_id,
                    'amount' => $partialAmount,
                    'payment_type' => 'partial',
                    'payment_method' => 'credit_card',
                    'transaction_id' => 'PAR' . str_pad($booking->id, 6, '0', STR_PAD_LEFT),
                    'notes' => 'Partial payment towards outstanding balance',
                    'status' => 'completed',
                    'paid_at' => Carbon::now()->subDays(rand(1, 5)),
                ];
            }
        }

        // Add some pending payments
        $pendingBookings = $bookings->where('status', 'pending');
        
        foreach ($pendingBookings->take(1) as $booking) {
            $payments[] = [
                'booking_id' => $booking->id,
                'user_id' => $booking->user_id,
                'amount' => $booking->total_amount * 0.3,
                'payment_type' => 'advance',
                'payment_method' => 'online_payment',
                'transaction_id' => 'PEN' . str_pad($booking->id, 6, '0', STR_PAD_LEFT),
                'notes' => 'Pending payment verification',
                'status' => 'pending',
                'paid_at' => null,
            ];
        }

        foreach ($payments as $paymentData) {
            Payment::create($paymentData);
        }

        $this->command->info('Payment seeder completed successfully! Created ' . count($payments) . ' payments.');
    }
}