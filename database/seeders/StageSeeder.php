<?php

namespace Database\Seeders;

use App\Models\Stage;
use Illuminate\Database\Seeder;

class StageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Stage::create(['name' => 'Lead', 'order' => 1, 'funnel_id' => 1]);
        Stage::create(['name' => 'Prospect', 'order' => 2, 'funnel_id' => 1]);
        Stage::create(['name' => 'Cliente', 'order' => 1, 'funnel_id' => 2]);
        Stage::create(['name' => 'Assinante', 'order' => 2, 'funnel_id' => 2]);
    }
}
