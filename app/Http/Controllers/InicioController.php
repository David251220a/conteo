<?php

namespace App\Http\Controllers;

use App\Models\General;
use App\Models\Padron;
use Illuminate\Http\Request;

class InicioController extends Controller
{
    public $general;

    public function __construct()
    {
        $this->general = General::find(1);
    }

    public function index(Request $request)
    {
        $data = Padron::where('documento', $request->documento)
        ->where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->first();
        return view('welcome', compact('data'));
    }
}
