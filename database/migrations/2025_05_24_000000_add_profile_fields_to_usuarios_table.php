<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('usuarios', function (Blueprint $table) {
            // Campos comunes
            $table->string('telefono')->nullable();
            $table->string('ubicacion')->nullable();
            $table->text('descripcion')->nullable();

            // Campos específicos para empleado
            $table->string('profesion')->nullable();
            $table->text('experiencia')->nullable();
            $table->text('educacion')->nullable();
            $table->text('habilidades')->nullable();
            $table->string('cv_path')->nullable();

            // Campos específicos para empleador
            $table->string('nombre_empresa')->nullable();
            $table->string('logo_empresa')->nullable();
            $table->string('sector')->nullable();
            $table->string('sitio_web')->nullable();
            $table->text('mision')->nullable();
            $table->text('vision')->nullable();
            $table->integer('numero_empleados')->nullable();
            $table->text('beneficios')->nullable();
        });
    }

    public function down()
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->dropColumn([
                'telefono',
                'ubicacion',
                'descripcion',
                'profesion',
                'experiencia',
                'educacion',
                'habilidades',
                'cv_path',
                'nombre_empresa',
                'logo_empresa',
                'sector',
                'sitio_web',
                'mision',
                'vision',
                'numero_empleados',
                'beneficios'
            ]);
        });
    }
}; 