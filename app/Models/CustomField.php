<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomField extends Model
{
    protected $fillable = [
        'info',
    ];

    protected $casts = [
        'info' => 'object'
    ];

    public $timestamps = true;

    public function values()
    {
        return $this->hasOne(CustomFieldValue::class, 'field_id');
    }
}
