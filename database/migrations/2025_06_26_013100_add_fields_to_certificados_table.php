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
        Schema::table('certificados', function (Blueprint $table) {
            $table->string('emisor')->nullable()->after('nombre');
            $table->date('fecha_emision')->nullable()->after('emisor');
            $table->date('fecha_vencimiento')->nullable()->after('fecha_emision');
            $table->text('descripcion')->nullable()->after('fecha_vencimiento');
            
            // Eliminar campos antiguos que ya no se usan
            $table->dropColumn(['institucion', 'anio', 'archivo']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('certificados', function (Blueprint $table) {
            $table->string('institucion')->nullable()->after('nombre');
            $table->string('anio')->nullable()->after('institucion');
            $table->string('archivo')->nullable()->after('anio');
            
            // Eliminar campos nuevos
            $table->dropColumn(['emisor', 'fecha_emision', 'fecha_vencimiento', 'descripcion']);
        });
    }
};
