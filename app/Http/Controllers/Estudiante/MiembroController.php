<?php

namespace App\Http\Controllers\Estudiante;

use App\Http\Controllers\Controller;
use App\Models\MiembroEquipo;
use App\Models\SolicitudUnion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MiembroController extends Controller
{
    /**
     * Update the role of a team member.
     */
    public function updateRole(Request $request, MiembroEquipo $miembro)
    {
        $request->validate([
            'id_rol_equipo' => 'required|exists:cat_roles_equipo,id_rol_equipo',
        ]);

        $user = Auth::user();
        $inscripcion = $miembro->inscripcion;
        $esLider = $inscripcion->equipo->miembros()->where('id_estudiante', $user->id_usuario)->where('es_lider', true)->exists();

        // Autorización: solo el líder puede cambiar roles.
        if (!$esLider) {
            return back()->with('error', 'No tienes permiso para cambiar roles.');
        }

        // Un líder no puede cambiar su propio rol.
        if ($miembro->es_lider) {
            return back()->with('error', 'El rol del líder no se puede cambiar.');
        }

        $miembro->update(['id_rol_equipo' => $request->id_rol_equipo]);

        return back()->with('success', 'Rol del miembro actualizado correctamente.');
    }

    /**
     * Remove a member from the team.
     */
    public function destroy(MiembroEquipo $miembro)
    {
        $user = Auth::user();
        $inscripcion = $miembro->inscripcion;
        $equipo = $inscripcion->equipo;
        $esLider = $equipo->miembros()->where('id_estudiante', $user->id_usuario)->where('es_lider', true)->exists();

        // Autorización: solo el líder puede eliminar miembros.
        if (!$esLider) {
            return back()->with('error', 'No tienes permiso para eliminar miembros.');
        }

        // Edge case: un líder no puede eliminarse a sí mismo.
        if ($miembro->id_estudiante == $user->id_usuario) {
            return back()->with('error', 'No puedes eliminarte a ti mismo del equipo.');
        }

        try {
            DB::transaction(function () use ($miembro, $inscripcion) {
                $estudianteId = $miembro->id_estudiante;
                $eventoId = $inscripcion->id_evento;

                // 1. Eliminar al miembro del equipo
                $miembro->delete();

                // 2. Eliminar TODAS las solicitudes del estudiante para este evento para "resetear" su estado.
                SolicitudUnion::where('estudiante_id', $estudianteId)
                    ->whereHas('equipo.inscripciones', function($q) use ($eventoId) {
                        $q->where('id_evento', $eventoId);
                    })
                    ->delete();
            });
        } catch (\Exception $e) {
            return back()->with('error', 'Ocurrió un error al eliminar al miembro: ' . $e->getMessage());
        }

        return back()->with('success', 'Miembro eliminado del equipo.');
    }

    /**
     * Permitir que un miembro se salga del equipo por su propia voluntad
     */
    public function leave()
    {
        $user = Auth::user();

        // Buscar el equipo del estudiante
        $miembro = MiembroEquipo::where('id_estudiante', $user->id_usuario)
            ->whereHas('inscripcion.evento', function ($query) {
                $query->whereIn('estado', ['Próximo', 'Activo', 'Cerrado']);
            })
            ->with('inscripcion')
            ->first();

        if (!$miembro) {
            return back()->with('error', 'No perteneces a ningún equipo activo.');
        }

        // Verificar que NO sea líder
        if ($miembro->es_lider) {
            return back()->with('error', 'Como líder, no puedes abandonar el equipo. Debes transferir el liderazgo o eliminar el equipo.');
        }

        try {
            DB::transaction(function () use ($miembro) {
                $estudianteId = $miembro->id_estudiante;
                $eventoId = $miembro->inscripcion->id_evento;

                // 1. Eliminar al miembro del equipo
                $miembro->delete();

                // 2. Eliminar sus solicitudes para este evento
                SolicitudUnion::where('estudiante_id', $estudianteId)
                    ->whereHas('equipo.inscripciones', function($q) use ($eventoId) {
                        $q->where('id_evento', $eventoId);
                    })
                    ->delete();
            });

            return redirect()->route('estudiante.eventos.index')
                ->with('success', 'Has abandonado el equipo exitosamente.');

        } catch (\Exception $e) {
            return back()->with('error', 'Ocurrió un error al salir del equipo: ' . $e->getMessage());
        }
    }
}
