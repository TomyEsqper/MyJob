<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entrevista extends Model
{
    protected $table = 'entrevistas';

    protected $fillable = [
        'aplicacion_id',
        'fecha_hora',
        'lugar',
        'notas',
    ];

    public function aplicacion()
    {
        return $this->belongsTo(Aplicacion::class);
    }
} 