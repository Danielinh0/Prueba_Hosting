<?php

namespace App\Http\Controllers\Estudiante;

use App\Http\Controllers\Controller;
use App\Models\Evento;
use App\Models\InscripcionEvento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $user = Auth::user();

        // Buscar la inscripción activa del estudiante
        $miInscripcion = InscripcionEvento::whereHas('miembros', function ($query) use ($user) {
            $query->where('id_estudiante', $user->id_usuario);
        })->whereHas('evento', function ($query) {
            $query->whereIn('estado', ['Activo', 'En Progreso']);
        })->with([
            'equipo', 
            'evento.inscripciones',
            'evento.proyectoGeneral',
            'proyectoEvento',
            'proyecto'
        ])->first();

        // Obtener los eventos disponibles según el estado del estudiante
        if ($miInscripcion) {
            // Si ya está en un evento activo, mostrar solo eventos próximos (excluyendo el actual)
            $eventosDisponibles = Evento::where('estado', 'Próximo')
                                       ->where('id_evento', '!=', $miInscripcion->id_evento)
                                       ->with('inscripciones')
                                       ->orderBy('fecha_inicio', 'asc')
                                       ->get();
        } else {
            // Si NO está en un evento activo, mostrar solo eventos activos
            $eventosDisponibles = Evento::where('estado', 'Activo')
                                       ->with('inscripciones')
                                       ->orderBy('fecha_inicio', 'asc')
                                       ->get();
        }
                         
        return view('estudiante.dashboard-prueba', compact('miInscripcion', 'eventosDisponibles'));
    }
}
