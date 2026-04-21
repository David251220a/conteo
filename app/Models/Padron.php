<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Padron extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function local()
    {
        return $this->belongsTo(Local::class);
    }


    public function padronConsulta()
    {
        return $this->hasMany(PadronConsulta::class);
    }

    public function refe()
    {
        return $this->belongsTo(Referente::class, 'referente_id');
    }

    public function Vehiculo()
    {
        return $this->belongsTo(Vehiculo::class, 'vehiculo_id');
    }

}
