<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleador extends Model
{
    use HasFactory;

    /**
     * La tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'empleadores';

    /**
     * Los atributos que son asignables de manera masiva.
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
     * Obtener el usuario que posee el empleador.
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'id_usuario');
    }
}
