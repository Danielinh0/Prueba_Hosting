<?php

namespace App\Http\Controllers\Estudiante;

use App\Http\Controllers\Controller;
use App\Models\InscripcionEvento;
use App\Models\CatRolEquipo;
use App\Models\SolicitudUnion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MiEquipoController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $user = Auth::user();

        // Buscar TODAS las inscripciones del estudiante
        $misInscripciones = InscripcionEvento::whereHas('miembros', function ($query) use ($user) {
            $query->where('id_estudiante', $user->id_usuario);
        })->where(function ($query) {
            // Equipos sin evento O eventos NO finalizados (incluyendo eliminados)
            $query->whereNull('id_evento')
                  ->orWhereHas('evento', function ($q) {
                      $q->withTrashed() // Incluir eventos eliminados (soft deleted)
                        ->where('estado', '!=', 'Finalizado');
                  });
        })->with([
            'equipo', 
            'miembros.user.estudiante.carrera',
            'miembros.rol',
            'evento' => function ($query) {
                $query->withTrashed(); // Incluir eventos eliminados en la relación
            }
        ])->get();
        
        // Preparar datos de cada equipo
        $equiposData = $misInscripciones->map(function ($inscripcion) use ($user) {
            $miembro = $inscripcion->miembros->firstWhere('id_estudiante', $user->id_usuario);
            $esLider = $miembro ? $miembro->es_lider : false;
            
            $solicitudes = collect();
            $roles = collect();
            
            if ($esLider) {
                // Cargar solicitudes pendientes para el equipo
                $solicitudes = SolicitudUnion::where('equipo_id', $inscripcion->id_equipo)
                    ->where('status', 'pendiente')
                    ->with('estudiante.user')
                    ->get();
                
                // Cargar los roles de equipo disponibles
                $roles = CatRolEquipo::all();
            }
            
            return [
                'inscripcion' => $inscripcion,
                'esLider' => $esLider,
                'solicitudes' => $solicitudes,
                'roles' => $roles,
            ];
        });

        return view('estudiante.equipo.index', [
            'equipos' => $equiposData,
        ]);
    }

    /**
     * Mostrar detalle de un equipo específico
     */
    public function showDetalle(InscripcionEvento $inscripcion)
    {
        $user = Auth::user();

        // Verificar que el usuario es miembro de este equipo
        $miembro = $inscripcion->miembros()->where('id_estudiante', $user->id_usuario)->first();
        
        if (!$miembro) {
            return redirect()->route('estudiante.equipo.index')->with('error', 'No tienes acceso a este equipo.');
        }

        // Cargar relaciones necesarias
        $inscripcion->load([
            'equipo',
            'miembros.user.estudiante.carrera',
            'miembros.rol',
            'evento' => function ($query) {
                $query->withTrashed(); // Incluir eventos eliminados
            }
        ]);

        $esLider = $miembro->es_lider;
        $solicitudes = collect();
        $roles = collect();

        if ($esLider) {
            // Cargar solicitudes pendientes para el equipo
            $solicitudes = SolicitudUnion::where('equipo_id', $inscripcion->id_equipo)
                ->where('status', 'pendiente')
                ->with('estudiante.user')
                ->get();
            
            // Cargar los roles de equipo disponibles
            $roles = CatRolEquipo::all();
        }

        return view('estudiante.equipo.show', [
            'inscripcion' => $inscripcion,
            'esLider' => $esLider,
            'solicitudes' => $solicitudes,
            'roles' => $roles,
        ]);
    }
}
