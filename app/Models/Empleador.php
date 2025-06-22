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
     * Este atributo define el nombre de la tabla en la base de datos que
     * será utilizada por este modelo. En este caso, se asocia con la
     * tabla 'empleadores'.
     *
     * @var string
     */
    protected $table = 'empleadores';

    /**
     * Los atributos que son asignables de manera masiva.
     *
     * Este atributo define los campos de la tabla que pueden ser asignados
     * de manera masiva (por ejemplo, usando el método create).
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'beneficios' => 'array',
    ];

    /**
     * Obtener el usuario que posee el empleador.
     *
     * Este método establece una relación inversa entre el modelo `Empleador`
     * y el modelo `Usuario`. Un empleador está asociado a un usuario (empleador).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'id_usuario');
    }
}
