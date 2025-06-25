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
        Schema::create('empleadores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')
                ->constrained('usuarios', 'id_usuario')
                ->onDelete('cascade');
            $table->string('nit')->unique();
            $table->string('correo_empresarial');
            $table->string('nombre_empresa');
            $table->text('direccion_empresa');
            $table->string('telefono_contacto');
            $table->string('sitio_web')->nullable();
            $table->string('sector')->nullable();
            $table->string('ubicacion')->nullable();
            $table->integer('numero_empleados')->nullable();
            $table->text('descripcion')->nullable();
            $table->text('mision')->nullable();
            $table->text('vision')->nullable();
            $table->text('beneficios')->nullable();
            $table->string('logo_empresa')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Revierte la migración.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleadores');
    }
}; 