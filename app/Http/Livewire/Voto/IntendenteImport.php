<?php

namespace App\Http\Livewire\Voto;

use App\Exports\PlantillaIntendenteExport;
use App\Models\Candidato;
use App\Models\General;
use App\Models\Lista;
use App\Models\Local;
use App\Models\LocalMesa;
use App\Models\Voto;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Livewire\WithFileUploads;

class IntendenteImport extends Component
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
        $this->normal = 3;

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
        return view('livewire.voto.intendente-import');
    }

    public function descargarPlantilla()
    {
        return Excel::download(
            new PlantillaIntendenteExport(),
            'plantilla_intendente.xlsx'
        );
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

        $colLista = array_search('lista', $headers);
        // $colOpcion = array_search('opcion', $headers);
        $colVoto = array_search('voto', $headers);

        if ($colLista === false || $colVoto === false) {
            $this->emit('mensaje_error', 'El archivo debe tener las columnas: lista, voto.');
            return;
        }

        foreach (array_slice($rows, 1) as $row) {

            if (
                !isset($row[$colLista]) || trim($row[$colLista]) === ''
            ) {
                continue;
            }

            $lista = strtolower(trim($row[$colLista]));
            // $orden = (int) $row[$colOpcion];
            $votos = isset($row[$colVoto]) ? (int) $row[$colVoto] : 0;

            if ($votos < 0) {
                $this->emit('mensaje_error', 'No se permiten votos negativos.');
                return;
            }

            $datosExcel[] = [
                // 'orden' => $orden,
                'lista' => $lista,
                'votos' => $votos,
            ];

            $totalExcel += $votos;
        }

        if (empty($datosExcel)) {
            $this->emit('mensaje_error', 'No se encontraron votos válidos en el Excel.');
            return;
        }
        session()->put('datos_excel_intendente', $datosExcel);

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

        session()->forget('datos_excel_intendente');
    }

    public function guardarVotos()
    {
        // 1. Obtener datos del Excel desde sesión
        $datosExcel = session()->get('datos_excel_intendente', []);

        if (empty($datosExcel)) {
            $this->emit('mensaje_error', 'Primero debe verificar el Excel.');
            return;
        }

        DB::beginTransaction();

        try {

            $tipo_candidato_id = 4;

            // 2. Evitar doble carga de la misma mesa
            $existe = Voto::where('local_id', $this->local_id)
            ->where('local_mesa_id', $this->mesa_id)
            ->where('anio', $this->general->anio)
            ->where('tipo_votacion', $this->general->tipo_votacion)
            ->where('tipo_cantidato_id', $tipo_candidato_id)
            ->where('estado_id', 1)
            ->exists();

            if ($existe) {
                DB::rollBack();
                $this->emit('mensaje_error', 'Esta mesa ya fue cargada.');
                return;
            }

            $mesa = LocalMesa::find($this->mesa_id);
            $mesa->update([
                'cargado' => 1,
            ]);

            // 3. Mapear listas (para evitar consultas repetidas)
            $listas = Lista::where('estado_id', 1)
            ->where('anio', $this->general->anio)
            ->where('tipo_votacion', $this->general->tipo_votacion)
            ->get()
            ->keyBy(function ($item) {
                return strtolower($item->descripcion);
            });

            foreach ($datosExcel as $item) {

                $listaNombre = strtolower(trim($item['lista']));
                // $orden = (int) $item['orden'];
                $votos = (int) $item['votos'];
                $listaNormalizada = str_replace(
                    ['á', 'é', 'í', 'ó', 'ú'],
                    ['a', 'e', 'i', 'o', 'u'],
                    $listaNombre
                );

                $esNulo = str_contains($listaNormalizada, 'nulo');
                $esBlanco = str_contains($listaNormalizada, 'blanco');
                $esAComputar = str_contains($listaNormalizada, 'computar');

                if ($esNulo || $esBlanco || $esAComputar) {

                    if ($esNulo) {
                        $ordenEspecial = 97;
                    } elseif ($esBlanco) {
                        $ordenEspecial = 98;
                    } else {
                        $ordenEspecial = 99;
                    }

                    $candidato = Candidato::where('orden', $ordenEspecial)
                    ->where('tipo_cantidato_id', $tipo_candidato_id)
                    ->where('estado_id', 1)
                    ->where('anio', $this->general->anio)
                    ->where('tipo_votacion', $this->general->tipo_votacion)
                    ->first();

                    if (!$candidato) {
                        DB::rollBack();
                        $this->emit('mensaje_error', "Candidato especial no encontrado: {$listaNombre}");
                        return;
                    }

                } else {

                    if (!isset($listas[$listaNombre])) {
                        DB::rollBack();
                        $this->emit('mensaje_error', "Lista no encontrada: {$listaNombre}");
                        return;
                    }

                    $lista = $listas[$listaNombre];

                    $candidato = Candidato::where('lista_id', $lista->id)
                    ->where('tipo_cantidato_id', $tipo_candidato_id)
                    ->where('estado_id', 1)
                    ->where('anio', $this->general->anio)
                    ->where('tipo_votacion', $this->general->tipo_votacion)
                    ->first();

                    if (!$candidato) {
                        DB::rollBack();
                        $this->emit('mensaje_error', "Candidato no encontrado ({$listaNombre})");
                        return;
                    }
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

            DB::commit();

            // 6. Limpiar todo
            session()->forget('datos_excel_intendente');

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

            $this->cargarMesas();
            $this->emit('mensaje_exitoso', 'Votos cargados correctamente.');

        } catch (\Throwable $e) {

            DB::rollBack();

            $this->emit('mensaje_error', 'Error al guardar: ' . $e->getMessage());
        }
    }


}
