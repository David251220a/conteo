<?php

namespace Database\Seeders;

use App\Models\General;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GeneralSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        General::firstOrCreate([
            'anio' => 2026,
            'tipo_votacion' => 1
        ]);

    }
}
