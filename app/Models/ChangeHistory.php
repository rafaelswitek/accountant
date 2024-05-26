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

    protected $with = [
        'user',
    ];

    protected $casts = [
        'payload' => 'object',
    ];

    protected static function booted()
    {
        static::addGlobalScope('order', function ($query) {
            $query->orderByDesc('created_at');
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function log(string $table, array $old, array $new)
    {
        $changes = [];

        foreach ($new as $key => $value) {
            if (
                array_key_exists($key, $old) &&
                $old[$key] !== $value &&
                $key !== 'updated_at' &&
                $key !== 'photo'
            ) {
                $changes[] = [
                    'field' => $key,
                    'old' => $old[$key],
                    'new' => $value,
                ];
            }
        }

        if (!empty($changes)) {
            ChangeHistory::create([
                'user_id' => auth()->user()->id,
                'table' => $table,
                'payload' => [
                    'id' => $old['id'],
                    'changes' => $changes
                ],
            ]);
        }
    }
}
