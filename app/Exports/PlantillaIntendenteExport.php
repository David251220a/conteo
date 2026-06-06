<?php

namespace App\Exports;

use App\Models\Lista;
use App\Models\General;
use Maatwebsite\Excel\Concerns\FromArray;

class PlantillaIntendenteExport implements FromArray
{
    public function array(): array
    {
        $general = General::find(1);

        $listas = Lista::where('estado_id', 1)
        ->where('anio', $general->anio)
        ->where('tipo_votacion', $general->tipo_votacion)
        ->orderBy('orden')
        ->get();

        $data = [];

        $data[] = [
            'lista',
            'voto'
        ];

        foreach ($listas as $lista) {
            $data[] = [
                $lista->descripcion,
                0
            ];
        }

        return $data;
    }
}
