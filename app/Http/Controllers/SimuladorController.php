<?php

namespace App\Http\Controllers;

use App\Models\General;
use App\Models\Simulacion;
use App\Models\TipoCantidato;
use Illuminate\Http\Request;

class SimuladorController extends Controller
{
    public $general;

    public function __construct()
    {
        $this->general = General::find(1);
        $this->middleware('permission:consulta.simulacion')->only('simulacion');
        $this->middleware('permission:consulta.simulacion_ver')->only('simulacion_ver');
    }

    public function simulacion()
    {
        $data = Simulacion::where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->select('fecha')
        ->groupBy('fecha')
        ->orderBy('fecha', 'DESC')
        ->get();
        return view('simulador.index', compact('data'));
    }

    public function simulacion_ver($fecha, Request $request)
    {
        $tipo_candidato_id = 4;
        if($request->tipo_candidato_id){
            $tipo_candidato_id = $request->tipo_candidato_id;
        }

        $tipoCandidato = $this->filtro_tipo_candidato();

        $data = Simulacion::where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->where('fecha', $fecha)
        ->where('tipo_cantidato_id', $tipo_candidato_id)
        ->selectRaw('candidato_id, lista_id, movimiento_id, COUNT(*) as cantidad')
        ->groupBy('candidato_id', 'lista_id', 'movimiento_id')
        ->orderByDesc('cantidad')
        ->get();

        return view('simulador.show', compact('data','tipoCandidato', 'tipo_candidato_id','fecha'));
    }

    private function filtro_tipo_candidato()
    {
        $data = [];
        if($this->general->tipo_votacion == 1){
            $data = TipoCantidato::whereIn('id', [4, 5])->orderBy('orden')->get();
        }

        if($this->general->tipo_votacion == 2){
            $data = TipoCantidato::whereIn('id', [4, 5])->orderBy('orden')->get();
        }

        if($this->general->tipo_votacion == 3){
            $data = TipoCantidato::whereNotIn('id', [1, 2, 3, 4, 5])->orderBy('orden')->get();
        }

        if($this->general->tipo_votacion == 4){
            $data = TipoCantidato::whereNotIn('id', [1, 2, 3, 4, 5])->orderBy('orden')->get();
        }

        return $data;
    }
}
