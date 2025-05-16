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
            $table->string('google_token')->nullable()->after('google_id');
            $table->string('foto_perfil')->nullable()->after('google_token');
            $table->boolean('activo')->default(false)->after('foto_perfil');
            $table->string('token_activacion')->nullable()->after('activo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table::table('usuarios', function (Blueprint $table) {
                $table->dropColumn([
                    'google_token',
                    'foto_perfil',
                    'activo',
                    'token_activacion'
                ]);
            });
        });
    }
};
