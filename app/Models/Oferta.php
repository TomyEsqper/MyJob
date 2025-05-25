<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Oferta extends Model
{
    protected $fillable = [
        'titulo',
        'descripcion',
        'ubicacion',
        'salario',
        'tipo_contrato',
        'fecha_inicio',
        'fecha_fin',
        'empleador_id'
    ];
    public function empleador()
    {
        return $this->belongsTo(Usuario::class, 'empleador_id', 'id_usuario');
    }
}
