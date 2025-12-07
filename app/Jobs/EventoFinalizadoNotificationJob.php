<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\Evento;
use App\Models\InscripcionEvento;
use App\Mail\EventoFinalizadoNotification;

class EventoFinalizadoNotificationJob implements ShouldQueue
{
    use Queueable;

    /**
     * El evento que se ha finalizado
     *
     * @var \App\Models\Evento
     */
    protected $evento;

    /**
     * Create a new job instance.
     */
    public function __construct(Evento $evento)
    {
        $this->evento = $evento;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Obtener todas las inscripciones con posiciones asignadas
        $inscripciones = $this->evento->inscripciones()
            ->with(['equipo', 'miembros.user'])
            ->whereNotNull('puesto_ganador')
            ->get();

        foreach ($inscripciones as $inscripcion) {
            // Enviar correo a cada miembro del equipo
            foreach ($inscripcion->miembros as $miembro) {
                try {
                    Mail::to($miembro->user->email)->send(
                        new EventoFinalizadoNotification(
                            $miembro->user,
                            $this->evento,
                            $inscripcion->equipo->nombre,
                            $inscripcion->puesto_ganador
                        )
                    );
                } catch (\Exception $e) {
                    // Loguear error pero continuar con el siguiente
                    \Log::error('Error al enviar correo de finalización de evento: ' . $e->getMessage(), [
                        'usuario' => $miembro->user->id_usuario,
                        'evento' => $this->evento->id_evento,
                        'equipo' => $inscripcion->equipo->id_equipo
                    ]);
                }
            }
        }
    }
}
