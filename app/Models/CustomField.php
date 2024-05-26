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
}
