<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sesion;

class SesionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sesiones = Sesion::with('pelicula')->get(); // 'with' asegura que se incluyan los datos de la película relacionada
        return response()->json($sesiones);
    }

    /**
    * Store a newly created resource in storage.
    */
    public function store(Request $request)
    {
        $request->validate([
            'pelicula_id' => 'required|exists:peliculas,id',
            'fecha' => 'required|date',
            'dia_espectador' => 'required|boolean',
            'hora' => 'required|date_format:H:i', // 'H:i' es el formato de hora 'HH:MM
            'VIP' => 'required|boolean',
        ]);

        $sesion = Sesion::create([
            'pelicula_id' => $request->pelicula_id,
            'fecha' => $request->fecha,
            'dia_espectador' => $request->dia_espectador,
            'VIP' => $request->VIP,
            'hora' => $request->hora,
        ]);

        return response()->json($sesion, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Busca la sesión por su ID y carga la película relacionada
        $sesion = Sesion::with('pelicula')->findOrFail($id);

        // Si la sesión no existe, findOrFail arrojará automáticamente un error 404
        return response()->json($sesion);
    }

    /**
    * Show the tickets for a specific session.
    */
    public function showEntradas($id)
    {
        // Busca la sesión por su ID y carga las entradas relacionadas
        $sesion = Sesion::with('entradas')->findOrFail($id);

        // Si la sesión no existe, findOrFail arrojará automáticamente un error 404
        return response()->json($sesion);
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
