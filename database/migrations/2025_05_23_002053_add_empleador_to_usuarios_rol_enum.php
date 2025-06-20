<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta la migración.
     *
     * Esta migración modifica la columna `rol` de la tabla `usuarios` para permitir tres valores en el campo `enum`:
     * - 'admin'
     * - 'empleado'
     * - 'empleador'
     *
     * Se establece el valor por defecto como 'empleado'.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->enum('rol', ['admin', 'empleado', 'empleador'])
                ->default('empleado')  // Establece 'empleado' como valor por defecto
                ->change();  // Cambia la definición de la columna `rol`
        });
    }

    /**
     * Revierte la migración.
     *
     * Esta función revierte los cambios hechos por la función `up()`.
     * Restaura la columna `rol` de la tabla `usuarios` a su estado anterior,
     * limitando los valores posibles del `enum` a 'admin' y 'empleado',
     * con 'empleado' como valor por defecto.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            // Rollback al enum original, eliminando 'empleador' como opción
            $table->enum('rol', ['admin', 'empleado'])
                ->default('empleado')  // Establece 'empleado' como valor por defecto
                ->change();  // Cambia de nuevo la definición de la columna `rol`
        });
    }
};
