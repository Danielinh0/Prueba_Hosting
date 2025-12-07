<?php

namespace App\Http\Controllers\Estudiante;

use App\Http\Controllers\Controller;
use App\Models\Avance;
use App\Models\InscripcionEvento;
use App\Models\Proyecto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AvanceController extends Controller
{
    /**
     * Obtener la inscripción del usuario actual
     */
    private function getInscripcion()
    {
        return InscripcionEvento::whereHas('miembros', function($q) {
            $q->where('id_estudiante', Auth::id());
        })->with(['equipo', 'proyecto.avances.usuarioRegistro'])->first();
    }

    /**
     * Timeline de avances
     */
    public function index()
    {
        $inscripcion = $this->getInscripcion();
        
        if (!$inscripcion || !$inscripcion->proyecto) {
            return redirect()->route('estudiante.proyecto.show')
                ->with('info', 'Primero debes crear el proyecto.');
        }

        $proyecto = $inscripcion->proyecto;
        $avances = $proyecto->avances()
            ->with(['usuarioRegistro', 'evaluaciones.jurado.user'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('estudiante.proyecto.avances.index', compact('inscripcion', 'proyecto', 'avances'));
    }

    /**
     * Formulario para nuevo avance
     */
    public function create()
    {
        $inscripcion = $this->getInscripcion();

        if (!$inscripcion || !$inscripcion->proyecto) {
            return redirect()->route('estudiante.proyecto.show')
                ->with('info', 'Primero debes crear el proyecto.');
        }

        return view('estudiante.proyecto.avances.create', compact('inscripcion'));
    }

    /**
     * Guardar nuevo avance
     */
    public function store(Request $request)
    {
        $inscripcion = $this->getInscripcion();

        if (!$inscripcion || !$inscripcion->proyecto) {
            return back()->with('error', 'No tienes un proyecto activo.');
        }

        $request->validate([
            'titulo' => 'nullable|string|max:100',
            'descripcion' => 'required|string',
            'archivo' => 'nullable|file|max:10240',  // 10MB max
        ]);

        $archivoPath = null;
        if ($request->hasFile('archivo')) {
            $archivoPath = $request->file('archivo')->store('avances', 'public');
        }

        Avance::create([
            'id_proyecto' => $inscripcion->proyecto->id_proyecto,
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'archivo_evidencia' => $archivoPath,
            'id_usuario_registro' => Auth::id(),
        ]);

        return redirect()->route('estudiante.avances.index')
            ->with('success', 'Avance registrado exitosamente.');
    }

    /**
     * Ver detalle de avance
     */
    public function show(Avance $avance)
    {
        $inscripcion = $this->getInscripcion();

        if (!$inscripcion || $avance->proyecto->id_inscripcion != $inscripcion->id_inscripcion) {
            return redirect()->route('estudiante.avances.index')
                ->with('error', 'No tienes permiso para ver este avance.');
        }

        $avance->load('usuarioRegistro');

        return view('estudiante.proyecto.avances.show', compact('avance', 'inscripcion'));
    }

    /**
     * Timeline de avances para un proyecto específico
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

        $avances = $proyecto->avances()
            ->with(['usuarioRegistro', 'evaluaciones.jurado.user'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('estudiante.avance.index-specific', compact(
            'proyecto',
            'inscripcion',
            'avances'
        ));
    }

    /**
     * Formulario para nuevo avance de proyecto específico
     */
    public function createSpecific(Proyecto $proyecto)
    {
        // Verificar que el usuario tiene permiso
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

        return view('estudiante.avance.create-specific', compact(
            'proyecto',
            'inscripcion'
        ));
    }

    /**
     * Guardar nuevo avance para proyecto específico
     */
    public function storeSpecific(Request $request, Proyecto $proyecto)
    {
        // Verificar que el usuario tiene permiso
        $inscripcion = $proyecto->inscripcion;

        if (!$inscripcion) {
            return back()->with('error', 'Proyecto no válido.');
        }

        // Verificar que el usuario es miembro del equipo
        $esMiembro = $inscripcion->miembros()
            ->where('id_estudiante', Auth::id())
            ->exists();

        if (!$esMiembro) {
            return back()->with('error', 'No tienes permiso para registrar avances en este proyecto.');
        }

        $request->validate([
            'titulo' => 'required|string|max:200',
            'descripcion' => 'required|string',
            'archivo_adjunto' => 'nullable|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png,gif|max:10240',
        ]);

        $rutaArchivo = null;
        if ($request->hasFile('archivo_adjunto')) {
            $rutaArchivo = $request->file('archivo_adjunto')
                ->store('avances_proyectos', 'public');
        }

        Avance::create([
            'id_proyecto' => $proyecto->id_proyecto,
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'archivo_adjunto' => $rutaArchivo,
            'id_usuario_registro' => Auth::id(),
        ]);

        return redirect()->route('estudiante.avances.index-specific', $proyecto->id_proyecto)
            ->with('success', 'Avance registrado exitosamente.');
    }

    /**
     * Mostrar avance específico
     */
    public function showSpecific(Avance $avance)
    {
        // Obtener el proyecto y verificar permisos
        $proyecto = $avance->proyecto;
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
                ->with('error', 'No tienes permiso para ver este avance.');
        }

        $avance->load(['usuarioRegistro', 'evaluaciones.jurado.user']);

        return view('estudiante.avance.show-specific', compact(
            'avance',
            'proyecto',
            'inscripcion'
        ));
    }
}
