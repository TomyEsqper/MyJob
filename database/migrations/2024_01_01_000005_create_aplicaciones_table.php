<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('aplicaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('oferta_id');
            $table->unsignedBigInteger('empleado_id');
            $table->enum('estado', ['pendiente', 'revisada', 'aceptada', 'rechazada'])->default('pendiente');
            $table->timestamp('fecha_aplicacion')->useCurrent();
            $table->timestamps();

            $table->foreign('oferta_id')->references('id')->on('ofertas')->onDelete('cascade');
            $table->foreign('empleado_id')->references('id_usuario')->on('usuarios')->onDelete('cascade');
            $table->unique(['oferta_id', 'empleado_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('aplicaciones');
    }
}; 