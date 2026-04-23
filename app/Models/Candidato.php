<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidato extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function movimiento()
    {
        return $this->belongsTo(Movimiento::class);
    }

    public function lista()
    {
        return $this->belongsTo(Lista::class);
    }
}
