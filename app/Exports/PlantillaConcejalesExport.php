<?php

namespace App\Exports;

use App\Models\Candidato;
use App\Models\General;
use App\Models\Lista;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PlantillaConcejalesExport implements FromArray, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $listas;
    protected $forma;

    public function __construct($forma)
    {
        $this->forma = $forma;
    }

    private function datos()
    {
        $general = General::first();

        $listas = Lista::where('estado_id', 1)
        ->where('anio', $general->anio)
        ->where('tipo_votacion', $general->tipo_votacion)
        ->whereNotIn('orden', [97, 98, 99])
        ->orderBy('orden')
        ->get();

        $ordenes = Candidato::where('estado_id', 1)
        ->where('tipo_cantidato_id', 5)
        ->where('anio', $general->anio)
        ->where('tipo_votacion', $general->tipo_votacion)
        ->whereNotIn('orden', [97, 98, 99])
        ->select('orden')
        ->distinct()
        ->orderBy('orden')
        ->pluck('orden');

        return compact('listas', 'ordenes');
    }

    public function headings(): array
    {
        $datos = $this->datos();
        $listas = $datos['listas'];
        $ordenes = $datos['ordenes'];

        if ($this->forma == 1) {
            $headers = ['orden'];

            foreach ($listas as $lista) {
                $headers[] = $lista->descripcion;
            }

            return $headers;
        }

        $headers = ['lista'];

        foreach ($ordenes as $orden) {
            $headers[] = $orden;
        }

        return $headers;
    }

    public function array(): array
    {
        $datos = $this->datos();
        $listas = $datos['listas'];
        $ordenes = $datos['ordenes'];

        $rows = [];

        // OPCION / LISTA
        // orden | Lista 2A | Lista 3
        if ($this->forma == 1) {
            foreach ($ordenes as $orden) {
                $fila = [$orden];

                foreach ($listas as $lista) {
                    $fila[] = 0;
                }

                $rows[] = $fila;
            }

            return $rows;
        }

        // LISTA / OPCION
        // lista | 1 | 2 | 3 | ...
        foreach ($listas as $lista) {
            $fila = [$lista->descripcion];

            foreach ($ordenes as $orden) {
                $fila[] = 0;
            }

            $rows[] = $fila;
        }

        return $rows;
    }
}
