<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta la migración.
     *
     * Este método crea la tabla `empleadores` en la base de datos, con las columnas necesarias
     * para almacenar la información de los empleadores que se registran en el sistema.
     * Además, define las relaciones entre las tablas, como la relación entre `empleadores` y `usuarios`.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('empleadores', function (Blueprint $table) {
            $table->id();  // Definir una columna 'id' como llave primaria
            $table->foreignId('usuario_id')  // Relación con la tabla `usuarios`
            ->constrained('usuarios', 'id_usuario')  // Establece la clave foránea con la tabla `usuarios`
            ->onDelete('cascade');  // Si se elimina un usuario, se eliminará su correspondiente empleador
            $table->string('nit')->unique();  // NIT del empleador, debe ser único
            $table->string('correo_empresarial');  // Correo empresarial del empleador
            $table->string('nombre_empresa');  // Nombre de la empresa
            $table->text('direccion_empresa');  // Dirección de la empresa
            $table->string('telefono_contacto');  // Teléfono de contacto
            $table->string('sitio_web')->nullable();  // Sitio web de la empresa, puede ser nulo
            $table->string('sector')->nullable();  // Sector de la empresa, puede ser nulo
            $table->string('ubicacion')->nullable();  // Ubicación de la empresa, puede ser nula
            $table->integer('numero_empleados')->nullable();  // Número de empleados de la empresa, puede ser nulo
            $table->text('descripcion')->nullable();  // Descripción de la empresa, puede ser nula
            $table->text('mision')->nullable();  // Misión de la empresa, puede ser nula
            $table->text('vision')->nullable();  // Visión de la empresa, puede ser nula
            $table->text('beneficios')->nullable();  // Beneficios de la empresa, puede ser nula
            $table->string('logo_empresa')->nullable();  // Logo de la empresa, puede ser nulo
            $table->timestamps();  // Timestamps para las fechas de creación y actualización del registro
        });
    }

    /**
     * Revierte la migración.
     *
     * Este método elimina la tabla `empleadores` si se necesita revertir la migración.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('empleadores');  // Elimina la tabla 'empleadores'
    }
};
