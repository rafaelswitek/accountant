<?php

namespace App\Models;

use App\Helpers\Number;
use App\Helpers\Text;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Company extends Model
{
    protected $fillable = [
        'document',
        'name',
        'trade',
        'phone',
        'email',
        'openingData',
        'status',
        'keys',
        'origin',
        'photo',
    ];

    protected $casts = [
        'status' => 'boolean'
    ];

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
}
