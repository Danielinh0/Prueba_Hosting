<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurado extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'id_usuario';

    protected $fillable = [
        'id_usuario',
        'especialidad',
        'empresa_institucion',
        'cedula_profesional',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id_usuario');
    }

    public function eventos()
    {
        return $this->belongsToMany(Evento::class, 'evento_jurados', 'id_jurado', 'id_evento');
    }

    /**
     * Evaluaciones de inscripciones/proyectos realizadas por el jurado
     */
    public function evaluaciones()
    {
        return $this->hasMany(Evaluacion::class, 'id_jurado', 'id_usuario');
    }

    /**
     * Evaluaciones de avances realizadas por el jurado
     */
    public function evaluacionesAvances()
    {
        return $this->hasMany(EvaluacionAvance::class, 'id_jurado', 'id_usuario');
    }
}