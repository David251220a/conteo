<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VotoController extends Controller
{
    public function intendente_manual()
    {
        return view('voto.intendente_manual');
    }
}
