<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntradasTable extends Migration
{
    public function up()
    {
        Schema::create('entradas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sesion_id')->constrained('sesiones')->onDelete('cascade');
            $table->json('asientos'); // Suponiendo que quieres almacenar múltiples asientos por entrada
            $table->decimal('precio', 8, 2); // Ajusta la precisión según necesites
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('entradas');
    }
}
