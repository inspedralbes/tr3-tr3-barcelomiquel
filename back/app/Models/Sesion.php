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
        'dia_espectador', 
        'VIP'
    ];

    public function pelicula()
    {
        return $this->belongsTo(Peliculas::class, 'pelicula_id');
    }
}

