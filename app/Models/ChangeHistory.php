<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChangeHistory extends Model
{
    protected $table = 'change_history';

    protected $fillable = [
        'user_id',
        'table',
        'payload',
    ];

    public $timestamps = true;

    public static function log(string $table, array $original, array $new)
    {
        $changes = [];

        foreach ($new as $key => $value) {
            if (
                array_key_exists($key, $original) &&
                $original[$key] !== $value &&
                $key !== 'updated_at'
            ) {
                $changes[] = [
                    'field' => $key,
                    'old' => $original[$key],
                    'new' => $value,
                ];
            }
        }

        if (!empty($changes)) {
            ChangeHistory::create([
                'user_id' => auth()->user()->id,
                'table' => $table,
                'payload' => json_encode([
                    'id' => $original['id'],
                    'changes' => $changes
                ]),
            ]);
        }
    }
}
