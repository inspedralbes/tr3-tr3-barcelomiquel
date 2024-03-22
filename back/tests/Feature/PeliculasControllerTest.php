<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Peliculas;

class PeliculasControllerTest extends TestCase
{
    /**
     * Test para verificar la creación de una nueva película.
     *
     * @return void
     */
    public function testCrearNuevaPelicula()
    {
        $response = $this->post('/api/peliculas', [
            'titol' => 'Nueva Película',
            'genere' => 'Acción',
            'descripcio' => 'Una descripción de la película',
            'duracio' => '120 minutos',
        ]);

        $response->assertStatus(201);
    }

    // Agrega más pruebas para los métodos restantes según tus necesidades.
}
