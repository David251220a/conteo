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
        $data = ['INTENDENTE', 'CONSEJAL', 'PRESIDENCIA', 'SENADOR', 'JUNTA', 'GOBERNADOR'];

        TipoCantidato::firstOrCreate([
            'descripcion' => 'NULOS',
            'orden' => 97
        ]);

        TipoCantidato::firstOrCreate([
            'descripcion' => 'A COMPUTAR',
            'orden' => 98
        ]);

        TipoCantidato::firstOrCreate([
            'descripcion' => 'BLANCOS',
            'orden' => 97
        ]);

        foreach ($data as $index => $item) {
            TipoCantidato::updateOrCreate(
                ['descripcion' => $item],
                ['orden' => $index + 1]
            );
        }
    }
}
