<?php

namespace Database\Seeders;

use App\Models\TipoCantidato;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoCantidatoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = ['NULOS', 'A COMPUTAR', 'BLANCOS', 'INTENDENTE', 'CONSEJAL', 'PRESIDENCIA', 'SENADOR', 'JUNTA', 'GOBERNADOR'];

        foreach ($data as $item) {
            TipoCantidato::firstOrCreate([
                'descripcion' => $item
            ]);
        }
    }
}
