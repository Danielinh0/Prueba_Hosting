<?php

namespace App\Http\Controllers\Estudiante;

use App\Http\Controllers\Controller;
use App\Models\Avance;
use App\Models\InscripcionEvento;
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
        $avances = $proyecto->avances()->with('usuarioRegistro')->orderBy('created_at', 'desc')->get();

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
}
