<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Local extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function local_mesas()
    {
        return $this->belongsTo(LocalMesa::class);
    }

    public function mesasActivas()
    {
        $general = General::first();

        return $this->hasMany(LocalMesa::class)
        ->where('anio', $general->anio)
        ->where('tipo_votacion', $general->tipo_votacion)
        ->where('estado_id', 1);
    }
}
