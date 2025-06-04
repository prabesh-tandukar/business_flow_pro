<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@businessflowpro.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Create sales manager
        User::create([
            'first_name' => 'Sarah',
            'last_name' => 'Johnson',
            'email' => 'sarah.johnson@businessflowpro.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Create sales reps
        $salesReps = [
            ['first_name' => 'Mike', 'last_name' => 'Chen', 'email' => 'mike.chen@businessflowpro.com'],
            ['first_name' => 'Emily', 'last_name' => 'Rodriguez', 'email' => 'emily.rodriguez@businessflowpro.com'],
            ['first_name' => 'David', 'last_name' => 'Thompson', 'email' => 'david.thompson@businessflowpro.com'],
            ['first_name' => 'Lisa', 'last_name' => 'Wang', 'email' => 'lisa.wang@businessflowpro.com'],
        ];

        foreach ($salesReps as $rep) {
            User::create([
                'first_name' => $rep['first_name'],
                'last_name' => $rep['last_name'],
                'email' => $rep['email'],
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]);
        }
    }
}