<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Rafael',
            'email' => 'rafael.goncalves@emitte.com.br',
            'password' => 'ETuUDdDTWbaYcx4'
        ]);

        User::create([
            'name' => 'Lucas',
            'email' => 'lucas.soares@emitte.com.br',
            'password' => 'ETuUDdDTWbaYcx4'
        ]);
    }
}
