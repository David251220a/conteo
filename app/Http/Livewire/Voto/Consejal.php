<?php

namespace App\Http\Livewire\Voto;

use App\Models\Candidato;
use App\Models\General;
use App\Models\Local;
use App\Models\LocalMesa;
use App\Models\Voto;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Consejal extends Component
{

    public $candidatos;
    public $votos = [];
    public $locales;
    public $mesas;
    public $general;
    public $local_id;
    public $mesa_id;
    public $normal;

    public function mount()
    {
        $this->general = General::find(1);
        $this->normal = 1;
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
        $candidatosNormales = $this->candidatos->filter(function ($item) {
            return (int) $item->orden < 97;
        });

        return view('livewire.voto.consejal', [
            'listasCandidatos' => $candidatosNormales->groupBy('lista_id'),
            'ordenesNormales' => $candidatosNormales
            ->pluck('orden')
            ->unique()
            ->sort()
            ->values(),
            'candidatosEspeciales' => $this->candidatos
            ->filter(function ($item) {
                return in_array((int) $item->orden, [97, 98, 99]);
            })
            ->sortBy('orden')
            ->values(),
        ]);
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

        $this->votos = [];

        foreach ($this->candidatos as $item) {
            $this->votos[$item->id] = 0;
        }
    }

    public function subtotalPorLista($listaId)
    {
        return collect($this->candidatos)
            ->filter(function ($item) use ($listaId) {
                return (int) $item->lista_id === (int) $listaId
                    && (int) $item->orden < 97;
            })
            ->sum(function ($item) {
                return (int) ($this->votos[$item->id] ?? 0);
            });
    }

    public function getTotalVotosProperty()
    {
        return collect($this->votos)->sum();
    }

    private function resetearCarga()
    {
        $this->cargarMesas();

        $this->votos = [];

        foreach ($this->candidatos as $item) {
            $this->votos[$item->id] = 0;
        }
    }

    public function grabar()
    {
        if (!$this->local_id || !$this->mesa_id) {
            $this->emit('mensaje_error', 'Debe seleccionar local y mesa.');
            return;
        }

        $totalGeneral = collect($this->votos)->sum(function ($cantidad) {
            return (int) $cantidad;
        });

        if ($totalGeneral <= 0) {
            $this->emit('mensaje_error', 'El total general de votos no puede ser cero.');
            return;
        }

        DB::beginTransaction();

        try {
            $aux_mesa = LocalMesa::find($this->mesa_id);
            foreach ($this->votos as $candidatoId => $cantidad) {
                $cantidad = (int) $cantidad;

                $candidato = $this->candidatos->firstWhere('id', (int) $candidatoId);
                $aux = Candidato::find($candidato->id);
                if (!$candidato) {
                    continue;
                }

                Voto::create([
                    'local_id'          => $this->local_id,
                    'local_mesa_id'     => $this->mesa_id,
                    'tipo_cantidato_id' => 5,
                    'lista_id'          => $candidato->lista_id,
                    'candidato_id'      => $candidato->id,
                    'movimiento_id' => $aux->movimiento_id,
                    'mesa' => $aux_mesa->mesa,
                    'votos'          => $cantidad,
                    'anio'              => $this->general->anio,
                    'tipo_votacion'     => $this->general->tipo_votacion,
                    'estado_id'         => 1,
                    'user_id'           => auth()->id(),
                ]);

            }

            LocalMesa::where('id', $this->mesa_id)->update([
                'cargado' => 1,
            ]);

            DB::commit();

            $this->resetearCarga();

            $this->emit('mensaje_exitoso', 'Votos de concejales guardados correctamente.');

        } catch (\Throwable $e) {
            DB::rollBack();

            $this->emit('mensaje_error', $e->getMessage());
        }
    }

}
