<?php

namespace App\Http\Controllers\Estudiante;

use App\Http\Controllers\Controller;
use App\Models\Equipo;
use App\Models\SolicitudUnion;
use App\Models\MiembroEquipo;
use App\Models\InscripcionEvento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SolicitudController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Equipo $equipo)
    {
        $user = Auth::user();

        // 1. Asegurarse de que el usuario es un estudiante
        if (!$user->esEstudiante() || !$user->estudiante) {
            return back()->with('error', 'Acción no permitida.');
        }
        
        $estudiante = $user->estudiante;
        $evento = $equipo->inscripciones->first()->evento; // Obtener el evento a través del equipo

        // Validar conflicto de fechas
        $conflicto = \App\Helpers\EventoHelper::verificarConflictoFechas($user->id_usuario, $evento->id_evento);
        
        if ($conflicto['conflicto']) {
            return back()->with('error', $conflicto['mensaje']);
        }

        // 2. Validar que el estudiante no esté ya en un equipo para CUALQUIER evento activo.
        $inscripcionActiva = InscripcionEvento::whereHas('miembros', function ($query) use ($user) {
            $query->where('id_estudiante', $user->id_usuario);
        })->whereHas('evento', function ($query) {
            $query->where('estado', 'Activo');
        })->exists();

        if ($inscripcionActiva) {
            return back()->with('error', 'Ya estás participando en un evento activo. No puedes unirte a un nuevo equipo hasta que termine.');
        }

        // 3. Validar que el estudiante no tenga ya una solicitud para este equipo (se mantiene la lógica)
        $solicitudExistente = SolicitudUnion::where('estudiante_id', $estudiante->id_usuario)
            ->where('equipo_id', $equipo->id_equipo)
            ->first();
            
        if ($solicitudExistente && $solicitudExistente->status != 'rechazada') {
            return back()->with('error', 'Ya has enviado una solicitud a este equipo.');
        }

        // Usar updateOrCreate para permitir volver a solicitar si fue rechazado
        SolicitudUnion::updateOrCreate(
            [
                'estudiante_id' => $estudiante->id_usuario,
                'equipo_id' => $equipo->id_equipo,
            ],
            [
                'status' => 'pendiente',
            ]
        );

        return back()->with('success', '¡Solicitud para unirte al equipo "' . $equipo->nombre . '" enviada exitosamente!');
    }

    /**
     * Aceptar una solicitud de unión.
     */
    public function accept(Request $request, SolicitudUnion $solicitud)
    {
        $request->validate(['id_rol_equipo' => 'required|exists:cat_roles_equipo,id_rol_equipo']);

        $user = Auth::user();
        $equipo = $solicitud->equipo;
        $inscripcion = $equipo->inscripciones->first(); // Assuming one inscription per team for this flow

        // Autorización: Verificar que el usuario actual es el líder del equipo
        $esLider = $equipo->miembros()->where('id_estudiante', $user->id_usuario)->where('es_lider', true)->exists();
        if (!$esLider) {
            return back()->with('error', 'No tienes permiso para realizar esta acción.');
        }

        // VALIDACIÓN CRÍTICA: Verificar que el estudiante no esté ya en otro equipo del MISMO evento
        $eventoId = $inscripcion->id_evento;
        $yaEstaEnEquipo = MiembroEquipo::where('id_estudiante', $solicitud->estudiante_id)
            ->whereHas('inscripcion', function ($query) use ($eventoId) {
                $query->where('id_evento', $eventoId);
            })
            ->exists();

        if ($yaEstaEnEquipo) {
            $solicitud->update(['status' => 'rechazada']);
            return back()->with('error', 'El estudiante ya pertenece a otro equipo en este evento. La solicitud ha sido rechazada automáticamente.');
        }

        // VALIDACIÓN ADICIONAL: Verificar conflicto de fechas
        $conflictoFechas = \App\Helpers\EventoHelper::verificarConflictoFechas($solicitud->estudiante_id, $inscripcion->id_evento);
        
        if ($conflictoFechas['conflicto']) {
            $solicitud->update(['status' => 'rechazada']);
            return back()->with('error', 'El estudiante tiene un conflicto de fechas: ' . $conflictoFechas['mensaje']);
        }

        try {
            DB::transaction(function () use ($request, $solicitud, $inscripcion) {
                // 1. Crear el nuevo miembro
                MiembroEquipo::create([
                    'id_inscripcion' => $inscripcion->id_inscripcion,
                    'id_estudiante' => $solicitud->estudiante_id,
                    'id_rol_equipo' => $request->id_rol_equipo,
                    'es_lider' => false,
                ]);

                // 2. Actualizar el estado de la solicitud actual a 'aceptada'
                $solicitud->update(['status' => 'aceptada']);

                // 3. Rechazar todas las demás solicitudes pendientes del estudiante para este evento
                $eventoId = $inscripcion->id_evento;
                $estudianteId = $solicitud->estudiante_id;

                SolicitudUnion::where('estudiante_id', $estudianteId)
                    ->where('id', '!=', $solicitud->id) // Excluir la que acabamos de aceptar
                    ->where('status', 'pendiente')
                    ->whereHas('equipo.inscripciones', function($q) use ($eventoId) {
                        $q->where('id_evento', $eventoId);
                    })
                    ->update(['status' => 'rechazada']);
            });
        } catch (\Exception $e) {
            return back()->with('error', 'Ocurrió un error al aceptar la solicitud: ' . $e->getMessage());
        }

        return back()->with('success', '¡Miembro añadido al equipo exitosamente!');
    }

    /**
     * Rechazar una solicitud de unión.
     */
    public function reject(SolicitudUnion $solicitud)
    {
        $user = Auth::user();
        $equipo = $solicitud->equipo;

        // Autorización: Verificar que el usuario actual es el líder del equipo
        $esLider = $equipo->miembros()->where('id_estudiante', $user->id_usuario)->where('es_lider', true)->exists();
        if (!$esLider) {
            return back()->with('error', 'No tienes permiso para realizar esta acción.');
        }

        $solicitud->update(['status' => 'rechazada']);

        return back()->with('success', 'Solicitud rechazada correctamente.');
    }
}
