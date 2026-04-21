<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referente extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function estado()
    {
        return $this->belongsTo(Estado::class);
    }

    public function local()
    {
        return $this->belongsTo(Local::class)->withDefault([
            'id' => 0,
            'descripcion' => 'Sin especificar'
        ]);
    }
}
