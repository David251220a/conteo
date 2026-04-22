<?php

namespace App\Http\Controllers;

use App\Models\General;
use App\Models\Lista;
use App\Models\Movimiento;
use App\Models\TipoCantidato;
use Illuminate\Http\Request;

class ListaController extends Controller
{
    public $general;

    public function __construct()
    {
        $this->general = General::find(1);
    }

    public function index(Request $request)
    {
        $tipoCandidato = $this->filtro_tipo_candidato();
        $tipo_candidato_id = $this->primer_filtro();
        $movimientos = Movimiento::all();
        if ($request->tipo_candidato_id)
        {
            $tipo_candidato_id = $request->tipo_candidato_id;
        }

        $desde = 1;
        $hasta = 999;
        if($request->movimiento_id){
            $desde = $request->movimiento_id;
            $hasta = $request->movimiento_id;
        }

        $data = Lista::where('estado_id', 1)
        ->where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->where('tipo_cantidato_id', $tipo_candidato_id)
        ->whereBetween('movimiento_id', [$desde, $hasta])
        ->get();

        return view('lista.index', compact('data','tipoCandidato', 'tipo_candidato_id', 'movimientos'));
    }

    public function create()
    {
        $tipoCandidato = $this->filtro_tipo_candidato();
        $movimientos = Movimiento::all();
        return view('lista.create', compact('tipoCandidato', 'movimientos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lista' => 'required',
            'orden' => 'required',
            'opcion' => 'required'
        ]);

        $existe = Lista::where('estado_id', 1)
        ->where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->where('tipo_cantidato_id', $request->tipo_candidato_id)
        ->where('movimiento_id', $request->movimiento_id)
        ->where('descripcion', $request->lista)
        ->first();

        if($existe){
            return redirect()->back()->withErrors('Ya existe lista.');
        }

        Lista::create([
            'movimiento_id' => $request->movimiento_id,
            'tipo_cantidato_id' => $request->tipo_candidato_id,
            'descripcion' => $request->lista,
            'opcion' => $request->opcion,
            'orden' => $request->orden,
            'anio' => $this->general->anio,
            'tipo_votacion' => $this->general->tipo_votacion,
            'estado_id' => 1,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('lista.index')->with('message', 'Lista creado correctamente.');

    }

    public function edit(Lista $lista)
    {
        $tipoCandidato = $this->filtro_tipo_candidato();
        $movimientos = Movimiento::all();
        $data = $lista;
        return view('lista.edit', compact('tipoCandidato','movimientos','data'));
    }

    public function update(Lista $lista, Request $request)
    {
        $request->validate([
            'lista' => 'required',
            'orden' => 'required',
            'opcion' => 'required'
        ]);

        $existe = Lista::where('estado_id', 1)
        ->where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->where('tipo_cantidato_id', $request->tipo_candidato_id)
        ->where('movimiento_id', $request->movimiento_id)
        ->where('descripcion', $request->lista)
        ->where('id', '<>', $lista->id)
        ->first();

        if($existe){
            return redirect()->back()->withErrors('Ya existe lista.');
        }

        $lista->update([
            'movimiento_id' => $request->movimiento_id,
            'tipo_cantidato_id' => $request->tipo_candidato_id,
            'descripcion' => $request->lista,
            'opcion' => $request->opcion,
            'orden' => $request->orden,
            'anio' => $this->general->anio,
            'tipo_votacion' => $this->general->tipo_votacion,
            'estado_id' => $request->estado_id,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('lista.index')->with('message', 'Lista editado correctamente.');
    }

    private function primer_filtro()
    {
        return match ($this->general->tipo_votacion) {
            1, 2 => 4,
            3, 4 => 6,
            default => 0,
        };
    }

    private function filtro_tipo_candidato()
    {
        $data = [];
        if($this->general->tipo_votacion == 1){
            $data = TipoCantidato::whereIn('id', [1, 2, 3, 4, 5])->get();
        }

        if($this->general->tipo_votacion == 2){
            $data = TipoCantidato::whereIn('id', [1, 2, 3, 4, 5])->get();
        }

        if($this->general->tipo_votacion == 3){
            $data = TipoCantidato::whereNotIn('id', [4, 5])->get();
        }

        if($this->general->tipo_votacion == 4){
            $data = TipoCantidato::whereNotIn('id', [4, 5])->get();
        }

        return $data;
    }
}
