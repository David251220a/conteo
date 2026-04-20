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
}
