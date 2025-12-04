<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluacionCriterio extends Model
{
    protected $table = 'evaluacion_criterios';
    public $timestamps = false;

    protected $fillable = [
        'id_evaluacion',
        'id_criterio',
        'calificacion',
    ];

    protected $casts = [
        'calificacion' => 'decimal:2',
    ];

    /**
     * Evaluación a la que pertenece esta calificación
     */
    public function evaluacion()
    {
        return $this->belongsTo(Evaluacion::class, 'id_evaluacion', 'id_evaluacion');
    }

    /**
     * Criterio que se está calificando
     */
    public function criterio()
    {
        return $this->belongsTo(CriterioEvaluacion::class, 'id_criterio', 'id_criterio');
    }
}
