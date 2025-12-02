<?php

namespace App\Http\Controllers\Jurado;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
                 'etapasRevision' => collect(),
                 'eventoActual' => null,
                 'proyectoDestacado' => null,
                 'nombreEquipoProyecto' => null,
                 'nombreEventoProyecto' => null,
                 'avancePorcentaje' => 0,
                 'eventosActivosCount' => 0,
                 'acusesCount' => 0,
                 'proyectosCount' => 0,
                 'equiposCount' => 0
             ]);
        }

        // 1. Eventos y sus relaciones
        $eventosAsignados = $jurado->eventos()
            ->withCount('inscripciones') 
            ->with(['inscripciones' => function($q) {
                $q->where('status_registro', 'Completo')
                  ->with(['equipo', 'proyecto.avances', 'proyecto.tareas']);
            }])
            ->orderBy('fecha_inicio', 'asc')
            ->get();

        // 2. Etapas de Revisión (Próximos Avances)
        $etapasRevision = collect();
        foreach ($eventosAsignados as $evento) {
            foreach ($evento->inscripciones as $inscripcion) {
                if ($inscripcion->proyecto && $inscripcion->proyecto->avances) {
                    foreach ($inscripcion->proyecto->avances as $avance) {
                        $etapasRevision->push((object)[
                            'equipo' => $inscripcion->equipo->nombre,
                            'fecha' => Carbon::parse($avance->fecha_entrega),
                            'proyecto' => $inscripcion->proyecto->nombre
                        ]);
                    }
                }
            }
        }
        // Ordenar por fecha y tomar los primeros 3
        $etapasRevision = $etapasRevision->sortBy('fecha')->take(3);

        // 3. Evento Actual (Prioridad: Activo, luego Próximo)
        $eventoActual = $eventosAsignados->where('estado', 'Activo')->first() 
                        ?? $eventosAsignados->where('estado', 'Próximo')->first()
                        ?? $eventosAsignados->first();

        // 4. Proyecto Destacado (Para la sección de Progreso)
        $proyectoDestacado = null;
        $avancePorcentaje = 0;
        $nombreEquipoProyecto = null;
        $nombreEventoProyecto = null;

        $poolEventos = $eventoActual ? collect([$eventoActual]) : $eventosAsignados;
        
        foreach ($poolEventos as $evento) {
            foreach ($evento->inscripciones as $inscripcion) {
                if ($inscripcion->proyecto) {
                    $proyectoDestacado = $inscripcion->proyecto;
                    $nombreEquipoProyecto = $inscripcion->equipo->nombre;
                    $nombreEventoProyecto = $evento->nombre;
                    
                    $totalTareas = $proyectoDestacado->tareas->count();
                    $tareasCompletadas = $proyectoDestacado->tareas->where('completada', true)->count();
                    $avancePorcentaje = $totalTareas > 0 ? round(($tareasCompletadas / $totalTareas) * 100) : 0;
                    
                    break 2; 
                }
            }
        }

        // 5. Contadores
        $eventosActivosCount = $eventosAsignados->where('estado', 'Activo')->count();
        $equiposCount = $eventosAsignados->sum(fn($e) => $e->inscripciones->count());
        $proyectosCount = $eventosAsignados->sum(fn($e) => $e->inscripciones->whereNotNull('proyecto')->count());
        
        // Acuses (Constancias)
        $acusesCount = DB::table('constancias')->where('id_usuario', $user->id_usuario)->count();

        return view('jurado.dashboard', compact(
            'etapasRevision',
            'eventoActual',
            'proyectoDestacado',
            'nombreEquipoProyecto',
            'nombreEventoProyecto',
            'avancePorcentaje',
            'eventosActivosCount',
            'equiposCount',
            'proyectosCount',
            'acusesCount'
        ));
    }
}
