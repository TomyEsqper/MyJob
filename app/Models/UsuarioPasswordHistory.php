<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsuarioPasswordHistory extends Model
{
    protected $table = 'usuario_password_histories';
    protected $fillable = [
        'usuario_id',
        'password',
    ];
} 