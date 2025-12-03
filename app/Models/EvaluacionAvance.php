<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluacionAvance extends Model
{
    protected $table = 'evaluaciones_avances';

    protected $fillable = [
        'id_avance',
        'id_jurado',
        'calificacion',
        'comentarios',
        'fecha_evaluacion',
    ];

    protected $casts = [
        'fecha_evaluacion' => 'datetime',
        'calificacion' => 'integer',
    ];

    /**
     * Avance que se evalúa
     */
    public function avance()
    {
        return $this->belongsTo(Avance::class, 'id_avance', 'id_avance');
    }

    /**
     * Jurado que realiza la evaluación
     */
    public function jurado()
    {
        return $this->belongsTo(Jurado::class, 'id_jurado', 'id_usuario');
    }
}
