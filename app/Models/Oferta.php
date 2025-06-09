<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Oferta extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion',
        'requisitos',
        'salario',
        'ubicacion',
        'tipo_contrato',
        'jornada',
        'estado',
        'empleador_id'
    ];

    protected $casts = [
        'salario' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function empleador()
    {
        return $this->belongsTo(User::class, 'empleador_id');
    }

    public function aplicaciones()
    {
        return $this->hasMany(Aplicacion::class);
    }
}
