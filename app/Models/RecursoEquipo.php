<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecursoEquipo extends Model
{
    protected $table = 'recurso_equipos';
    protected $primaryKey = 'id_recurso';

    protected $fillable = [
        'id_equipo',
        'nombre',
        'tipo',
        'url',
        'descripcion',
        'subido_por',
    ];

    /**
     * Equipo al que pertenece el recurso
     */
    public function equipo()
    {
        return $this->belongsTo(Equipo::class, 'id_equipo', 'id_equipo');
    }

    /**
     * Usuario que subió el recurso
     */
    public function subidoPor()
    {
        return $this->belongsTo(User::class, 'subido_por', 'id_usuario');
    }

    /**
     * Scope para filtrar por tipo
     */
    public function scopeTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    /**
     * Accessor para ícono según tipo
     */
    public function getIconoAttribute()
    {
        return match($this->tipo) {
            'documento' => '📄',
            'link' => '🔗',
            'video' => '🎥',
            'imagen' => '🖼️',
            default => '📎'
        };
    }
}
