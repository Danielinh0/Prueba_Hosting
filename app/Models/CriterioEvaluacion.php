<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CriterioEvaluacion extends Model
{
    protected $table = 'criterios_evaluacion';
    protected $primaryKey = 'id_criterio';
    public $timestamps = false;

    protected $fillable = [
        'id_evento',
        'nombre',
        'descripcion',
        'ponderacion',
    ];

    protected $casts = [
        'ponderacion' => 'integer',
    ];

    /**
     * Evento al que pertenece el criterio
     */
    public function evento()
    {
        return $this->belongsTo(Evento::class, 'id_evento', 'id_evento');
    }

    /**
     * Calificaciones de este criterio en diferentes evaluaciones
     */
    public function calificaciones()
    {
        return $this->hasMany(EvaluacionCriterio::class, 'id_criterio', 'id_criterio');
    }
}
