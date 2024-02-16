<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accountant extends Model
{
    protected $fillable = [
        'name',
        'cpf',
        'registry',
        'cfc',
    ];

    protected $casts = [
        'status' => 'boolean'
    ];

    public static function storeFromCFC(array $data)
    {
        foreach ($data as $item) {
            $accountant = new Accountant();
            $accountant->name = $item['campo1'];
            $accountant->cpf = $item['campo2'];
            $accountant->registry = $item['campo2'];
            $accountant->cfc = $item;

            $accountant->save();
        }
    }
}
