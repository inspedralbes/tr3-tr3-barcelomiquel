<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Entrada;
use App\Models\Sesion;
use App\Mail\ConfirmacionCompra;
use Illuminate\Support\Facades\Mail;

class EntradaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todas las entradas
        $entradas = Entrada::all();
        
        // Devolver una respuesta
        return response()->json($entradas);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request){
        $validated = $request->validate([
            'sesion_id' => 'required|exists:sesiones,id',
            'asientos.*.asiento' => 'required|string',
            'asientos.*.precio' => 'required|int',
            'email' => 'required|email',
            'titol_pelicula' => 'required|string', 
            'metodo_pago' => 'required|string',
        ]);
    
        try {
            DB::beginTransaction();
    
            $asientosSeleccionados = [];
    
            foreach ($validated['asientos'] as $asiento) {
                $entrada = Entrada::create([
                    'sesion_id' => $validated['sesion_id'],
                    'asiento' => $asiento['asiento'],
                    'precio' => $asiento['precio'],
                    'email' => $validated['email'],
                    'titol_pelicula' => $validated['titol_pelicula'],
                    'metodo_pago' => $validated['metodo_pago'],
                ]);
    
                $asientosSeleccionados[] = [
                    'asiento' => $entrada->asiento,
                    'precio' => $entrada->precio,
                ];
            }
    
            DB::commit();
    
            // Construye los datos para el correo electrónico
            $datosCorreo = [
                'entradas' => $asientosSeleccionados,
                'precioTotal' => array_sum(array_column($asientosSeleccionados, 'precio')),
                'metodoPago' => $validated['metodo_pago'],
                'titolPelicula' => $validated['titol_pelicula'],
            ];
    
            // Envía el correo electrónico de confirmación
            Mail::to($validated['email'])->send(new ConfirmacionCompra($datosCorreo));
    
            return response()->json(['message' => 'Entradas guardadas correctamente'], 201);
            
        } catch (\Exception $e) {
            DB::rollBack();
    
            return response()->json(['message' => 'Error al guardar las entradas: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Buscar la entrada por ID
        $entrada = Entrada::findOrFail($id);

        // Devolver una respuesta
        return response()->json($entrada);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validar los datos de entrada
        $validated = $request->validate([
            'asientos' => 'array',
            'precio' => 'numeric',
        ]);

        // Buscar la entrada por ID
        $entrada = Entrada::findOrFail($id);

        // Actualizar la entrada
        $entrada->update($validated);

        // Devolver una respuesta
        return response()->json($entrada, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Buscar la entrada por ID y eliminarla
        $entrada = Entrada::findOrFail($id);
        $entrada->delete();

        // Devolver una respuesta
        return response()->json(null, 204);
    }
}
