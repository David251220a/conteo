<?php

namespace App\Http\Controllers;

use App\Models\Candidato;
use App\Models\General;
use App\Models\Lista;
use App\Models\Movimiento;
use App\Models\TipoCantidato;
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

        return view('candidato.index', compact('tipo_candidato_id','movimientos','tipoCandidato'));

    }

    public function create()
    {
        $listas = Lista::where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->where('estado_id', 1)
        ->get();
        return view('candidato.create', compact('listas'));
    }

    public function store()
    {

    }

    public function edit()
    {

    }

    public function update(Candidato $candidato)
    {

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
