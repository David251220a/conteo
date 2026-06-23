<?php

namespace App\Http\Controllers;

use App\Models\General;
use App\Models\Local;
use App\Models\Padron;
use App\Models\Referente;
use App\Models\Vehiculo;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConsultaController extends Controller
{
    public $general;

    public function __construct()
    {
        $this->general = General::find(1);
        $this->middleware('permission:consulta.referente')->only('referente');
        $this->middleware('permission:consulta.referentesPorLocal')->only('referentesPorLocal');
        $this->middleware('permission:consulta.resumen')->only('resumen');
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
                $referentes = Referente::where('anio', $this->general->anio)
                ->where('tipo_votacion', $this->general->tipo_votacion)
                ->where('estado_id', 1)
                ->select('id', 'referente')
                ->orderBy('id')
                ->get();
            }
        }else{
            $referentes = Referente::where('anio', $this->general->anio)
            ->where('tipo_votacion', $this->general->tipo_votacion)
            ->where('estado_id', 1)
            ->select('id', 'referente')
            ->orderBy('id')
            ->get();
        }

        if ($request->filled('referente_id') && (int)$request->referente_id > 1){
            $moviles = Vehiculo::where('anio', $this->general->anio)
            ->where('tipo_votacion', $this->general->tipo_votacion)
            ->where('referente_id', $request->referente_id)
            ->select('id', 'nombre')
            ->get();

            $moviles->prepend((object)[
                'id' => 0,
                'nombre' => 'Sin especificar'
            ]);
        }else{
            $moviles = collect([
                (object)[
                    'id' => 0,
                    'nombre' => 'Sin especificar'
                ]
            ]);
        }


        $data = Padron::where('referente_id', '>', 0)->paginate(50);

        if ($request->filled('local_id') || $request->filled('referente_id') || $request->filled('movil_id')) {

            $query = Padron::query()
            ->where('anio', $this->general->anio)
            ->where('tipo_votacion', $this->general->tipo_votacion)
            ->where('estado_id', 1);

            // Si eligió un referente específico, manda el referente
            if ((int)$request->referente_id > 1) {
                $query->where('referente_id', $request->referente_id);
            } else {
                $query->where('referente_id', '>', 1);
            }

            if ((int)$request->local_id > 0) {
                $query->where('local_id', $request->local_id);
            }

            if ((int)$request->movil_id > 0) {
                $query->where('vehiculo_id', $request->movil_id);
            }

            $data = $query->orderBy('apellido')
            ->orderBy('nombre')
            ->paginate(50);
        }
        return view('consulta.referente', compact('locales','referentes','data','moviles'));
    }

    public function referentesPorLocal($localId)
    {
        if ((int)$localId === 0) {
            $data = Referente::select('id', 'referente')
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

    public function referentesMovil($referenteId)
    {
        if ((int)$referenteId > 1){
            $data = Vehiculo::where('anio', $this->general->anio)
            ->where('tipo_votacion', $this->general->tipo_votacion)
            ->where('referente_id', $referenteId)
            ->select('id', 'nombre')
            ->get();

            $data->prepend((object)[
                'id' => 0,
                'nombre' => 'Sin especificar'
            ]);
        }else{
            $data = collect([
                (object)[
                    'id' => 0,
                    'nombre' => 'Sin especificar'
                ]
            ]);
        }

        return response()->json($data);
    }

    public function asginar_movil(Request $request)
    {
        $referente_id = $request->referente_id_aux;
        if(empty($request->referente_id_aux)){
            $referente_id = 1;
        }

        $local_id = $request->local_id_aux;
        if(empty($request->local_id_aux)){
            $local_id = 0;
        }

        $movil_id = $request->movil_id_aux;
        if(empty($request->movil_id_aux)){
            $movil_id = 0;
        }

        if($request->padron_id_aux){
            $padron = Padron::find($request->padron_id_aux);
            $padron->vehiculo_id = $request->aux_movil_id;
            $padron->update();
        }

        return redirect()->route('consulta.referente', ['local_id' => $local_id, 'referente_id' => $referente_id, 'movil_id' => $movil_id]);
    }

    public function referenteImprimir(Request $request)
    {
        $query = Padron::query()
        ->where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->where('estado_id', 1);

        if ((int) $request->referente_id > 1) {
            $query->where('referente_id', $request->referente_id);
        } else {
            $query->where('referente_id', '>', 1);
        }

        if ((int) $request->local_id > 0) {
            $query->where('local_id', $request->local_id);
        }

        $descripcionLocal = Local::find($request->local_id);

        if ((int) $request->movil_id > 0) {
            $query->where('vehiculo_id', $request->movil_id);
        }

        $data = $query->orderBy('apellido')
        ->orderBy('nombre')
        ->get();

        $pdf = Pdf::loadView('consulta.referente_imprimir', [
            'data' => $data,
            'general' => $this->general,
            'descripcionLocal' => $descripcionLocal,
        ])->setPaper('legal', 'landscape');

        return $pdf->stream('voto.pdf');
    }

    public function resumen(Request $request)
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

        $localId = (int) $request->get('local_id', 0);
        $reporte = (int) $request->get('reporte', 1);

        $query = Padron::query()
        ->where('padrons.anio', $this->general->anio)
        ->where('padrons.tipo_votacion', $this->general->tipo_votacion)
        ->where('padrons.estado_id', 1)
        ->where('padrons.referente_id', '>', 1);

        if ($localId > 0) {
            $query->where('padrons.local_id', $localId);
        }

        if ($reporte == 1) {
            $data = $query
            ->join('referentes', 'referentes.id', '=', 'padrons.referente_id')
            ->select(
                'referentes.id',
                'referentes.referente',
                DB::raw('COUNT(*) as total_votantes'),
                DB::raw('COUNT(DISTINCT CASE WHEN padrons.vehiculo_id > 0 THEN padrons.vehiculo_id END) as total_vehiculos')
            )
            ->groupBy('referentes.id', 'referentes.referente')
            ->orderByDesc('total_votantes')
            ->get();
        } else {
            $data = $query
            ->where('padrons.vehiculo_id', '>', 0)
            ->join('vehiculos', 'vehiculos.id', '=', 'padrons.vehiculo_id')
            ->join('referentes', 'referentes.id', '=', 'padrons.referente_id')
            ->select(
                'vehiculos.id',
                'vehiculos.nombre as vehiculo',
                'referentes.referente',
                DB::raw('COUNT(*) as total_votantes')
            )
            ->groupBy('vehiculos.id', 'vehiculos.nombre', 'referentes.referente')
            ->orderBy('referentes.referente')
            ->orderByDesc('total_votantes')
            ->get();
        }

        return view('consulta.resumen', compact('locales', 'data', 'reporte', 'localId'));
    }

    public function resumen_imprimir(Request $request)
    {
        $localId = (int) $request->get('local_id', 0);
        $reporte = (int) $request->get('reporte', 1);

        if ($localId <> 0){
            $descripcionLocal = Local::find($localId);
        }


        $query = Padron::query()
        ->where('padrons.anio', $this->general->anio)
        ->where('padrons.tipo_votacion', $this->general->tipo_votacion)
        ->where('padrons.estado_id', 1)
        ->where('padrons.referente_id', '>', 1);

        if ($localId > 0) {
            $query->where('padrons.local_id', $localId);
        }

        if ($reporte == 1) {

            $data = $query
                ->join('referentes', 'referentes.id', '=', 'padrons.referente_id')
                ->select(
                    'referentes.id',
                    'referentes.referente',
                    DB::raw('COUNT(*) as total_votantes'),
                    DB::raw('COUNT(DISTINCT CASE WHEN padrons.vehiculo_id > 0 THEN padrons.vehiculo_id END) as total_vehiculos')
                )
                ->groupBy('referentes.id', 'referentes.referente')
                ->orderByDesc('total_votantes')
                ->get();

        } else {

            $data = $query
                ->where('padrons.vehiculo_id', '>', 0)
                ->join('vehiculos', 'vehiculos.id', '=', 'padrons.vehiculo_id')
                ->join('referentes', 'referentes.id', '=', 'padrons.referente_id')
                ->select(
                    'vehiculos.id',
                    'vehiculos.nombre as vehiculo',
                    'referentes.referente',
                    DB::raw('COUNT(*) as total_votantes')
                )
                ->groupBy('vehiculos.id', 'vehiculos.nombre', 'referentes.referente')
                ->orderBy('referentes.referente')
                ->orderByDesc('total_votantes')
                ->get();
        }

        $local = null;

        if ($localId > 0) {
            $local = Local::find($localId);
        }

        $pdf = Pdf::loadView('consulta.resumen_imprimir', [
            'data'     => $data,
            'reporte'  => $reporte,
            'local'    => $local,
            'general'  => $this->general,
            'descripcionLocal' => $descripcionLocal
        ])->setPaper('a4', 'portrait');

        return $pdf->stream('Resumen.pdf');
    }

}
