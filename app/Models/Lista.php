<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lista extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function movimiento()
    {
        return $this->belongsTo(Movimiento::class);
    }

    public function tipo_candidato()
    {
        return $this->belongsTo(TipoCantidato::class, 'tipo_cantidato_id');
    }
}
