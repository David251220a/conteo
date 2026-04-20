<?php

namespace App\Http\Livewire\Padron;

use App\Models\General;
use App\Models\Padron;
use App\Models\PadronConsulta;
use Livewire\Component;

class PadronIndex extends Component
{

    public $documento, $general;

    public function mount()
    {
        $this->general = General::find(1);
    }

    public function render()
    {
        $documento = str_replace('.', '', $this->documento);
        $data = Padron::where('documento', $documento)
        ->where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->first();

        if($data){
            PadronConsulta::create([
                'padron_id' => $data->id,
                'anio' => $this->general->anio,
                'tipo_votacion' => $this->general->tipo_votacion,
                'estado_id' => 1,
                'user_id' => auth()->id()
            ]);
        }

        return view('livewire.padron.padron-index', compact('data'));
    }

    public function buscar()
    {

    }


}
