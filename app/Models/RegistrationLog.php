<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistrationLog extends Model
{
    protected $fillable = [
        'origin',
        'payload',
    ];

    protected $casts = [
        'payload' => 'object',
    ];

    public $timestamps = true;
}
