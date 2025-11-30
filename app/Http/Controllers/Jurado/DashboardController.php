<?php

namespace App\Http\Controllers\Jurado;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $jurado = Auth::user()->jurado;
        
        // Obtener eventos asignados al jurado
        $eventosAsignados = $jurado->eventos()
            ->with(['inscripciones' => function($q) {
                $q->where('status_registro', 'Completo')
                  ->with(['equipo', 'proyecto.avances']);
            }])
            ->whereIn('estado', ['Próximo', 'Activo'])
            ->orderBy('fecha_inicio')
            ->get();

        // Contar equipos totales a evaluar
        $totalEquipos = $eventosAsignados->sum(function($evento) {
            return $evento->inscripciones->count();
        });

        // Contar avances pendientes de revisar (últimos 7 días)
        $avancesRecientes = 0;
        foreach($eventosAsignados as $evento) {
            foreach($evento->inscripciones as $inscripcion) {
                if($inscripcion->proyecto) {
                    $avancesRecientes += $inscripcion->proyecto->avances()
                        ->where('created_at', '>=', now()->subDays(7))
                        ->count();
                }
            }
        }

        return view('jurado.dashboard', compact(
            'jurado',
            'eventosAsignados',
            'totalEquipos',
            'avancesRecientes'
        ));
    }
}
