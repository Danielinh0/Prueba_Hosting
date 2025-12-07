<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\Proyecto;
use App\Models\InscripcionEvento;
use App\Mail\ProyectoEvaluacionCompletaNotification;

class ProyectoTotalmenteEvaluadoJob implements ShouldQueue
{
    use Queueable;

    /**
     * El proyecto que ha sido completamente evaluado
     *
     * @var \App\Models\Proyecto
     */
    protected $proyecto;

    /**
     * Create a new job instance.
     */
    public function __construct(Proyecto $proyecto)
    {
        $this->proyecto = $proyecto;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $inscripcion = $this->proyecto->inscripcion;
        $equipo = $inscripcion->equipo;

        // 1. Calcular calificación final del proyecto
        $calificacionFinal = $this->calcularCalificacionFinal();

        // 2. Actualizar la inscripción con la calificación final
        $inscripcion->calificacion_final = $calificacionFinal;
        $inscripcion->save();

        // 3. Notificar a todos los miembros
        foreach ($equipo->miembros as $miembro) {
            try {
                Mail::to($miembro->user->email)->send(
                    new ProyectoEvaluacionCompletaNotification(
                        $miembro->user,
                        $this->proyecto,
                        $calificacionFinal,
                        $equipo->nombre
                    )
                );
            } catch (\Exception $e) {
                Log::error('Error al enviar notificación de proyecto evaluado: ' . $e->getMessage(), [
                    'proyecto' => $this->proyecto->id_proyecto,
                    'usuario' => $miembro->user->id_usuario,
                ]);
            }
        }

        // 4. Verificar si todos los proyectos del evento están evaluados
        $this->verificarEventoCompletamenteEvaluado($inscripcion->evento);
    }

    /**
     * Calcular la calificación final del proyecto
     */
    private function calcularCalificacionFinal(): float
    {
        // Obtener todas las evaluaciones de todos los avances
        $evaluaciones = $this->proyecto->avances()
            ->with('evaluaciones')
            ->get()
            ->pluck('evaluaciones')
            ->flatten()
            ->whereNotNull('calificacion');

        // Calcular promedio ponderado por criterios
        $calificacionesPorCriterio = [];

        foreach ($evaluaciones as $evaluacion) {
            if (!isset($calificacionesPorCriterio[$evaluacion->id_criterio])) {
                $calificacionesPorCriterio[$evaluacion->id_criterio] = [];
            }
            $calificacionesPorCriterio[$evaluacion->id_criterio][] = $evaluacion->calificacion;
        }

        // Obtener ponderación de cada criterio
        $ponderaciones = $this->proyecto->inscripcion->evento->criteriosEvaluacion()
            ->pluck('ponderacion', 'id_criterio');

        // Calcular promedio final ponderado
        $sumaPonderada = 0;
        $sumaPonderaciones = 0;

        foreach ($calificacionesPorCriterio as $idCriterio => $calificaciones) {
            $promedioCriterio = array_sum($calificaciones) / count($calificaciones);
            $ponderacion = $ponderaciones[$idCriterio] ?? 0;

            $sumaPonderada += $promedioCriterio * $ponderacion;
            $sumaPonderaciones += $ponderacion;
        }

        return $sumaPonderaciones > 0 ? round($sumaPonderada / $sumaPonderaciones, 2) : 0;
    }

    /**
     * Verificar si todos los proyectos del evento están evaluados
     */
    private function verificarEventoCompletamenteEvaluado($evento)
    {
        $proyectosPendientes = $evento->inscripciones()
            ->whereHas('proyecto')
            ->whereNull('calificacion_final')
            ->count();

        if ($proyectosPendientes === 0) {
            // Todos los proyectos evaluados - podrías activar algo aquí
            // Como generar posiciones automáticamente o notificar al admin
            Log::info('Todos los proyectos del evento están evaluados', [
                'evento' => $evento->id_evento,
                'nombre_evento' => $evento->nombre
            ]);
        }
    }
}