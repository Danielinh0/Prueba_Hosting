<?php

namespace App\Http\Controllers\Estudiante;

use App\Http\Controllers\Controller;
use App\Models\TareaProyecto;
use App\Models\InscripcionEvento;
use App\Models\Proyecto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TareaController extends Controller
{
    /**
     * Obtener la inscripción del usuario actual
     */
    private function getInscripcion()
    {
        return InscripcionEvento::whereHas('miembros', function($q) {
            $q->where('id_estudiante', Auth::id());
        })->with(['equipo', 'proyecto.tareas.asignadoA.user'])->first();
    }

    /**
     * Verificar si el usuario es líder
     */
    private function esLider($inscripcion): bool
    {
        return $inscripcion->miembros()
            ->where('id_estudiante', Auth::id())
            ->where('es_lider', true)
            ->exists();
    }

    /**
     * Mostrar lista de tareas
     */
    public function index()
    {
        $inscripcion = $this->getInscripcion();
        
        if (!$inscripcion || !$inscripcion->proyecto) {
            return redirect()->route('estudiante.proyecto.show')
                ->with('info', 'Primero debes crear el proyecto.');
        }

        $esLider = $this->esLider($inscripcion);
        $proyecto = $inscripcion->proyecto;
        $tareas = $proyecto->tareas()->with(['asignadoA.user', 'completadaPor'])->orderBy('completada')->orderBy('created_at', 'desc')->get();
        $miembros = $inscripcion->miembros;

        // Calcular progreso
        $totalTareas = $tareas->count();
        $tareasCompletadas = $tareas->where('completada', true)->count();
        $progreso = $totalTareas > 0 ? round(($tareasCompletadas / $totalTareas) * 100) : 0;

        return view('estudiante.proyecto.tareas', compact('inscripcion', 'proyecto', 'tareas', 'esLider', 'miembros', 'progreso'));
    }

    /**
     * Crear nueva tarea
     */
    public function store(Request $request)
    {
        $inscripcion = $this->getInscripcion();

        if (!$inscripcion || !$this->esLider($inscripcion)) {
            return back()->with('error', 'Solo el líder puede crear tareas.');
        }

        $request->validate([
            'nombre' => 'required|string|max:200',
            'descripcion' => 'nullable|string',
            'asignado_a' => 'nullable|exists:miembros_equipo,id_miembro',
            'fecha_limite' => 'nullable|date',
            'prioridad' => 'required|in:Alta,Media,Baja',
        ]);

        TareaProyecto::create([
            'id_proyecto' => $inscripcion->proyecto->id_proyecto,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'asignado_a' => $request->asignado_a,
            'fecha_limite' => $request->fecha_limite,
            'prioridad' => $request->prioridad,
        ]);

        return back()->with('success', 'Tarea creada exitosamente.');
    }


    /**
     * Marcar tarea como completada/pendiente
     */
    public function toggle(TareaProyecto $tarea)
    {
        // Obtener la inscripción desde el proyecto de la tarea
        $inscripcion = $tarea->proyecto->inscripcion;

        if (!$inscripcion) {
            return back()->with('error', 'Proyecto no válido.');
        }

        // Verificar que el usuario es miembro del equipo
        $esMiembro = $inscripcion->miembros()
            ->where('id_estudiante', Auth::id())
            ->exists();

        if (!$esMiembro) {
            return back()->with('error', 'No tienes permiso para modificar esta tarea.');
        }

        if ($tarea->completada) {
            $tarea->marcarPendiente();
            $mensaje = 'Tarea marcada como pendiente.';
        } else {
            $tarea->marcarCompletada(Auth::user());
            $mensaje = 'Tarea marcada como completada.';
        }

        return back()->with('success', $mensaje);
    }

    /**
     * Eliminar tarea
     */
    public function destroy(TareaProyecto $tarea)
    {
        $inscripcion = $this->getInscripcion();

        if (!$inscripcion || !$this->esLider($inscripcion)) {
            return back()->with('error', 'Solo el líder puede eliminar tareas.');
        }

        if ($tarea->proyecto->id_inscripcion != $inscripcion->id_inscripcion) {
            return back()->with('error', 'No tienes permiso para eliminar esta tarea.');
        }

        $tarea->delete();

        return back()->with('success', 'Tarea eliminada exitosamente.');
    }

    /**
     * Mostrar lista de tareas para un proyecto específico
     */
    public function indexSpecific(Proyecto $proyecto)
    {
        // Verificar que el usuario tiene permiso para ver este proyecto
        $inscripcion = $proyecto->inscripcion;

        if (!$inscripcion) {
            return redirect()->route('estudiante.proyectos.index')
                ->with('error', 'Proyecto no válido.');
        }

        // Verificar que el usuario es miembro del equipo
        $esMiembro = $inscripcion->miembros()
            ->where('id_estudiante', Auth::id())
            ->exists();

        if (!$esMiembro) {
            return redirect()->route('estudiante.proyectos.index')
                ->with('error', 'No tienes permiso para ver este proyecto.');
        }

        $esLider = $this->esLider($inscripcion);
        $tareas = $proyecto->tareas()->with(['asignadoA.user', 'completadaPor'])->orderBy('completada')->orderBy('created_at', 'desc')->get();
        $miembros = $inscripcion->miembros;

        return view('estudiante.tarea.index-specific', compact(
            'proyecto',
            'tareas',
            'miembros',
            'esLider',
            'inscripcion'
        ));
    }

    /**
     * Guardar nueva tarea para un proyecto específico
     */
    public function storeSpecific(Request $request, Proyecto $proyecto)
    {
        // Verificar que el usuario tiene permiso
        $inscripcion = $proyecto->inscripcion;

        if (!$inscripcion || !$this->esLider($inscripcion)) {
            return back()->with('error', 'Solo el líder puede crear tareas.');
        }

        $request->validate([
            'nombre' => 'required|string|max:200',
            'descripcion' => 'nullable|string',
            'asignado_a' => 'nullable|exists:users,id_usuario',
            'fecha_vencimiento' => 'nullable|date|after_or_equal:today',
        ]);

        TareaProyecto::create([
            'id_proyecto' => $proyecto->id_proyecto,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'asignado_a' => $request->asignado_a,
            'fecha_vencimiento' => $request->fecha_vencimiento,
            'creado_por' => Auth::id(),
        ]);

        return redirect()->route('estudiante.tareas.index-specific', $proyecto->id_proyecto)
            ->with('success', 'Tarea creada exitosamente.');
    }
}
