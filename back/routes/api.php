<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeliculasController;
use App\Http\Controllers\EntradaController;
use App\Http\Controllers\SesionController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/registro', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/peliculas', [PeliculasController::class, 'index']);
Route::post('/peliculas', [PeliculasController::class, 'store']);

Route::post('/entradas', [EntradaController::class, 'store']);
Route::get('/entradas', [EntradaController::class, 'index']);


Route::get('/sesiones', [SesionController::class, 'index']);
Route::post('/sesiones', [SesionController::class, 'store']);
Route::get('/sesiones-entradas/{id}', [SesionController::class, 'showEntradas']);
Route::get('/sesiones/{id}', [SesionController::class, 'show']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
