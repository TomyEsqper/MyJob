<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aplicacion extends Model
{
    protected $table = 'aplicaciones';

    protected $fillable = [
        'oferta_id',
        'empleado_id',
        'estado',
        'fecha_aplicacion'
    ];

    public function oferta()
    {
        return $this->belongsTo(Oferta::class);
    }

    public function empleado()
    {
        return $this->belongsTo(Usuario::class, 'empleado_id', 'id_usuario');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'empleado_id', 'id_usuario');
    }
} 