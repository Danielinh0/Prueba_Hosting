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
use Illuminate\Support\Facades\Log;
use App\Services\EmailNotificacionService;

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
            return back()->with('error', 'Acción no permitida. Debes ser estudiante.');
        }
        
        $estudiante = $user->estudiante;
        
        // Verificar que el equipo tiene inscripción con evento
        $inscripcion = $equipo->inscripciones->first();
        if (!$inscripcion) {
            return back()->with('error', 'Este equipo no tiene inscripciones activas.');
        }
        
        $evento = $inscripcion->evento;
        if (!$evento) {
            return back()->with('error', 'El equipo no está asociado a ningún evento.');
        }

        // Validar conflicto de fechas
        $conflicto = \App\Helpers\EventoHelper::verificarConflictoFechas($user->id_usuario, $evento->id_evento);
        
        if ($conflicto['conflicto']) {
            return back()->with('error', $conflicto['mensaje']);
        }

        // 2. Validar que el estudiante no esté ya en un equipo para ESTE evento específico
        $yaEnEquipoDeEsteEvento = InscripcionEvento::whereHas('miembros', function ($query) use ($user) {
            $query->where('id_estudiante', $user->id_usuario);
        })->where('id_evento', $evento->id_evento)->exists();

        if ($yaEnEquipoDeEsteEvento) {
            return back()->with('error', 'Ya eres miembro de un equipo en este evento.');
        }

        // 3. Validar que el estudiante no tenga ya una solicitud PENDIENTE para este equipo
        $solicitudExistente = SolicitudUnion::where('estudiante_id', $estudiante->id_usuario)
            ->where('equipo_id', $equipo->id_equipo)
            ->first();
            
        if ($solicitudExistente && $solicitudExistente->status === 'pendiente') {
            return back()->with('error', 'Ya tienes una solicitud pendiente para este equipo.');
        }

        try {
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

            // Enviar email al líder del equipo
            $lider = $equipo->miembros()->where('es_lider', true)->with('user')->first();

            if ($lider && $lider->user) {
                Log::info("Enviando email de solicitud al líder: " . $lider->user->nombre);

                $emailService = new EmailNotificacionService();
                $emailService->notificarSolicitudEquipo(
                    $lider->user->id_usuario,
                    [
                        'nombre_estudiante' => $user->nombre,
                        'nombre_equipo' => $equipo->nombre,
                        'nombre_evento' => $evento->nombre
                    ]
                );
            }

            return back()->with('success', '¡Solicitud para unirte al equipo "' . $equipo->nombre . '" enviada exitosamente!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al enviar la solicitud: ' . $e->getMessage());
        }
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

        // Enviar email de notificación al estudiante
        try {
            $emailService = new EmailNotificacionService();

            // Obtener la inscripción para el evento
            $inscripcion = $equipo->inscripciones()->first();

            if ($inscripcion) {
                Log::info("Enviando email de rechazo al estudiante");

                $emailService->notificarSolicitudRechazada(
                    $solicitud->estudiante_id,
                    [
                        'nombre_equipo' => $equipo->nombre,
                        'nombre_evento' => $inscripcion->evento->nombre,
                        'nombre_lider' => $user->nombre
                    ]
                );
            }
        } catch (\Exception $e) {
            Log::error("Error al enviar email de rechazo: " . $e->getMessage());
        }

        return back()->with('success', 'Solicitud rechazada correctamente.');
    }
}
