<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    public $timestamps = true;

    protected $fillable = [
        'nombre_usuario',
        'correo_electronico',
        'contrasena',
        'rol',
        'google_id',
        'google_token',
        'foto_perfil',
        'activo',
        'token_activacion',
        // Campos comunes
        'telefono',
        'ubicacion',
        'descripcion',
        // Campos de empleado
        'profesion',
        'experiencia',
        'educacion',
        'habilidades',
        'cv_path'
    ];

    protected $hidden = [
        'contrasena',
        'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->contrasena;
    }

    /**
     * Get the empleador associated with the usuario.
     */
    public function empleador()
    {
        return $this->hasOne(Empleador::class, 'usuario_id', 'id_usuario');
    }

    /**
     * Verifica si el usuario es un empleador
     */
    public function esEmpleador()
    {
        return $this->rol === 'empleador';
    }

    // Método para obtener las ofertas de un empleador
    public function ofertas()
    {
        return $this->hasMany(Oferta::class, 'empleador_id', 'id_usuario');
    }

    // Método para obtener el conteo de ofertas activas
    public function getOfertasCountAttribute()
    {
        return $this->ofertas()->where('estado', 'activa')->count();
    }

    // Relación con las aplicaciones (para empleados)
    public function aplicaciones()
    {
        return $this->hasMany(Aplicacion::class, 'empleado_id', 'id_usuario');
    }

    /**
     * Override para el sistema de reseteo de contraseña de Laravel
     * Devuelve el correo personalizado.
     */
    public function getEmailForPasswordReset()
    {
        return $this->correo_electronico;
    }

    /**
     * Historial de contraseñas del usuario
     */
    public function passwordHistories()
    {
        return $this->hasMany(\App\Models\UsuarioPasswordHistory::class, 'usuario_id', 'id_usuario');
    }

    public function notificaciones()
    {
        return $this->hasMany(Notificacion::class, 'usuario_id', 'id_usuario');
    }
}
