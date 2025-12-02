<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // Import Hash to secure passwords

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create your Admin Account
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'uwunantekotta@gmail.com',
            'password' => Hash::make('akinto23'), // Hashed password
            'role' => User::ROLE_ADMIN, // Sets this user as Admin
        ]);

        // 2. (Optional) Create a dummy Viewer to test non-admin access
        User::factory()->create([
            'name' => 'Test Viewer',
            'email' => 'viewer@example.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_VIEWER, // Sets this user as Viewer
        ]);
    }
}