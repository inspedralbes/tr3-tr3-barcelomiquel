<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntradasTable extends Migration
{
    public function up()
    {
        Schema::create('entradas', function (Blueprint $table) {
            $table->foreignId('sesion_id')->constrained('sesiones')->onDelete('cascade');
            $table->string('asiento'); // Cambiado a string para utilizarlo como parte de la clave primaria
            $table->decimal('precio', 8, 2);
            $table->timestamps();

            // Definición de clave primaria compuesta
            $table->primary(['sesion_id', 'asiento']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('entradas');
    }
}
