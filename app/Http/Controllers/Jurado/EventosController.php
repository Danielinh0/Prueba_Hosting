<?php

namespace App\Http\Controllers\Jurado;

use App\Http\Controllers\Controller;
use App\Models\Equipo;
use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'inscripciones.miembros' => function($query) {
                $query->orderBy('es_lider', 'desc');
            },
            'inscripciones.miembros.user',
        ]);

        // Procesar cada inscripción para obtener el líder y el número de miembros
        foreach ($evento->inscripciones as $inscripcion) {
            if ($inscripcion->equipo) {
                // Obtener el líder del equipo
                $lider = $inscripcion->miembros->where('es_lider', true)->first();
                $inscripcion->equipo->lider_nombre = $lider ? $lider->user->nombre : 'Sin líder';
                
                // Obtener el número de miembros
                $inscripcion->equipo->num_miembros = $inscripcion->miembros->count();
            }
        }

        // Contar equipos inscritos
        $totalEquipos = $evento->inscripciones->count();
        return view('jurado.eventos.show', compact('evento', 'esJuradoDelEvento', 'totalEquipos', 'eventoActivo'));
    }

    public function equipo_evento(Evento $evento, Equipo $equipo)
    {
        // Obtener la inscripción del equipo en este evento específico
        $inscripcion = $equipo->inscripciones()
            ->where('id_evento', $evento->id_evento)
            ->with(['proyecto.avances.usuarioRegistro', 'proyecto.tareas'])
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

        // Obtener los avances para el selector
        $avances = $proyecto ? $proyecto->avances()->orderBy('created_at', 'desc')->get() : collect();

        return view('jurado.eventos.equipo', compact(
            'evento', 
            'equipo', 
            'miembros', 
            'proyecto',
            'inscripcion',
            'totalAvances',
            'totalTareas',
            'progreso',
            'avances'
        ));
    }
}