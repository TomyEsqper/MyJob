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
        'token_activacion'
    ];
    protected $hidden = [
        'contrasena',
        'remember_token',
    ];

    public function getAuthPassword(){
        return $this->contrasena;
    }
}
