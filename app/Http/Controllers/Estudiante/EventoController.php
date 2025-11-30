<?php

namespace App\Http\Controllers\Estudiante;

use App\Http\Controllers\Controller;
use App\Models\Evento;
use App\Models\InscripcionEvento;
use App\Models\MiembroEquipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        // 1. Obtener los eventos en los que el usuario está inscrito
        $misEventosInscritos = Evento::whereHas('inscripciones.miembros', function ($query) use ($user) {
            $query->where('id_estudiante', $user->id_usuario);
        })->orderBy('fecha_inicio', 'desc')->get();

        $misEventosIds = $misEventosInscritos->pluck('id_evento');

        $eventosActivos = Evento::where('estado', 'Activo')
                                 ->whereNotIn('id_evento', $misEventosIds)
                                 ->orderBy('fecha_inicio', 'asc')
                                 ->get();
        
        $eventosProximos = Evento::where('estado', 'Próximo')
                                 ->whereNotIn('id_evento', $misEventosIds)
                                 ->orderBy('fecha_inicio', 'asc')
                                 ->get();
                                 
        return view('estudiante.eventos.index', compact('misEventosInscritos', 'eventosActivos', 'eventosProximos'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Evento $evento)
    {
        $evento->load('inscripciones.equipo');
        
        // Verificar si el usuario ya tiene un equipo en este evento
        $user = Auth::user();
        $yaTieneEquipo = MiembroEquipo::where('id_estudiante', $user->id_usuario)
            ->whereHas('inscripcion', function ($query) use ($evento) {
                $query->where('id_evento', $evento->id_evento);
            })
            ->exists();
        
        return view('estudiante.eventos.show', compact('evento', 'yaTieneEquipo'));
    }
}
