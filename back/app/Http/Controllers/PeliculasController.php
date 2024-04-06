<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peliculas;

class PeliculasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todas las películas
        $peliculas = Peliculas::all();

        // Devolver respuesta
        return response()->json($peliculas);
    }

    /**
    * Store a newly created resource in storage.
    */
    public function store(Request $request)
    {
        $request->validate([
            'titol' => 'required|string|max:255',
            'genere' => 'required|string|max:255',
            'descripcio' => 'required|string|max:255', 
            'poster' => 'nullable|string|max:255',
            'duracio' => 'required|string|max:255',
        ]);

        $pelicula = Peliculas::create([
            'titol' =>  $request->titol,
            'genere' => $request->genere,
            'descripcio' => $request->descripcio,
            'poster' => $request->poster,
            'duracio' => $request->duracio,
        ]);

        return response()->json($pelicula, 201); 
    }


    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        // Buscar la película por ID
        $pelicula = Peliculas::findOrFail($id); // Si no encuentra la película, devolverá un error 404
    
        // Devolver respuesta
        return response()->json($pelicula);
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
        // Buscar la película por ID
        $pelicula = Peliculas::findOrFail($id); // Si no encuentra la película, devolverá un error 404

        // Eliminar la película
        $pelicula->delete();

        // Devolver respuesta
        return response()->json(null, 204);
    }
}
