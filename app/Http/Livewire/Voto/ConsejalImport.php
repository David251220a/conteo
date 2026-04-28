<?php

namespace App\Http\Livewire\Voto;

use App\Exports\PlantillaConcejalesExport;
use App\Models\Candidato;
use App\Models\General;
use App\Models\Lista;
use App\Models\Local;
use App\Models\LocalMesa;
use App\Models\Voto;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\ValidationException;

class ConsejalImport extends Component
{
    use WithFileUploads;

    public $archivo;
    public $nulos = 0;
    public $blancos = 0;
    public $a_computar = 0;

    public $verificado = false;
    public $total_excel = 0;
    public $total_extras = 0;
    public $total_general = 0;

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
    }

    public function updatedLocalId()
    {
        $this->resetearVerificacion();
    }

    public function updatedMesaId()
    {
        $this->resetearVerificacion();
    }

    public function updatedNormal()
    {
        $this->resetearVerificacion();
    }

    public function render()
    {
        return view('livewire.voto.consejal-import');
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

    public function descargarPlantilla()
    {
        return Excel::download(
            new PlantillaConcejalesExport($this->normal),
            'plantilla_concejales.xlsx'
        );
    }

    public function verificarExcel()
    {
        try {

            $this->validate([
                'archivo' => 'required|file|mimes:xlsx,xls,csv',
                'nulos' => 'nullable|numeric|min:0',
                'blancos' => 'nullable|numeric|min:0',
                'a_computar' => 'nullable|numeric|min:0',
                'local_id' => 'required',
                'mesa_id' => 'required',
            ]);

        } catch (ValidationException $e) {
            $mensaje = collect($e->errors())->flatten()->first();
            $this->emit('mensaje_error', $mensaje);
            return;
        }

        $rows = Excel::toArray([], $this->archivo)[0];

        if (count($rows) < 2) {
            $this->emit('mensaje_error', 'El archivo no contiene datos.');
            return;
        }

        $headers = array_map(function ($item) {
            return strtolower(trim($item));
        }, $rows[0]);

        $datosExcel = [];
        $totalExcel = 0;

        if ($this->normal == 1) {
            $colOrden = array_search('orden', $headers);

            if ($colOrden === false) {
                $this->emit('mensaje_error', 'El archivo debe tener la columna orden.');
                return;
            }

            foreach (array_slice($rows, 1) as $row) {
                if (!isset($row[$colOrden]) || $row[$colOrden] === null || $row[$colOrden] === '') {
                    continue;
                }

                $orden = (int) $row[$colOrden];

                foreach ($headers as $index => $header) {
                    if ($index == $colOrden) {
                        continue;
                    }

                    $votos = isset($row[$index]) ? (int) $row[$index] : 0;

                    if ($votos < 0) {
                        $this->emit('mensaje_error', 'No se permiten votos negativos.');
                        return;
                    }

                    $datosExcel[] = [
                        'orden' => $orden,
                        'lista' => $header,
                        'votos' => $votos,
                    ];

                    $totalExcel += $votos;
                }
            }
        }

        if ($this->normal == 2) {
            $colLista = array_search('lista', $headers);

            if ($colLista === false) {
                $this->emit('mensaje_error', 'El archivo debe tener la columna lista.');
                return;
            }

            foreach (array_slice($rows, 1) as $row) {
                if (!isset($row[$colLista]) || $row[$colLista] === null || $row[$colLista] === '') {
                    continue;
                }

                $lista = strtolower(trim($row[$colLista]));

                foreach ($headers as $index => $header) {
                    if ($index == $colLista) {
                        continue;
                    }

                    $orden = (int) $header;
                    $votos = isset($row[$index]) ? (int) $row[$index] : 0;

                    if ($votos < 0) {
                        $this->emit('mensaje_error', 'No se permiten votos negativos.');
                        return;
                    }

                    $datosExcel[] = [
                        'orden' => $orden,
                        'lista' => $lista,
                        'votos' => $votos,
                    ];

                    $totalExcel += $votos;
                }
            }
        }

        session()->put('datos_excel_concejales', $datosExcel);

        $this->total_excel = $totalExcel;
        $this->total_extras = (int) $this->nulos + (int) $this->blancos + (int) $this->a_computar;
        $this->total_general = $this->total_excel + $this->total_extras;
        $this->verificado = true;
    }

    private function resetearVerificacion()
    {
        $this->reset([
            'archivo',
            'verificado',
            'total_excel',
            'total_extras',
            'total_general',
            'nulos',
            'blancos',
            'a_computar',
        ]);

        $this->verificado = false;

        session()->forget('datos_excel_concejales');
    }

    public function guardarVotos()
    {
        // 1. Obtener datos del Excel desde sesión
        $datosExcel = session()->get('datos_excel_concejales', []);

        if (empty($datosExcel)) {
            $this->emit('mensaje_error', 'Primero debe verificar el Excel.');
            return;
        }

        DB::beginTransaction();

        try {

            $tipo_candidato_id = 5;

            // 2. Evitar doble carga de la misma mesa
            $existe = Voto::where('local_id', $this->local_id)
            ->where('local_mesa_id', $this->mesa_id)
            ->where('anio', $this->general->anio)
            ->where('tipo_votacion', $this->general->tipo_votacion)
            ->where('tipo_cantidato_id', $tipo_candidato_id)
            ->where('estado_id', 1)
            ->exists();

            $mesa = LocalMesa::find($this->mesa_id);
            $mesa->update([
                'cargado' => 1,
            ]);

            if ($existe) {
                DB::rollBack();
                $this->emit('mensaje_error', 'Esta mesa ya fue cargada.');
                return;
            }

            // 3. Mapear listas (para evitar consultas repetidas)
            $listas = Lista::where('estado_id', 1)
            ->where('anio', $this->general->anio)
            ->where('tipo_votacion', $this->general->tipo_votacion)
            ->get()
            ->keyBy(function ($item) {
                return strtolower($item->descripcion);
            });

            // 4. Recorrer Excel
            foreach ($datosExcel as $item) {

                $listaNombre = strtolower(trim($item['lista']));
                $orden = (int) $item['orden'];
                $votos = (int) $item['votos'];

                // if ($votos == 0) continue;

                if (!isset($listas[$listaNombre])) {
                    DB::rollBack();
                    $this->emit('mensaje_error', "Lista no encontrada: {$listaNombre}");
                    return;
                }

                $lista = $listas[$listaNombre];

                $candidato = Candidato::where('lista_id', $lista->id)
                ->where('tipo_cantidato_id', $tipo_candidato_id)
                ->where('orden', $orden)
                ->where('estado_id', 1)
                ->first();

                if (!$candidato) {
                    DB::rollBack();
                    $this->emit('mensaje_error', "Candidato no encontrado (orden {$orden} - {$listaNombre})");
                    return;
                }

                Voto::create([
                    'local_id' => $this->local_id,
                    'local_mesa_id' => $this->mesa_id,
                    'candidato_id' => $candidato->id,
                    'tipo_cantidato_id' => $tipo_candidato_id,
                    'lista_id' => $candidato->lista_id,
                    'movimiento_id' => $candidato->movimiento_id,
                    'mesa' => $mesa->mesa,
                    'votos' => $votos,
                    'estado_id' => 1,
                    'user_id' => auth()->id(),
                    'anio' => $this->general->anio,
                    'tipo_votacion' => $this->general->tipo_votacion,
                ]);
            }

            // 5. Guardar NULOS, BLANCOS, A COMPUTAR

            $especiales = [
                97 => $this->nulos,
                98 => $this->blancos,
                99 => $this->a_computar,
            ];

            foreach ($especiales as $orden => $votos) {

                // if ($votos <= 0) continue;

                $candidato = Candidato::where('orden', $orden)
                ->where('tipo_cantidato_id', $tipo_candidato_id)
                ->first();

                if ($candidato) {
                    Voto::create([
                        'local_id' => $this->local_id,
                        'local_mesa_id' => $this->mesa_id,
                        'candidato_id' => $candidato->id,
                        'tipo_cantidato_id' => $tipo_candidato_id,
                        'lista_id' => $candidato->lista_id,
                        'movimiento_id' => $candidato->movimiento_id,
                        'mesa' => $mesa->mesa,
                        'votos' => $votos,
                        'estado_id' => 1,
                        'user_id' => auth()->id(),
                        'anio' => $this->general->anio,
                        'tipo_votacion' => $this->general->tipo_votacion,
                    ]);
                }
            }

            DB::commit();

            // 6. Limpiar todo
            session()->forget('datos_excel_concejales');

            $this->reset([
                'archivo',
                'verificado',
                'total_excel',
                'total_extras',
                'total_general',
                'nulos',
                'blancos',
                'a_computar'
            ]);

            $this->emit('mensaje_exitoso', 'Votos cargados correctamente.');

        } catch (\Throwable $e) {

            DB::rollBack();

            $this->emit('mensaje_error', 'Error al guardar: ' . $e->getMessage());
        }
    }

}
