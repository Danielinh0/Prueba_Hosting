<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProyectoEvento extends Model
{
    protected $table = 'proyectos_evento';
    protected $primaryKey = 'id_proyecto_evento';
    
    protected $fillable = [
        'id_evento',
        'id_inscripcion',
        'titulo',
        'descripcion_completa',
        'objetivo',
        'requisitos',
        'premios',
        'archivo_bases',
        'archivo_recursos',
        'url_externa',
        'publicado',
        'fecha_publicacion'
    ];

    protected $casts = [
        'publicado' => 'boolean',
        'fecha_publicacion' => 'datetime',
    ];

    /**
     * Evento al que pertenece el proyecto
     */
    public function evento()
    {
        return $this->belongsTo(Evento::class, 'id_evento', 'id_evento');
    }

    /**
     * Inscripción específica (si es para un solo equipo)
     * NULL = para todos los equipos
     */
    public function inscripcion()
    {
        return $this->belongsTo(InscripcionEvento::class, 'id_inscripcion', 'id_inscripcion');
    }

    /**
     * Scope para proyectos publicados
     */
    public function scopePublicados($query)
    {
        return $query->where('publicado', true);
    }

    /**
     * Scope para proyectos generales (sin inscripción específica)
     */
    public function scopeGenerales($query)
    {
        return $query->whereNull('id_inscripcion');
    }

    /**
     * Scope para proyectos de un equipo específico
     */
    public function scopeParaEquipo($query, $inscripcion)
    {
        $evento = $inscripcion->evento;
        
        if ($evento->tipo_proyecto == 'general') {
            // Buscar proyecto general (sin inscripción)
            return $query->where('id_evento', $evento->id_evento)
                        ->whereNull('id_inscripcion');
        } else {
            // Buscar proyecto específico del equipo
            return $query->where('id_inscripcion', $inscripcion->id_inscripcion);
        }
    }

    /**
     * Publicar el proyecto
     */
    public function publicar()
    {
        $this->publicado = true;
        $this->fecha_publicacion = now();
        $this->save();
    }

    /**
     * Despublicar el proyecto
     */
    public function despublicar()
    {
        $this->publicado = false;
        $this->fecha_publicacion = null;
        $this->save();
    }

    /**
     * Verificar si es un proyecto general (para todos los equipos)
     */
    public function esGeneral()
    {
        return $this->id_inscripcion === null;
    }

    /**
     * Verificar si es un proyecto individual (para un equipo específico)
     */
    public function esIndividual()
    {
        return $this->id_inscripcion !== null;
    }
}
