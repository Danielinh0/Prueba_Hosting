<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class TokenJurado extends Model
{
    use HasFactory;
    protected $table = 'tokens_jurado';
    protected $primaryKey = 'id_token';

    /**
     *? Indica si el modelo debe tener marcas de tiempo (created_at, updated_at).
     * ?Ponlo en FALSE si en tu migración no pusiste $table->timestamps();
     */
    public $timestamps = true; 
    protected $fillable = [
        'token',
        'usado',
        'fecha_expiracion',
        'email_invitado',
        'nombre_destinatario',
        'apellido_paterno',
        'apellido_materno',
        'especialidad_sugerida',
        'empresa_institucion',
        'mensaje_personalizado',
        'eventos_asignar',
        'creado_por'
    ];


   protected $casts = [
        'usado' => 'boolean',
        'fecha_expiracion' => 'datetime',
    ];

    /**
     * Relación con el usuario que creó el token
     */
    public function creador()
    {
        return $this->belongsTo(User::class, 'creado_por', 'id_usuario');
    }

    /**
     * Scope (Filtro) para buscar tokens válidos rápidamente.
     * TokenJurado::validos()->where('token', 'ABC')->first();
     */
    public function scopeValidos($query)
    {
        return $query->where('usado', false)
                     ->where('fecha_expiracion', '>', now());
    }
}