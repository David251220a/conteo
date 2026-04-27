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

}
