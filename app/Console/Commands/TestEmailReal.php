<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestEmailReal extends Command
{
    protected $signature = 'email:test-real';
    protected $description = 'Probar envío de email a una cuenta real';

    public function handle()
    {
        $email = 'diego469quiroga@gmail.com';
        $this->info("Enviando email de prueba a: {$email}");

        try {
            Mail::raw(
                "Este es un email de prueba del sistema escolar.\n\nFecha: " . now()->format('d/m/Y H:i:s'),
                function ($message) use ($email) {
                    $message->to($email)
                           ->subject('Email de Prueba - Sistema Escolar')
                           ->from(config('mail.from.address'), config('mail.from.name'));
                }
            );

            $this->info('Email enviado exitosamente a ' . $email);
        } catch (\Exception $e) {
            $this->error('Error al enviar email: ' . $e->getMessage());
            $this->error('Archivo: ' . $e->getFile());
            $this->error('Línea: ' . $e->getLine());
        }
    }
}