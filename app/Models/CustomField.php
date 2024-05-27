<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomField extends Model
{
    protected $fillable = [
        'status',
        'info',
    ];

    protected $casts = [
        'info' => 'object',
        'status' => 'boolean'
    ];

    public $timestamps = true;

    public function values()
    {
        return $this->hasOne(CustomFieldValue::class, 'field_id');
    }

    public static function updateCustomFields(array $data, int $id): array
    {
        $customFields = [];

        foreach ($data as $key => $value) {
            if (strpos($key, 'custom_') === 0) {
                $newKey = str_replace('custom_', '', $key);
                $customFields[$newKey] = $value;
            }
        }

        $oldValues = [];
        $newValues = [];

        foreach ($customFields as $fieldId => $newValue) {
            $condition = ['field_id' => $fieldId, 'company_id' => $id];

            $customFieldOld = CustomFieldValue::where($condition)->first();

            $dataForUpdate = array_merge($condition, ['info' => ['value' => $newValue]]);

            $customFieldNew = CustomFieldValue::updateOrCreate($condition, $dataForUpdate);

            $fieldLabel = $customFieldNew->fields->info->label;

            $oldValues[$fieldLabel] = $customFieldOld->info->value ?? null;
            $newValues[$fieldLabel] = $newValue;
        }

        return ['old' => $oldValues, 'new' => $newValues];
    }
}
