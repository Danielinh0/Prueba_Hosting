<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    protected $table = 'proyectos';
    protected $primaryKey = 'id_proyecto';
    
    protected $fillable = [
        'id_inscripcion',
        'nombre',
        'descripcion_tecnica',
        'repositorio_url',
    ];

    /**
     * Inscripción del equipo
     */
    public function inscripcion()
    {
        return $this->belongsTo(InscripcionEvento::class, 'id_inscripcion', 'id_inscripcion');
    }

    /**
     * Tareas del proyecto
     */
    public function tareas()
    {
        return $this->hasMany(TareaProyecto::class, 'id_proyecto', 'id_proyecto');
    }

    /**
     * Avances del proyecto
     */
    public function avances()
    {
        return $this->hasMany(Avance::class, 'id_proyecto', 'id_proyecto');
    }

    /**
     * Tecnologías/tags del proyecto
     
        *public function tecnologias()
        *{
        *return $this->hasMany(ProyectoTecnologia::class, 'id_proyecto', 'id_proyecto');
            *}
    */


}
