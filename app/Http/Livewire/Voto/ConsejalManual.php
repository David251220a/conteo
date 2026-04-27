<?php

namespace App\Http\Livewire\Voto;

use App\Models\Candidato;
use App\Models\General;
use App\Models\Local;
use App\Models\LocalMesa;
use Livewire\Component;

class ConsejalManual extends Component
{
    public $candidatos;
    public $listasCandidatos;
    public $ordenesNormales;
    public $candidatosEspeciales;
    public $votos = [];
    public $locales;
    public $mesas;
    public $general;
    public $local_id;
    public $mesa_id;

    public function mount()
    {
        $this->general = General::find(1);

        $this->cargarLocales();
        $this->cargarMesas();
        $this->cargarCandidatosConcejales();
    }

    public function updatedLocalId()
    {
        $this->cargarMesas();
    }

    public function render()
    {
        return view('livewire.voto.consejal-manual');
    }


    private function cargarLocales()
    {
        $this->locales = Local::where('estado_id', 1)
            ->where('anio', $this->general->anio)
            ->where('tipo_votacion', $this->general->tipo_votacion)
            ->get();

        $this->local_id = $this->locales->first()->id ?? 0;
    }

    private function cargarMesas()
    {
        $this->mesas = LocalMesa::where('estado_id', 1)
        ->where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->where('tipo_cantidato_id', 5)
        ->where('cargado', 0)
        ->where('local_id', $this->local_id)
        ->get();

        $this->mesa_id = $this->mesas->first()->id ?? 0;
    }


    private function cargarCandidatosConcejales()
    {
        $this->candidatos = Candidato::with('lista')
            ->where('candidatos.estado_id', 1)
            ->where('candidatos.anio', $this->general->anio)
            ->where('candidatos.tipo_votacion', $this->general->tipo_votacion)
            ->where('candidatos.tipo_cantidato_id', 5)
            ->join('listas', 'listas.id', '=', 'candidatos.lista_id')
            ->orderBy('listas.orden')
            ->orderBy('candidatos.orden')
            ->select('candidatos.*')
            ->get();

        $this->listasCandidatos = $this->candidatos
            ->where('orden', '<', 97)
            ->groupBy('lista_id');

        $this->ordenesNormales = $this->candidatos
            ->where('orden', '<', 97)
            ->pluck('orden')
            ->unique()
            ->sort()
            ->values();

        $this->candidatosEspeciales = $this->candidatos
            ->whereIn('orden', [97, 98, 99])
            ->sortBy('orden')
            ->values();

        $this->votos = [];

        foreach ($this->candidatos as $item) {
            $this->votos[$item->id] = 0;
        }
    }

    public function subtotalPorLista($listaId)
    {
        return $this->candidatos
            ->where('lista_id', $listaId)
            ->where('orden', '<', 97)
            ->sum(function ($item) {
                return (int) ($this->votos[$item->id] ?? 0);
            });
    }

    public function getTotalVotosProperty()
    {
        return collect($this->votos)->sum();
    }
}
