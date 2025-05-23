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
        Schema::table('usuarios', function (Blueprint $table) {
            $table->enum('rol', ['admin', 'empleado', 'empleador'])
                ->default('empleado')
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            // Rollback al enum original
            $table->enum('rol', ['admin', 'empleado'])
                ->default('empleado')
                ->change();
        });
    }
};
