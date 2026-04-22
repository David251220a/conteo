<?php

namespace App\Http\Controllers;

use App\Models\General;
use App\Models\Local;
use Illuminate\Http\Request;

class LocalController extends Controller
{
    public $general;

    public function __construct()
    {
        $this->general = General::find(1);
    }

    public function index()
    {
        $data = Local::where('estado_id', 1)
        ->where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->get();

        return view('local.index', compact('data'));
    }

    public function create()
    {
        return view('local.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required',
            'orden' => 'required',
            'total_mesas' => 'required'
        ]);

        Local::create([
            'descripcion' => mb_strtoupper($request->descripcion, 'UTF-8'),
            'total_mesas' => $request->total_mesas,
            'orden' => $request->orden,
            'anio' => $this->general->anio,
            'tipo_votacion' => $this->general->tipo_votacion,
            'estado_id' => 1,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('local.index')->with('message', 'Local creado correctamente.');

    }

    public function edit(Local $local)
    {
        $data = $local;
        return view('local.edit', compact('data'));
    }

    public function update(Local $local, Request $request)
    {
        $request->validate([
            'descripcion' => 'required',
            'orden' => 'required',
            'total_mesas' => 'required'
        ]);

        $local->update([
            'descripcion' => mb_strtoupper($request->descripcion, 'UTF-8'),
            'total_mesas' => $request->total_mesas,
            'orden' => $request->orden,
            'anio' => $this->general->anio,
            'tipo_votacion' => $this->general->tipo_votacion,
            'estado_id' => $request->estado_id,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('local.index')->with('message', 'Local editado correctamente.');
    }
}
