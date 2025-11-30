<?php

namespace App\Helpers;

use App\Models\MiembroEquipo;
use App\Models\Evento;

class EventoHelper
{
    /**
     * Verificar si un estudiante tiene conflicto de fechas con otro evento
     * 
     * @param int $estudianteId ID del estudiante
     * @param int $eventoId ID del evento a verificar
     * @return array ['conflicto' => bool, 'evento' => Evento|null, 'mensaje' => string|null]
     */
    public static function verificarConflictoFechas(int $estudianteId, int $eventoId): array
    {
        // Obtener el evento nuevo
        $eventoNuevo = Evento::find($eventoId);
        
        if (!$eventoNuevo) {
            return ['conflicto' => false, 'evento' => null, 'mensaje' => null];
        }

        // Buscar todos los equipos del estudiante en otros eventos
        $equiposDelEstudiante = MiembroEquipo::where('id_estudiante', $estudianteId)
            ->whereHas('inscripcion', function ($query) use ($eventoId) {
                // Eventos diferentes al nuevo Y que tengan evento asignado
                $query->where('id_evento', '!=', $eventoId)
                      ->whereNotNull('id_evento');
            })
            ->with('inscripcion.evento')
            ->get();

        // Verificar traslape de fechas con cada evento
        foreach ($equiposDelEstudiante as $miembro) {
            $eventoExistente = $miembro->inscripcion->evento;
            
            if (!$eventoExistente) {
                continue;
            }

            // Lógica de traslape:
            // Hay traslape SI:
            // - fecha_inicio_nuevo < fecha_fin_existente Y
            // - fecha_fin_nuevo > fecha_inicio_existente
            //
            // PERO permitimos si el fin de uno es el inicio del otro (mismo día)
            $hayTraslape = 
                $eventoNuevo->fecha_inicio < $eventoExistente->fecha_fin &&
                $eventoNuevo->fecha_fin > $eventoExistente->fecha_inicio;

            if ($hayTraslape) {
                $mensaje = sprintf(
                    'Ya estás participando en "%s" del %s al %s. No puedes participar en eventos con fechas traslapadas.',
                    $eventoExistente->nombre,
                    $eventoExistente->fecha_inicio->format('d/m/Y'),
                    $eventoExistente->fecha_fin->format('d/m/Y')
                );

                return [
                    'conflicto' => true,
                    'evento' => $eventoExistente,
                    'mensaje' => $mensaje
                ];
            }
        }

        return ['conflicto' => false, 'evento' => null, 'mensaje' => null];
    }
}
