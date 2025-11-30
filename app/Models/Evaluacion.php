<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluacion extends Model
{
    protected $table = 'evaluaciones';
    protected $primaryKey = 'id_evaluacion';
    
    protected $fillable = [
        'id_inscripcion',
        'id_jurado',
        'calificacion_innovacion',
        'calificacion_funcionalidad',
        'calificacion_presentacion',
        'calificacion_impacto',
        'calificacion_final',
        'comentarios_fortalezas',
        'comentarios_areas_mejora',
        'comentarios_generales',
        'estado'
    ];

    protected $casts = [
        'calificacion_innovacion' => 'decimal:2',
        'calificacion_funcionalidad' => 'decimal:2',
        'calificacion_presentacion' => 'decimal:2',
        'calificacion_impacto' => 'decimal:2',
        'calificacion_final' => 'decimal:2',
    ];

    /**
     * Inscripción evaluada
     */
    public function inscripcion()
    {
        return $this->belongsTo(InscripcionEvento::class, 'id_inscripcion', 'id_inscripcion');
    }

    /**
     * Jurado evaluador
     */
    public function jurado()
    {
        return $this->belongsTo(Jurado::class, 'id_jurado', 'id_usuario');
    }

    /**
     * Calcular calificación final promedio
     */
    public function calcularCalificacionFinal()
    {
        $criterios = [
            $this->calificacion_innovacion,
            $this->calificacion_funcionalidad,
            $this->calificacion_presentacion,
            $this->calificacion_impacto,
        ];

        $criteriosValidos = array_filter($criterios, fn($c) => $c !== null);
        
        if (count($criteriosValidos) === 0) {
            return null;
        }

        return round(array_sum($criteriosValidos) / count($criteriosValidos), 2);
    }

    /**
     * Verificar si la evaluación está completa
     */
    public function estaCompleta(): bool
    {
        return $this->calificacion_innovacion !== null &&
               $this->calificacion_funcionalidad !== null &&
               $this->calificacion_presentacion !== null &&
               $this->calificacion_impacto !== null;
    }

    /**
     * Finalizar evaluación
     */
    public function finalizar()
    {
        $this->calificacion_final = $this->calcularCalificacionFinal();
        $this->estado = 'Finalizada';
        $this->save();
    }
}
