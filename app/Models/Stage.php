<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    protected $fillable = ['name', 'order', 'funnel_id'];

    public function funnel()
    {
        return $this->belongsTo(Funnel::class);
    }
}
