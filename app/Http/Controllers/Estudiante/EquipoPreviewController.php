<?php

namespace App\Http\Controllers\Estudiante;

use App\Http\Controllers\Controller;
use App\Models\Equipo;
use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EquipoPreviewController extends Controller
{
    /**
     * Show the preview of a team
     */
    public function show(Equipo $equipo)
    {
        $user = Auth::user();

        // Verificar que el usuario sea un estudiante
        if (!$user->esEstudiante()) {
            return redirect()->route('dashboard')->with('error', 'Acceso no autorizado');
        }

        // Cargar las relaciones necesarias
        $equipo->load([
            'miembros.user',
            'miembros.rol',
            'proyecto',
            'inscripciones.evento'
        ]);

        // Obtener la inscripción activa del equipo
        $inscripcionActiva = $equipo->inscripciones()
            ->whereHas('evento', function($query) {
                $query->whereIn('estado', ['Activo', 'En Progreso']);
            })
            ->with('evento')
            ->first();

        // Verificar si el usuario ya es miembro o tiene solicitud pendiente
        $esMiembro = $equipo->miembros()->where('id_estudiante', $user->id_usuario)->exists();
        $tieneSolicitudPendiente = \App\Models\SolicitudUnion::where('estudiante_id', $user->id_usuario)
            ->where('equipo_id', $equipo->id_equipo)
            ->where('status', 'pendiente')
            ->exists();

        // Contar miembros actuales
        $cantidadMiembros = $equipo->miembros->count();
        $lider = $equipo->miembros->where('es_lider', true)->first();

        return view('estudiante.equipos.preview', compact(
            'equipo',
            'inscripcionActiva',
            'esMiembro',
            'tieneSolicitudPendiente',
            'cantidadMiembros',
            'lider'
        ));
    }

    /**
     * Get available teams for carousel
     */
    public function getAvailableTeams()
    {
        $user = Auth::user();

        // Obtener equipos de eventos activos donde el usuario no es miembro
        $equipos = Equipo::whereHas('inscripciones', function($query) {
                $query->whereHas('evento', function($subQuery) {
                    $subQuery->whereIn('estado', ['Activo', 'En Progreso']);
                });
            })
            ->with(['miembros.user', 'inscripciones.evento', 'proyecto'])
            ->whereDoesntHave('miembros', function($query) use ($user) {
                $query->where('id_estudiante', $user->id_usuario);
            })
            ->take(6) // Limitar a 6 equipos para el carrusel
            ->get();

        return response()->json($equipos);
    }
}