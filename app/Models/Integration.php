<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Integration extends Model
{
    protected $fillable = [
        'source',
        'payload',
    ];

    protected $casts = [
        'payload' => 'object',
        'payload.user' => 'object',
    ];

    public $timestamps = true;
}
