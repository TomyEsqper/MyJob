<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Usuario;

class Oferta extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion',
        'requisitos',
        'responsabilidades',
        'salario',
        'ubicacion',
        'tipo_contrato',
        'jornada',
        'estado',
        'empleador_id',
        'nivel_experiencia',
        'categoria',
        'beneficios',
        'modalidad_trabajo',
        'fecha_limite'
    ];

    protected $casts = [
        'salario' => 'decimal:2',
        'beneficios' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'fecha_limite' => 'date'
    ];

    public function empleador()
    {
        return $this->belongsTo(Usuario::class, 'empleador_id', 'id_usuario');
    }

    public function aplicaciones()
    {
        return $this->hasMany(Aplicacion::class);
    }

    public static function getNivelesExperiencia()
    {
        return [
            'sin_experiencia' => 'Sin experiencia',
            'junior' => 'Junior (1-3 años)',
            'semi_senior' => 'Semi-Senior (3-5 años)',
            'senior' => 'Senior (5+ años)',
            'experto' => 'Experto (8+ años)'
        ];
    }

    public static function getModalidadesTrabajo()
    {
        return [
            'presencial' => 'Presencial',
            'hibrido' => 'Híbrido',
            'remoto' => 'Remoto'
        ];
    }

    public static function getCategorias()
    {
        return [
            'tecnologia' => 'Tecnología',
            'ventas' => 'Ventas',
            'marketing' => 'Marketing',
            'administracion' => 'Administración',
            'finanzas' => 'Finanzas',
            'recursos_humanos' => 'Recursos Humanos',
            'diseno' => 'Diseño',
            'educacion' => 'Educación',
            'salud' => 'Salud',
            'otros' => 'Otros'
        ];
    }

    public static function getBeneficiosDisponibles()
    {
        return [
            'seguro_medico' => 'Seguro Médico',
            'seguro_dental' => 'Seguro Dental',
            'gimnasio' => 'Gimnasio',
            'formacion' => 'Formación Continua',
            'teletrabajo' => 'Teletrabajo',
            'horario_flexible' => 'Horario Flexible',
            'bonus_anual' => 'Bonus Anual',
            'plan_pension' => 'Plan de Pensiones',
            'tickets_restaurante' => 'Tickets Restaurante',
            'transporte' => 'Ayuda Transporte'
        ];
    }
}
