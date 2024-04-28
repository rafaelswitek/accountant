<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    protected $fillable = ['name', 'stage_id'];

    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }
}
