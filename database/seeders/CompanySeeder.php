<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = [
            ['document' => '13885290000140', 'name' => 'Competi Sistemas LTDA', 'trade' => 'Competi Sistemas', 'status' => false, 'phone' => '6230982122', 'email' => 'competi@emitte.com.br'],
            ['document' => '40215418000130', 'name' => 'Emitte Solucoes B2b Ltda', 'trade' => 'Emitte', 'status' => true, 'phone' => '6230982122', 'email' => 'email@emitte.com.br'],
        ];

        foreach ($companies as $company) {
            Company::create($company);
        }
    }
}
