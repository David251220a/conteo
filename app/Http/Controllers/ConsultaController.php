<?php

namespace App\Http\Controllers;

use App\Models\General;
use App\Models\Local;
use App\Models\Padron;
use App\Models\Referente;
use Illuminate\Http\Request;

class ConsultaController extends Controller
{
    public $general;

    public function __construct()
    {
        $this->general = General::find(1);
    }

    public function referente(Request $request)
    {
        $locales = Local::where('estado_id', 1)
        ->where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->select('id', 'descripcion')
        ->get();

        $locales->prepend((object)[
            'id' => 0,
            'descripcion' => 'Sin especificar'
        ]);

        if ($request->filled('local_id')){
            if ((int)$request->local_id > 0) {
                $referentes = Referente::where('estado_id', 1)
                ->where('anio', $this->general->anio)
                ->where('tipo_votacion', $this->general->tipo_votacion)
                ->where('local_id', $request->local_id)
                ->orWhere('id', 1)
                ->select('id', 'referente')
                ->orderBy('id')
                ->get();
            }else{
                $referentes = Referente::where('local_id', 0)
                ->select('id', 'referente')
                ->orderBy('id')
                ->get();
            }
        }else{
            $referentes = Referente::where('local_id', 0)
            ->select('id', 'referente')
            ->orderBy('id')
            ->get();
        }

        $data = Padron::where('referente_id', '>', 0)->paginate(50);

        if ($request->filled('local_id') || $request->filled('referente_id')) {

            $query = Padron::query()
            ->where('anio', $this->general->anio)
            ->where('tipo_votacion', $this->general->tipo_votacion)
            ->where('estado_id', 1);

            // Si eligió un referente específico, manda el referente
            if ((int)$request->referente_id > 1) {
                $query->where('referente_id', $request->referente_id);
            } else {
                // Si no eligió referente, entonces filtra por local
                if ((int)$request->local_id > 0) {
                    $query->where('local_id', $request->local_id)
                    ->where('referente_id', '>', 0);
                }
            }

            $data = $query->orderBy('apellido')
            ->orderBy('nombre')
            ->paginate(50);
        }
        return view('consulta.referente', compact('locales','referentes','data'));
    }

    public function referentesPorLocal($localId)
    {
        if ((int)$localId === 0) {
            $data = Referente::where('local_id', 0)
            ->select('id', 'referente')
            ->get();
            return response()->json($data);
        }

        $referentes = Referente::where('estado_id', 1)
        ->where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->where('local_id', $localId)
        ->select('id', 'referente')
        ->orderBy('referente')
        ->get();

        $data = collect([
            [
                'id' => 1,
                'referente' => 'Sin especificar'
            ]
        ])->merge($referentes->toArray())->values();

        return response()->json($data);
    }
}
