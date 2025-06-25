<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta la migración.
     *
     * Esta función crea la tabla `usuarios` en la base de datos con los siguientes campos:
     * - `id_usuario`: clave primaria de tipo `bigint` auto incrementable.
     * - `nombre_usuario`: campo `string` que almacena el nombre del usuario.
     * - `correo_electronico`: campo `string` único para almacenar el correo electrónico del usuario.
     * - `contrasena`: campo `string` para almacenar la contraseña cifrada del usuario.
     * - `rol`: campo `enum` con valores posibles `'empleado'`, `'empleador'` y `'admin'`, con valor por defecto `'empleado'`.
     * - `google_id`: campo `string` que almacena el ID de Google para la autenticación a través de Google.
     * - `google_token`: campo `text` que almacena el token de Google.
     * - `foto_perfil`: campo `string` para almacenar la URL de la foto de perfil del usuario.
     * - `activo`: campo `boolean` que indica si la cuenta está activa, con valor por defecto `true`.
     * - `token_activacion`: campo `string` que almacena el token de activación de la cuenta.
     * - Campos comunes:
     *   - `telefono`: campo `string` para almacenar el número de teléfono del usuario.
     *   - `ubicacion`: campo `string` para almacenar la ubicación del usuario.
     *   - `descripcion`: campo `text` para almacenar una descripción del usuario.
     * - Campos específicos de empleado:
     *   - `profesion`: campo `string` para almacenar la profesión del empleado.
     *   - `experiencia`: campo `text` para almacenar la experiencia laboral del empleado.
     *   - `educacion`: campo `text` para almacenar los estudios académicos del empleado.
     *   - `habilidades`: campo `text` para almacenar las habilidades del empleado.
     *   - `cv_path`: campo `string` para almacenar la ruta del archivo del currículum vitae del empleado.
     * - `rememberToken`: campo de tipo `string` utilizado por Laravel para gestionar la sesión del usuario.
     * - `timestamps`: campos `created_at` y `updated_at` que Laravel gestiona automáticamente.
     *
     * La tabla será creada con todos estos campos, que permiten almacenar los detalles de los usuarios y sus roles, así como otros detalles específicos según el tipo de usuario.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('id_usuario');  // ID del usuario
            $table->string('nombre_usuario');  // Nombre del usuario
            $table->string('correo_electronico')->unique();  // Correo electrónico único
            $table->string('contrasena');  // Contraseña del usuario
            $table->enum('rol', ['empleado', 'empleador', 'admin'])->default('empleado');  // Rol del usuario (empleado, empleador o admin)
            $table->string('google_id')->nullable();  // ID de Google (para autenticación con Google)
            $table->text('google_token')->nullable();  // Token de Google
            $table->string('foto_perfil')->nullable();  // Foto de perfil del usuario
            $table->boolean('activo')->default(true);  // Estado de la cuenta, activa o desactivada
            $table->string('token_activacion')->nullable();  // Token para la activación de la cuenta
            // Campos comunes
            $table->string('telefono')->nullable();  // Número de teléfono
            $table->string('ubicacion')->nullable();  // Ubicación
            $table->text('descripcion')->nullable();  // Descripción del usuario
            // Campos específicos de empleado
            $table->string('profesion')->nullable();  // Profesión del empleado
            $table->text('experiencia')->nullable();  // Experiencia laboral del empleado
            $table->text('educacion')->nullable();  // Educación del empleado
            $table->text('habilidades')->nullable();  // Habilidades del empleado
            $table->string('cv_path')->nullable();  // Ruta del archivo del currículum
            $table->rememberToken();  // Token de sesión de Laravel
            $table->timestamps();  // Campos created_at y updated_at automáticos
            $table->string('notificaciones_email')->default('todas'); // Preferencias de notificaciones
            $table->string('idioma')->default('es'); // Idioma de la plataforma
            $table->string('tema')->default('claro'); // Tema de visualización
            $table->string('privacidad_perfil')->default('publico'); // Privacidad del perfil
        });
    }

    /**
     * Revierte la migración.
     *
     * Elimina la tabla `usuarios` si ya existe.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
};
