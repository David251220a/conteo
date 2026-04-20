<?php

namespace Database\Seeders;

use App\Models\Movimiento;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MovimientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = ['ANR', 'PLRA'];

        foreach ($data as $item) {
            Movimiento::firstOrCreate([
                'descripcion' => $item
            ]);
        }
    }
}
