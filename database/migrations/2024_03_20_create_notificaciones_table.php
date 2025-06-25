<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('notificaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id');
            $table->string('tipo'); // 'aplicacion', 'mensaje', 'sistema', etc.
            $table->string('titulo');
            $table->text('mensaje');
            $table->string('icono')->nullable();
            $table->string('color')->default('primary'); // primary, success, warning, danger
            $table->string('url')->nullable();
            $table->boolean('leida')->default(false);
            $table->timestamp('leida_en')->nullable();
            $table->timestamps();

            $table->foreign('usuario_id')
                  ->references('id_usuario')
                  ->on('usuarios')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('notificaciones');
    }
}; 