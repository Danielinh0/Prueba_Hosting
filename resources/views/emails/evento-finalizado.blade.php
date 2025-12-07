<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evento Finalizado</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: linear-gradient(135deg, #FFEEE2, #FFFDF4);
            padding: 40px 30px;
            text-align: center;
        }

        .trophy-icon {
            font-size: 60px;
            margin-bottom: 20px;
        }

        .header h1 {
            color: #2c2c2c;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .header p {
            color: #6b7280;
            font-size: 16px;
        }

        .content {
            padding: 40px 30px;
        }

        .congratulations {
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(139, 92, 246, 0.1));
            border: 2px solid rgba(99, 102, 241, 0.2);
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            margin-bottom: 30px;
        }

        .position-display {
            font-size: 36px;
            font-weight: 800;
            color: #e89a3c;
            margin: 20px 0;
        }

        .team-name {
            font-size: 24px;
            font-weight: 600;
            color: #2c2c2c;
            margin-bottom: 10px;
        }

        .info-section {
            margin: 30px 0;
        }

        .info-section h3 {
            color: #2c2c2c;
            font-size: 20px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin: 20px 0;
        }

        .info-item {
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 12px;
        }

        .info-item strong {
            display: block;
            color: #6b7280;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .info-item span {
            color: #2c2c2c;
            font-size: 16px;
            font-weight: 600;
        }

        .message {
            background-color: #f0f9ff;
            border-left: 4px solid #3b82f6;
            padding: 20px;
            margin: 30px 0;
            border-radius: 8px;
        }

        .message p {
            color: #1e40af;
            font-size: 16px;
            line-height: 1.6;
        }

        .footer {
            background: linear-gradient(135deg, #FFEEE2, #FFFDF4);
            padding: 30px;
            text-align: center;
        }

        .footer p {
            color: #6b7280;
            font-size: 14px;
        }

        .footer a {
            color: #3b82f6;
            text-decoration: none;
        }

        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #e89a3c, #f5a847);
            color: white;
            padding: 15px 30px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            margin-top: 20px;
            box-shadow: 0 4px 8px rgba(232, 154, 60, 0.3);
            transition: all 0.3s ease;
        }

        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(232, 154, 60, 0.4);
        }

        @media (max-width: 600px) {
            .info-grid {
                grid-template-columns: 1fr;
            }

            .email-container {
                border-radius: 0;
            }

            body {
                padding: 0;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <div class="trophy-icon">🏆</div>
            <h1>¡Evento Finalizado!</h1>
            <p>Gracias por participar en el evento</p>
        </div>

        <div class="content">
            <div class="congratulations">
                <h2>¡Felicidades!</h2>
                <p>Tu equipo ha quedado en:</p>
                <div class="position-display">
                    {{ $posicionTexto }}
                </div>
                <div class="team-name">
                    {{ $nombreEquipo }}
                </div>
            </div>

            <div class="info-section">
                <h3>📋 Detalles del Evento</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <strong>Evento</strong>
                        <span>{{ $evento->nombre }}</span>
                    </div>
                    <div class="info-item">
                        <strong>Fecha de Finalización</strong>
                        <span>{{ $evento->fecha_fin->format('d/m/Y') }}</span>
                    </div>
                </div>
            </div>

            <div class="message">
                <p>
                    Estimado(a) {{ $user->nombre }},<br><br>
                    ¡Gracias por tu dedicación y esfuerzo en el evento "{{ $evento->nombre }}"!
                    Tu participación ha sido valiosa y esperamos que hayas disfrutado esta experiencia.<br><br>
                    Puedes ver los resultados completos y las posiciones de todos los equipos
                    iniciando sesión en la plataforma.
                </p>
            </div>

            <div style="text-align: center;">
                <a href="{{ route('estudiante.eventos.posiciones', $evento) }}" class="cta-button">
                    Ver Posiciones Completas
                </a>
            </div>
        </div>

        <div class="footer">
            <p>
                Este correo se ha enviado automáticamente desde el Sistema Escolar.<br>
                Si no participaste en este evento, por favor ignora este mensaje.
            </p>
            <p>
                <a href="{{ config('app.url') }}">{{ config('app.name') }}</a>
            </p>
        </div>
    </div>
</body>
</html>