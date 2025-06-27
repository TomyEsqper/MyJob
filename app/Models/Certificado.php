<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Certificado extends Model {
    protected $table = 'certificados';
    protected $fillable = [
        'usuario_id', 'nombre', 'emisor', 'fecha_emision', 'fecha_vencimiento', 'descripcion'
    ];
    
    protected $casts = [
        'fecha_emision' => 'date',
        'fecha_vencimiento' => 'date',
    ];
    
    public function usuario() {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'id_usuario');
    }
} 