<?php

namespace App\Http\Controllers\Jurado;

use App\Http\Controllers\Controller;
use App\Models\Equipo;
use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Avance;
use App\Services\EmailNotificacionService;

class EventosController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $jurado = $user->jurado;

        // Obtener los eventos donde el jurado está asignado
        $misEventosInscritos = $jurado ? $jurado->eventos()->orderBy('fecha_inicio', 'desc')->get() : collect();
        $misEventosIds = $misEventosInscritos->pluck('id_evento');

        // Eventos activos disponibles (excluyendo los que ya tiene asignados)
        $eventosActivos = Evento::where('estado', 'Activo')
                                 ->whereNotIn('id_evento', $misEventosIds)
                                 ->orderBy('fecha_inicio', 'asc')
                                 ->get();
        
        // Próximos eventos (excluyendo los que ya tiene asignados)
        $eventosProximos = Evento::where('estado', 'Próximo')
                                 ->whereNotIn('id_evento', $misEventosIds)
                                 ->orderBy('fecha_inicio', 'asc')
                                 ->get();
                                 
        return view('jurado.eventos.index', compact('misEventosInscritos', 'eventosActivos', 'eventosProximos'));
    }

    public function show(Evento $evento)
    {
        $user = Auth::user();
        $jurado = $user->jurado;

        // Verificar si el jurado está asignado a este evento (especificando la tabla para evitar ambigüedad)
        $esJuradoDelEvento = $jurado && $jurado->eventos()->where('eventos.id_evento', $evento->id_evento)->exists();

        // Determinar si el evento está activo
        $eventoActivo = ($evento->estado === 'En Progreso' || $evento->estado === 'Activo');

        // Cargar las relaciones necesarias del evento
        $evento->load([
            'inscripciones' => function($query) {
                $query->orderBy('fecha_inscripcion', 'desc');
            },
            'inscripciones.equipo',
            'inscripciones.proyecto',
            'inscripciones.miembros' => function($query) {
                $query->orderBy('es_lider', 'desc');
            },
            'inscripciones.miembros.user',
        ]);

        // Procesar cada inscripción para obtener el líder y el nombre del proyecto
        foreach ($evento->inscripciones as $inscripcion) {
            if ($inscripcion->equipo) {
                // Obtener el líder del equipo
                $lider = $inscripcion->miembros->where('es_lider', true)->first();
                $inscripcion->equipo->lider_nombre = $lider ? $lider->user->nombre : 'Sin líder';
                
                // Obtener el nombre del proyecto
                $inscripcion->equipo->nombre_proyecto = $inscripcion->proyecto?->nombre ?? 'Sin proyecto';
            }
        }

        // Contar equipos inscritos
        $totalEquipos = $evento->inscripciones->count();
        return view('jurado.eventos.show', compact('evento', 'esJuradoDelEvento', 'totalEquipos', 'eventoActivo'));
    }

    public function equipo_evento(Evento $evento, Equipo $equipo)
    {
        $user = Auth::user();
        $jurado = $user->jurado;

        // Obtener la inscripción del equipo en este evento específico
        $inscripcion = $equipo->inscripciones()
            ->where('id_evento', $evento->id_evento)
            ->with(['proyecto.avances.usuarioRegistro', 'proyecto.avances.evaluaciones', 'proyecto.tareas'])
            ->first();

        // Cargar los miembros del equipo con sus relaciones
        $miembros = collect();
        if ($inscripcion) {
            $miembros = $inscripcion->miembros()
                ->with([
                    'user.estudiante.carrera',
                    'rol'
                ])
                ->orderBy('es_lider', 'desc')
                ->get();
        }

        // Obtener el proyecto del equipo
        $proyecto = $inscripcion ? $inscripcion->proyecto : null;

        // Calcular estadísticas del proyecto
        $totalAvances = $proyecto ? $proyecto->avances->count() : 0;
        $totalTareas = $proyecto ? $proyecto->tareas->count() : 0;
        $tareasCompletadas = $proyecto ? $proyecto->tareas->where('completada', true)->count() : 0;
        $progreso = $totalTareas > 0 ? round(($tareasCompletadas / $totalTareas) * 100) : 0;

        // Contar avances calificados por este jurado y crear lista de IDs calificados
        $avancesCalificados = 0;
        $avancesCalificadosIds = [];
        if ($proyecto && $jurado) {
            foreach ($proyecto->avances as $avance) {
                $tieneEvaluacion = $avance->evaluaciones->where('id_jurado', $jurado->id_usuario)->count() > 0;
                if ($tieneEvaluacion) {
                    $avancesCalificados++;
                    $avancesCalificadosIds[] = $avance->id_avance;
                }
            }
        }

        // Verificar si todos los avances están calificados
        $todosCalificados = ($totalAvances > 0 && $avancesCalificados >= $totalAvances);

        // Obtener los avances para el selector
        $avances = $proyecto ? $proyecto->avances()->orderBy('created_at', 'desc')->get() : collect();

        // Verificar si este jurado ya realizó la evaluación final
        $evaluacionFinalExistente = null;
        $evaluacionEnBorrador = false;
        if ($inscripcion && $jurado) {
            $evaluacionFinalExistente = \App\Models\Evaluacion::where('id_inscripcion', $inscripcion->id_inscripcion)
                ->where('id_jurado', $jurado->id_usuario)
                ->first();
            
            // Verificar si está en borrador o finalizada
            if ($evaluacionFinalExistente && $evaluacionFinalExistente->estado === 'Borrador') {
                $evaluacionEnBorrador = true;
            }
        }
        // Solo considerar como "ya evaluado" si la evaluación está FINALIZADA
        $yaEvaluoProyecto = $evaluacionFinalExistente !== null && $evaluacionFinalExistente->estado === 'Finalizada';

        return view('jurado.eventos.equipo', compact(
            'evento', 
            'equipo', 
            'miembros', 
            'proyecto',
            'inscripcion',
            'totalAvances',
            'totalTareas',
            'progreso',
            'avances',
            'avancesCalificados',
            'avancesCalificadosIds',
            'todosCalificados',
            'yaEvaluoProyecto',
            'evaluacionEnBorrador',
            'evaluacionFinalExistente'
        ));
    }

public function calificar_avance(Evento $evento, Equipo $equipo, Avance $avance)
    {
        $user = Auth::user();
        $jurado = $user->jurado;

        // Cargar las relaciones del avance
        $avance->load('usuarioRegistro', 'proyecto');

        // Verificar si ya existe una evaluación de este jurado para este avance
        $evaluacionExistente = \App\Models\EvaluacionAvance::where('id_avance', $avance->id_avance)
            ->where('id_jurado', $jurado->id_usuario)
            ->first();
        
        return view('jurado.eventos.avance', compact('evento', 'equipo', 'avance', 'evaluacionExistente'));
    }

    /**
     * Guardar la calificación del avance
     */
    public function guardar_calificacion(Request $request, Evento $evento, Equipo $equipo, Avance $avance)
    {
        $request->validate([
            'calificacion' => 'required|integer|min:0|max:100',
            'comentarios' => 'nullable|string|max:1000',
        ]);

        $user = Auth::user();
        $jurado = $user->jurado;

        // Usar updateOrCreate para evitar duplicados
        $evaluacion = \App\Models\EvaluacionAvance::updateOrCreate(
            [
                'id_avance' => $avance->id_avance,
                'id_jurado' => $jurado->id_usuario,
            ],
            [
                'calificacion' => $request->calificacion,
                'comentarios' => $request->comentarios,
                'fecha_evaluacion' => now(),
            ]
        );

        // Enviar email de notificación (solo si es nueva evaluación)
        if ($evaluacion->wasRecentlyCreated) {
            $emailService = new EmailNotificacionService();

            // Obtener el equipo para encontrar al líder
            $equipoConLider = $equipo->load('miembros.user');
            $lider = $equipoConLider->miembros->where('es_lider', true)->first();

            if ($lider && $lider->user) {
                $emailService->notificarAvanceCalificado(
                    $lider->user->id_usuario,
                    [
                        'nombre' => $avance->proyecto->nombre ?? 'Proyecto del equipo ' . $equipo->nombre,
                        'nombre_jurado' => Auth::user()->nombre,
                        'comentarios' => $request->comentarios ?: 'Tu avance ha sido revisado y calificado por el jurado.'
                    ]
                );
            }
        }

        $mensaje = $evaluacion->wasRecentlyCreated
            ? 'Avance calificado exitosamente.' . ($evaluacion->wasRecentlyCreated ? ' (Email enviado al estudiante)' : '')
            : 'Calificación actualizada exitosamente.';

        return redirect()->route('jurado.eventos.equipo_evento', [$evento, $equipo])
            ->with('success', $mensaje);
    }

}