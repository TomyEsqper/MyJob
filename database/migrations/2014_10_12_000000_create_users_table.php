<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
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
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
}; 