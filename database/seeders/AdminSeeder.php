<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Seed the admin user.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@malvedaproperties.com'],
            [
                'name' => 'Admin',
                'email' => 'admin@malvedaproperties.com',
                'password' => Hash::make('mpdc2026'),
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}
