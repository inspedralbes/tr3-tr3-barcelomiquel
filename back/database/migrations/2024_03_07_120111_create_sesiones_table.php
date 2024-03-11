<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSesionesTable extends Migration
{
    public function up()
    {
        Schema::create('sesiones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelicula_id')->constrained('peliculas')->onDelete('cascade');
            $table->date('fecha');
            $table->boolean('dia_espectador');
            $table->boolean('VIP');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sesiones');
    }
}

