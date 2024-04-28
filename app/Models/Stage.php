<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    protected $fillable = ['name', 'order', 'funnel_id'];

    /**
     * Registre um observador para a classe.
     *
     * @return void
     */
    protected static function booted()
    {
        // Adicione a cláusula orderBy por padrão
        static::addGlobalScope('order', function ($query) {
            $query->orderBy('order');
        });
    }

    public function funnel()
    {
        return $this->belongsTo(Funnel::class);
    }
}
