<?php

namespace App\Models;

use App\Helpers\Number;
use App\Helpers\Text;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Company extends Model
{
    protected $fillable = [
        'photo', 'document', 'name', 'trade', 'phone', 'email', 'status', 'keys', 'origin'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($company) {
            $data = request()->all();
            $company->updateCustomFields($data);
        });
    }

    public function scopeSearch($query, $param)
    {
        return $query->where(function ($query) use ($param) {
            $query->where('document', 'like', "%{$param}%")
                ->orWhere('name', 'like', "%{$param}%")
                ->orWhere('trade', 'like', "%{$param}%");
        });
    }

    public function customFields(): HasMany
    {
        return $this->hasMany(CustomFieldValue::class);
    }

    public static function storeFromCFC(array $data)
    {
        $upsertData = [];
        $log = [];

        try {
            DB::beginTransaction();

            foreach ($data as $item) {
                $upsertData[] = [
                    'name' => Text::sanitize($item['Nome']),
                    'cnpj' => Arr::has($item, 'CpfCnpj') ? Number::onlyNumbers($item['CpfCnpj']) : null,
                    'registry' => $item['Registro'],
                    'status' => $item['SituacaoCadastral'] == 'Ativo',
                ];
                $log[] = [
                    'origin' => 'cfc',
                    'payload' => json_encode($item)
                ];
            }

            self::upsert($upsertData, ['cnpj']);

            RegistrationLog::insert($log);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('[DB][STORE][CFC]: ', ['message' => $e->getMessage()]);
        }
    }

    public function updateCustomFields(array $data): array
    {
        $customFields = $this->extractCustomFields($data);
        $oldValues = [];
        $newValues = [];

        foreach ($customFields as $fieldId => $newValue) {
            $condition = ['field_id' => $fieldId, 'company_id' => $this->id];

            $customFieldOld = CustomFieldValue::where($condition)->first();

            $dataForUpdate = array_merge($condition, ['info' => ['value' => $newValue]]);

            $customFieldNew = CustomFieldValue::updateOrCreate($condition, $dataForUpdate);

            $fieldLabel = $customFieldNew->fields->info->label;

            $oldValues[$fieldLabel] = $customFieldOld->info->value ?? null;
            $newValues[$fieldLabel] = $newValue;
        }

        return ['old' => $oldValues, 'new' => $newValues];
    }

    private function extractCustomFields(array $data): array
    {
        $customFields = [];

        foreach ($data as $key => $value) {
            if (strpos($key, 'custom_') === 0) {
                $newKey = str_replace('custom_', '', $key);
                $customFields[$newKey] = $value;
            }
        }

        return $customFields;
    }
}
