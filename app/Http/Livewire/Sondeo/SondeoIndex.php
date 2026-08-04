<?php

namespace App\Http\Livewire\Sondeo;

use App\Models\Candidato;
use App\Models\General;
use App\Models\Lista;
use App\Models\Movimiento;
use App\Models\Urna;
use App\Models\User;
use Livewire\Component;

class SondeoIndex extends Component
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
    public $estilo_titulo = '';

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

        $this->modo = 1;

        $this->restablecer();
    }

    public function render()
    {
        return view('livewire.sondeo.sondeo-index');
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
            ->orderBy('orden', 'ASC')
            ->get();
            $this->titulo = 'Listas participantes al cargo de CONCEJAL';
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
            $this->titulo = 'Candidatos al cargo de CONCEJAL';
            if($this->general->tipo_votacion === 2){
                $movimiento_id = Lista::find($id)->movimiento_id;
                $movimiento = Movimiento::find($movimiento_id);
                $this->estilo_titulo = 'background-color:' . $movimiento->color_fondo . '; color:' . $movimiento->color_letra . ';';
            }else{
                $this->estilo_titulo = '';
            }
        } else {
            $this->consejal_id = Candidato::where('anio', $this->general->anio)
            ->where('tipo_votacion', $this->general->tipo_votacion)
            ->where('estado_id', 1)
            ->where('orden', $orden)
            ->where('tipo_cantidato_id', 5)
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
        $this->estilo_titulo = '';
    }

    public function volverIntendente()
    {
        $this->modo = 2;
        $this->reset('intendenteSeleccionado');
        $this->reset('intendente_id');
        $this->paso = 1;
        $this->estilo_titulo = '';
    }

    public function volverConcejal()
    {
        $this->listas = Lista::where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->whereNotIn('orden', [97,99])
        ->orderBy('orden', 'ASC')
        ->get();
        $this->titulo = 'Listas participantes al cargo de CONCEJAL';
        $this->paso = 2;
        $this->estilo_titulo = '';
    }

    public function imprimirSeleccion()
    {
        $this->paso = 5;
        $this->titulo = '';
        $this->estilo_titulo = '';
        Urna::create([
            'fecha' => now(),
            'candidato_id' => $this->intendenteSeleccionado->id,
            'tipo_cantidato_id' => $this->intendenteSeleccionado->tipo_cantidato_id,
            'lista_id' => $this->intendenteSeleccionado->lista_id,
            'movimiento_id' => $this->intendenteSeleccionado->movimiento_id,
            'voto' => 1,
            'anio'=> $this->general->anio,
            'tipo_votacion' => $this->general->tipo_votacion,
            'local_id' => auth()->user()->local_id,
            'user_id' => auth()->id(),
        ]);

        Urna::create([
            'fecha' => now(),
            'candidato_id' => $this->concejalSeleccionado->id,
            'tipo_cantidato_id' => $this->concejalSeleccionado->tipo_cantidato_id,
            'lista_id' => $this->concejalSeleccionado->lista_id,
            'movimiento_id' => $this->concejalSeleccionado->movimiento_id,
            'voto' => 1,
            'anio'=> $this->general->anio,
            'tipo_votacion' => $this->general->tipo_votacion,
            'local_id' => auth()->user()->local_id,
            'user_id' => auth()->id(),
        ]);

    }

}
