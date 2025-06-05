<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    public $timestamps = false;

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
        'cv_path',
        // Campos de empleador
        'nombre_empresa',
        'logo_empresa',
        'sector',
        'sitio_web',
        'mision',
        'vision',
        'numero_empleados',
        'beneficios'
    ];

    protected $hidden = [
        'contrasena',
        'remember_token',
    ];

    public function getAuthPassword(){
        return $this->contrasena;
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
}
