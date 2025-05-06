<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
class Usuario extends Authenticatable
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';

    protected $fillable = [
        'nombre_usuario',
        'correo_electronico',
        'contrasena',
        'rol'
    ];

    public $timestamps = false;

    protected $hidden = ['contrasena'];

    public function getAuthPassword(){
        return $this->contrasena;
    }
}
