<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\Avance;
use App\Mail\AvanceTotalmenteEvaluadoNotification;

class AvanceCompletamenteEvaluadoJob implements ShouldQueue
{
    use Queueable;

    /**
     * El avance que ha sido completamente evaluado
     *
     * @var \App\Models\Avance
     */
    protected $avance;

    /**
     * Create a new job instance.
     */
    public function __construct(Avance $avance)
    {
        $this->avance = $avance;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $proyecto = $this->avance->proyecto;
        $equipo = $proyecto->inscripcion->equipo;

        // Calcular promedio de calificaciones
        $promedio = $this->avance->evaluaciones()
            ->whereNotNull('calificacion')
            ->avg('calificacion');

        // 1. Notificar a todos los miembros sobre la evaluación completa
        foreach ($equipo->miembros as $miembro) {
            try {
                Mail::to($miembro->user->email)->send(
                    new AvanceTotalmenteEvaluadoNotification(
                        $miembro->user,
                        $this->avance,
                        $promedio,
                        $equipo->nombre
                    )
                );
            } catch (\Exception $e) {
                Log::error('Error al enviar notificación de avance evaluado: ' . $e->getMessage(), [
                    'avance' => $this->avance->id_avance,
                    'usuario' => $miembro->user->id_usuario,
                ]);
            }
        }

        // 2. Actualizar estadísticas del proyecto
        $this->actualizarEstadisticasProyecto($proyecto);

        // 3. Verificar si todos los avances están evaluados
        $this->verificarProyectoCompletamenteEvaluado($proyecto);
    }

    /**
     * Actualizar estadísticas del proyecto
     */
    private function actualizarEstadisticasProyecto($proyecto)
    {
        $avancesTotales = $proyecto->avances()->count();
        $avancesEvaluados = $proyecto->avances()
            ->whereHas('evaluaciones', function($query) {
                $query->whereNotNull('calificacion');
            })
            ->count();

        // Guardar estadísticas (podrías tener una tabla para esto)
        $proyecto->estadisticas = [
            'avances_totales' => $avancesTotales,
            'avances_evaluados' => $avancesEvaluados,
            'porcentaje_evaluado' => $avancesTotales > 0 ? round(($avancesEvaluados / $avancesTotales) * 100, 1) : 0,
            'actualizado_en' => now()
        ];
        $proyecto->save();
    }

    /**
     * Verificar si todo el proyecto está evaluado
     */
    private function verificarProyectoCompletamenteEvaluado($proyecto)
    {
        $avancesPendientes = $proyecto->avances()
            ->whereDoesntHave('evaluaciones', function($query) {
                $query->whereNotNull('calificacion');
            })
            ->count();

        if ($avancesPendientes === 0) {
            // Todo el proyecto está evaluado
            ProyectoTotalmenteEvaluadoJob::dispatch($proyecto);
        }
    }
}