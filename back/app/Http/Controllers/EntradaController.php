<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entrada;

class EntradaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos de entrada
        $validated = $request->validate([
            'sesion_id' => 'required|exists:sesiones,id',
            'asientos' => 'required|array',
            'precio' => 'required|numeric',
        ]);

        // Crear la entrada
        $entrada = Entrada::create($validated);

        // Devolver una respuesta
        return response()->json($entrada, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
