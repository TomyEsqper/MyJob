<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('experiencias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id');
            $table->string('puesto');
            $table->string('empresa');
            $table->string('periodo')->nullable();
            $table->text('descripcion')->nullable();
            $table->string('logro')->nullable();
            $table->timestamps();
            $table->foreign('usuario_id')->references('id_usuario')->on('usuarios')->onDelete('cascade');
        });
    }
    public function down() {
        Schema::dropIfExists('experiencias');
    }
}; 