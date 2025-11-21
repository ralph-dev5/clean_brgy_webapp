<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@cleanbrgy.com'], // Check if email exists
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123'), // Your password
                'role' => 'admin',
            ]
        );
    }
}
