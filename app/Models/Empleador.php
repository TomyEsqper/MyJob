<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleador extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'empleadores';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'usuario_id',
        'nit',
        'correo_empresarial',
        'nombre_empresa',
        'direccion_empresa',
        'telefono_contacto',
        'sitio_web',
        'sector',
        'ubicacion',
        'numero_empleados',
        'descripcion',
        'mision',
        'vision',
        'beneficios',
        'logo_empresa'
    ];

    /**
     * Get the usuario that owns the empleador.
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'id_usuario');
    }
} 