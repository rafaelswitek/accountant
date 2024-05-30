<?php

namespace App\Models;

use App\Helpers\Number;
use App\Helpers\Text;
use Carbon\Carbon;
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
        $timestamp = Carbon::now();
        $log = [];

        try {
            DB::beginTransaction();

            foreach ($data as $item) {
                $company = self::updateOrCreate(
                    ['document' => Number::onlyNumbers($item['CpfCnpj'])],
                    [
                        'name' => Text::sanitize($item['Nome']),
                        'trade' => Text::sanitize($item['Nome']),
                        'document' => isset($item['CpfCnpj']) ? Number::onlyNumbers($item['CpfCnpj']) : null,

                        'status' => $item['SituacaoCadastral'] == 'Ativo',
                        'origin' => "CFC"
                    ]
                );

                CustomField::updateCustomFields(['custom_1' => $item['Registro']], $company->id);

                $log[] = [
                    'origin' => 'CFC',
                    'payload' => json_encode($item),
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
                ];
            }

            RegistrationLog::insert($log);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('[DB][STORE][CFC]: ', ['message' => $e->getMessage()]);
        }
    }

    public function updateFromCNPJWS(array $data)
    {
        $timestamp = Carbon::now();
        try {
            DB::beginTransaction();

            $this->email = $data['estabelecimento']['email'] ?? null;
            $this->phone = $data['estabelecimento']['ddd1'] .  $data['estabelecimento']['telefone1'] ?? null;
            $this->status = $data['estabelecimento']['situacao_cadastral'] == "Ativa" ? true : false;
            $this->save();

            RegistrationLog::insert([
                'origin' => 'CNPJWS',
                'payload' => json_encode($data),
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('[DB][UPDATE][CNPJWS]: ', ['message' => $e->getMessage()]);
        }
    }
}
