<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function estado()
    {
        return $this->belongsTo(Estado::class);
    }

    public function refe()
    {
        return $this->belongsTo(Referente::class, 'referente_id');
    }

    public function vehiculo_local()
    {
        return $this->hasMany(VehiculoLocal::class)->where('estado_id', 1);
    }
}
