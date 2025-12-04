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
        'calificacion_final',
        'comentarios_fortalezas',
        'comentarios_areas_mejora',
        'comentarios_generales',
        'estado'
    ];

    protected $casts = [
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
     * Calificaciones por criterio de esta evaluación
     */
    public function criteriosCalificados()
    {
        return $this->hasMany(EvaluacionCriterio::class, 'id_evaluacion', 'id_evaluacion');
    }

    /**
     * Calcular calificación final ponderada
     * Fórmula: Σ (calificacion × ponderacion / 100)
     */
    public function calcularCalificacionFinal()
    {
        $calificaciones = $this->criteriosCalificados()->with('criterio')->get();
        
        if ($calificaciones->isEmpty()) {
            return null;
        }

        $total = 0;
        foreach ($calificaciones as $calificacion) {
            if ($calificacion->calificacion !== null && $calificacion->criterio) {
                $total += ($calificacion->calificacion * $calificacion->criterio->ponderacion) / 100;
            }
        }

        return round($total, 2);
    }

    /**
     * Verificar si la evaluación está completa
     * (todos los criterios del evento tienen calificación)
     */
    public function estaCompleta(): bool
    {
        // Obtener el evento a través de la inscripción
        $evento = $this->inscripcion->evento;
        
        if (!$evento) {
            return false;
        }

        // Contar criterios del evento
        $totalCriterios = $evento->criteriosEvaluacion()->count();
        
        // Contar criterios calificados en esta evaluación
        $criteriosCalificados = $this->criteriosCalificados()
            ->whereNotNull('calificacion')
            ->count();

        return $totalCriterios > 0 && $totalCriterios === $criteriosCalificados;
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

