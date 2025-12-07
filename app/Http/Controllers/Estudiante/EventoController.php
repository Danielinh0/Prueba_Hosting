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
    public function index(Request $request)
    {
        $user = Auth::user();
        $idUsuario = $user->id_usuario;
        
        // Obtener parámetros de búsqueda
        $search = $request->input('search');
        $statusFilter = $request->input('status');

        // Obtener IDs de todos los eventos donde el usuario está inscrito
        $eventosInscritosIds = Evento::whereHas('inscripciones.miembros', function ($query) use ($idUsuario) {
            $query->where('id_estudiante', $idUsuario);
        })->pluck('id_evento');

        // Si hay filtro de estado, mostrar solo esa sección
        if ($statusFilter) {
            // Mis eventos inscritos con ese estado
            $misEventosEnProgresoQuery = Evento::whereIn('id_evento', $eventosInscritosIds)
                ->where('estado', $statusFilter);
            
            if ($search) {
                $misEventosEnProgresoQuery->where('nombre', 'like', "%{$search}%");
            }
            
            $misEventosEnProgreso = $statusFilter === 'En Progreso' 
                ? $misEventosEnProgresoQuery->orderBy('fecha_inicio', 'desc')->get() 
                : collect();
            
            $misOtrosEventosInscritos = $statusFilter !== 'En Progreso' 
                ? $misEventosEnProgresoQuery->orderBy('fecha_inicio', 'desc')->get() 
                : collect();
            
            // Eventos disponibles con ese estado
            $eventosActivosQuery = Evento::where('estado', $statusFilter)
                ->whereNotIn('id_evento', $eventosInscritosIds)
                ->with('jurados.user');
            
            if ($search) {
                $eventosActivosQuery->where('nombre', 'like', "%{$search}%");
            }
            
            $eventosActivos = $statusFilter === 'Activo' 
                ? $eventosActivosQuery->orderBy('fecha_inicio', 'asc')->get() 
                : collect();
            
            $eventosProximos = $statusFilter === 'Próximo' 
                ? $eventosActivosQuery->orderBy('fecha_inicio', 'asc')->get() 
                : collect();
        } else {
            // Sin filtro de estado - mostrar todo
            $misEventosEnProgresoQuery = Evento::whereIn('id_evento', $eventosInscritosIds)
                ->where('estado', 'En Progreso');
            
            if ($search) {
                $misEventosEnProgresoQuery->where('nombre', 'like', "%{$search}%");
            }
            
            $misEventosEnProgreso = $misEventosEnProgresoQuery->orderBy('fecha_inicio', 'desc')->get();

            $misOtrosEventosInscritosQuery = Evento::whereIn('id_evento', $eventosInscritosIds)
                ->where('estado', '!=', 'En Progreso');
                
            if ($search) {
                $misOtrosEventosInscritosQuery->where('nombre', 'like', "%{$search}%");
            }
            
            $misOtrosEventosInscritos = $misOtrosEventosInscritosQuery->orderBy('fecha_inicio', 'desc')->get();

            $eventosActivosQuery = Evento::where('estado', 'Activo')
                                     ->whereNotIn('id_evento', $eventosInscritosIds)
                                     ->with('jurados.user');
            
            if ($search) {
                $eventosActivosQuery->where('nombre', 'like', "%{$search}%");
            }
            
            $eventosActivos = $eventosActivosQuery->orderBy('fecha_inicio', 'asc')->get();
            
            $eventosProximosQuery = Evento::where('estado', 'Próximo')
                                     ->whereNotIn('id_evento', $eventosInscritosIds)
                                     ->with('jurados.user');
                                     
            if ($search) {
                $eventosProximosQuery->where('nombre', 'like', "%{$search}%");
            }
            
            $eventosProximos = $eventosProximosQuery->orderBy('fecha_inicio', 'asc')->get();
        }
        
        // Aplicar filtro de inscripción
        $inscripcionFilter = $request->input('inscripcion');
        if ($inscripcionFilter === 'inscrito') {
            // Solo eventos inscritos
            $eventosActivos = collect();
            $eventosProximos = collect();
        } elseif ($inscripcionFilter === 'no_inscrito') {
            // Solo eventos no inscritos
            $misEventosEnProgreso = collect();
            $misOtrosEventosInscritos = collect();
        }
                                 
        return view('estudiante.eventos.index', compact(
            'misEventosEnProgreso',
            'misOtrosEventosInscritos',
            'eventosActivos',
            'eventosProximos',
            'search',
            'statusFilter',
            'inscripcionFilter'
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

    /**
     * Mostrar las posiciones de los equipos en el evento
     */
    public function posiciones(Evento $evento)
    {
        // Verificar que el evento esté finalizado
        if ($evento->estado !== 'Finalizado') {
            return redirect()->route('estudiante.eventos.show', $evento)
                ->with('error', 'El evento aún no ha finalizado.');
        }

        // Obtener inscripciones con sus equipos, ordenadas por puesto_ganador
        $inscripciones = $evento->inscripciones()
            ->with(['equipo', 'miembros.user'])
            ->whereNotNull('puesto_ganador')
            ->orderBy('puesto_ganador')
            ->get();

        // Obtener el equipo del usuario actual (si participa)
        $user = Auth::user();
        $miInscripcion = $evento->inscripciones()
            ->whereHas('miembros', function ($query) use ($user) {
                $query->where('id_estudiante', $user->id_usuario);
            })
            ->first();

        return view('estudiante.eventos.posiciones', compact('evento', 'inscripciones', 'miInscripcion'));
    }
}
