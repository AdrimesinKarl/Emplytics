<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'HR User',
            'email' => 'hr@test.com',
            'password' => Hash::make('password123'),
            'role' => 'hr',
        ]);

        User::factory()->create([
            'name' => 'Employee User',
            'email' =>'employee@test.com',
            'password' => Hash::make('password123'),
            'role' => 'employee',
        ]);
    }
}
