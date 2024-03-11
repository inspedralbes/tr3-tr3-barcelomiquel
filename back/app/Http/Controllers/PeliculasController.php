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
        $peliculas = Peliculas::all();
        return Peliculas::all();
    }

    /**
    * Store a newly created resource in storage.
    */
    public function store(Request $request)
    {
        // Validación de datos
        $validatedData = $request->validate([
            'titol' => 'required|string|max:255',
            'genere' => 'required|string|max:255',
            'descripcio' => 'required|string|max:255', 
            'poster' => 'nullable|string|max:255',
            'duracio' => 'required|string|max:255',
        ]);

        // Crear nueva película
        $pelicula = Peliculas::create($validatedData);

        // Devolver respuesta
        return response()->json($pelicula, 201); // 201 = Created
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         // Validación de datos
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'genere' => 'required|string|max:255',
            'poster' => 'nullable|string|max:255',
            'dia' => 'required|date',
            'imagen' => 'nullable|string|max:255',
        ]);

        // Buscar la película por ID
        $pelicula = Peliculas::findOrFail($id); // Si no encuentra la película, devolverá un error 404

        // Actualizar la película
        $pelicula->update($validatedData);

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
        //
    }
}
