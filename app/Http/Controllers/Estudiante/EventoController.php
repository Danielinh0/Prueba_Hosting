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
        $filtro = $request->input('filtro'); // Filtro unificado

        // Obtener IDs de todos los eventos donde el usuario está inscrito
        $eventosInscritosIds = Evento::whereHas('inscripciones.miembros', function ($query) use ($idUsuario) {
            $query->where('id_estudiante', $idUsuario);
        })->pluck('id_evento');

        // Inicializar todas las colecciones
        $misEventosEnProgreso = collect();
        $misOtrosEventosInscritos = collect();
        $eventosActivos = collect();
        $eventosProximos = collect();
        $eventosCerrados = collect();
        $eventosFinalizados = collect();

        // Determinar si aplicar filtro de estado o inscripción
        $isEstadoFilter = in_array($filtro, ['En Progreso', 'Activo', 'Próximo', 'Cerrado', 'Finalizado']);
        $isInscripcionFilter = in_array($filtro, ['inscrito', 'no_inscrito']);

        // === MIS EVENTOS EN PROGRESO (Inscrito + En Progreso) ===
        if (!$filtro || $filtro === 'En Progreso' || $filtro === 'inscrito') {
            $query = Evento::whereIn('id_evento', $eventosInscritosIds)
                ->where('estado', 'En Progreso');
            if ($search) {
                $query->where('nombre', 'like', "%{$search}%");
            }
            if (!$isInscripcionFilter || $filtro === 'inscrito') {
                $misEventosEnProgreso = $query->orderBy('fecha_inicio', 'desc')->get();
            }
        }

        // === OTROS EVENTOS INSCRITOS (Inscrito + otros estados) ===
        if (!$filtro || $isEstadoFilter || $filtro === 'inscrito') {
            $query = Evento::whereIn('id_evento', $eventosInscritosIds)
                ->where('estado', '!=', 'En Progreso');
            if ($isEstadoFilter && $filtro !== 'En Progreso') {
                $query->where('estado', $filtro);
            }
            if ($search) {
                $query->where('nombre', 'like', "%{$search}%");
            }
            if (!$isInscripcionFilter || $filtro === 'inscrito') {
                $misOtrosEventosInscritos = $query->orderBy('fecha_inicio', 'desc')->get();
            }
        }

        // === EVENTOS ACTIVOS PARA INSCRIBIRSE ===
        if (!$filtro || $filtro === 'Activo' || $filtro === 'no_inscrito') {
            $query = Evento::where('estado', 'Activo')
                ->whereNotIn('id_evento', $eventosInscritosIds)
                ->with('jurados.user');
            if ($search) {
                $query->where('nombre', 'like', "%{$search}%");
            }
            if (!$isInscripcionFilter || $filtro === 'no_inscrito') {
                $eventosActivos = $query->orderBy('fecha_inicio', 'asc')->get();
            }
        }

        // === PRÓXIMOS EVENTOS ===
        if (!$filtro || $filtro === 'Próximo' || $filtro === 'no_inscrito') {
            $query = Evento::where('estado', 'Próximo')
                ->whereNotIn('id_evento', $eventosInscritosIds)
                ->with('jurados.user');
            if ($search) {
                $query->where('nombre', 'like', "%{$search}%");
            }
            if (!$isInscripcionFilter || $filtro === 'no_inscrito') {
                $eventosProximos = $query->orderBy('fecha_inicio', 'asc')->get();
            }
        }

        // === EVENTOS CERRADOS ===
        if (!$filtro || $filtro === 'Cerrado') {
            // Eventos cerrados donde estoy inscrito
            $queryCerradosInscritos = Evento::whereIn('id_evento', $eventosInscritosIds)
                ->where('estado', 'Cerrado');
            if ($search) {
                $queryCerradosInscritos->where('nombre', 'like', "%{$search}%");
            }
            
            // Eventos cerrados donde no estoy inscrito
            $queryCerradosNoInscritos = Evento::where('estado', 'Cerrado')
                ->whereNotIn('id_evento', $eventosInscritosIds);
            if ($search) {
                $queryCerradosNoInscritos->where('nombre', 'like', "%{$search}%");
            }
            
            // Combinar ambos
            $eventosCerrados = $queryCerradosInscritos->orderBy('fecha_fin', 'desc')->get()
                ->merge($queryCerradosNoInscritos->orderBy('fecha_fin', 'desc')->get());
        }

        // === EVENTOS FINALIZADOS ===
        if (!$filtro || $filtro === 'Finalizado') {
            // Eventos finalizados donde estoy inscrito
            $queryFinalizadosInscritos = Evento::whereIn('id_evento', $eventosInscritosIds)
                ->where('estado', 'Finalizado');
            if ($search) {
                $queryFinalizadosInscritos->where('nombre', 'like', "%{$search}%");
            }
            
            // Eventos finalizados donde no estoy inscrito
            $queryFinalizadosNoInscritos = Evento::where('estado', 'Finalizado')
                ->whereNotIn('id_evento', $eventosInscritosIds);
            if ($search) {
                $queryFinalizadosNoInscritos->where('nombre', 'like', "%{$search}%");
            }
            
            // Combinar ambos
            $eventosFinalizados = $queryFinalizadosInscritos->orderBy('fecha_fin', 'desc')->get()
                ->merge($queryFinalizadosNoInscritos->orderBy('fecha_fin', 'desc')->get());
        }

        // Si es filtro de inscripción, ajustar las secciones
        if ($filtro === 'inscrito') {
            $eventosActivos = collect();
            $eventosProximos = collect();
            $eventosCerrados = Evento::whereIn('id_evento', $eventosInscritosIds)
                ->where('estado', 'Cerrado');
            if ($search) {
                $eventosCerrados->where('nombre', 'like', "%{$search}%");
            }
            $eventosCerrados = $eventosCerrados->orderBy('fecha_fin', 'desc')->get();
            
            $eventosFinalizados = Evento::whereIn('id_evento', $eventosInscritosIds)
                ->where('estado', 'Finalizado');
            if ($search) {
                $eventosFinalizados->where('nombre', 'like', "%{$search}%");
            }
            $eventosFinalizados = $eventosFinalizados->orderBy('fecha_fin', 'desc')->get();
        } elseif ($filtro === 'no_inscrito') {
            $misEventosEnProgreso = collect();
            $misOtrosEventosInscritos = collect();
            $eventosCerrados = Evento::where('estado', 'Cerrado')
                ->whereNotIn('id_evento', $eventosInscritosIds);
            if ($search) {
                $eventosCerrados->where('nombre', 'like', "%{$search}%");
            }
            $eventosCerrados = $eventosCerrados->orderBy('fecha_fin', 'desc')->get();
            
            $eventosFinalizados = Evento::where('estado', 'Finalizado')
                ->whereNotIn('id_evento', $eventosInscritosIds);
            if ($search) {
                $eventosFinalizados->where('nombre', 'like', "%{$search}%");
            }
            $eventosFinalizados = $eventosFinalizados->orderBy('fecha_fin', 'desc')->get();
        }
        
        // Para mantener compatibilidad con variables antiguas
        $eventosInscritosIds = $eventosInscritosIds;
                                 
        return view('estudiante.eventos.index', compact(
            'misEventosEnProgreso',
            'misOtrosEventosInscritos',
            'eventosActivos',
            'eventosProximos',
            'eventosCerrados',
            'eventosFinalizados',
            'eventosInscritosIds',
            'search',
            'filtro'
        ));
    }

    /**
     * Display the specified resource.
     */
    public function show(Evento $evento)
    {
        $evento->load(['inscripciones.equipo', 'jurados.user', 'criteriosEvaluacion']);

        $user = Auth::user();
        
        // Verificar si el usuario ya tiene un equipo en este evento
        $miembro = MiembroEquipo::where('id_estudiante', $user->id_usuario)
            ->whereHas('inscripcion', function ($query) use ($evento) {
                $query->where('id_evento', $evento->id_evento);
            })
            ->with('inscripcion')
            ->first();
        
        $yaTieneEquipo = $miembro !== null;
        $esLider = $miembro ? $miembro->es_lider : false;
        $miInscripcion = $miembro ? $miembro->inscripcion : null;

        // ===== VALIDACIÓN DE CRUCE DE FECHAS =====
        $hayConflictoFechas = false;
        $eventoConflicto = null;
        
        // Solo verificar conflictos si NO está inscrito en este evento
        if (!$yaTieneEquipo) {
            // Obtener eventos donde el estudiante ya está inscrito (excluyendo el actual)
            $eventosInscritos = Evento::whereHas('inscripciones.miembros', function ($q) use ($user) {
                $q->where('id_estudiante', $user->id_usuario);
            })
            ->where('id_evento', '!=', $evento->id_evento)
            ->whereIn('estado', ['Próximo', 'Activo', 'En Progreso', 'Cerrado']) // Solo eventos activos/pendientes
            ->get();

            foreach ($eventosInscritos as $eventoInscrito) {
                if ($this->fechasSeSuperponen($evento, $eventoInscrito)) {
                    $hayConflictoFechas = true;
                    $eventoConflicto = $eventoInscrito;
                    break;
                }
            }
        }

        // Verificar cuántos equipos faltan para llenar el evento
        $equiposFaltantes = $evento->cupo_max_equipos - $evento->inscripciones->count();
        $eventoLleno = $equiposFaltantes <= 0;

        return view('estudiante.eventos.show', compact(
            'evento', 
            'yaTieneEquipo', 
            'esLider',
            'miInscripcion',
            'hayConflictoFechas', 
            'eventoConflicto',
            'equiposFaltantes',
            'eventoLleno'
        ));
    }

    /**
     * Verificar si las fechas de dos eventos se superponen
     */
    private function fechasSeSuperponen(Evento $eventoA, Evento $eventoB): bool
    {
        // Evento A: fecha_inicio_A, fecha_fin_A
        // Evento B: fecha_inicio_B, fecha_fin_B
        // Hay superposición si: inicio_A <= fin_B AND fin_A >= inicio_B
        
        return $eventoA->fecha_inicio <= $eventoB->fecha_fin 
            && $eventoA->fecha_fin >= $eventoB->fecha_inicio;
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

    /**
     * Permite al líder del equipo abandonar el evento (solo si está Activo)
     */
    public function leaveEvent(Evento $evento)
    {
        $user = Auth::user();

        // Verificar que el evento está Activo
        if ($evento->estado !== 'Activo') {
            return back()->with('error', 'Solo puedes abandonar eventos que estén en estado Activo.');
        }

        // Obtener la inscripción del usuario en este evento
        $miembro = MiembroEquipo::where('id_estudiante', $user->id_usuario)
            ->whereHas('inscripcion', function ($query) use ($evento) {
                $query->where('id_evento', $evento->id_evento);
            })
            ->with('inscripcion')
            ->first();

        if (!$miembro) {
            return back()->with('error', 'No estás inscrito en este evento.');
        }

        // Verificar que es líder
        if (!$miembro->es_lider) {
            return back()->with('error', 'Solo el líder del equipo puede abandonar el evento.');
        }

        $inscripcion = $miembro->inscripcion;
        $nombreEquipo = $inscripcion->equipo->nombre;

        try {
            // Desasociar el equipo del evento (no eliminar la inscripción)
            $inscripcion->update([
                'id_evento' => null,
                'status_registro' => 'Incompleto',
            ]);

            return redirect()->route('estudiante.eventos.index')
                ->with('success', "Tu equipo \"{$nombreEquipo}\" ha abandonado el evento exitosamente.");

        } catch (\Exception $e) {
            return back()->with('error', 'Error al abandonar el evento: ' . $e->getMessage());
        }
    }
}

