<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('entrevistas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('aplicacion_id');
            $table->dateTime('fecha_hora');
            $table->string('lugar')->nullable();
            $table->text('notas')->nullable();
            $table->timestamps();

            $table->foreign('aplicacion_id')->references('id')->on('aplicaciones')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('entrevistas');
    }
}; 