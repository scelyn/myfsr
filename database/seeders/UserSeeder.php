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
        // Default Admin Account
        User::updateOrCreate(
            ['email' => 'admin@sipedis.com'],
            [
                'name' => 'Admin SIPEDIS',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );

        // Additional dummy users
        User::factory(2)->create();
    }
}
