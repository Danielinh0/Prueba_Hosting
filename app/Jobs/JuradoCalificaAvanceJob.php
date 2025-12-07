<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\Avance;
use App\Models\Evaluacion;
use App\Mail\AvanceEvaluadoNotification;

class JuradoCalificaAvanceJob implements ShouldQueue
{
    use Queueable;

    /**
     * La evaluación que se ha realizado
     *
     * @var \App\Models\Evaluacion
     */
    protected $evaluacion;

    /**
     * Create a new job instance.
     */
    public function __construct(Evaluacion $evaluacion)
    {
        $this->evaluacion = $evaluacion;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $avance = $this->evaluacion->avance;
        $proyecto = $avance->proyecto;
        $equipo = $proyecto->inscripcion->equipo;

        // 1. Notificar a todos los miembros del equipo
        foreach ($equipo->miembros as $miembro) {
            try {
                Mail::to($miembro->user->email)->send(
                    new AvanceEvaluadoNotification(
                        $miembro->user,
                        $avance,
                        $this->evaluacion,
                        $equipo->nombre
                    )
                );
            } catch (\Exception $e) {
                Log::error('Error al enviar notificación de evaluación de avance: ' . $e->getMessage(), [
                    'evaluacion' => $this->evaluacion->id_evaluacion,
                    'usuario' => $miembro->user->id_usuario,
                ]);
            }
        }

        // 2. Verificar si es la última evaluación pendiente
        $evaluacionesPendientes = $avance->evaluaciones()
            ->whereNull('calificacion')
            ->count();

        if ($evaluacionesPendientes === 0) {
            // Despachar job para notificar que el avance está completamente evaluado
            AvanceCompletamenteEvaluadoJob::dispatch($avance);
        }
    }
}