<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vista_perfils', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empleado_id'); // El perfil que fue visto
            $table->unsignedBigInteger('visitante_id')->nullable(); // Quién vio el perfil (puede ser null si no está logueado)
            $table->string('user_agent')->nullable();
            $table->string('ip')->nullable();
            $table->timestamps();

            $table->foreign('empleado_id')->references('id_usuario')->on('usuarios')->onDelete('cascade');
            $table->foreign('visitante_id')->references('id_usuario')->on('usuarios')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vista_perfils');
    }
};
