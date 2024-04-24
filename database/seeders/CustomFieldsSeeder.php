<?php

namespace Database\Seeders;

use App\Models\CustomField;
use App\Models\CustomFieldValue;
use Illuminate\Database\Seeder;

class CustomFieldsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fields = [
            ['id' => 1, 'status' => true, 'info' => json_encode(['type' => 'textInput', 'label' => 'Campo 1', 'placeholder' => 'Insira aqui', 'required' => false])],
            ['id' => 2, 'status' => true, 'info' => json_encode(['type' => 'textInput', 'label' => 'Campo 2', 'placeholder' => 'Insira aqui', 'required' => true])],
        ];

        CustomField::insert($fields);

        $values = [
            ['field_id' => 1, 'company_id' => 1, 'info' => json_encode(['value' => 'Teste 1'])],
            ['field_id' => 2, 'company_id' => 1, 'info' => json_encode(['value' => 'Teste 2'])],
        ];

        CustomFieldValue::insert($values);
    }
}
