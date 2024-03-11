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
            'VIP' => 'required|boolean',
        ]);

        $sesion = Sesion::create([
            'pelicula_id' => $request->pelicula_id,
            'fecha' => $request->fecha,
            'dia_espectador' => $request->dia_espectador,
            'VIP' => $request->VIP,
        ]);

        return response()->json($sesion, 201);
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
