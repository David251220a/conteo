<?php

namespace App\Http\Livewire\Voto;

use App\Models\Candidato;
use App\Models\General;
use App\Models\Local;
use App\Models\LocalMesa;
use App\Models\Voto;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class IntendenteManual extends Component
{
    public $locales;
    public $mesas;
    public $general;
    public $local_id;
    public $mesa_id;
    public $candidatos;
    public $votos;
    public $totalVotos = 0;

    public function mount()
    {
        $this->general = General::find(1);

        $this->cargarLocales();
        $this->cargarMesas();
        $this->cargarCandidatos();
    }

    public function updatedLocalId()
    {
        $this->cargarMesas();
    }

    public function render()
    {
        return view('livewire.voto.intendente-manual');
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
        ->where('tipo_cantidato_id', 4)
        ->where('cargado', 0)
        ->where('local_id', $this->local_id)
        ->get();

        $this->mesa_id = $this->mesas->first()->id ?? 0;
    }

    private function recalcularTotalVotos()
    {
        $this->totalVotos = collect($this->votos)->sum();
    }

    public function updatedVotos()
    {
        $this->recalcularTotalVotos();
    }

    private function cargarCandidatos()
    {
        $this->candidatos = Candidato::with('lista')
            ->where('candidatos.estado_id', 1)
            ->where('candidatos.anio', $this->general->anio)
            ->where('candidatos.tipo_votacion', $this->general->tipo_votacion)
            ->where('candidatos.tipo_cantidato_id', 4)
            ->join('listas', 'listas.id', '=', 'candidatos.lista_id')
            ->orderBy('listas.orden')
            ->orderBy('candidatos.orden')
            ->select('candidatos.*')
            ->get();

        $this->votos = [];

        foreach ($this->candidatos as $item) {
            $this->votos[$item->id] = 0;
        }

        $this->totalVotos = 0;
    }

    public function grabar()
    {

        if (!$this->mesa_id || $this->mesa_id == 0) {
            $this->emit('mensaje_error', 'Debe seleccionar una mesa.');
            return;
        }

        if ($this->totalVotos <= 0) {
            $this->emit('mensaje_error','No puede grabar una carga con total de votos igual a cero.');
            return;
        }

        $existe = Voto::where('local_mesa_id', $this->mesa_id)
        ->where('estado_id', 1)
        ->exists();

        if ($existe) {
            $this->emit('mensaje_error','La mesa ya fue cargada por otro usuario.');
            return;
        }

        DB::transaction(function () {
            $aux_mesa = LocalMesa::find($this->mesa_id);
            foreach ($this->votos as $candidatoId => $cantidad) {
                $aux = Candidato::find($candidatoId);
                Voto::create([
                    'local_id' => $aux_mesa->local_id,
                    'local_mesa_id' => $this->mesa_id,
                    'tipo_cantidato_id' => 4,
                    'lista_id' => $aux->lista_id,
                    'candidato_id' => $aux->id,
                    'movimiento_id' => $aux->movimiento_id,
                    'mesa' => $aux_mesa->mesa,
                    'votos' => $cantidad ?? 0,
                    'anio' => $this->general->anio,
                    'tipo_votacion' => $this->general->tipo_votacion,
                    'estado_id' => 1,
                    'user_id' => auth()->id(),
                ]);
            }

            LocalMesa::where('id', $this->mesa_id)->update([
                'cargado' => 1,
                'updated_at' => now(),
            ]);
        });

        $this->cargarMesas();
        $this->cargarCandidatos();
        $this->totalVotos = 0;
        $this->mesa_id = $this->mesas->first()->id ?? 0;
        $this->emit('mensaje_exitoso','Votos grabados correctamente.');
    }


}
