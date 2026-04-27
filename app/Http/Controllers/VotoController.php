<?php

namespace App\Http\Controllers;

use App\Models\General;
use App\Models\Local;
use App\Models\LocalMesa;
use App\Models\TipoCantidato;
use App\Models\Voto;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VotoController extends Controller
{
    public $general;

    public function __construct()
    {
        $this->general = General::find(1);
    }

    public function intendente_manual()
    {
        return view('voto.intendente_manual');
    }

    public function consejal_manual()
    {
        return view('voto.consejal_manual');
    }

    public function consulta_votos_carga(Request $request)
    {

        $tipoCandidato = $this->filtro_tipo_candidato_segundo();
        $tipo_candidato_id = $this->primer_filtro();
        if ($request->tipo_candidato_id)
        {
            $tipo_candidato_id = $request->tipo_candidato_id;
        }
        $locales = Local::where('estado_id', 1)
        ->where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->get();

        $query = LocalMesa::where('estado_id', 1)
        ->where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->where('tipo_cantidato_id', $tipo_candidato_id)
        ->where('cargado', 1);

        if ($request->filled('local_id') && $request->local_id <> 0) {
            $query->where('local_id', $request->local_id);
        }

        $query->withSum(['votos as total_votos' => function ($q) {
            $q->where('estado_id', 1);
        }], 'votos');

        $data = $query
        ->orderBy('local_id')
        ->orderBy('mesa')
        ->paginate(50)
        ->appends($request->query());

        $totalGeneral = Voto::where('estado_id', 1)
        ->where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->where('tipo_cantidato_id', $tipo_candidato_id)
        ->when($request->filled('local_id') && $request->local_id != 0, function ($q) use ($request) {
            $q->where('local_id', $request->local_id);
        })
        ->sum('votos');

        return view('voto.consulta_votos_carga', compact('tipoCandidato','tipo_candidato_id','locales','data','totalGeneral'));
    }

    public function consulta_lista(Request $request)
    {
        $tipoCandidato = $this->filtro_tipo_candidato_segundo();
        $tipo_candidato_id = $this->primer_filtro();
        if ($request->tipo_candidato_id)
        {
            $tipo_candidato_id = $request->tipo_candidato_id;
        }

        $local_id = $request->local_id != 0 ? $request->local_id : null;
        $tipo_reporte = $request->tipo_reporte ?? 'general';

        $locales = Local::where('estado_id', 1)
        ->where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->get();

        $query = Voto::query()
        ->join('candidatos', 'candidatos.id', '=', 'votos.candidato_id')
        ->join('listas', 'listas.id', '=', 'candidatos.lista_id')
        ->join('locals', 'locals.id', '=', 'votos.local_id')
        ->where('votos.estado_id', 1)
        ->where('votos.anio', $this->general->anio)
        ->where('votos.tipo_votacion', $this->general->tipo_votacion)
        ->where('votos.tipo_cantidato_id', $tipo_candidato_id)
        ->when($local_id, function ($query) use ($local_id) {
            $query->where('votos.local_id', $local_id);
        });

        if ($tipo_reporte == 'general') {
            $data = $query
            ->select(
                'candidatos.id',
                'candidatos.nombre',
                'listas.descripcion as lista',
                DB::raw('SUM(votos.votos) as total_votos')
            )
            ->groupBy(
                'candidatos.id',
                'candidatos.nombre',
                'listas.descripcion'
            )
            ->orderByDesc('total_votos', 'DESC')
            ->get();
        }

        if ($tipo_reporte == 'local') {
            $data = $query
            ->select(
                'locals.descripcion as local',
                'candidatos.id',
                'candidatos.nombre',
                'listas.descripcion as lista',
                DB::raw('SUM(votos.votos) as total_votos')
            )
            ->groupBy(
                'locals.descripcion',
                'candidatos.id',
                'candidatos.nombre',
                'listas.descripcion'
            )
            ->orderBy('locals.descripcion')
            ->orderByDesc('total_votos', 'DESC')
            ->get();
        }

        if ($tipo_reporte == 'mesa') {
            $data = $query
                ->select(
                    'locals.descripcion as local',
                    'votos.mesa',
                    'candidatos.id',
                    'candidatos.nombre',
                    'listas.descripcion as lista',
                    DB::raw('SUM(votos.votos) as total_votos')
                )
                ->groupBy(
                    'locals.descripcion',
                    'votos.mesa',
                    'candidatos.id',
                    'candidatos.nombre',
                    'listas.descripcion'
                )
                ->orderBy('locals.descripcion')
                ->orderBy('votos.mesa')
                ->orderByDesc('total_votos', 'DESC')
                ->get();
        }

        if ($tipo_reporte == 'lista') {
            $data = $query
                ->select(
                    'listas.id',
                    'listas.descripcion as lista',
                    DB::raw('SUM(votos.votos) as total_votos')
                )
                ->groupBy(
                    'listas.id',
                    'listas.descripcion'
                )
                ->orderByDesc('total_votos')
                ->get();
        }

        $totalGeneral = 0;
        return view('voto.consulta_lista', compact('tipo_candidato_id', 'tipoCandidato', 'locales','data'));
    }

    public function consulta_pdf(LocalMesa $localMesa)
    {
        $data = Voto::where('estado_id', 1)
        ->where('local_mesa_id', $localMesa->id)
        ->get();


        return view('voto.consulta_pdf');
    }

    public function reporte(Request $request)
    {
        $datos = $this->getDataConsulta($request);
        $pdf = Pdf::loadView('voto.reporte', array_merge($datos, [
            'general' => $this->general,
        ]));

        return $pdf->stream('voto.reporte');
    }

    private function getDataConsulta($request)
    {
        $tipoCandidato = $this->filtro_tipo_candidato_segundo();

        $tipo_candidato_id = $this->primer_filtro();

        if ($request->tipo_candidato_id) {
            $tipo_candidato_id = $request->tipo_candidato_id;
        }

        $local_id = $request->local_id != 0 ? $request->local_id : null;
        $tipo_reporte = $request->tipo_reporte ?? 'general';
        $query = Voto::query()
        ->join('candidatos', 'candidatos.id', '=', 'votos.candidato_id')
        ->join('listas', 'listas.id', '=', 'candidatos.lista_id')
        ->join('locals', 'locals.id', '=', 'votos.local_id')
        ->where('votos.estado_id', 1)
        ->where('votos.anio', $this->general->anio)
        ->where('votos.tipo_votacion', $this->general->tipo_votacion)
        ->where('votos.tipo_cantidato_id', $tipo_candidato_id)
        ->when($local_id, fn($q) => $q->where('votos.local_id', $local_id));

        if ($tipo_reporte == 'general') {
            $data = $query->select(
                'candidatos.id',
                'candidatos.nombre',
                'listas.descripcion as lista',
                DB::raw('SUM(votos.votos) as total_votos')
            )
            ->groupBy('candidatos.id', 'candidatos.nombre', 'listas.descripcion')
            ->orderByDesc('total_votos')
            ->get();
        }

        if ($tipo_reporte == 'local') {
            $data = $query->select(
                'locals.descripcion as local',
                'candidatos.nombre',
                'listas.descripcion as lista',
                DB::raw('SUM(votos.votos) as total_votos')
            )
            ->groupBy('locals.descripcion','candidatos.nombre','listas.descripcion')
            ->orderBy('locals.descripcion')
            ->orderByDesc('total_votos')
            ->get();
        }

        if ($tipo_reporte == 'mesa') {
            $data = $query->select(
                'locals.descripcion as local',
                'votos.mesa',
                'candidatos.nombre',
                'listas.descripcion as lista',
                DB::raw('SUM(votos.votos) as total_votos')
            )
            ->groupBy('locals.descripcion','votos.mesa','candidatos.nombre','listas.descripcion')
            ->orderBy('locals.descripcion')
            ->orderBy('votos.mesa')
            ->orderByDesc('total_votos')
            ->get();
        }

        if ($tipo_reporte == 'lista') {
            $data = $query->select(
                'listas.descripcion as lista',
                DB::raw('SUM(votos.votos) as total_votos')
            )
            ->groupBy('listas.descripcion')
            ->orderByDesc('total_votos')
            ->get();
        }

        $local_descripcion = $local_id
        ? Local::find($local_id)?->descripcion
        : 'TODOS';

        $tipo_candidato_descripcion = $tipoCandidato
        ->where('id', $tipo_candidato_id)
        ->first()?->descripcion;

        return compact(
            'data',
            'tipo_reporte',
            'tipo_candidato_id',
            'local_id',
            'tipoCandidato',
            'local_descripcion',
            'tipo_candidato_descripcion'
        );
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

    private function filtro_tipo_candidato_segundo()
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
