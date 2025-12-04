<?php

namespace App\Http\Controllers\Jurado;

use App\Http\Controllers\Controller;
use App\Models\Equipo;
use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EquipoController extends Controller
{
    /**
     * Mostrar lista de equipos agrupados por evento para evaluar
     */
    public function index()
    {
        $jurado = Auth::user()->jurado;
        
        // Obtener eventos asignados al jurado con sus inscripciones y equipos
        $eventos = Evento::whereHas('jurados', function($q) use ($jurado) {
                $q->where('jurados.id_usuario', $jurado->id_usuario);
            })
            ->with(['inscripciones' => function($query) {
                $query->with([
                    'equipo',
                    'miembros.user',
                    'miembros.rol',
                    'proyecto.avances.evaluaciones',
                    'evaluaciones'
                ])->where('status_registro', 'Completo');
            }])
            ->orderBy('fecha_inicio', 'desc')
            ->get();

        return view('jurado.equipos.index', compact('eventos', 'jurado'));
    }

    /**
     * Mostrar detalles de un equipo y sus avances
     */
    public function show(Equipo $equipo)
    {
        $jurado = Auth::user()->jurado;
        
        // Verificar que el jurado esté asignado al evento del equipo
        $inscripcion = $equipo->inscripciones()
            ->with(['proyecto.avances.registradoPor', 'evento', 'miembros.user', 'miembros.rolEquipo'])
            ->whereHas('evento.jurados', function($q) use ($jurado) {
                $q->where('id_jurado', $jurado->id_usuario);
            })
            ->first();

        if (!$inscripcion) {
            return redirect()->route('jurado.dashboard')
                ->with('error', 'No tienes permiso para ver este equipo.');
        }

        $proyecto = $inscripcion->proyecto;
        $evento = $inscripcion->evento;

        return view('jurado.equipos.show', compact('equipo', 'inscripcion', 'proyecto', 'evento', 'jurado'));
    }
}
