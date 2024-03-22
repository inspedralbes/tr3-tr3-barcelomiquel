<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Entrada;

class EntradaControllerTest extends TestCase
{
    /**
     * Test para verificar la obtención de todas las entradas.
     *
     * @return void
     */
    public function testObtenerTodasLasEntradas()
    {
        $response = $this->get('/api/entradas');

        $response->assertStatus(200);
    }

    // Agrega más pruebas para los métodos restantes según tus necesidades.
}
