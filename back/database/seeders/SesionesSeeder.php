<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SesionesSeeder extends Seeder
{
    public function run()
    {
        $sesiones = [
            [
                'pelicula_id' => 1,
                'fecha' => '2024-04-12',
                'preu_entrada' => 6,
                'VIP' => false,
                'hora' => '18:00',
                'preu_entradaVip' => 8,
            ],
            [
                'pelicula_id' => 2,
                'fecha' => '2024-04-19',
                'preu_entrada' => 6,
                'VIP' => false,
                'hora' => '18:00',
                'preu_entradaVip' => 8,
            ],
            [
                'pelicula_id' => 3,
                'fecha' => '2024-04-26',
                'preu_entrada' => 6,
                'VIP' => false,
                'hora' => '18:00',
                'preu_entradaVip' => 8,
            ],
            [
                'pelicula_id' => 4,
                'fecha' => '2024-05-03',
                'preu_entrada' => 6,
                'VIP' => false,
                'hora' => '18:00',
                'preu_entradaVip' => 8,
            ],
            [
                'pelicula_id' => 5,
                'fecha' => '2024-05-10',
                'preu_entrada' => 6,
                'VIP' => false,
                'hora' => '18:00',
                'preu_entradaVip' => 8,
            ],
            [
                'pelicula_id' => 6,
                'fecha' => '2024-05-17',
                'preu_entrada' => 6,
                'VIP' => false,
                'hora' => '18:00',
                'preu_entradaVip' => 8,
            ],
        ];

        // Insertar datos en la base de datos
        DB::table('sesiones')->insert($sesiones);
    }
}
