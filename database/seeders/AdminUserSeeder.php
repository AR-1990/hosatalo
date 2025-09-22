<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@hostal.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'phone' => '1234567890',
            'address' => 'Admin Address',
        ]);

        // Create sample client user
        User::create([
            'name' => 'Client User',
            'email' => 'client@hostal.com',
            'password' => Hash::make('client123'),
            'role' => 'client',
            'phone' => '9876543210',
            'address' => 'Client Address',
        ]);

        // Create sample regular user
        User::create([
            'name' => 'Regular User',
            'email' => 'user@hostal.com',
            'password' => Hash::make('user123'),
            'role' => 'user',
            'phone' => '5555555555',
            'address' => 'User Address',
        ]);

        $this->command->info('Admin, Client, and User accounts created successfully!');
        $this->command->info('Admin: admin@hostal.com / admin123');
        $this->command->info('Client: client@hostal.com / client123');
        $this->command->info('User: user@hostal.com / user123');
    }
}
