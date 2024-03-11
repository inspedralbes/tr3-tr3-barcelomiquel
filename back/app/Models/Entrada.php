<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrada extends Model
{
    use HasFactory;

    protected $table = 'entradas';

    protected $fillable = [
        'sesion_id', 
        'asientos', 
        'precio'
    ];

    protected $casts = [
        'asientos' => 'array', // Esto asegura que Laravel maneje el campo 'asientos' como un array
    ];

    public function sesion()
    {
        return $this->belongsTo(Sesion::class, 'sesion_id');
    }
}

