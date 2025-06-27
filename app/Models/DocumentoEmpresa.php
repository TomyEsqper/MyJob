<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DocumentoEmpresa extends Model
{
    use HasFactory;

    protected $table = 'documentos_empresa';

    protected $fillable = [
        'empleador_id',
        'nombre_archivo',
        'ruta_archivo',
        'tipo_documento'
    ];

    public function empleador()
    {
        return $this->belongsTo(Empleador::class);
    }

    public static function getTiposDocumento()
    {
        return [
            'registro_mercantil' => 'Registro Mercantil',
            'rut' => 'RUT',
            'cedula_representante' => 'Cédula del Representante Legal',
            'certificado_existencia' => 'Certificado de Existencia',
            'otros' => 'Otros Documentos'
        ];
    }
} 