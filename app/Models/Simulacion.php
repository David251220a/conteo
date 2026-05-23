<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Simulacion extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function lista()
    {
        return $this->belongsTo(Lista::class);
    }

    public function candidato()
    {
        return $this->belongsTo(Candidato::class);
    }
}
