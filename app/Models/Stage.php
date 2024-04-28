<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    protected $fillable = ['name', 'order', 'funnel_id'];

    protected static function booted()
    {
        static::addGlobalScope('order', function ($query) {
            $query->orderBy('order');
        });
    }

    public function funnel()
    {
        return $this->belongsTo(Funnel::class);
    }

    public function deals()
    {
        return $this->hasMany(Deal::class);
    }
}
