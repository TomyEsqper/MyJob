<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notificacion extends Model
{
    use HasFactory;

    protected $table = 'notificaciones';

    protected $fillable = [
        'usuario_id',
        'tipo',
        'titulo',
        'mensaje',
        'icono',
        'color',
        'url',
        'leida',
        'leida_en'
    ];

    protected $casts = [
        'leida' => 'boolean',
        'leida_en' => 'datetime',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'id_usuario');
    }

    public function marcarComoLeida()
    {
        $this->update([
            'leida' => true,
            'leida_en' => now()
        ]);
    }

    public function getIconoClaseAttribute()
    {
        return match($this->tipo) {
            'aplicacion' => 'fas fa-user-tie',
            'mensaje' => 'fas fa-envelope',
            'sistema' => 'fas fa-cog',
            'oferta' => 'fas fa-briefcase',
            default => 'fas fa-bell'
        };
    }

    public function getColorClaseAttribute()
    {
        return match($this->color) {
            'success' => 'text-success',
            'warning' => 'text-warning',
            'danger' => 'text-danger',
            default => 'text-primary'
        };
    }
} 