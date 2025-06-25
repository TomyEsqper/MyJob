<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Experiencia extends Model {
    protected $table = 'experiencias';
    protected $fillable = [
        'usuario_id', 'puesto', 'empresa', 'periodo', 'descripcion', 'logro'
    ];
    public function usuario() {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'id_usuario');
    }
} 