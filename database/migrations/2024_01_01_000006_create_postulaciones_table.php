<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('postulaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('oferta_id');
            $table->unsignedBigInteger('usuario_id');
            $table->date('fecha_postulacion')->nullable();
            $table->string('estado')->default('pendiente'); // 'aceptado', 'rechazado'
            $table->timestamps();
            // Relaciones
            // Puedes agregar claves foráneas si lo deseas, pero en la migración original no estaban
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('postulaciones');
    }
}; 