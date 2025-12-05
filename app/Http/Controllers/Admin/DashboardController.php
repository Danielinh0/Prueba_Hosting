<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Evento;
use App\Models\Equipo;
use App\Models\User;
use App\Models\Jurado;
use App\Models\CatRolSistema;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // KPIs
        $totalEstudiantesActivos = User::whereHas('rolSistema', function($q) { $q->where('nombre', 'estudiante'); })
                                        ->where('activo', true)
                                        ->count();
        $eventosEnCursoCount = Evento::where('estado', 'Activo')->count();
        $equiposRegistradosCount = Equipo::count();
        $juradosAsignadosCount = Jurado::count();
        
        // Eventos Activos (en curso)
        $eventosActivos = Evento::where('estado', 'Activo')
                                ->orderBy('fecha_inicio')
                                ->get();
        
        // Eventos Próximos (por venir)
        $eventosProximos = Evento::where('estado', 'Próximo')
                                 ->orderBy('fecha_inicio')
                                 ->get();

        // Sección "Eventos que Requieren Atención"
        $eventosPorIniciar = Evento::where('estado', 'Próximo')
                                   ->where('fecha_inicio', '>=', now())
                                   ->where('fecha_inicio', '<=', now()->addDays(3))
                                   ->get();

        $eventosSinJurados = Evento::where('estado', 'Activo')
                                   ->whereDoesntHave('jurados')
                                   ->get();
        
        $eventosConEquiposIncompletos = Evento::where('estado', 'Activo')
                                             ->whereHas('inscripciones', function ($query) {
                                                 $query->where('status_registro', 'Incompleto');
                                             })
                                             ->withCount(['inscripciones' => function ($query) {
                                                 $query->where('status_registro', 'Incompleto');
                                             }])
                                             ->get();


        return view('admin.dashboard', compact(
            'totalEstudiantesActivos', 
            'eventosEnCursoCount', 
            'equiposRegistradosCount', 
            'juradosAsignadosCount',
            'eventosActivos',
            'eventosProximos',
            'eventosPorIniciar',
            'eventosSinJurados',
            'eventosConEquiposIncompletos'
        ));
    }
}
