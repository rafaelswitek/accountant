<?php

namespace Database\Seeders;

use App\Models\Deal;
use Illuminate\Database\Seeder;

class DealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Deal::create(['name' => 'Negócio 1', 'stage_id' => 1, 'user_id' => 1, 'status' => 'won']);
        Deal::create(['name' => 'Negócio 2', 'stage_id' => 1, 'user_id' => 1, 'status' => 'lost']);
        Deal::create(['name' => 'Negócio 3', 'stage_id' => 2, 'user_id' => 1, 'status' => 'lost']);

        for ($i = 4; $i <= 10; $i++) {
            Deal::create(['name' => "Negócio {$i}", 'stage_id' => 3, 'user_id' => 2]);
        }
    }
}
