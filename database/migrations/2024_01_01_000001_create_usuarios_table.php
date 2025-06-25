<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta la migración.
     */
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('id_usuario');
            $table->string('nombre_usuario');
            $table->string('correo_electronico')->unique();
            $table->string('contrasena');
            $table->enum('rol', ['empleado', 'empleador', 'admin'])->default('empleado');
            $table->string('google_id')->nullable();
            $table->text('google_token')->nullable();
            $table->string('foto_perfil')->nullable();
            $table->boolean('activo')->default(true);
            $table->string('token_activacion')->nullable();
            // Campos comunes
            $table->string('telefono')->nullable();
            $table->string('ubicacion')->nullable();
            $table->text('descripcion')->nullable();
            // Campos específicos de empleado
            $table->string('profesion')->nullable();
            $table->text('experiencia')->nullable();
            $table->text('educacion')->nullable();
            $table->text('habilidades')->nullable();
            $table->string('cv_path')->nullable();
            // Preferencias y configuración
            $table->string('idioma')->default('es');
            $table->string('tema')->default('claro');
            $table->string('privacidad_perfil')->default('publico');
            // Campos adicionales de perfil
            $table->string('whatsapp')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('linkedin')->nullable();
            $table->text('resumen_profesional')->nullable();
            $table->string('disponibilidad_horario')->nullable();
            $table->string('disponibilidad_jornada')->nullable();
            $table->boolean('disponibilidad_movilidad')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Revierte la migración.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
}; 