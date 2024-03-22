<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Sesion;

class SesionControllerTest extends TestCase
{
    /**
     * Test para verificar la obtención de todas las sesiones.
     *
     * @return void
     */
    public function testObtenerTodasLasSesiones()
    {
        $response = $this->get('/api/sesiones');

        $response->assertStatus(200);
    }

    // Agrega más pruebas para los métodos restantes según tus necesidades.
}
