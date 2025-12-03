<?php

namespace App\Http\Controllers\Jurado;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Evaluacion;
use App\Models\Evento;
use App\Models\InscripcionEvento;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $user = Auth::user();
        $jurado = $user->jurado;

        if (!$jurado) {
            return view('jurado.dashboard', [
                'eventosAsignados' => collect(),
                'evaluacionesPendientes' => collect(),
                'evaluacionesRecientes' => collect(),
                'estadisticas' => [
                    'totalEventos' => 0,
                    'eventosActivos' => 0,
                    'totalEquipos' => 0,
                    'evaluacionesCompletadas' => 0,
                    'evaluacionesPendientes' => 0,
                    'avancesPorCalificar' => 0,
                ],
            ]);
        }

        // 1. Eventos asignados al jurado con sus inscripciones
        $eventosAsignados = $jurado->eventos()
            ->withCount(['inscripciones' => function($q) {
                $q->where('status_registro', 'Completo');
            }])
            ->with(['inscripciones' => function($q) {
                $q->where('status_registro', 'Completo')
                  ->with(['equipo', 'proyecto.avances' => function($qa) {
                      $qa->orderBy('created_at', 'desc');
                  }]);
            }])
            ->orderByRaw("CASE 
                WHEN estado = 'Activo' THEN 1 
                WHEN estado = 'En Progreso' THEN 2
                WHEN estado = 'Próximo' THEN 3 
                WHEN estado = 'Cerrado' THEN 4
                ELSE 5 END")
            ->orderBy('fecha_inicio', 'asc')
            ->get();

        // 2. Obtener todas las inscripciones de los eventos del jurado
        $inscripcionIds = $eventosAsignados->flatMap(function($evento) {
            return $evento->inscripciones->pluck('id_inscripcion');
        });

        // 3. Evaluaciones del jurado
        $evaluacionesDelJurado = Evaluacion::where('id_jurado', $jurado->id_jurado)
            ->whereIn('id_inscripcion', $inscripcionIds)
            ->with(['inscripcion.equipo', 'inscripcion.evento'])
            ->get();

        // 4. Evaluaciones completadas (Finalizadas)
        $evaluacionesCompletadas = $evaluacionesDelJurado->where('estado', 'Finalizada');
        
        // 5. Evaluaciones en borrador
        $evaluacionesBorrador = $evaluacionesDelJurado->where('estado', 'Borrador');

        // 6. Inscripciones pendientes de evaluar (no tienen evaluación o solo borrador)
        $inscripcionesEvaluadas = $evaluacionesCompletadas->pluck('id_inscripcion')->toArray();
        
        $evaluacionesPendientes = collect();
        foreach ($eventosAsignados as $evento) {
            // Solo eventos que estén en estados donde se puede evaluar
            if (in_array($evento->estado, ['Activo', 'En Progreso', 'Cerrado'])) {
                foreach ($evento->inscripciones as $inscripcion) {
                    if (!in_array($inscripcion->id_inscripcion, $inscripcionesEvaluadas)) {
                        // Verificar si tiene borrador
                        $borrador = $evaluacionesBorrador->where('id_inscripcion', $inscripcion->id_inscripcion)->first();
                        
                        $evaluacionesPendientes->push((object)[
                            'inscripcion' => $inscripcion,
                            'evento' => $evento,
                            'equipo' => $inscripcion->equipo,
                            'proyecto' => $inscripcion->proyecto,
                            'tieneBorrador' => $borrador !== null,
                            'borrador' => $borrador,
                        ]);
                    }
                }
            }
        }

        // 7. Evaluaciones recientes (últimas 5 finalizadas)
        $evaluacionesRecientes = $evaluacionesCompletadas
            ->sortByDesc('updated_at')
            ->take(5)
            ->values();

        // 8. Avances pendientes de calificar
        $avancesPorCalificar = 0;
        foreach ($eventosAsignados as $evento) {
            if (in_array($evento->estado, ['Activo', 'En Progreso'])) {
                foreach ($evento->inscripciones as $inscripcion) {
                    if ($inscripcion->proyecto && $inscripcion->proyecto->avances) {
                        foreach ($inscripcion->proyecto->avances as $avance) {
                            // Verificar si este jurado ya calificó este avance
                            $yaCalificado = DB::table('evaluaciones_avances')
                                ->where('id_avance', $avance->id_avance)
                                ->where('id_jurado', $jurado->id_jurado)
                                ->exists();
                            
                            if (!$yaCalificado) {
                                $avancesPorCalificar++;
                            }
                        }
                    }
                }
            }
        }

        // 9. Estadísticas generales
        $estadisticas = [
            'totalEventos' => $eventosAsignados->count(),
            'eventosActivos' => $eventosAsignados->whereIn('estado', ['Activo', 'En Progreso'])->count(),
            'totalEquipos' => $eventosAsignados->sum('inscripciones_count'),
            'evaluacionesCompletadas' => $evaluacionesCompletadas->count(),
            'evaluacionesPendientes' => $evaluacionesPendientes->count(),
            'avancesPorCalificar' => $avancesPorCalificar,
        ];

        return view('jurado.dashboard', compact(
            'eventosAsignados',
            'evaluacionesPendientes',
            'evaluacionesRecientes',
            'estadisticas'
        ));
    }
}
