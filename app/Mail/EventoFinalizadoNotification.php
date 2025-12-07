<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EventoFinalizadoNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * El usuario que recibirá el correo
     *
     * @var \App\Models\User
     */
    public $user;

    /**
     * El evento que ha finalizado
     *
     * @var \App\Models\Evento
     */
    public $evento;

    /**
     * El nombre del equipo
     *
     * @var string
     */
    public $nombreEquipo;

    /**
     * La posición obtenida
     *
     * @var int
     */
    public $posicion;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $evento, $nombreEquipo, $posicion)
    {
        $this->user = $user;
        $this->evento = $evento;
        $this->nombreEquipo = $nombreEquipo;
        $this->posicion = $posicion;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🏆 ¡El evento "' . $this->evento->nombre . '" ha finalizado!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.evento-finalizado',
            with: [
                'user' => $this->user,
                'evento' => $this->evento,
                'nombreEquipo' => $this->nombreEquipo,
                'posicion' => $this->posicion,
                'posicionTexto' => $this->getPosicionTexto($this->posicion),
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }

    /**
     * Obtener el texto formateado de la posición
     */
    private function getPosicionTexto($posicion): string
    {
        switch ($posicion) {
            case 1:
                return '🥇 1er Lugar';
            case 2:
                return '🥈 2do Lugar';
            case 3:
                return '🥉 3er Lugar';
            default:
                return $posicion . '° Lugar';
        }
    }
}
