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
        Schema::create('ofertas', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('categoria');
            $table->text('descripcion');
            $table->text('requisitos');
            $table->text('responsabilidades')->nullable();
            $table->decimal('salario', 10, 2)->nullable();
            $table->decimal('salario_max', 10, 2)->nullable();
            $table->string('ubicacion');
            $table->string('modalidad_trabajo');
            $table->string('tipo_contrato');
            $table->string('jornada');
            $table->string('nivel_experiencia');
            $table->json('beneficios')->nullable();
            $table->enum('estado', ['activa', 'inactiva'])->default('activa');
            $table->date('fecha_limite')->nullable();
            $table->unsignedBigInteger('empleador_id');
            $table->foreign('empleador_id')->references('id_usuario')->on('usuarios')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ofertas');
    }
};
