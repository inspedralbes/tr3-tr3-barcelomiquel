<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sesion extends Model
{
    use HasFactory;

    protected $table = 'sesiones';

    protected $fillable = [
        'pelicula_id', 
        'fecha', 
        'hora', 
        'preu_entrada',
        'preu_entradaVip',
        'VIP'
    ];

    public function pelicula()
    {
        return $this->belongsTo(Peliculas::class, 'pelicula_id');
    }

    public function entradas()
    {
        return $this->hasMany(Entrada::class, 'sesion_id');
    }
}

