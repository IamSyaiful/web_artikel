<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin Ruang Cinema',
            'email' => 'saipulamin32467@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'User Ruang Cinema',
            'email' => 'ipulpoel54321@gmail.com',
            'password' => Hash::make('password1234'),
            'role' => 'user',
            'email_verified_at' => now(),
        ]);
    }
}
