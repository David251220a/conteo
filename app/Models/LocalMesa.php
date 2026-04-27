<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocalMesa extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function local()
    {
        return $this->belongsTo(Local::class);
    }

    public function votos()
    {
        return $this->hasMany(Voto::class, 'local_mesa_id')->where('estado_id', 1);
    }
}
