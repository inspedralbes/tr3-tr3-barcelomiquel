<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peliculas extends Model
{
    use HasFactory;

    protected $table = 'peliculas';

    protected $fillable = [
        'id',
        'titol',
        'genere',
        'descripcio',
        'poster',
        'duracio',
    ];

    protected $casts = [
        'butacasOcupadas' => 'array',
    ];
}
