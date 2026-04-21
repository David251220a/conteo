<?php

namespace App\Http\Livewire\Padron;

use App\Models\General;
use App\Models\Padron;
use App\Models\PadronConsulta;
use App\Models\Referente;
use App\Models\Vehiculo;
use Livewire\Component;

class PadronIndex extends Component
{

    public $documento, $general;
    public $verMas;
    public $data;
    public $referentes;
    public $vehiculos;

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

        if($this->data){
            PadronConsulta::create([
                'padron_id' => $this->data->id,
                'anio' => $this->general->anio,
                'tipo_votacion' => $this->general->tipo_votacion,
                'estado_id' => 1,
                'user_id' => auth()->id()
            ]);
        }
        if ($this->data) {
            $this->dispatchBrowserEvent('mostrar-mapa');
        }
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


}
