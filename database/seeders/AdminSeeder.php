<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@cleanbrgy.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123'), // Change to a secure password
                'role' => 'admin',
            ]
        );
    }
}
