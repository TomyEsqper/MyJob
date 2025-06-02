<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    public $timestamps = false;

    protected $fillable = [
        'nombre_usuario',
        'correo_electronico',
        'contrasena',
        'rol',
        'nit',
        'google_id',
        'google_token',
        'foto_perfil',
        'activo',
        'token_activacion',
    ];

    protected $hidden = [
        'contrasena',
        'remember_token',
    ];

    // Para que Auth::attempt() use la columna "contrasena" en lugar de "password"
    public function getAuthPassword()
    {
        return $this->contrasena;
    }
}
