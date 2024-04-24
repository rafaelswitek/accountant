<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomFieldValue extends Model
{
    protected $fillable = [
        'field_id',
        'company_id',
        'person_id',
        'info',
    ];

    protected $casts = [
        'info' => 'object'
    ];

    protected $with = [
        'fields',
    ];

    public $timestamps = true;

    public function fields()
    {
        return $this->belongsTo(CustomField::class, 'field_id');
    }
}
