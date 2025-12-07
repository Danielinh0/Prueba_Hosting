<?php

namespace App\Http\Controllers\Estudiante;

use App\Http\Controllers\Controller;
use App\Models\Proyecto;
use App\Models\InscripcionEvento;
use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProyectoController extends Controller
{
    /**
     * Obtener la inscripción del usuario actual en evento EN PROGRESO
     */
    private function getInscripcion()
    {
        return InscripcionEvento::whereHas('miembros', function($q) {
            $q->where('id_estudiante', Auth::id());
        })
        ->whereHas('evento', function($q) {
            $q->where('estado', 'En Progreso');
        })
        ->with(['equipo', 'evento', 'proyecto'])
        ->orderBy('fecha_inscripcion', 'desc')
        ->first();
    }

    /**
     * Verificar si el usuario es líder
     */
    private function esLider($inscripcion): bool
    {
        if (!$inscripcion) return false;

        return $inscripcion->miembros()
            ->where('id_estudiante', Auth::id())
            ->where('es_lider', true)
            ->exists();
    }

    /**
     * Mostrar el proyecto del equipo
     */
    public function show()
    {
        // Obtener la inscripción más reciente del usuario en estado EN PROGRESO
        $inscripcion = InscripcionEvento::whereHas('miembros', function($q) {
                $q->where('id_estudiante', Auth::id());
            })
            ->whereHas('evento', function($q) {
                $q->where('estado', 'En Progreso');
            })
            ->with(['equipo', 'evento', 'proyecto'])
            ->orderBy('fecha_inscripcion', 'desc')
            ->first();

        if (!$inscripcion) {
            return redirect()->route('estudiante.dashboard')
                ->with('info', 'No estás inscrito en ningún evento activo.');
        }

        $esLider = $this->esLider($inscripcion);
        $proyecto = $inscripcion->proyecto;

        // Cargar evaluaciones finales de los jurados
        $evaluacionesFinales = $inscripcion->evaluaciones()
            ->with('jurado.user')
            ->orderBy('created_at', 'desc')
            ->get();

        // Contar evaluaciones finalizadas vs totales
        $totalEvaluaciones = $evaluacionesFinales->count();
        $evaluacionesFinalizadas = $evaluacionesFinales->where('estado', 'Finalizada')->count();
        
        // Calcular promedio general si hay evaluaciones finalizadas
        $promedioGeneral = null;
        if ($evaluacionesFinalizadas > 0) {
            $promedioGeneral = round(
                $evaluacionesFinales->where('estado', 'Finalizada')->avg('calificacion_final'), 
                2
            );
        }

        return view('estudiante.proyecto.show', compact(
            'inscripcion', 
            'proyecto', 
            'esLider',
            'evaluacionesFinales',
            'totalEvaluaciones',
            'evaluacionesFinalizadas',
            'promedioGeneral'
        ));
    }

    /**
     * Mostrar el Proyecto del Evento (asignado por el admin)
     */
    public function showProyectoEvento(Evento $evento = null)
    {
        // Si no se especifica evento, obtener la inscripción más reciente (comportamiento original)
        if (!$evento) {
            $inscripcion = InscripcionEvento::whereHas('miembros', function($q) {
                $q->where('id_estudiante', Auth::id());
            })
            ->whereHas('evento', function($q) {
                $q->where('estado', 'En Progreso');
            })
            ->with(['equipo', 'evento', 'proyecto', 'proyectoEvento'])
            ->orderBy('fecha_inscripcion', 'desc')
            ->first();

            if (!$inscripcion) {
                return redirect()->route('estudiante.dashboard')
                    ->with('info', 'No estás participando en ningún evento en progreso.');
            }

            return $this->mostrarProyectoIndividual($inscripcion);
        }

        // Buscar la inscripción del usuario para este evento específico
        $inscripcion = InscripcionEvento::where('id_evento', $evento->id_evento)
            ->whereHas('miembros', function($q) {
                $q->where('id_estudiante', Auth::id());
            })
            ->with(['equipo', 'evento', 'proyecto', 'proyectoEvento'])
            ->first();

        if (!$inscripcion) {
            return redirect()->route('estudiante.dashboard')
                ->with('error', 'No participas en este evento o el evento no está en progreso.');
        }

        return $this->mostrarProyectoIndividual($inscripcion);
    }

    /**
     * Mostrar el proyecto de un evento específico
     */
    public function showProyectoEventoEspecifico(Evento $evento)
    {
        // Reutilizar el método showProyectoEvento pasándole el evento específico
        return $this->showProyectoEvento($evento);
    }

    /**
     * Helper para mostrar el proyecto de una inscripción específica
     */
    private function mostrarProyectoIndividual($inscripcion)
    {
        $evento = $inscripcion->evento;

        // Defensive check for orphaned inscription records
        if (!$evento) {
            return redirect()->route('estudiante.dashboard')
                ->with('error', 'El evento asociado a tu inscripción ya no existe o ha sido eliminado.');
        }

        // Verificar que el evento esté en progreso
        if ($evento->estado !== 'En Progreso') {
            return redirect()->route('estudiante.dashboard')
                ->with('info', 'El proyecto aún no está disponible. Espera a que inicie el evento.');
        }

        // Obtener el proyecto del evento (general o individual)
        if ($evento->tipo_proyecto === 'general') {
            $proyectoEvento = $evento->proyectoGeneral;
        } else {
            $proyectoEvento = $inscripcion->proyectoEvento;
        }

        $esLider = $this->esLider($inscripcion);
        $proyecto = $inscripcion->proyecto; // Solución del equipo

        return view('estudiante.proyecto-evento.show', compact('inscripcion', 'proyectoEvento', 'proyecto', 'esLider'));
    }

    /**
     * Formulario para crear proyecto
     */
    public function create()
    {
        $inscripcion = $this->getInscripcion();

        if (!$inscripcion || !$this->esLider($inscripcion)) {
            return redirect()->route('estudiante.proyecto.show')
                ->with('error', 'Solo el líder puede crear el proyecto.');
        }

        if ($inscripcion->proyecto) {
            return redirect()->route('estudiante.proyecto.show')
                ->with('info', 'El equipo ya tiene un proyecto creado.');
        }

        return view('estudiante.proyecto.form', compact('inscripcion'));
    }

    /**
     * Guardar nuevo proyecto
     */
    public function store(Request $request)
    {
        $inscripcion = $this->getInscripcion();

        if (!$inscripcion || !$this->esLider($inscripcion)) {
            return back()->with('error', 'Solo el líder puede crear el proyecto.');
        }

        $request->validate([
            'nombre' => 'required|string|max:200',
            'descripcion_tecnica' => 'nullable|string',
            'repositorio_url' => 'nullable|url|max:255',
        ]);

        Proyecto::create([
            'id_inscripcion' => $inscripcion->id_inscripcion,
            'nombre' => $request->nombre,
            'descripcion_tecnica' => $request->descripcion_tecnica,
            'repositorio_url' => $request->repositorio_url,
        ]);

        return redirect()->route('estudiante.proyecto.show')
            ->with('success', 'Proyecto creado exitosamente.');
    }

    /**
     * Formulario para editar proyecto
     */
    public function edit()
    {
        $inscripcion = $this->getInscripcion();

        if (!$inscripcion || !$this->esLider($inscripcion)) {
            return redirect()->route('estudiante.proyecto.show')
                ->with('error', 'Solo el líder puede editar el proyecto.');
        }

        $proyecto = $inscripcion->proyecto;

        if (!$proyecto) {
            return redirect()->route('estudiante.proyecto.create');
        }

        return view('estudiante.proyecto.form', compact('inscripcion', 'proyecto'));
    }

    /**
     * Actualizar proyecto
     */
    public function update(Request $request)
    {
        $inscripcion = $this->getInscripcion();

        if (!$inscripcion || !$this->esLider($inscripcion)) {
            return back()->with('error', 'Solo el líder puede editar el proyecto.');
        }

        $proyecto = $inscripcion->proyecto;

        if (!$proyecto) {
            return redirect()->route('estudiante.proyecto.create');
        }

        $request->validate([
            'nombre' => 'required|string|max:200',
            'descripcion_tecnica' => 'nullable|string',
            'repositorio_url' => 'nullable|url|max:255',
        ]);

        $proyecto->update([
            'nombre' => $request->nombre,
            'descripcion_tecnica' => $request->descripcion_tecnica,
            'repositorio_url' => $request->repositorio_url,
        ]);

        return redirect()->route('estudiante.proyecto.show')
            ->with('success', 'Proyecto actualizado exitosamente.');
    }

    /**
     * Formulario para crear proyecto basado en un evento específico
     */
    public function createFromEvento(Evento $evento)
    {
        // Obtener la inscripción del usuario para este evento
        $inscripcion = InscripcionEvento::where('id_evento', $evento->id_evento)
            ->whereHas('miembros', function($q) {
                $q->where('id_estudiante', Auth::id());
            })
            ->with(['equipo', 'evento', 'proyecto'])
            ->first();

        if (!$inscripcion) {
            return redirect()->route('estudiante.dashboard')
                ->with('error', 'No participas en este evento.');
        }

        // Verificar que sea líder
        if (!$this->esLider($inscripcion)) {
            return redirect()->route('estudiante.proyecto-evento.especifico', $evento->id_evento)
                ->with('error', 'Solo el líder puede crear el proyecto.');
        }

        // Verificar que no tenga proyecto ya creado
        if ($inscripcion->proyecto) {
            return redirect()->route('estudiante.proyecto-evento.especifico', $evento->id_evento)
                ->with('info', 'El equipo ya tiene un proyecto creado para este evento.');
        }

        return view('estudiante.proyecto.create-from-evento', compact('inscripcion', 'evento'));
    }

    /**
     * Guardar nuevo proyecto basado en un evento
     */
    public function storeFromEvento(Request $request, Evento $evento)
    {
        // Obtener la inscripción del usuario para este evento
        $inscripcion = InscripcionEvento::where('id_evento', $evento->id_evento)
            ->whereHas('miembros', function($q) {
                $q->where('id_estudiante', Auth::id());
            })
            ->first();

        if (!$inscripcion || !$this->esLider($inscripcion)) {
            return back()->with('error', 'Solo el líder puede crear el proyecto.');
        }

        $request->validate([
            'nombre' => 'required|string|max:200',
            'descripcion_tecnica' => 'nullable|string',
            'repositorio_url' => 'nullable|url|max:255',
        ]);

        Proyecto::create([
            'id_inscripcion' => $inscripcion->id_inscripcion,
            'nombre' => $request->nombre,
            'descripcion_tecnica' => $request->descripcion_tecnica,
            'repositorio_url' => $request->repositorio_url,
        ]);

        return redirect()->route('estudiante.proyecto-evento.especifico', $evento->id_evento)
            ->with('success', 'Proyecto creado exitosamente para el evento.');
    }

    /**
     * Mostrar un proyecto específico (desde mis-proyectos)
     */
    public function showSpecific(Proyecto $proyecto)
    {
        // Verificar que el usuario tiene permiso para ver este proyecto
        $user = Auth::user();

        // Obtener la inscripción asociada al proyecto
        $inscripcion = $proyecto->inscripcion;

        if (!$inscripcion) {
            return redirect()->route('estudiante.dashboard')
                ->with('error', 'Proyecto no válido.');
        }

        // Verificar que el usuario es miembro del equipo
        $esMiembro = $inscripcion->miembros()
            ->where('id_estudiante', $user->id_usuario)
            ->exists();

        if (!$esMiembro) {
            return redirect()->route('estudiante.dashboard')
                ->with('error', 'No tienes permiso para ver este proyecto.');
        }

        $esLider = $this->esLider($inscripcion);
        $evento = $inscripcion->evento;

        // Cargar evaluaciones finales de los jurados
        $evaluacionesFinales = $inscripcion->evaluaciones()
            ->with('jurado.user')
            ->orderBy('created_at', 'desc')
            ->get();

        // Contar evaluaciones finalizadas vs totales
        $totalEvaluaciones = $evaluacionesFinales->count();
        $evaluacionesFinalizadas = $evaluacionesFinales->where('estado', 'Finalizada')->count();

        // Calcular promedio general si hay evaluaciones finalizadas
        $promedioGeneral = null;
        if ($evaluacionesFinalizadas > 0) {
            $promedioGeneral = round(
                $evaluacionesFinales->where('estado', 'Finalizada')->avg('calificacion_final'),
                2
            );
        }

        // Cargar tareas y avances
        $tareas = $proyecto->tareas()->orderBy('created_at', 'desc')->get();
        $avances = $proyecto->avances()->orderBy('created_at', 'desc')->get();

        // Calcular estadísticas
        $totalTareas = $tareas->count();
        $tareasCompletadas = $tareas->where('completada', true)->count();
        $porcentajeTareas = $totalTareas > 0 ? round(($tareasCompletadas / $totalTareas) * 100) : 0;

        return view('estudiante.proyecto.show-specific', compact(
            'proyecto',
            'inscripcion',
            'evento',
            'esLider',
            'evaluacionesFinales',
            'totalEvaluaciones',
            'evaluacionesFinalizadas',
            'promedioGeneral',
            'tareas',
            'avances',
            'totalTareas',
            'tareasCompletadas',
            'porcentajeTareas'
        ));
    }

    /**
     * Formulario para editar un proyecto específico
     */
    public function editSpecific(Proyecto $proyecto)
    {
        // Verificar que el usuario tiene permiso para editar este proyecto
        $user = Auth::user();

        // Obtener la inscripción asociada al proyecto
        $inscripcion = $proyecto->inscripcion;

        if (!$inscripcion) {
            return redirect()->route('estudiante.dashboard')
                ->with('error', 'Proyecto no válido.');
        }

        // Verificar que el usuario es líder del equipo
        $esLider = $inscripcion->miembros()
            ->where('id_estudiante', $user->id_usuario)
            ->where('es_lider', true)
            ->exists();

        if (!$esLider) {
            return redirect()->route('estudiante.proyecto.show-specific', $proyecto->id_proyecto)
                ->with('error', 'Solo el líder puede editar el proyecto.');
        }

        $evento = $inscripcion->evento;

        return view('estudiante.proyecto.edit-specific', compact('proyecto', 'inscripcion', 'evento'));
    }

    /**
     * Actualizar un proyecto específico
     */
    public function updateSpecific(Request $request, Proyecto $proyecto)
    {
        // Verificar que el usuario tiene permiso para editar este proyecto
        $user = Auth::user();

        // Obtener la inscripción asociada al proyecto
        $inscripcion = $proyecto->inscripcion;

        if (!$inscripcion) {
            return back()->with('error', 'Proyecto no válido.');
        }

        // Verificar que el usuario es líder del equipo
        $esLider = $inscripcion->miembros()
            ->where('id_estudiante', $user->id_usuario)
            ->where('es_lider', true)
            ->exists();

        if (!$esLider) {
            return back()->with('error', 'Solo el líder puede editar el proyecto.');
        }

        $request->validate([
            'nombre' => 'required|string|max:200',
            'descripcion_tecnica' => 'nullable|string',
            'repositorio_url' => 'nullable|url|max:255',
        ]);

        $proyecto->update([
            'nombre' => $request->nombre,
            'descripcion_tecnica' => $request->descripcion_tecnica,
            'repositorio_url' => $request->repositorio_url,
        ]);

        return redirect()->route('estudiante.proyecto.show-specific', $proyecto->id_proyecto)
            ->with('success', 'Proyecto actualizado exitosamente.');
    }
}
