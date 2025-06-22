<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postulacion extends Model
{
    use HasFactory;

    
    protected $table = 'postulaciones'; // 👈 añade esto
    
    protected $fillable = [
        'oferta_id',
        'usuario_id',
        'fecha_postulacion',
        'estado',
        // Puedes añadir otros campos como 'cv', 'mensaje', etc.
    ];

    /**
     * Relación: Una postulación pertenece a una oferta.
     */
    public function oferta()
    {
        return $this->belongsTo(Oferta::class, 'oferta_id');
    }

    /**
     * Relación: Una postulación pertenece a un usuario.
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
