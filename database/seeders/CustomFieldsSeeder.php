<?php

namespace Database\Seeders;

use App\Models\CustomField;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CustomFieldsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $timestamp = Carbon::now();
        $fields = [
            [
                'id' => 1,
                'status' => true,
                'info' => json_encode(['type' => 'textInput', 'label' => 'CRC', 'placeholder' => 'UF-999999', 'required' => false]),
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],
        ];

        CustomField::insert($fields);
    }
}
