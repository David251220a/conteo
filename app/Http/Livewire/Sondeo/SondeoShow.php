<?php

namespace App\Http\Livewire\Sondeo;

use App\Models\General;
use App\Models\Lista;
use App\Models\Local;
use App\Models\Urna;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class SondeoShow extends Component
{
    public $tipo = 1;
    public $tipo_candidato_id = 4;
    public $local_id = 0;
    public $lista_id = 0;
    public $locales;
    public $listas;
    public $general;

    public function mount()
    {
        $this->general = General::find(1);
        $this->locales = Local::where('tipo_votacion', $this->general->tipo_votacion)
        ->where('anio', $this->general->anio)
        ->where('estado_id', 1)
        ->get();
        $this->listas = Lista::where('tipo_votacion', $this->general->tipo_votacion)
        ->where('anio', $this->general->anio)
        ->where('estado_id', 1)
        ->get();
    }


    public function render()
    {
        $query = Urna::query()
        ->join('candidatos', 'candidatos.id', '=', 'urnas.candidato_id')
        ->join('listas', 'listas.id', '=', 'urnas.lista_id')
        ->leftJoin('locals', 'locals.id', '=', 'urnas.local_id')
        ->where('urnas.anio', $this->general->anio)
        ->where('urnas.tipo_votacion', $this->general->tipo_votacion)
        ->where('urnas.tipo_cantidato_id', $this->tipo_candidato_id);

        if($this->tipo == 2){
            if ($this->local_id != 0) {
                $query->where('urnas.local_id', $this->local_id);
            }
        }

        if($this->tipo == 3){
            if ($this->lista_id != 0) {
                $query->where('urnas.lista_id', $this->lista_id);
            }
        }






        if ($this->tipo == 1) {
            // GENERAL POR CANDIDATO
            $data = $query
            ->select(
                'candidatos.id',
                'candidatos.nombre',
                'listas.descripcion as lista',
                DB::raw('COUNT(*) as total_votos')
            )
            ->groupBy('candidatos.id', 'candidatos.nombre', 'listas.descripcion')
            ->orderByDesc('total_votos')
            ->get();
        } elseif ($this->tipo == 2) {
            // POR LOCAL
            $data = $query
            ->select(
                'locals.descripcion as local',
                'candidatos.id',
                'candidatos.nombre',
                'listas.descripcion as lista',
                DB::raw('COUNT(*) as total_votos')
            )
            ->groupBy('locals.descripcion', 'candidatos.id', 'candidatos.nombre', 'listas.descripcion')
            ->orderBy('locals.descripcion')
            ->orderByDesc('total_votos')
            ->get();
        } else {
            // POR LISTA
            $data = $query
            ->select(
                'listas.id',
                'listas.descripcion as lista',
                DB::raw('COUNT(*) as total_votos')
            )
            ->groupBy('listas.id', 'listas.descripcion')
            ->orderByDesc('total_votos')
            ->get();
        }
        // dd($data);
        return view('livewire.sondeo.sondeo-show', [
            'data' => $data,
        ]);
    }

}
