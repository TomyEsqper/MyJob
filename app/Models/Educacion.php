<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Educacion extends Model {
    protected $table = 'educaciones';
    protected $fillable = [
        'usuario_id', 'titulo', 'institucion', 'periodo'
    ];
    public function usuario() {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'id_usuario');
    }
} 