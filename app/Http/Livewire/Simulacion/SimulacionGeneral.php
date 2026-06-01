<?php

namespace App\Http\Livewire\Simulacion;

use App\Http\Livewire\Voto\Consejal;
use App\Models\Candidato;
use App\Models\General;
use App\Models\Lista;
use App\Models\Simulacion;
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
    public $padron_id;
    public $back;
    public $consejal_nuestra;

    public function mount($padron_id, $back)
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

        $this->padron_id = $padron_id;
        $this->back = $back;

        $this->dato = Candidato::find(1);
        $this->modo = 1;

        $this->muestra();

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
        $this->titulo = 'Listas participantes al cargo de CONCEJAL';
        $this->paso = 2;
    }

    public function imprimirSeleccion()
    {
        $this->paso = 5;
        $this->titulo = '';

        Simulacion::create([
            'fecha' => now(),
            'candidato_id' => $this->intendenteSeleccionado->id,
            'tipo_cantidato_id' => $this->intendenteSeleccionado->tipo_cantidato_id,
            'lista_id' => $this->intendenteSeleccionado->lista_id,
            'movimiento_id' => $this->intendenteSeleccionado->movimiento_id,
            'voto' => 1,
            'anio'=> $this->general->anio,
            'tipo_votacion' => $this->general->tipo_votacion,
            'padron_id' => $this->padron_id,
            'local_id' => 0,
        ]);

        Simulacion::create([
            'fecha' => now(),
            'candidato_id' => $this->concejalSeleccionado->id,
            'tipo_cantidato_id' => $this->concejalSeleccionado->tipo_cantidato_id,
            'lista_id' => $this->concejalSeleccionado->lista_id,
            'movimiento_id' => $this->concejalSeleccionado->movimiento_id,
            'voto' => 1,
            'anio'=> $this->general->anio,
            'tipo_votacion' => $this->general->tipo_votacion,
            'padron_id' => $this->padron_id,
            'local_id' => 0,
        ]);

    }

    public function muestra(){
        if ($this->back == 'cesar'){
            $this->consejal_nuestra = Candidato::find(8);
        }

        if ($this->back == 'dani'){
            $this->consejal_nuestra = Candidato::find(9);
        }

        if ($this->back == 'giselle'){
            $this->consejal_nuestra = Candidato::find(10);
        }

        if ($this->back == 'roberto'){
            $this->consejal_nuestra = Candidato::find(11);
        }

        if ($this->back == 'esmilse'){
            $this->consejal_nuestra = Candidato::find(12);
        }

        if ($this->back == 'diosnel'){
            $this->consejal_nuestra = Candidato::find(13);
        }

        if ($this->back == 'liza'){
            $this->consejal_nuestra = Candidato::find(14);
        }

        if ($this->back == 'carlos'){
            $this->consejal_nuestra = Candidato::find(15);
        }

        if ($this->back == 'julio'){
            $this->consejal_nuestra = Candidato::find(16);
        }

        if ($this->back == 'joel'){
            $this->consejal_nuestra = Candidato::find(17);
        }

        if ($this->back == 'oliver'){
            $this->consejal_nuestra = Candidato::find(18);
        }

        if ($this->back == 'adolfo'){
            $this->consejal_nuestra = Candidato::find(19);
        }


        if ($this->back == 'benito'){
            $this->consejal_nuestra = Candidato::find(32);
        }


        if ($this->back == 'humberto'){
            $this->consejal_nuestra = Candidato::find(33);
        }


        if ($this->back == 'juan'){
            $this->consejal_nuestra = Candidato::find(34);
        }


        if ($this->back == 'gabriela'){
            $this->consejal_nuestra = Candidato::find(35);
        }


        if ($this->back == 'diego'){
            $this->consejal_nuestra = Candidato::find(36);
        }


        if ($this->back == 'miguel'){
            $this->consejal_nuestra = Candidato::find(37);
        }


        if ($this->back == 'espinola'){
            $this->consejal_nuestra = Candidato::find(38);
        }


        if ($this->back == 'ofelia'){
            $this->consejal_nuestra = Candidato::find(39);
        }


        if ($this->back == 'gilberto'){
            $this->consejal_nuestra = Candidato::find(40);
        }


        if ($this->back == 'ernesto'){
            $this->consejal_nuestra = Candidato::find(41);
        }


        if ($this->back == 'maria'){
            $this->consejal_nuestra = Candidato::find(42);
        }


        if ($this->back == 'cuevas'){
            $this->consejal_nuestra = Candidato::find(43);
        }
    }

}
