<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rooms = Room::all();
        $users = User::where('role', '!=', 'admin')->get();
        
        if ($rooms->isEmpty()) {
            $this->command->error('No rooms found. Please run RoomSeeder first.');
            return;
        }
        
        if ($users->isEmpty()) {
            $this->command->error('No users found. Please run AdminUserSeeder first.');
            return;
        }

        $bookings = [
            [
                'user_id' => $users->where('role', 'user')->first()->id,
                'room_id' => $rooms->first()->id,
                'assigned_room_id' => $rooms->first()->id,
                'check_in_date' => Carbon::now()->addDays(2),
                'check_out_date' => Carbon::now()->addDays(5),
                'number_of_nights' => 3,
                'total_amount' => $rooms->first()->price_per_night * 3,
                'status' => 'confirmed',
                'payment_status' => 'partial',
                'advance_amount' => $rooms->first()->price_per_night * 1.5,
                'outstanding_balance' => $rooms->first()->price_per_night * 1.5,
                'special_requests' => 'Early check-in if possible',
                'admin_notes' => 'Regular customer, good payment history',
                'customer_details' => [
                    'name' => 'Ahmed Ali',
                    'phone' => '03001234567',
                    'email' => 'ahmed.ali@email.com',
                    'nic' => '12345-6789012-3',
                ],
            ],
            [
                'user_id' => $users->where('role', 'client')->first()->id,
                'room_id' => $rooms->skip(1)->first()->id,
                'assigned_room_id' => $rooms->skip(1)->first()->id,
                'check_in_date' => Carbon::now()->addDays(7),
                'check_out_date' => Carbon::now()->addDays(10),
                'number_of_nights' => 3,
                'total_amount' => $rooms->skip(1)->first()->price_per_night * 3,
                'status' => 'pending',
                'payment_status' => 'pending',
                'advance_amount' => 0,
                'outstanding_balance' => $rooms->skip(1)->first()->price_per_night * 3,
                'special_requests' => 'Ground floor room preferred',
                'admin_notes' => 'New customer',
                'customer_details' => [
                    'name' => 'Sara Khan',
                    'phone' => '03009876543',
                    'email' => 'sara.khan@email.com',
                    'nic' => '54321-9876543-2',
                ],
            ],
            [
                'user_id' => $users->first()->id,
                'room_id' => $rooms->skip(2)->first()->id,
                'assigned_room_id' => $rooms->skip(2)->first()->id,
                'check_in_date' => Carbon::now()->subDays(5),
                'check_out_date' => Carbon::now()->subDays(2),
                'number_of_nights' => 3,
                'total_amount' => $rooms->skip(2)->first()->price_per_night * 3,
                'status' => 'completed',
                'payment_status' => 'full',
                'advance_amount' => $rooms->skip(2)->first()->price_per_night * 3,
                'outstanding_balance' => 0,
                'special_requests' => 'Extra towels',
                'admin_notes' => 'Satisfied customer, left good review',
                'customer_details' => [
                    'name' => 'Muhammad Hassan',
                    'phone' => '03005555555',
                    'email' => 'hassan@email.com',
                    'nic' => '11111-2222233-4',
                ],
            ],
            [
                'user_id' => $users->last()->id,
                'room_id' => $rooms->skip(3)->first()->id,
                'assigned_room_id' => $rooms->skip(3)->first()->id,
                'check_in_date' => Carbon::now()->addDays(15),
                'check_out_date' => Carbon::now()->addDays(45),
                'number_of_nights' => 30,
                'total_amount' => $rooms->skip(3)->first()->price_per_night * 30 * 0.8, // 20% monthly discount
                'status' => 'confirmed',
                'payment_status' => 'partial',
                'advance_amount' => $rooms->skip(3)->first()->price_per_night * 10,
                'outstanding_balance' => ($rooms->skip(3)->first()->price_per_night * 30 * 0.8) - ($rooms->skip(3)->first()->price_per_night * 10),
                'special_requests' => 'Monthly stay, need weekly cleaning',
                'admin_notes' => 'Long-term guest, monthly payment plan',
                'customer_details' => [
                    'name' => 'Fatima Sheikh',
                    'phone' => '03007777777',
                    'email' => 'fatima.sheikh@email.com',
                    'nic' => '99999-8888877-6',
                ],
            ],
            [
                'user_id' => $users->first()->id,
                'room_id' => $rooms->last()->id,
                'assigned_room_id' => $rooms->last()->id,
                'check_in_date' => Carbon::now()->addDays(1),
                'check_out_date' => Carbon::now()->addDays(2),
                'number_of_nights' => 1,
                'total_amount' => $rooms->last()->price_per_night,
                'status' => 'cancelled',
                'payment_status' => 'pending',
                'advance_amount' => 0,
                'outstanding_balance' => 0,
                'special_requests' => 'Late check-out',
                'admin_notes' => 'Cancelled due to emergency, full refund processed',
                'customer_details' => [
                    'name' => 'Ali Raza',
                    'phone' => '03008888888',
                    'email' => 'ali.raza@email.com',
                    'nic' => '77777-6666655-5',
                ],
            ],
        ];

        foreach ($bookings as $bookingData) {
            Booking::create($bookingData);
        }

        $this->command->info('Booking seeder completed successfully! Created ' . count($bookings) . ' bookings.');
    }
}