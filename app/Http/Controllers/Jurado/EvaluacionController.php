<?php

namespace App\Http\Controllers\Jurado;

use App\Http\Controllers\Controller;
use App\Models\Evaluacion;
use App\Models\InscripcionEvento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EvaluacionController extends Controller
{
    /**
     * Formulario para evaluar equipo
     */
    public function create(InscripcionEvento $inscripcion)
    {
        $jurado = Auth::user()->jurado;
        
        // Verificar que el jurado esté asignado al evento
        if (!$inscripcion->evento->jurados->contains('id_usuario', $jurado->id_usuario)) {
            return redirect()->route('jurado.dashboard')
                ->with('error', 'No tienes permiso para evaluar este equipo.');
        }

        // Obtener o crear evaluación en borrador
        $evaluacion = Evaluacion::firstOrCreate(
            [
                'id_inscripcion' => $inscripcion->id_inscripcion,
                'id_jurado' => $jurado->id_usuario,
            ],
            ['estado' => 'Borrador']
        );

        $proyecto = $inscripcion->proyecto;
        $equipo = $inscripcion->equipo;

        return view('jurado.evaluaciones.create', compact('inscripcion', 'evaluacion', 'proyecto', 'equipo', 'jurado'));
    }

    /**
     * Guardar evaluación (borrador o finalizar)
     */
    public function store(Request $request, InscripcionEvento $inscripcion)
    {
        $jurado = Auth::user()->jurado;

        $request->validate([
            'calificacion_innovacion' => 'nullable|numeric|min:0|max:100',
            'calificacion_funcionalidad' => 'nullable|numeric|min:0|max:100',
            'calificacion_presentacion' => 'nullable|numeric|min:0|max:100',
            'calificacion_impacto' => 'nullable|numeric|min:0|max:100',
            'comentarios_fortalezas' => 'nullable|string',
            'comentarios_areas_mejora' => 'nullable|string',
            'comentarios_generales' => 'nullable|string',
            'finalizar' => 'nullable|boolean',
        ]);

        $evaluacion = Evaluacion::updateOrCreate(
            [
                'id_inscripcion' => $inscripcion->id_inscripcion,
                'id_jurado' => $jurado->id_usuario,
            ],
            [
                'calificacion_innovacion' => $request->calificacion_innovacion,
                'calificacion_funcionalidad' => $request->calificacion_funcionalidad,
                'calificacion_presentacion' => $request->calificacion_presentacion,
                'calificacion_impacto' => $request->calificacion_impacto,
                'comentarios_fortalezas' => $request->comentarios_fortalezas,
                'comentarios_areas_mejora' => $request->comentarios_areas_mejora,
                'comentarios_generales' => $request->comentarios_generales,
            ]
        );

        // Si se pidió finalizar la evaluación
        if ($request->finalizar && $evaluacion->estaCompleta()) {
            $evaluacion->finalizar();
            return redirect()->route('jurado.dashboard')
                ->with('success', 'Evaluación finalizada exitosamente.');
        }

        return redirect()->route('jurado.evaluaciones.create', $inscripcion)
            ->with('success', 'Evaluación guardada como borrador.');
    }

    /**
     * Ver evaluación finalizada
     */
    public function show(Evaluacion $evaluacion)
    {
        $jurado = Auth::user()->jurado;

        // Verificar que sea la evaluación de este jurado
        if ($evaluacion->id_jurado != $jurado->id_usuario) {
            return redirect()->route('jurado.dashboard')
                ->with('error', 'No tienes permiso para ver esta evaluación.');
        }

        $inscripcion = $evaluacion->inscripcion;
        $proyecto = $inscripcion->proyecto;
        $equipo = $inscripcion->equipo;

        return view('jurado.evaluaciones.show', compact('evaluacion', 'inscripcion', 'proyecto', 'equipo'));
    }
}
