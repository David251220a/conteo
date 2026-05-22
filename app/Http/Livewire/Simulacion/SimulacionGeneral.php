<?php

namespace App\Http\Livewire\Simulacion;

use App\Models\Candidato;
use App\Models\General;
use App\Models\Lista;
use Livewire\Component;

class SimulacionGeneral extends Component
{

    public $general;
    public $intendente;
    public $consejales;
    public $paso;
    public $intendente_id;
    public $consejal_id;
    public $listas;
    public $titulo;
    public $intendenteSeleccionado;
    public $concejalSeleccionado;
    public $modo = 1;
    public $dato;

    public function mount()
    {
        $this->general = General::find(1);

        $this->intendente = Candidato::query()
        ->join('listas', 'listas.id', '=', 'candidatos.lista_id')
        ->where('candidatos.anio', $this->general->anio)
        ->where('candidatos.tipo_votacion', $this->general->tipo_votacion)
        ->where('candidatos.estado_id', 1)
        ->where('candidatos.tipo_cantidato_id', 4)
        ->whereNotIn('candidatos.orden', [97,99])
        ->orderBy('listas.orden')
        ->orderBy('candidatos.orden')
        ->select('candidatos.*')
        ->get();

        $this->dato = Candidato::find(1);
        $this->modo = 1;

        $this->restablecer();
    }

    public function render()
    {
        return view('livewire.simulacion.simulacion-general');
    }

    public function restablecer()
    {
        $this->reset('intendente_id');
        $this->reset('consejal_id');
        $this->paso = 1;
        $this->modo = 1;
        $this->reset('intendenteSeleccionado');
        $this->reset('concejalSeleccionado');
        $this->titulo = 'Candidatos a INTENDENTE MUNICIPAL';
    }

    public function seleccionarIntendente($id, $modo)
    {
        $this->intendente_id = $id;
        $this->modo = $modo;
        if ($modo == 1) {
            $this->listas = Lista::where('anio', $this->general->anio)
            ->where('tipo_votacion', $this->general->tipo_votacion)
            ->whereNotIn('orden', [97,99])
            ->get();
            $this->titulo = 'Listas participantes al cargo de CONSEJAL';
            $this->paso = 2;
        } else {
            $this->titulo = 'OPCIONES SELECCIONADAS';
            $this->paso = 4;
            $this->intendenteSeleccionado = Candidato::find($this->intendente_id);
            $this->concejalSeleccionado = Candidato::find($this->consejal_id);
        }


    }

    public function seleccionarLista($id, $orden)
    {
        if ($orden < 90) {
            $this->consejales = Candidato::query()
            ->join('listas', 'listas.id', '=', 'candidatos.lista_id')
            ->where('candidatos.anio', $this->general->anio)
            ->where('candidatos.tipo_votacion', $this->general->tipo_votacion)
            ->where('candidatos.estado_id', 1)
            ->where('candidatos.lista_id', $id)
            ->where('candidatos.tipo_cantidato_id', 5)
            ->whereNotIn('candidatos.orden', [97,99])
            ->orderBy('listas.orden')
            ->orderBy('candidatos.orden')
            ->select('candidatos.*')
            ->get();
            $this->paso = 3;
            $this->titulo = 'Candidatos al cargo de CONSEJAL';
        } else {
            $this->consejal_id = Candidato::where('anio', $this->general->anio)
            ->where('tipo_votacion', $this->general->tipo_votacion)
            ->where('estado_id', 1)
            ->where('orden', $orden)
            ->first()->id;
            $this->titulo = 'OPCIONES SELECCIONADAS';
            $this->paso = 4;
            $this->intendenteSeleccionado = Candidato::find($this->intendente_id);
            $this->concejalSeleccionado = Candidato::find($this->consejal_id);
        }

    }

    public function seleccionarConsejal($id)
    {
        $this->consejal_id = $id;
        $this->titulo = 'OPCIONES SELECCIONADAS';
        $this->paso = 4;
        $this->intendenteSeleccionado = Candidato::find($this->intendente_id);
        $this->concejalSeleccionado = Candidato::find($id);
    }

    public function volverIntendente()
    {
        $this->modo = 2;
        $this->reset('intendenteSeleccionado');
        $this->reset('intendente_id');
        $this->paso = 1;
    }

    public function volverConcejal()
    {
        $this->listas = Lista::where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->whereNotIn('orden', [97,99])
        ->get();
        $this->titulo = 'Listas participantes al cargo de CONSEJAL';
        $this->paso = 2;
    }

    public function imprimirSeleccion()
    {
        $this->paso = 5;
        $this->titulo = '';
    }

}
