<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), // Change to a strong password in production
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Coach User',
            'email' => 'coach@example.com',
            'password' => Hash::make('password'), // Change to a strong password in production
            'role' => 'coach',
        ]);

        User::create([  
            'name' => 'Player User',
            'email' => 'player@example.com',
            'password' => Hash::make('password'), // Change to a strong password in production
            'role' => 'player',
        ]);

        // Create 49 other users with random coach or player roles
        User::factory(49)->create()->each(function ($user) {
            $user->update(['role' => rand(0, 1) ? 'coach' : 'player']);
        });
    }
}