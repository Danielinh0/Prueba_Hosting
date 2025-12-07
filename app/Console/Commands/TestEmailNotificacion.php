<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\EmailNotificacionService;
use App\Models\User;

class TestEmailNotificacion extends Command
{
    protected $signature = 'email:test {tipo}';
    protected $description = 'Probar el envío de emails de notificación';

    public function handle()
    {
        $tipo = $this->argument('tipo');
        $emailService = new EmailNotificacionService();

        switch ($tipo) {
            case 'calificacion':
                // Probar email de calificación final
                $estudiante = User::where('email', 'like', '%@%')->first();
                if ($estudiante) {
                    $this->info("Enviando email de calificación a: " . $estudiante->email);
                    $emailService->notificarCalificacionFinal(
                        $estudiante->id_usuario,
                        [
                            'nombre' => 'Proyecto de Prueba',
                            'nombre_jurado' => 'Jurado de Prueba',
                            'comentarios' => 'Este es un comentario de prueba'
                        ],
                        95
                    );
                    $this->info('Email de calificación enviado');
                } else {
                    $this->error('No se encontró ningún estudiante con email');
                }
                break;

            case 'asignacion':
                // Probar email de asignación de jurado
                $jurado = User::whereHas('jurado')->where('email', 'like', '%@%')->first();
                if ($jurado) {
                    $this->info("Enviando email de asignación a: " . $jurado->email);
                    $emailService->notificarJuradoAsignado(
                        $jurado->id_usuario,
                        [
                            'nombre' => 'Evento de Prueba 2025',
                            'fecha' => '15/12/2025',
                            'cantidad_proyectos' => 5
                        ]
                    );
                    $this->info('Email de asignación enviado');
                } else {
                    $this->error('No se encontró ningún jurado con email');
                }
                break;

            case 'avance':
                // Probar email de avance calificado
                $estudiante = User::where('email', 'like', '%@%')->first();
                if ($estudiante) {
                    $this->info("Enviando email de avance calificado a: " . $estudiante->email);
                    $emailService->notificarAvanceCalificado(
                        $estudiante->id_usuario,
                        [
                            'nombre' => 'Proyecto Avance Test',
                            'nombre_jurado' => 'Jurado Test',
                            'comentarios' => 'Tu avance ha sido revisado exitosamente'
                        ]
                    );
                    $this->info('✓ Email de avance enviado');
                } else {
                    $this->error('❌ No se encontró ningún estudiante con email');
                }
                break;

            default:
                $this->error('❌ Tipo no válido. Usa: calificacion, asignacion o avance');
                return;
        }

        $this->info('\n✅ Prueba completada. Revisa tu bandeja de entrada.');
    }
}