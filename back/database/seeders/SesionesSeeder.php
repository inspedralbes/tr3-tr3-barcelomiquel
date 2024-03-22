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
                'fecha' => '2024-03-15',
                'dia_espectador' => false,
                'VIP' => false,
                'hora' => '18:00',
            ],
            [
                'pelicula_id' => 2,
                'fecha' => '2024-03-22',
                'dia_espectador' => false,
                'VIP' => false,
                'hora' => '18:00',
            ],
            [
                'pelicula_id' => 3,
                'fecha' => '2024-03-29',
                'dia_espectador' => false,
                'VIP' => false,
                'hora' => '18:00',
            ],
            [
                'pelicula_id' => 4,
                'fecha' => '2024-04-05',
                'dia_espectador' => false,
                'VIP' => false,
                'hora' => '18:00',
            ],
            [
                'pelicula_id' => 5,
                'fecha' => '2024-04-12',
                'dia_espectador' => false,
                'VIP' => false,
                'hora' => '18:00',
            ],
            [
                'pelicula_id' => 6,
                'fecha' => '2024-04-19',
                'dia_espectador' => false,
                'VIP' => false,
                'hora' => '18:00',
            ],
        ];

        // Insertar datos en la base de datos
        DB::table('sesiones')->insert($sesiones);
    }
}
