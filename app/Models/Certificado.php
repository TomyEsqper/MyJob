<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Certificado extends Model {
    protected $table = 'certificados';
    protected $fillable = [
        'usuario_id', 'nombre', 'institucion', 'anio', 'archivo'
    ];
    public function usuario() {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'id_usuario');
    }
} 