<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Integration;
use Illuminate\Database\Seeder;

class IntegrationSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Integration::create([
            'source' => 'whatsapp',
            'payload' => [
                'state' => '',
                'qrCode' => '',
                'user' => [
                    'name' => '',
                    'picture' => '',
                    'status' => '',
                ],
                'instanceId' => ''
            ]
        ]);
    }
}
