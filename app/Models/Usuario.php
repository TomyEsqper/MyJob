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
        'rol'
    ];
    protected $hidden = [
        'contrasena',
        'remember_token',
    ];

    public function getAuthPassword(){
        return $this->contrasena;
    }
}
