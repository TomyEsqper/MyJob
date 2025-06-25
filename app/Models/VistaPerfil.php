<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VistaPerfil extends Model
{
    use HasFactory;

    protected $fillable = [
        'empleado_id',
        'visitante_id',
        'user_agent',
        'ip',
    ];

    public function empleado()
    {
        return $this->belongsTo(Usuario::class, 'empleado_id', 'id_usuario');
    }

    public function visitante()
    {
        return $this->belongsTo(Usuario::class, 'visitante_id', 'id_usuario');
    }
}
