<?php

namespace App\Http\Controllers;

use App\Models\Candidato;
use App\Models\General;
use App\Models\Lista;
use App\Models\Movimiento;
use App\Models\TipoCantidato;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;

class CandidatoController extends Controller
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

        $data = Candidato::where('estado_id', 1)
        ->where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->whereBetween('movimiento_id', [$desde, $hasta])
        ->where('tipo_cantidato_id', $tipo_candidato_id)
        ->get();

        return view('candidato.index', compact('tipo_candidato_id','movimientos','tipoCandidato', 'data'));

    }

    public function create()
    {
        $tipoCandidato = $this->filtro_tipo_candidato();
        $listas = Lista::where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->where('estado_id', 1)
        ->get();
        return view('candidato.create', compact('listas','tipoCandidato'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'orden' => 'required',
            'imagen' => 'file|mimes:jpg,jpeg'
        ]);

        $lista = Lista::find($request->lista_id);
        $filepath = '';
        if($request->imagen){
            $filepath = $request->imagen->store('candidato', 'public');
        }

        Candidato::create([
            'movimiento_id' => $lista->movimiento_id,
            'tipo_cantidato_id' => $request->tipo_candidato_id,
            'lista_id' => $lista->id,
            'nombre' => mb_strtoupper($request->nombre, 'UTF-8'),
            'orden' => $request->orden,
            'imagen' => $filepath,
            'anio' => $this->general->anio,
            'tipo_votacion' => $this->general->tipo_votacion,
            'estado_id' => 1,
            'user_id' => auth()->id()
        ]);

        return redirect()->route('candidato.index')->with('message', 'Candidato creado correctamente.');
    }

    public function edit(Candidato $candidato)
    {
        $data = $candidato;
        $tipoCandidato = $this->filtro_tipo_candidato();
        $listas = Lista::where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->where('estado_id', 1)
        ->get();
        return view('candidato.edit', compact('data','listas','tipoCandidato'));
    }

    public function update(Candidato $candidato, Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'orden' => 'required',
            'imagen' => 'file|mimes:jpg,jpeg'
        ]);

        $lista = Lista::find($request->lista_id);
        $filepath = $candidato->imagen;
        if($request->imagen){
            $filepath = $request->imagen->store('candidato', 'public');
        }

        $candidato->update([
            'movimiento_id' => $lista->movimiento_id,
            'tipo_cantidato_id' => $request->tipo_candidato_id,
            'lista_id' => $lista->id,
            'nombre' => mb_strtoupper($request->nombre, 'UTF-8'),
            'orden' => $request->orden,
            'imagen' => $filepath,
            'anio' => $this->general->anio,
            'tipo_votacion' => $this->general->tipo_votacion,
            'estado_id' => $request->estado_id,
            'user_id' => auth()->id()
        ]);

        return redirect()->route('candidato.index')->with('message', 'Candidato editado correctamente.');
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
            $data = TipoCantidato::whereIn('id', [1, 2, 3, 4, 5])->orderBy('orden')->get();
        }

        if($this->general->tipo_votacion == 2){
            $data = TipoCantidato::whereIn('id', [1, 2, 3, 4, 5])->orderBy('orden')->get();
        }

        if($this->general->tipo_votacion == 3){
            $data = TipoCantidato::whereNotIn('id', [4, 5])->orderBy('orden')->get();
        }

        if($this->general->tipo_votacion == 4){
            $data = TipoCantidato::whereNotIn('id', [4, 5])->orderBy('orden')->get();
        }

        return $data;
    }
}
