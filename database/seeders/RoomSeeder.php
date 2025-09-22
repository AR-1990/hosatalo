<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;
use App\Models\User;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get client user
        $clientUser = User::where('role', 'client')->first();
        
        if (!$clientUser) {
            $this->command->error('No client user found. Please run AdminUserSeeder first.');
            return;
        }

        $rooms = [
            [
                'user_id' => $clientUser->id,
                'name' => 'Deluxe Single Room',
                'description' => 'A comfortable single room with modern amenities including AC, WiFi, and private bathroom.',
                'price_per_night' => 2500.00,
                'capacity' => 1,
                'room_type' => 'single',
                'is_available' => true,
                'amenities' => ['AC', 'WiFi', 'Private Bathroom', 'TV', 'Mini Fridge'],
                'rules' => 'No smoking, No pets, Check-in after 2 PM',
                'entered_by' => $clientUser->id,
            ],
            [
                'user_id' => $clientUser->id,
                'name' => 'Standard Double Room',
                'description' => 'Spacious double room perfect for couples with all basic amenities.',
                'price_per_night' => 3500.00,
                'capacity' => 2,
                'room_type' => 'double',
                'is_available' => true,
                'amenities' => ['AC', 'WiFi', 'Private Bathroom', 'TV', 'Balcony'],
                'rules' => 'No smoking, Check-in after 2 PM, Check-out before 11 AM',
                'entered_by' => $clientUser->id,
            ],
            [
                'user_id' => $clientUser->id,
                'name' => 'Family Triple Room',
                'description' => 'Large room suitable for small families with extra bed and space.',
                'price_per_night' => 4500.00,
                'capacity' => 3,
                'room_type' => 'triple',
                'is_available' => true,
                'amenities' => ['AC', 'WiFi', 'Private Bathroom', 'TV', 'Extra Bed', 'Mini Fridge'],
                'rules' => 'No smoking, Children allowed, Check-in after 2 PM',
                'entered_by' => $clientUser->id,
            ],
            [
                'user_id' => $clientUser->id,
                'name' => 'Budget Single Room',
                'description' => 'Affordable single room with basic amenities for budget travelers.',
                'price_per_night' => 1500.00,
                'capacity' => 1,
                'room_type' => 'single',
                'is_available' => true,
                'amenities' => ['Fan', 'WiFi', 'Shared Bathroom'],
                'rules' => 'No smoking, Shared facilities, Check-in after 3 PM',
                'entered_by' => $clientUser->id,
            ],
            [
                'user_id' => $clientUser->id,
                'name' => 'Premium Suite',
                'description' => 'Luxurious suite with separate living area and premium amenities.',
                'price_per_night' => 6500.00,
                'capacity' => 4,
                'room_type' => 'suite',
                'is_available' => true,
                'amenities' => ['AC', 'WiFi', 'Private Bathroom', 'TV', 'Living Area', 'Mini Bar', 'Room Service'],
                'rules' => 'No smoking, Premium service included, 24/7 room service',
                'entered_by' => $clientUser->id,
            ],
        ];

        foreach ($rooms as $roomData) {
            Room::create($roomData);
        }

        $this->command->info('Room seeder completed successfully! Created ' . count($rooms) . ' rooms.');
    }
}