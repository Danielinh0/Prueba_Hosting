<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Avance extends Model
{
    protected $table = 'avances';
    protected $primaryKey = 'id_avance';

    protected $fillable = [
        'id_proyecto',
        'id_usuario_registro',
        'titulo',
        'descripcion',
        'archivo_evidencia',
    ];

    /**
     * Proyecto al que pertenece el avance
     */
    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'id_proyecto', 'id_proyecto');
    }

    /**
     * Usuario que registró el avance
     */
    public function usuarioRegistro()
    {
        return $this->belongsTo(User::class, 'id_usuario_registro', 'id_usuario');
    }

    /**
     * Evaluaciones del avance
     */
    public function evaluaciones()
    {
        return $this->hasMany(EvaluacionAvance::class, 'id_avance', 'id_avance');
    }
}
