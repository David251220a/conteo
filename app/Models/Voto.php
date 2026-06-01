<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voto extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function localMesa()
    {
        return $this->belongsTo(LocalMesa::class, 'local_mesa_id');
    }

    public function lista()
    {
        return $this->belongsTo(Lista::class);
    }

    public function candidato()
    {
        return $this->belongsTo(Candidato::class);
    }

    public function tipo()
    {
        return $this->belongsTo(TipoCantidato::class,'tipo_cantidato_id');
    }

}
