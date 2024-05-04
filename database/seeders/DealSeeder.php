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
        Deal::create(['name' => 'Negócio 1', 'stage_id' => 1, 'user_id' => 1, 'company_id' => 1, 'status' => 'won']);
        Deal::create(['name' => 'Negócio 2', 'stage_id' => 1, 'user_id' => 2, 'company_id' => 2, 'status' => 'lost']);
    }
}
