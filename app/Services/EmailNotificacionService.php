<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class EmailNotificacionService
{
    /**
     * Enviar notificación por email cuando un jurado califica un proyecto
     */
    public function notificarCalificacionFinal($idEstudiante, $datosProyecto, $calificacion)
    {
        try {
            $estudiante = User::find($idEstudiante);

            if (!$estudiante || !$estudiante->email) {
                Log::warning("Estudiante {$idEstudiante} no encontrado o sin email");
                return false;
            }

            // Enviar email real
            Log::info("Enviando email de calificación a: " . $estudiante->email);
            $asunto = "¡Felicidades! Tu proyecto ha sido calificado";
            $datos = [
                'nombreEstudiante' => $estudiante->nombre,
                'nombreProyecto' => $datosProyecto['nombre'] ?? 'Tu proyecto',
                'calificacion' => $calificacion,
                'nombreJurado' => $datosProyecto['nombre_jurado'] ?? 'El jurado',
                'comentarios' => $datosProyecto['comentarios'] ?? ''
            ];

            Mail::raw(
                $this->generarMensajeCalificacion($datos),
                function ($message) use ($estudiante, $asunto) {
                    $message->to($estudiante->email)
                           ->cc('diego469quiroga@gmail.com') // Enviar copia a tu correo
                           ->subject($asunto)
                           ->from(config('mail.from.address'), config('mail.from.name'));
                }
            );

            Log::info("Email de calificación enviado a {$estudiante->email}");

            return true;
        } catch (\Exception $e) {
            Log::error("Error procesando notificación de calificación: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Enviar notificación por email cuando un jurado califica un avance
     */
    public function notificarAvanceCalificado($idEstudiante, $datosProyecto)
    {
        try {
            $estudiante = User::find($idEstudiante);

            if (!$estudiante || !$estudiante->email) {
                Log::warning("Estudiante {$idEstudiante} no encontrado o sin email");
                return false;
            }

            $asunto = "Tu avance de proyecto ha sido revisado";
            $datos = [
                'nombreEstudiante' => $estudiante->nombre,
                'nombreProyecto' => $datosProyecto['nombre'] ?? 'Tu proyecto',
                'nombreJurado' => $datosProyecto['nombre_jurado'] ?? 'El jurado',
                'comentarios' => $datosProyecto['comentarios'] ?? 'Tu avance ha sido revisado.'
            ];

            Mail::raw(
                $this->generarMensajeAvance($datos),
                function ($message) use ($estudiante, $asunto) {
                    $message->to($estudiante->email)
                           ->cc('diego469quiroga@gmail.com') // Enviar copia a tu correo
                           ->subject($asunto)
                           ->from(config('mail.from.address'), config('mail.from.name'));
                }
            );

            Log::info("Email de avance calificado enviado a {$estudiante->email}");
            return true;
        } catch (\Exception $e) {
            Log::error("Error enviando email de avance: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Enviar notificación cuando se asigna un jurado a un evento
     */
    public function notificarJuradoAsignado($idJurado, $datosEvento)
    {
        try {
            Log::info("=== INICIANDO notificarJuradoAsignado ===");
            Log::info("ID Jurado: " . $idJurado);
            Log::info("Datos evento: " . json_encode($datosEvento));

            $jurado = User::find($idJurado);

            if (!$jurado) {
                Log::error("❌ Jurado {$idJurado} no encontrado");
                return false;
            }

            if (!$jurado->email) {
                Log::error("❌ Jurado {$idJurado} no tiene email");
                return false;
            }

            Log::info("Jurado encontrado: " . $jurado->nombre);
            Log::info("Email del jurado: " . $jurado->email);

            $asunto = "Te han asignado como jurado en un evento";
            $datos = [
                'nombreJurado' => $jurado->nombre,
                'nombreEvento' => $datosEvento['nombre'],
                'fechaEvento' => $datosEvento['fecha'] ?? 'Próximamente',
                'cantidadProyectos' => $datosEvento['cantidad_proyectos'] ?? 0
            ];

            Log::info("Intentando enviar email con Mail facade...");

            // Verificar configuración
            Log::info("MAIL_MAILER: " . config('mail.mailer'));
            Log::info("MAIL_HOST: " . config('mail.host'));
            Log::info("MAIL_PORT: " . config('mail.port'));
            Log::info("MAIL_ENCRYPTION: " . config('mail.encryption'));
            Log::info("MAIL_USERNAME: " . config('mail.username'));
            Log::info("MAIL_FROM_ADDRESS: " . config('mail.from.address'));
            Log::info("MAIL_PASSWORD configurada: " . (config('mail.password') ? 'Sí' : 'No'));

            Mail::raw(
                $this->generarMensajeAsignacion($datos),
                function ($message) use ($jurado, $asunto) {
                    $message->to($jurado->email)
                           ->cc('diego469quiroga@gmail.com') // Enviar copia a tu correo
                           ->subject($asunto)
                           ->from(config('mail.from.address'), config('mail.from.name'));

                    Log::info("Email creado correctamente para: " . $jurado->email);
                }
            );

            Log::info("✅ Email de asignación enviado a {$jurado->email}");
            return true;
        } catch (\Exception $e) {
            Log::error("❌ ERROR ENVIANDO EMAIL DE ASIGNACIÓN");
            Log::error("Error: " . $e->getMessage());
            Log::error("Línea: " . $e->getLine());
            Log::error("Archivo: " . $e->getFile());
            Log::error("Stack trace: " . $e->getTraceAsString());
            return false;
        }
    }

    /**
     * Generar el mensaje para calificación final
     */
    private function generarMensajeCalificacion($datos)
    {
        return "
Hola {$datos['nombreEstudiante']},

¡Felicidades! Tu proyecto '{$datos['nombreProyecto']}' ha sido calificado.

📊 Calificación obtenida: {$datos['calificacion']}/100
👤 Evaluado por: {$datos['nombreJurado']}

" . ($datos['comentarios'] ? "💬 Comentarios: {$datos['comentarios']}\n" : "") . "

Puedes revisar los detalles completos en el sistema.

¡Sigue así con el excelente trabajo!

Atentamente,
El equipo de " . config('app.name') . "
        ";
    }

    /**
     * Generar el mensaje para avance calificado
     */
    private function generarMensajeAvance($datos)
    {
        return "
Hola {$datos['nombreEstudiante']},

Tu avance del proyecto '{$datos['nombreProyecto']}' ha sido revisado por el jurado.

👨‍💼 Revisado por: {$datos['nombreJurado']}
💬 {$datos['comentarios']}

Puedes ingresar al sistema para ver los comentarios detallados y continuar con tu proyecto.

¡Mucho éxito!

Atentamente,
El equipo de " . config('app.name') . "
        ";
    }

    /**
     * Enviar notificación cuando se elimina un jurado de un evento
     */
    public function notificarJuradoEliminado($idJurado, $datosEvento)
    {
        try {
            Log::info("=== INICIANDO notificarJuradoEliminado ===");
            Log::info("ID Jurado: " . $idJurado);
            Log::info("Datos evento: " . json_encode($datosEvento));

            $jurado = User::find($idJurado);

            if (!$jurado || !$jurado->email) {
                Log::error("❌ Jurado {$idJurado} no encontrado o sin email");
                return false;
            }

            Log::info("Jurado encontrado: " . $jurado->nombre);
            Log::info("Email del jurado: " . $jurado->email);

            $asunto = "Has sido removido como jurado de un evento";
            $datos = [
                'nombreJurado' => $jurado->nombre,
                'nombreEvento' => $datosEvento['nombre'],
                'fechaEvento' => $datosEvento['fecha'] ?? 'Próximamente',
                'motivo' => $datosEvento['motivo'] ?? 'Reorganización de jurados'
            ];

            Mail::raw(
                $this->generarMensajeEliminacion($datos),
                function ($message) use ($jurado, $asunto) {
                    $message->to($jurado->email)
                           ->cc('diego469quiroga@gmail.com') // Enviar copia a tu correo
                           ->subject($asunto)
                           ->from(config('mail.from.address'), config('mail.from.name'));
                }
            );

            Log::info("✅ Email de eliminación enviado a {$jurado->email}");
            return true;
        } catch (\Exception $e) {
            Log::error("❌ ERROR ENVIANDO EMAIL DE ELIMINACIÓN");
            Log::error("Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Enviar notificación cuando se actualiza la asignación de jurados
     */
    public function notificarActualizacionJurados($idEvento, $datosEvento)
    {
        try {
            Log::info("=== INICIANDO notificarActualizacionJurados ===");

            $asunto = "Actualización de jurados en evento: " . $datosEvento['nombre'];
            $datos = [
                'nombreEvento' => $datosEvento['nombre'],
                'fechaEvento' => $datosEvento['fecha'] ?? 'Próximamente',
                'juradosNuevos' => $datosEvento['jurados_nuevos'] ?? [],
                'juradosEliminados' => $datosEvento['jurados_eliminados'] ?? []
            ];

            Mail::raw(
                $this->generarMensajeActualizacion($datos),
                function ($message) use ($asunto) {
                    $message->to('diego469quiroga@gmail.com')
                           ->subject($asunto)
                           ->from(config('mail.from.address'), config('mail.from.name'));
                }
            );

            Log::info("✅ Email de actualización enviado a diego469quiroga@gmail.com");
            return true;
        } catch (\Exception $e) {
            Log::error("❌ ERROR ENVIANDO EMAIL DE ACTUALIZACIÓN");
            Log::error("Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Generar el mensaje para asignación de jurado
     */
    private function generarMensajeAsignacion($datos)
    {
        return "
Hola {$datos['nombreJurado']},

Te informamos que has sido asignado como jurado en el evento:

📅 Evento: {$datos['nombreEvento']}
🗓️ Fecha: {$datos['fechaEvento']}
📁 Proyectos asignados: {$datos['cantidadProyectos']}

Por favor, ingresa al sistema para revisar los detalles de los proyectos que te han sido asignados.

Gracias por tu colaboración como jurado.

Atentamente,
El equipo de " . config('app.name') . "
        ";
    }

    /**
     * Generar el mensaje para eliminación de jurado
     */
    private function generarMensajeEliminacion($datos)
    {
        return "
Hola {$datos['nombreJurado']},

Te informamos que has sido removido como jurado del evento:

📅 Evento: {$datos['nombreEvento']}
🗓️ Fecha: {$datos['fechaEvento']}
📝 Motivo: {$datos['motivo']}

Agradecemos tu tiempo y disposición para colaborar. Si tienes alguna pregunta, no dudes en contactarnos.

Atentamente,
El equipo de " . config('app.name') . "
        ";
    }

    /**
     * Generar el mensaje para actualización de jurados
     */
    private function generarMensajeActualizacion($datos)
    {
        $mensaje = "
Se ha realizado una actualización en los jurados del evento:

📅 Evento: {$datos['nombreEvento']}
🗓️ Fecha: {$datos['fechaEvento']}
";

        if (!empty($datos['juradosNuevos'])) {
            $mensaje .= "\n✅ Jurados agregados:\n";
            foreach ($datos['juradosNuevos'] as $jurado) {
                $mensaje .= "- {$jurado}\n";
            }
        }

        if (!empty($datos['juradosEliminados'])) {
            $mensaje .= "\n❌ Jurados removidos:\n";
            foreach ($datos['juradosEliminados'] as $jurado) {
                $mensaje .= "- {$jurado}\n";
            }
        }

        $mensaje .= "\nPor favor, revisa el sistema para ver los detalles actualizados.

Atentamente,
El equipo de " . config('app.name');

        return $mensaje;
    }

    /**
     * Enviar notificación cuando un estudiante solicita unirse a un equipo
     */
    public function notificarSolicitudEquipo($idLider, $datosSolicitud)
    {
        try {
            Log::info("=== INICIANDO notificarSolicitudEquipo ===");
            Log::info("ID Líder: " . $idLider);

            $lider = User::find($idLider);

            if (!$lider || !$lider->email) {
                Log::error("❌ Líder {$idLider} no encontrado o sin email");
                return false;
            }

            Log::info("Líder encontrado: " . $lider->nombre);

            $asunto = "Nuevo estudiante solicita unirse a tu equipo";
            $datos = [
                'nombreLider' => $lider->nombre,
                'nombreEstudiante' => $datosSolicitud['nombre_estudiante'],
                'nombreEquipo' => $datosSolicitud['nombre_equipo'],
                'nombreEvento' => $datosSolicitud['nombre_evento']
            ];

            Mail::raw(
                $this->generarMensajeSolicitudEquipo($datos),
                function ($message) use ($lider, $asunto) {
                    $message->to($lider->email)
                           ->cc('diego469quiroga@gmail.com') // Enviar copia a tu correo
                           ->subject($asunto)
                           ->from(config('mail.from.address'), config('mail.from.name'));
                }
            );

            Log::info("✅ Email de solicitud enviado a {$lider->email}");
            return true;
        } catch (\Exception $e) {
            Log::error("❌ ERROR ENVIANDO EMAIL DE SOLICITUD");
            Log::error("Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Generar el mensaje para solicitud de equipo
     */
    private function generarMensajeSolicitudEquipo($datos)
    {
        return "
Hola {$datos['nombreLider']},

Buenas noticias. Un estudiante ha solicitado unirse a tu equipo:

👤 Estudiante: {$datos['nombreEstudiante']}
🏆 Equipo: {$datos['nombreEquipo']}
📅 Evento: {$datos['nombreEvento']}

Por favor, ingresa al sistema para revisar y aceptar o rechazar esta solicitud.

Atentamente,
El equipo de " . config('app.name') . "
        ";
    }

    /**
     * Enviar notificación cuando se asigna un proyecto a un equipo
     */
    public function notificarProyectoAsignado($idLider, $datosProyecto)
    {
        try {
            Log::info("=== INICIANDO notificarProyectoAsignado ===");
            Log::info("ID Líder: " . $idLider);

            $lider = User::find($idLider);

            if (!$lider || !$lider->email) {
                Log::error("❌ Líder {$idLider} no encontrado o sin email");
                return false;
            }

            Log::info("Líder encontrado: " . $lider->nombre);

            $asunto = "¡Tu equipo tiene un nuevo proyecto asignado!";
            $datos = [
                'nombreLider' => $lider->nombre,
                'nombreEquipo' => $datosProyecto['nombre_equipo'],
                'nombreEvento' => $datosProyecto['nombre_evento'],
                'nombreProyecto' => $datosProyecto['nombre_proyecto'],
                'descripcion' => $datosProyecto['descripcion'] ?? 'Sin descripción',
                'objetivo' => $datosProyecto['objetivo'] ?? 'Sin objetivo específico'
            ];

            Mail::raw(
                $this->generarMensajeProyectoAsignado($datos),
                function ($message) use ($lider, $asunto) {
                    $message->to($lider->email)
                           ->cc('diego469quiroga@gmail.com') // Enviar copia a tu correo
                           ->subject($asunto)
                           ->from(config('mail.from.address'), config('mail.from.name'));
                }
            );

            Log::info("✅ Email de proyecto asignado enviado a {$lider->email}");
            return true;
        } catch (\Exception $e) {
            Log::error("❌ ERROR ENVIANDO EMAIL DE PROYECTO ASIGNADO");
            Log::error("Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Generar el mensaje para proyecto asignado
     */
    private function generarMensajeProyectoAsignado($datos)
    {
        return "
¡Hola {$datos['nombreLider']}!

¡Excelentes noticias! Tu equipo ha recibido un proyecto oficial para el evento.

📋 Evento: {$datos['nombreEvento']}
🏆 Equipo: {$datos['nombreEquipo']}
📄 Proyecto: {$datos['nombreProyecto']}

📝 Objetivo:
{$datos['objetivo']}

📖 Descripción:
{$datos['descripcion']}

Es hora de comenzar a trabajar. Revisa los requisitos y recursos disponibles en el sistema.

¡Mucho éxito en tu proyecto!

Atentamente,
El equipo de " . config('app.name') . "
        ";
    }

    /**
     * Enviar notificación cuando un líder rechaza una solicitud
     */
    public function notificarSolicitudRechazada($idEstudiante, $datosRechazo)
    {
        try {
            Log::info("=== INICIANDO notificarSolicitudRechazada ===");
            Log::info("ID Estudiante: " . $idEstudiante);

            $estudiante = User::find($idEstudiante);

            if (!$estudiante || !$estudiante->email) {
                Log::error("❌ Estudiante {$idEstudiante} no encontrado o sin email");
                return false;
            }

            Log::info("Estudiante encontrado: " . $estudiante->nombre);

            $asunto = "Tu solicitud para unirte a un equipo ha sido revisada";
            $datos = [
                'nombreEstudiante' => $estudiante->nombre,
                'nombreEquipo' => $datosRechazo['nombre_equipo'],
                'nombreEvento' => $datosRechazo['nombre_evento'],
                'nombreLider' => $datosRechazo['nombre_lider']
            ];

            Mail::raw(
                $this->generarMensajeRechazo($datos),
                function ($message) use ($estudiante, $asunto) {
                    $message->to($estudiante->email)
                           ->cc('diego469quiroga@gmail.com') // Enviar copia a tu correo
                           ->subject($asunto)
                           ->from(config('mail.from.address'), config('mail.from.name'));
                }
            );

            Log::info("✅ Email de rechazo enviado a {$estudiante->email}");
            return true;
        } catch (\Exception $e) {
            Log::error("❌ ERROR ENVIANDO EMAIL DE RECHAZO");
            Log::error("Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Generar el mensaje para solicitud rechazada
     */
    private function generarMensajeRechazo($datos)
    {
        return "
Hola {$datos['nombreEstudiante']},

Lamentamos informarte que tu solicitud para unirte al equipo ha sido rechazada.

🏆 Equipo: {$datos['nombreEquipo']}
📅 Evento: {$datos['nombreEvento']}
👤 Revisado por: {$datos['nombreLider']} (Líder del equipo)

No te desanimes. Hay muchos otros equipos disponibles donde podrías encontrar un lugar.

¡Sigue intentando y mucho éxito en tu búsqueda!

Atentamente,
El equipo de " . config('app.name') . "
        ";
    }
}