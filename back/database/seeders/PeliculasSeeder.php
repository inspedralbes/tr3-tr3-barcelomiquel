<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PeliculasSeeder extends Seeder
{
    public function run()
    {
        $peliculas = [
            [
                'titol' => 'John Wick 4',
                'genere' => 'Acció',
                'poster' => '/JohnWick4.jpg',
                'duracio' => '120 min',
                'descripcio' => 'Descripció de John Wick 4'
            ],
            [
                'titol' => 'Equalizador 3',
                'genere' => 'Acció',
                'poster' => '/TheEqualizer3.jpg',
                'duracio' => '105 min',
                'descripcio' => 'Descripció de Equalizador 3'
            ],
            [
                'titol' => 'Beekeeper',
                'genere' => 'Acció',
                'poster' => '/Beekeeper.jpg',
                'duracio' => '98 min',
                'descripcio' => 'Descripció de Beekeeper'
            ],
            [
                'titol' => 'Ferrari vs Ford',
                'genere' => 'Acció',
                'poster' => '/LeManse.jpg',
                'duracio' => '115 min',
                'descripcio' => 'Descripció de Ferrari vs Ford'
            ],
            [
                'titol' => 'Lamborhgini',
                'genere' => 'Acció',
                'poster' => '/Lamborghini.jpg',
                'duracio' => '110 min',
                'descripcio' => 'Descripció de Lamborhgini'
            ],
            [
                'titol' => 'Kill Bill',
                'genere' => 'Acció',
                'poster' => '/KillBill.jpg',
                'duracio' => '137 min',
                'descripcio' => 'Descripció de Kill Bill'
            ],
        ];

        // Insertar datos en la base de datos
        DB::table('peliculas')->insert($peliculas);
    }
}
