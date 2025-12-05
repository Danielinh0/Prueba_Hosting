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
        $idUsuario = $user->id_usuario;

        // Obtener IDs de todos los eventos donde el usuario está inscrito
        $eventosInscritosIds = Evento::whereHas('inscripciones.miembros', function ($query) use ($idUsuario) {
            $query->where('id_estudiante', $idUsuario);
        })->pluck('id_evento');

        // 1. Mis Eventos "En Progreso"
        $misEventosEnProgreso = Evento::whereIn('id_evento', $eventosInscritosIds)
            ->where('estado', 'En Progreso')
            ->orderBy('fecha_inicio', 'desc')
            ->get();

        // 2. Mis otros eventos inscritos (Activos, Finalizados, etc.)
        $misOtrosEventosInscritos = Evento::whereIn('id_evento', $eventosInscritosIds)
            ->where('estado', '!=', 'En Progreso')
            ->orderBy('fecha_inicio', 'desc')
            ->get();

        // 3. Eventos disponibles para unirse (no inscritos)
        $eventosActivos = Evento::where('estado', 'Activo')
                                 ->whereNotIn('id_evento', $eventosInscritosIds)
                                 ->with('jurados.user')
                                 ->orderBy('fecha_inicio', 'asc')
                                 ->get();
        
        $eventosProximos = Evento::where('estado', 'Próximo')
                                 ->whereNotIn('id_evento', $eventosInscritosIds)
                                 ->with('jurados.user')
                                 ->orderBy('fecha_inicio', 'asc')
                                 ->get();
                                 
        return view('estudiante.eventos.index', compact(
            'misEventosEnProgreso',
            'misOtrosEventosInscritos',
            'eventosActivos',
            'eventosProximos'
        ));
    }

    /**
     * Display the specified resource.
     */
    public function show(Evento $evento)
    {
        $evento->load(['inscripciones.equipo', 'jurados.user', 'criteriosEvaluacion']);
        
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
