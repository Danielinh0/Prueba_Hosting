<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Evento;
use Illuminate\Http\Request;

class ResultadosController extends Controller
{
    /**
     * Ver resultados y evaluaciones de un evento
     */
    public function show(Evento $evento)
    {
        // Obtener inscripciones con sus equipos, proyectos y evaluaciones
        $inscripciones = $evento->inscripciones()
            ->where('status_registro', 'Completo')
            ->with([
                'equipo',
                'proyecto',
                'evaluaciones.jurado.user'
            ])
            ->get();

        // Calcular calificación promedio por equipo
        $equiposConCalificaciones = $inscripciones->map(function($inscripcion) {
            $evaluacionesFinalizadas = $inscripcion->evaluaciones
                ->where('estado', 'Finalizada');

            $promedioGeneral = null;
            $totalEvaluaciones = $evaluacionesFinalizadas->count();

            if ($totalEvaluaciones > 0) {
                $sumaCalificaciones = $evaluacionesFinalizadas->sum('calificacion_final');
                $promedioGeneral = round($sumaCalificaciones / $totalEvaluaciones, 2);
            }

            return [
                'inscripcion' => $inscripcion,
                'equipo' => $inscripcion->equipo,
                'proyecto' => $inscripcion->proyecto,
                'evaluaciones' => $evaluacionesFinalizadas,
                'total_evaluaciones' => $totalEvaluaciones,
                'promedio_general' => $promedioGeneral,
                'puesto_actual' => $inscripcion->puesto_ganador,
            ];
        })->sortByDesc('promedio_general');

        return view('admin.eventos.resultados', compact('evento', 'equiposConCalificaciones'));
    }

    /**
     * Asignar puesto ganador a un equipo
     */
    public function asignarPuesto(Request $request, Evento $evento)
    {
        $request->validate([
            'id_inscripcion' => 'required|exists:inscripciones_evento,id_inscripcion',
            'puesto' => 'required|integer|min:1|max:10',
        ]);

        $inscripcion = $evento->inscripciones()
            ->where('id_inscripcion', $request->id_inscripcion)
            ->first();

        if (!$inscripcion) {
            return back()->with('error', 'Inscripción no encontrada.');
        }

        // Verificar que no haya otro equipo con el mismo puesto
        $puestoExistente = $evento->inscripciones()
            ->where('id_inscripcion', '!=', $inscripcion->id_inscripcion)
            ->where('puesto_ganador', $request->puesto)
            ->first();

        if ($puestoExistente) {
            return back()->with('error', "Ya existe un equipo asignado al puesto {$request->puesto}.");
        }

        $inscripcion->puesto_ganador = $request->puesto;
        $inscripcion->save();

        return back()->with('success', "Puesto {$request->puesto} asignado exitosamente.");
    }

    /**
     * Quitar puesto ganador
     */
    public function quitarPuesto(Request $request, Evento $evento)
    {
        $request->validate([
            'id_inscripcion' => 'required|exists:inscripciones_evento,id_inscripcion',
        ]);

        $inscripcion = $evento->inscripciones()
            ->where('id_inscripcion', $request->id_inscripcion)
            ->first();

        if ($inscripcion) {
            $inscripcion->puesto_ganador = null;
            $inscripcion->save();
        }

        return back()->with('success', 'Puesto removido exitosamente.');
    }
}
