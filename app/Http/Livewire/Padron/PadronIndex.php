<?php

namespace App\Http\Livewire\Padron;

use App\Models\General;
use App\Models\Padron;
use App\Models\PadronConsulta;
use App\Models\Referente;
use App\Models\User;
use App\Models\Vehiculo;
use Livewire\Component;

class PadronIndex extends Component
{

    public $documento, $general;
    public $verMas;
    public $data;
    public $referentes;
    public $vehiculos;
    public $mensaje;
    public $estilo;
    public $titulo;

    public function mount()
    {
        $this->general = General::find(1);
        $this->verMas = false;
        $this->referentes = Referente::where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->where('estado_id', 1)
        ->get();

        $this->vehiculos = Vehiculo::where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->where('estado_id', 1)
        ->get();

        $local = auth()->user()->local;
        $this->titulo = 'Padron - Local Vinculado: ' . $local->descripcion;

    }

    public function render()
    {

        $data = $this->data;
        return view('livewire.padron.padron-index', compact('data'));
    }

    public function buscar()
    {
        $this->verMas = false;
        $documento = str_replace('.', '', $this->documento);
        $this->data = Padron::where('documento', $documento)
        ->where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->first();
        $usuario_local = auth()->user()->local_id;
        $id = 0;
        if ($this->data && $this->data->local_id == $usuario_local){
            PadronConsulta::create([
                'padron_id' => $this->data->id,
                'anio' => $this->general->anio,
                'tipo_votacion' => $this->general->tipo_votacion,
                'estado_id' => 1,
                'user_id' => auth()->id()
            ]);
            Padron::where('id', $this->data->id)->update(['voto' => 1]);
            $id = $this->data->id;
            $this->mensaje = 'Confirmado';
            $this->estilo = 'text-success text-bold';
        }else{
            $this->mensaje = 'No corresponde a este local';
            $this->estilo = 'text-danger text-bold';
        }

        $conteo = PadronConsulta::where('padron_id', $id)
        ->where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->orderBy('created_at', 'ASC')
        ->get();

        if ($conteo->count() > 1){
            $primeraConsulta = $conteo->first();
            $usuario_consulta = User::find($primeraConsulta->user_id);
            $mensaje = 'La persona ya fue consultada por primera vez a las: ' . $primeraConsulta->created_at->format('H:i:s') . ' por el usuario:' . $usuario_consulta->username;
            $this->mensaje = 'Confirmado';
            $this->estilo = 'text-success text-bold';
            $this->emit('mensaje_error', $mensaje);
        }

        // if ($this->data && $this->data->local_id != $usuario_local){
        //     $this->emit('mensaje_error', 'La persona no pertenece a su local de votación.');
        // }

        // if ($this->data) {
        //     $this->dispatchBrowserEvent('mostrar-mapa');
        // }
    }

    public function toggleVerMas()
    {
        $this->verMas = !$this->verMas;
        if ($this->verMas) {
            $this->dispatchBrowserEvent('mostrar-mapa');
        }
    }

    public function guardarReferente($padronId, $referenteId)
    {
        $padron = Padron::find($padronId);
        if (!$padron) {
            return;
        }
        $padron->update(['referente_id' => $referenteId]);
        $this->data = $padron;
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('mostrar-mapa');
    }

    public function guardarVehiculo($padronId, $vehiculoId)
    {
        $padron = Padron::find($padronId);

        if (!$padron) {
            return;
        }

        $padron->update([
            'vehiculo_id' => $vehiculoId
        ]);

        $this->data = $padron;

        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('mostrar-mapa');
    }

    public function guardarUbicacion($padronId, $lat, $lng)
    {
        $padron = Padron::find($padronId);

        if (!$padron) {
            return;
        }

        $padron->update([
            'latitude' => $lat,
            'longitude' => $lng
        ]);

        $this->data = $padron;
        $this->dispatchBrowserEvent('mostrar-mapa');
    }

    public function padron_voto()
    {
        $voto = !$this->data->voto;
        $padron = Padron::find($this->data->id);

        $padron->update([
            'voto' => $voto
        ]);

        $this->data = $padron;
        $this->dispatchBrowserEvent('mostrar-mapa');
    }

    public function confirmar_voto()
    {
        $voto = !$this->data->voto;
        $padron = Padron::find($this->data->id);

        $padron->update([
            'voto' => $voto
        ]);

        $this->data = $padron;
        $this->dispatchBrowserEvent('mostrar-mapa');
    }


}
