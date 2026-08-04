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
        $this->normal = 2;
        $this->cargarLocales();
        $this->cargarMesas();
    }

    public function updatedLocalId()
    {
        $this->resetearVerificacion();
        $this->cargarMesas();
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
            return strtolower(trim((string) $item));
        }, $rows[0]);

        $datosExcel = [];
        $totalExcel = 0;

        /*
        |--------------------------------------------------------------------------
        | Indica si NULOS, BLANCOS o A COMPUTAR vienen en el archivo
        |--------------------------------------------------------------------------
        */
        $especialesEnArchivo = false;
        /*
        |--------------------------------------------------------------------------
        | FORMATO 1
        | orden | lista 1 | lista 2 | nulos | blancos | a computar
        |--------------------------------------------------------------------------
        */
        if ($this->normal == 1) {

            $colOrden = array_search('orden', $headers);

            if ($colOrden === false) {
                $this->emit('mensaje_error','El archivo debe tener la columna orden.');
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

                    $headerNormalizado = str_replace(
                        ['á', 'é', 'í', 'ó', 'ú'],
                        ['a', 'e', 'i', 'o', 'u'],
                        strtolower(trim($header))
                    );

                    $esEspecial = str_contains($headerNormalizado, 'nulo') || str_contains($headerNormalizado, 'blanco') || str_contains($headerNormalizado, 'computar');

                    if ($esEspecial) {
                        $especialesEnArchivo = true;
                    }

                    $votos = isset($row[$index]) ? (int) $row[$index] : 0;

                    if ($votos < 0) {
                        $this->emit('mensaje_error','No se permiten votos negativos.');
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

        /*
        |--------------------------------------------------------------------------
        | FORMATO 2
        | lista | 1 | 2 | 3
        |--------------------------------------------------------------------------
        */
        if ($this->normal == 2) {

            $colLista = array_search('lista', $headers);

            if ($colLista === false) {
                $this->emit('mensaje_error','El archivo debe tener la columna lista.');
                return;
            }

            foreach (array_slice($rows, 1) as $row) {

                if (!isset($row[$colLista]) || $row[$colLista] === null || trim((string) $row[$colLista]) === '') {
                    continue;
                }

                $lista = strtolower(trim((string) $row[$colLista]));
                $listaNormalizada = str_replace(
                    ['á', 'é', 'í', 'ó', 'ú'],
                    ['a', 'e', 'i', 'o', 'u'],
                    $lista
                );

                $esEspecial = str_contains($listaNormalizada, 'nulo') || str_contains($listaNormalizada, 'blanco') || str_contains($listaNormalizada, 'computar');

                if ($esEspecial) {
                    $especialesEnArchivo = true;
                }

                foreach ($headers as $index => $header) {

                    if ($index == $colLista) {
                        continue;
                    }

                    /*
                    * Los especiales solamente toman la opción 1.
                    */
                    if ($esEspecial && trim($header) != '1') {
                        continue;
                    }

                    $orden = (int) $header;
                    $votos = isset($row[$index]) ? (int) $row[$index] : 0;

                    if ($votos < 0) {
                        $this->emit('mensaje_error','No se permiten votos negativos.');
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

        /*
        |--------------------------------------------------------------------------
        | FORMATO 3
        | lista | opcion | voto
        |--------------------------------------------------------------------------
        */
        if ($this->normal == 3) {

            $colLista = array_search('lista', $headers);
            $colOpcion = array_search('opcion', $headers);
            $colVoto = array_search('voto', $headers);

            if ($colLista === false || $colOpcion === false || $colVoto === false) {
                $this->emit('mensaje_error','El archivo debe tener las columnas: lista, opcion, voto.');
                return;
            }

            foreach (array_slice($rows, 1) as $row) {

                if (!isset($row[$colLista]) || trim((string) $row[$colLista]) === '' || !isset($row[$colOpcion]) || trim((string) $row[$colOpcion]) === '') {
                    continue;
                }

                $lista = strtolower(trim((string) $row[$colLista]));
                $orden = (int) $row[$colOpcion];

                $listaNormalizada = str_replace(
                    ['á', 'é', 'í', 'ó', 'ú'],
                    ['a', 'e', 'i', 'o', 'u'],
                    $lista
                );

                $esEspecial = str_contains($listaNormalizada, 'nulo') || str_contains($listaNormalizada, 'blanco') || str_contains($listaNormalizada, 'computar');

                if ($esEspecial) {
                    $especialesEnArchivo = true;
                }

                $votos = isset($row[$colVoto]) ? (int) $row[$colVoto] : 0;

                if ($votos < 0) {
                    $this->emit('mensaje_error','No se permiten votos negativos.');
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

        session()->put('datos_excel_concejales', $datosExcel);

        /*
        |--------------------------------------------------------------------------
        | Totales
        |--------------------------------------------------------------------------
        |
        | Si los especiales vienen en el Excel, ya están incluidos en totalExcel.
        | Si no vienen, se agregan los campos manuales.
        |
        */

        $this->total_excel = $totalExcel;

        if ($especialesEnArchivo) {
            $this->total_extras = 0;
            $this->total_general = $this->total_excel;
        } else {
            $this->total_extras = (int) $this->nulos + (int) $this->blancos + (int) $this->a_computar;
            $this->total_general = $this->total_excel + $this->total_extras;
        }

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
        $datosExcel = session()->get('datos_excel_concejales', []);

        if (empty($datosExcel)) {
            $this->emit('mensaje_error', 'Primero debe verificar el Excel.');
            return;
        }

        DB::beginTransaction();

        try {

            $tipo_candidato_id = 5;

            /*
            |--------------------------------------------------------------------------
            | Verificar si la mesa ya fue cargada
            |--------------------------------------------------------------------------
            */

            $existe = Voto::where('local_id', $this->local_id)
            ->where('local_mesa_id', $this->mesa_id)
            ->where('anio', $this->general->anio)
            ->where('tipo_votacion', $this->general->tipo_votacion)
            ->where('tipo_cantidato_id', $tipo_candidato_id)
            ->where('estado_id', 1)
            ->exists();

            if ($existe) {
                DB::rollBack();
                $this->emit('mensaje_error','Esta mesa ya fue cargada.');
                return;
            }
            /*
            |--------------------------------------------------------------------------
            | Obtener mesa
            |--------------------------------------------------------------------------
            */
            $mesa = LocalMesa::find($this->mesa_id);
            if (!$mesa) {
                DB::rollBack();
                $this->emit('mensaje_error','La mesa seleccionada no fue encontrada.');
                return;
            }
            /*
            |--------------------------------------------------------------------------
            | Obtener listas
            |--------------------------------------------------------------------------
            */
            $listas = Lista::where('estado_id', 1)
            ->where('anio', $this->general->anio)
            ->where('tipo_votacion', $this->general->tipo_votacion)
            ->get()
            ->keyBy(function ($item) {
                return strtolower(trim($item->descripcion));
            });

            /*
            |--------------------------------------------------------------------------
            | Acumuladores de votos especiales
            |--------------------------------------------------------------------------
            */

            $especialesExcel = [
                97 => 0, // NULOS
                98 => 0, // BLANCOS
                99 => 0, // A COMPUTAR
            ];

            $especialesEncontrados = [
                97 => false,
                98 => false,
                99 => false,
            ];

            /*
            |--------------------------------------------------------------------------
            | Recorrer datos del Excel
            |--------------------------------------------------------------------------
            */

            foreach ($datosExcel as $item) {

                $listaNombre = strtolower(trim($item['lista'] ?? ''));
                $orden = (int) ($item['orden'] ?? 0);
                $votos = (int) ($item['votos'] ?? 0);

                $listaNormalizada = str_replace(
                    ['á', 'é', 'í', 'ó', 'ú'],
                    ['a', 'e', 'i', 'o', 'u'],
                    $listaNombre
                );

                $esNulo = str_contains($listaNormalizada, 'nulo');
                $esBlanco = str_contains($listaNormalizada, 'blanco');
                $esAComputar = str_contains($listaNormalizada, 'computar');

                /*
                |--------------------------------------------------------------------------
                | Acumular votos especiales
                |--------------------------------------------------------------------------
                */

                if ($esNulo || $esBlanco || $esAComputar) {

                    if ($esNulo) {
                        $ordenEspecial = 97;
                    } elseif ($esBlanco) {
                        $ordenEspecial = 98;
                    } else {
                        $ordenEspecial = 99;
                    }

                    $especialesExcel[$ordenEspecial] += $votos;
                    $especialesEncontrados[$ordenEspecial] = true;

                    /*
                    * No guardamos todavía.
                    * Se guardarán una sola vez al terminar el recorrido.
                    */
                    continue;
                }

                /*
                |--------------------------------------------------------------------------
                | Validar lista normal
                |--------------------------------------------------------------------------
                */

                if (!isset($listas[$listaNombre])) {
                    DB::rollBack();
                    $this->emit('mensaje_error',"Lista no encontrada: {$listaNombre}");
                    return;
                }

                $lista = $listas[$listaNombre];

                /*
                |--------------------------------------------------------------------------
                | Buscar candidato normal
                |--------------------------------------------------------------------------
                */

                $candidato = Candidato::where('lista_id', $lista->id)
                ->where('tipo_cantidato_id', $tipo_candidato_id)
                ->where('orden', $orden)
                ->where('estado_id', 1)
                ->where('anio', $this->general->anio)
                ->where('tipo_votacion', $this->general->tipo_votacion)
                ->first();

                if (!$candidato) {
                    DB::rollBack();
                    $this->emit('mensaje_error',"Candidato no encontrado (opción {$orden} - {$listaNombre})");
                    return;
                }

                /*
                |--------------------------------------------------------------------------
                | Guardar voto normal
                |--------------------------------------------------------------------------
                */

                Voto::create([
                    'local_id'          => $this->local_id,
                    'local_mesa_id'     => $this->mesa_id,
                    'candidato_id'      => $candidato->id,
                    'tipo_cantidato_id' => $tipo_candidato_id,
                    'lista_id'          => $candidato->lista_id,
                    'movimiento_id'     => $candidato->movimiento_id,
                    'mesa'              => $mesa->mesa,
                    'votos'             => $votos,
                    'estado_id'         => 1,
                    'user_id'           => auth()->id(),
                    'anio'              => $this->general->anio,
                    'tipo_votacion'     => $this->general->tipo_votacion,
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Valores especiales finales
            |--------------------------------------------------------------------------
            |
            | Si un valor vino dentro del Excel, se utiliza ese valor.
            | Si no vino, se utiliza el valor cargado manualmente.
            |
            */

            $especialesFinales = [
                97 => $especialesEncontrados[97]
                    ? $especialesExcel[97]
                    : (int) $this->nulos,

                98 => $especialesEncontrados[98]
                    ? $especialesExcel[98]
                    : (int) $this->blancos,

                99 => $especialesEncontrados[99]
                    ? $especialesExcel[99]
                    : (int) $this->a_computar,
            ];

            /*
            |--------------------------------------------------------------------------
            | Guardar NULOS, BLANCOS y A COMPUTAR
            |--------------------------------------------------------------------------
            */

            foreach ($especialesFinales as $ordenEspecial => $cantidadVotos) {
                $candidatoEspecial = Candidato::where('orden', $ordenEspecial)
                ->where('tipo_cantidato_id', $tipo_candidato_id)
                ->where('estado_id', 1)
                ->where('anio', $this->general->anio)
                ->where('tipo_votacion', $this->general->tipo_votacion)
                ->first();

                if (!$candidatoEspecial) {

                    $nombresEspeciales = [
                        97 => 'NULOS',
                        98 => 'BLANCOS',
                        99 => 'A COMPUTAR',
                    ];

                    DB::rollBack();
                    $this->emit('mensaje_error','Candidato especial no encontrado: '. $nombresEspeciales[$ordenEspecial]);
                    return;
                }

                Voto::create([
                    'local_id'          => $this->local_id,
                    'local_mesa_id'     => $this->mesa_id,
                    'candidato_id'      => $candidatoEspecial->id,
                    'tipo_cantidato_id' => $tipo_candidato_id,
                    'lista_id'          => $candidatoEspecial->lista_id,
                    'movimiento_id'     => $candidatoEspecial->movimiento_id,
                    'mesa'              => $mesa->mesa,
                    'votos'             => $cantidadVotos,
                    'estado_id'         => 1,
                    'user_id'           => auth()->id(),
                    'anio'              => $this->general->anio,
                    'tipo_votacion'     => $this->general->tipo_votacion,
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Marcar mesa como cargada
            |--------------------------------------------------------------------------
            */

            $mesa->update([
                'cargado' => 1,
            ]);

            DB::commit();

            /*
            |--------------------------------------------------------------------------
            | Limpiar datos
            |--------------------------------------------------------------------------
            */

            session()->forget('datos_excel_concejales');

            $this->cargarMesas();

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

            $this->emit(
                'mensaje_exitoso',
                'Votos cargados correctamente.'
            );

        } catch (\Throwable $e) {

            DB::rollBack();

            $this->emit(
                'mensaje_error',
                'Error al guardar: ' . $e->getMessage()
            );
        }
    }

}
