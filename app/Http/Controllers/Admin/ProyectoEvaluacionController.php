<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Evento;
use App\Models\Proyecto;
use App\Models\Evaluacion;
use App\Models\InscripcionEvento;
use Illuminate\Http\Request;

class ProyectoEvaluacionController extends Controller
{
    /**
     * Mostrar listado de todos los proyectos con sus evaluaciones
     */
    public function index(Request $request)
    {
        // Filtros
        $eventoId = $request->get('evento');
        $estadoEvaluacion = $request->get('estado_evaluacion');
        $busqueda = $request->get('busqueda');

        // Query de inscripciones con proyectos
        $query = InscripcionEvento::with([
            'evento.criteriosEvaluacion',
            'equipo',
            'proyecto',
            'evaluaciones.jurado.user',
            'evaluaciones.criteriosCalificados.criterio'
        ])
        ->where('status_registro', 'Completo')
        ->whereHas('proyecto');

        // Filtro por evento
        if ($eventoId) {
            $query->where('id_evento', $eventoId);
        }

        // Filtro por búsqueda
        if ($busqueda) {
            $query->where(function($q) use ($busqueda) {
                $q->whereHas('proyecto', function($pq) use ($busqueda) {
                    $pq->where('nombre', 'ilike', "%{$busqueda}%")
                       ->orWhere('descripcion_tecnica', 'ilike', "%{$busqueda}%");
                })
                ->orWhereHas('equipo', function($eq) use ($busqueda) {
                    $eq->where('nombre_equipo', 'ilike', "%{$busqueda}%");
                });
            });
        }

        // Obtener inscripciones (ordenar por id ya que la tabla no tiene timestamps)
        $inscripciones = $query->orderBy('id_inscripcion', 'desc')->get();

        // Aplicar filtro de estado de evaluación después de obtener
        if ($estadoEvaluacion) {
            $inscripciones = $inscripciones->filter(function($inscripcion) use ($estadoEvaluacion) {
                $totalEvaluaciones = $inscripcion->evaluaciones->count();
                $evaluacionesFinalizadas = $inscripcion->evaluaciones->where('estado', 'Finalizada')->count();
                
                switch ($estadoEvaluacion) {
                    case 'sin_evaluar':
                        return $totalEvaluaciones === 0;
                    case 'en_proceso':
                        return $totalEvaluaciones > 0 && $evaluacionesFinalizadas < $totalEvaluaciones;
                    case 'evaluado':
                        return $totalEvaluaciones > 0 && $evaluacionesFinalizadas === $totalEvaluaciones;
                    default:
                        return true;
                }
            });
        }

        // Calcular estadísticas por inscripción
        $proyectosConStats = $inscripciones->map(function($inscripcion) {
            $evaluacionesFinalizadas = $inscripcion->evaluaciones->where('estado', 'Finalizada');
            $totalEvaluaciones = $inscripcion->evaluaciones->count();
            
            $promedioGeneral = null;
            if ($evaluacionesFinalizadas->count() > 0) {
                $sumaCalificaciones = $evaluacionesFinalizadas->sum('calificacion_final');
                $promedioGeneral = round($sumaCalificaciones / $evaluacionesFinalizadas->count(), 2);
            }

            // Calcular promedio por criterio
            $promediosPorCriterio = [];
            if ($inscripcion->evento->criteriosEvaluacion->count() > 0 && $evaluacionesFinalizadas->count() > 0) {
                foreach ($inscripcion->evento->criteriosEvaluacion as $criterio) {
                    $sumaCriterio = 0;
                    $countCriterio = 0;
                    
                    foreach ($evaluacionesFinalizadas as $eval) {
                        $criterioEval = $eval->criteriosCalificados->where('id_criterio', $criterio->id_criterio)->first();
                        if ($criterioEval) {
                            $sumaCriterio += $criterioEval->calificacion;
                            $countCriterio++;
                        }
                    }
                    
                    if ($countCriterio > 0) {
                        $promediosPorCriterio[$criterio->id_criterio] = [
                            'nombre' => $criterio->nombre,
                            'ponderacion' => $criterio->ponderacion,
                            'promedio' => round($sumaCriterio / $countCriterio, 1)
                        ];
                    }
                }
            }

            return [
                'inscripcion' => $inscripcion,
                'proyecto' => $inscripcion->proyecto,
                'equipo' => $inscripcion->equipo,
                'evento' => $inscripcion->evento,
                'total_evaluaciones' => $totalEvaluaciones,
                'evaluaciones_finalizadas' => $evaluacionesFinalizadas->count(),
                'promedio_general' => $promedioGeneral,
                'promedios_criterio' => $promediosPorCriterio,
                'evaluaciones' => $evaluacionesFinalizadas,
                'puesto_ganador' => $inscripcion->puesto_ganador
            ];
        });

        // Obtener eventos para el filtro
        $eventos = Evento::orderBy('fecha_inicio', 'desc')->get();

        // Estadísticas generales
        $totalProyectos = $proyectosConStats->count();
        $proyectosSinEvaluar = $proyectosConStats->where('total_evaluaciones', 0)->count();
        $proyectosEvaluados = $proyectosConStats->filter(function($p) {
            return $p['total_evaluaciones'] > 0 && $p['evaluaciones_finalizadas'] === $p['total_evaluaciones'];
        })->count();

        return view('admin.proyectos-evaluaciones.index', compact(
            'proyectosConStats',
            'eventos',
            'totalProyectos',
            'proyectosSinEvaluar',
            'proyectosEvaluados',
            'eventoId',
            'estadoEvaluacion',
            'busqueda'
        ));
    }

    /**
     * Mostrar detalle de un proyecto con todas sus evaluaciones
     */
    public function show(InscripcionEvento $inscripcion)
    {
        $inscripcion->load([
            'evento.criteriosEvaluacion',
            'equipo.miembros.user',
            'equipo.miembros.rol',
            'proyecto',
            'evaluaciones.jurado.user',
            'evaluaciones.criteriosCalificados.criterio'
        ]);

        // Calcular estadísticas
        $evaluacionesFinalizadas = $inscripcion->evaluaciones->where('estado', 'Finalizada');
        $promedioGeneral = null;
        
        if ($evaluacionesFinalizadas->count() > 0) {
            $sumaCalificaciones = $evaluacionesFinalizadas->sum('calificacion_final');
            $promedioGeneral = round($sumaCalificaciones / $evaluacionesFinalizadas->count(), 2);
        }

        // Promedios por criterio
        $promediosPorCriterio = [];
        foreach ($inscripcion->evento->criteriosEvaluacion as $criterio) {
            $sumaCriterio = 0;
            $countCriterio = 0;
            
            foreach ($evaluacionesFinalizadas as $eval) {
                $criterioEval = $eval->criteriosCalificados->where('id_criterio', $criterio->id_criterio)->first();
                if ($criterioEval) {
                    $sumaCriterio += $criterioEval->calificacion;
                    $countCriterio++;
                }
            }
            
            $promediosPorCriterio[$criterio->id_criterio] = [
                'nombre' => $criterio->nombre,
                'ponderacion' => $criterio->ponderacion,
                'promedio' => $countCriterio > 0 ? round($sumaCriterio / $countCriterio, 1) : null,
                'total_evaluaciones' => $countCriterio
            ];
        }

        return view('admin.proyectos-evaluaciones.show', compact(
            'inscripcion',
            'promedioGeneral',
            'promediosPorCriterio',
            'evaluacionesFinalizadas'
        ));
    }
}
