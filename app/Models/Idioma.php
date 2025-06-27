<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Idioma extends Model {
    protected $table = 'idiomas';
    protected $fillable = [
        'usuario_id', 'idioma', 'nivel', 'descripcion'
    ];
    public function usuario() {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'id_usuario');
    }
} 