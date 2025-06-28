<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('documentos_empresa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empleador_id')->constrained('empleadores')->onDelete('cascade');
            $table->string('tipo_documento')->default('general');
            $table->string('nombre_archivo');
            $table->string('ruta_archivo');
            $table->string('estado')->default('pendiente'); // pendiente, aprobado, rechazado
            $table->text('comentarios_admin')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('documentos_empresa');
    }
}; 