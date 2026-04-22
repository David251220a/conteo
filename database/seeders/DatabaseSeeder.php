<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Estado;
use App\Models\Referente;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);

        User::firstOrCreate([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@dev',
            'password' => Hash::make('admin123456'),
        ])->assignRole('admin');

        $estado = ['ACTIVO', 'INACTIVO'];

        foreach ($estado as $item) {
            Estado::firstOrCreate([
                'descripcion' => $item
            ]);
        }

        Referente::create([
            'documento' => '0',
            'referente' => 'SIN ESPECIFICAR',
            'celular' => '0',
            'estado_id' => 1,
            'user_id' => 1,
            'anio' => 2026,
            'tipo_votacion' => 1,
        ]);

        $this->call([
            GeneralSeeder::class,
            MovimientoSeeder::class,
            TipoCantidatoSeeder::class,
        ]);
    }
}
