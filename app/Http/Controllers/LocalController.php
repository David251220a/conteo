<?php

namespace App\Http\Controllers;

use App\Models\General;
use App\Models\Local;
use App\Models\LocalMesa;
use App\Models\TipoCantidato;
use App\Models\Voto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function generar_mesas(Local $local)
    {
        $existeVoto = Voto::where('estado_id', 1)
        ->where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->where('local_id', $local->id)
        ->exists();

        if ($existeVoto) {
            return back()->withErrors('No se puede regenerar las mesas porque ya existen votos cargados en este local.');
        }

        DB::transaction(function () use ($local) {

            LocalMesa::where('estado_id', 1)
            ->where('anio', $this->general->anio)
            ->where('tipo_votacion', $this->general->tipo_votacion)
            ->where('local_id', $local->id)
            ->update(['estado_id' => 2]);

            $tipo = $this->filtro_tipo_candidato();
            foreach ($tipo as $item) {
                for ($i=1; $i <= $local->total_mesas; $i++) {
                    LocalMesa::create([
                        'local_id' => $local->id,
                        'tipo_cantidato_id' => $item->id,
                        'mesa' => $i,
                        'cargado' => 0,
                        'anio' => $this->general->anio,
                        'tipo_votacion' => $this->general->tipo_votacion,
                        'estado_id' => 1,
                        'user_id' => auth()->id()
                    ]);
                }
            }

        });

        return redirect()->route('local.index')->with('message', 'Mesas generadas correctamente.');
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
