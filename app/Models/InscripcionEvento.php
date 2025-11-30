<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InscripcionEvento extends Model
{
    protected $table = 'inscripciones_evento';
    protected $primaryKey = 'id_inscripcion';
    public $timestamps = false;

    protected $fillable = [
        'id_equipo',
        'id_evento',
        'codigo_acceso_equipo',
        'puesto_ganador',
        'status_registro',
    ];

    /**
     * Relación: Una inscripción pertenece a un evento.
     */
    public function evento()
    {
        return $this->belongsTo(Evento::class, 'id_evento', 'id_evento');
    }

    /**
     * Relación: Una inscripción pertenece a un equipo.
     */
    public function equipo()
    {
        return $this->belongsTo(Equipo::class, 'id_equipo', 'id_equipo');
    }

    /**
     * Relación: Una inscripción tiene muchos miembros.
     */
    public function miembros()
    {
        return $this->hasMany(MiembroEquipo::class, 'id_inscripcion', 'id_inscripcion');
    }

    /**
     * Relación: Una inscripción tiene un proyecto (del equipo).
     */
    public function proyecto()
    {
        return $this->hasOne(Proyecto::class, 'id_inscripcion', 'id_inscripcion');
    }

    /**
     * Relación: Una inscripción puede tener un proyecto del evento específico.
     */
    public function proyectoEvento()
    {
        return $this->hasOne(ProyectoEvento::class, 'id_inscripcion', 'id_inscripcion');
    }

    /**
     * Relación: Una inscripción tiene evaluaciones de jurados.
     */
    public function evaluaciones()
    {
        return $this->hasMany(Evaluacion::class, 'id_inscripcion', 'id_inscripcion');
    }

    /**
     * Revisa la composición del equipo y actualiza el estado de la inscripción.
     * Regla #2: El equipo debe tener al menos 6 miembros.
     * Regla #3: Debe haber al menos un miembro de una carrera diferente.
     */
    public function actualizarEstadoCompletitud()
    {
        $numeroMiembros = $this->miembros()->count();

        if ($numeroMiembros < 6) {
            $this->status_registro = 'Incompleto';
            $this->save();
            return;
        }

        // Si hay 6 o más miembros, verificar diversidad de carreras
        $carrerasDistintas = $this->miembros()
            ->join('estudiantes', 'miembros_equipo.id_estudiante', '=', 'estudiantes.id_usuario')
            ->distinct('estudiantes.id_carrera')
            ->count('estudiantes.id_carrera');

        if ($carrerasDistintas > 1) {
            $this->status_registro = 'Completo';
        } else {
            // Aún se considera incompleto si no hay diversidad de carreras
            $this->status_registro = 'Incompleto';
        }

        $this->save();
    }
}