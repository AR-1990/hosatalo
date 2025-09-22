<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contact;
use App\Models\Room;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rooms = Room::all();
        
        if ($rooms->isEmpty()) {
            $this->command->error('No rooms found. Please run RoomSeeder first.');
            return;
        }

        $contacts = [
            [
                'name' => 'Ahmed Ali',
                'email' => 'ahmed.ali@email.com',
                'phone' => '03001234567',
                'subject' => 'Room Booking Inquiry',
                'message' => 'I would like to book a single room for 3 nights. Please let me know availability.',
                'source' => 'website',
                'status' => 'new',
                'additional_data' => [
                    'room_id' => $rooms->where('room_type', 'single')->first()->id,
                    'check_in_date' => now()->addDays(5)->format('Y-m-d'),
                    'check_out_date' => now()->addDays(8)->format('Y-m-d'),
                    'booking_type' => 'daily',
                    'guests' => 1,
                ],
            ],
            [
                'name' => 'Sara Khan',
                'email' => 'sara.khan@email.com',
                'phone' => '03009876543',
                'subject' => 'Family Room Booking',
                'message' => 'Looking for a family room for weekend stay. Do you have availability?',
                'source' => 'phone',
                'status' => 'contacted',
                'additional_data' => [
                    'room_id' => $rooms->where('room_type', 'triple')->first()->id,
                    'check_in_date' => now()->addDays(10)->format('Y-m-d'),
                    'check_out_date' => now()->addDays(12)->format('Y-m-d'),
                    'booking_type' => 'daily',
                    'guests' => 3,
                ],
            ],
            [
                'name' => 'Muhammad Hassan',
                'email' => 'hassan@email.com',
                'phone' => '03005555555',
                'subject' => 'Long Stay Inquiry',
                'message' => 'I need accommodation for a month. Do you offer monthly rates?',
                'source' => 'website',
                'status' => 'new',
                'additional_data' => [
                    'room_id' => $rooms->where('room_type', 'double')->first()->id,
                    'check_in_date' => now()->addDays(15)->format('Y-m-d'),
                    'check_out_date' => now()->addDays(45)->format('Y-m-d'),
                    'booking_type' => 'monthly',
                    'guests' => 2,
                ],
            ],
            [
                'name' => 'Fatima Sheikh',
                'email' => 'fatima.sheikh@email.com',
                'phone' => '03007777777',
                'subject' => 'Budget Room Inquiry',
                'message' => 'Looking for affordable accommodation for students. What are your rates?',
                'source' => 'social_media',
                'status' => 'new',
                'additional_data' => [
                    'room_id' => $rooms->where('price_per_night', '<', 2000)->first()->id,
                    'check_in_date' => now()->addDays(7)->format('Y-m-d'),
                    'check_out_date' => now()->addDays(14)->format('Y-m-d'),
                    'booking_type' => 'daily',
                    'guests' => 1,
                ],
            ],
            [
                'name' => 'Ali Raza',
                'email' => 'ali.raza@email.com',
                'phone' => '03008888888',
                'subject' => 'Premium Suite Booking',
                'message' => 'I want to book your premium suite for a special occasion. Please confirm availability.',
                'source' => 'referral',
                'status' => 'converted',
                'additional_data' => [
                    'room_id' => $rooms->where('room_type', 'suite')->first()->id,
                    'check_in_date' => now()->addDays(20)->format('Y-m-d'),
                    'check_out_date' => now()->addDays(22)->format('Y-m-d'),
                    'booking_type' => 'daily',
                    'guests' => 2,
                ],
            ],
        ];

        foreach ($contacts as $contactData) {
            Contact::create($contactData);
        }

        $this->command->info('Contact seeder completed successfully! Created ' . count($contacts) . ' contacts.');
    }
}