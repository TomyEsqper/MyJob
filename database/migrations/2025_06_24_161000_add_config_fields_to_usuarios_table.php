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
            if (!Schema::hasColumn('usuarios', 'notificaciones_email')) {
                $table->string('notificaciones_email')->default('todas');
            }
            if (!Schema::hasColumn('usuarios', 'idioma')) {
                $table->string('idioma')->default('es');
            }
            if (!Schema::hasColumn('usuarios', 'tema')) {
                $table->string('tema')->default('claro');
            }
            if (!Schema::hasColumn('usuarios', 'privacidad_perfil')) {
                $table->string('privacidad_perfil')->default('publico');
            }
            if (!Schema::hasColumn('usuarios', 'whatsapp')) {
                $table->string('whatsapp')->nullable();
            }
            if (!Schema::hasColumn('usuarios', 'facebook')) {
                $table->string('facebook')->nullable();
            }
            if (!Schema::hasColumn('usuarios', 'instagram')) {
                $table->string('instagram')->nullable();
            }
            if (!Schema::hasColumn('usuarios', 'linkedin')) {
                $table->string('linkedin')->nullable();
            }
            if (!Schema::hasColumn('usuarios', 'resumen_profesional')) {
                $table->text('resumen_profesional')->nullable();
            }
            if (!Schema::hasColumn('usuarios', 'disponibilidad_horario')) {
                $table->string('disponibilidad_horario')->nullable();
            }
            if (!Schema::hasColumn('usuarios', 'disponibilidad_jornada')) {
                $table->string('disponibilidad_jornada')->nullable();
            }
            if (!Schema::hasColumn('usuarios', 'disponibilidad_movilidad')) {
                $table->boolean('disponibilidad_movilidad')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            if (Schema::hasColumn('usuarios', 'notificaciones_email')) {
                $table->dropColumn('notificaciones_email');
            }
            if (Schema::hasColumn('usuarios', 'idioma')) {
                $table->dropColumn('idioma');
            }
            if (Schema::hasColumn('usuarios', 'tema')) {
                $table->dropColumn('tema');
            }
            if (Schema::hasColumn('usuarios', 'privacidad_perfil')) {
                $table->dropColumn('privacidad_perfil');
            }
            if (Schema::hasColumn('usuarios', 'whatsapp')) {
                $table->dropColumn('whatsapp');
            }
            if (Schema::hasColumn('usuarios', 'facebook')) {
                $table->dropColumn('facebook');
            }
            if (Schema::hasColumn('usuarios', 'instagram')) {
                $table->dropColumn('instagram');
            }
            if (Schema::hasColumn('usuarios', 'linkedin')) {
                $table->dropColumn('linkedin');
            }
            if (Schema::hasColumn('usuarios', 'resumen_profesional')) {
                $table->dropColumn('resumen_profesional');
            }
            if (Schema::hasColumn('usuarios', 'disponibilidad_horario')) {
                $table->dropColumn('disponibilidad_horario');
            }
            if (Schema::hasColumn('usuarios', 'disponibilidad_jornada')) {
                $table->dropColumn('disponibilidad_jornada');
            }
            if (Schema::hasColumn('usuarios', 'disponibilidad_movilidad')) {
                $table->dropColumn('disponibilidad_movilidad');
            }
        });
    }
};
