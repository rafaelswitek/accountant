<?php

namespace Database\Seeders;

use App\Models\Funnel;
use Illuminate\Database\Seeder;

class FunnelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Funnel::create(['name' => 'Vendas']);
        Funnel::create(['name' => 'Marketing']);
    }
}
