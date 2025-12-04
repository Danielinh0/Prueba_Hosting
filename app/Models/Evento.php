<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Evento extends Model
{
    use SoftDeletes;

    protected $table = 'eventos';
    protected $primaryKey = 'id_evento';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'descripcion',
        'fecha_inicio',
        'fecha_fin',
        'cupo_max_equipos',
        'ruta_imagen',
        'estado',
        'tipo_proyecto',
    ];

    protected $casts = [
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
    ];

    /**
     * Relación muchos a muchos con Jurado a través de la tabla evento_jurados.
     */
    public function jurados()
    {
        return $this->belongsToMany(Jurado::class, 'evento_jurados', 'id_evento', 'id_jurado');
    }

    /**
     * Relación uno a muchos con InscripcionEvento.
     */
    public function inscripciones()
    {
        return $this->hasMany(InscripcionEvento::class, 'id_evento', 'id_evento');
    }

    /**
     * Relación uno a muchos con ProyectoEvento.
     */
    public function proyectosEvento()
    {
        return $this->hasMany(ProyectoEvento::class, 'id_evento', 'id_evento');
    }

    /**
     * Proyecto general del evento (sin inscripción específica).
     */
    public function proyectoGeneral()
    {
        return $this->hasOne(ProyectoEvento::class, 'id_evento', 'id_evento')
                    ->whereNull('id_inscripcion');
    }

    /**
     * Proyectos individuales del evento (con inscripción específica).
     */
    public function proyectosEventoIndividuales()
    {
        return $this->hasMany(ProyectoEvento::class, 'id_evento', 'id_evento')
                    ->whereNotNull('id_inscripcion');
    }

    /**
     * Scope para eventos en progreso.
     */
    public function scopeEnProgreso($query)
    {
        return $query->where('estado', 'En Progreso');
    }

    /**
     * Cambiar el estado del evento a "En Progreso".
     */
    public function cambiarAEnProgreso()
    {
        if (in_array($this->estado, ['Activo', 'Cerrado'])) {
            $this->estado = 'En Progreso';
            $this->save();
            return true;
        }
        return false;
    }

    /**
     * Verificar si todos los proyectos individuales están publicados.
     */
    public function todosProyectosIndividualesPublicados()
    {
        if ($this->tipo_proyecto !== 'individual') {
            return false;
        }

        $totalEquiposCompletos = $this->inscripciones()
            ->where('status_registro', 'Completo')
            ->count();

        if ($totalEquiposCompletos === 0) {
            return false;
        }

        $proyectosPublicados = $this->proyectosEventoIndividuales()
            ->where('publicado', true)
            ->count();

        return $totalEquiposCompletos === $proyectosPublicados;
    }

    /**
     * Criterios de evaluación del evento
     */
    public function criteriosEvaluacion()
    {
        return $this->hasMany(CriterioEvaluacion::class, 'id_evento', 'id_evento');
    }

    /**
     * Verificar si la suma de ponderaciones es 100%
     */
    public function ponderacionesCompletas(): bool
    {
        return $this->criteriosEvaluacion()->sum('ponderacion') === 100;
    }

    /**
     * Verificar si el evento puede ser activado
     * (debe tener criterios y ponderaciones completas)
     */
    public function puedeSerActivado(): bool
    {
        return $this->criteriosEvaluacion()->count() > 0 && $this->ponderacionesCompletas();
    }

    /**
     * Verificar si se pueden cambiar los criterios de evaluación
     * Solo se pueden cambiar si el evento no tiene evaluaciones realizadas
     */
    public function puedeCambiarCriterios(): bool
    {
        // Si el evento está finalizado, no se pueden cambiar
        if ($this->estado === 'Finalizado') {
            return false;
        }

        // Verificar si hay evaluaciones asociadas a los criterios del evento
        $tieneEvaluaciones = EvaluacionCriterio::whereHas('criterio', function ($query) {
            $query->where('id_evento', $this->id_evento);
        })->exists();

        return !$tieneEvaluaciones;
    }
}
