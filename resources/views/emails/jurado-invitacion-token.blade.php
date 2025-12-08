<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invitación a ser Jurado</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }

        .header p {
            font-size: 16px;
            opacity: 0.9;
        }

        .content {
            padding: 40px 30px;
        }

        .saludo {
            font-size: 20px;
            margin-bottom: 20px;
            color: #444;
        }

        .mensaje {
            margin-bottom: 30px;
            font-size: 16px;
        }

        .token-box {
            background-color: #f8f9fa;
            border: 2px dashed #6c63ff;
            border-radius: 10px;
            padding: 25px;
            margin: 30px 0;
            text-align: center;
        }

        .token-label {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .token-code {
            font-size: 24px;
            font-weight: bold;
            color: #6c63ff;
            letter-spacing: 3px;
            font-family: 'Courier New', monospace;
            background: white;
            padding: 15px;
            border-radius: 5px;
            display: inline-block;
            margin: 10px 0;
        }

        .vigencia {
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }

        .vigencia strong {
            color: #e74c3c;
        }

        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 40px;
            text-decoration: none;
            border-radius: 50px;
            font-weight: bold;
            font-size: 16px;
            margin: 30px 0;
            transition: transform 0.2s;
        }

        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .info-box {
            background-color: #e8f4f8;
            border-left: 4px solid #17a2b8;
            padding: 20px;
            margin: 30px 0;
            border-radius: 5px;
        }

        .info-box h4 {
            color: #17a2b8;
            margin-bottom: 10px;
        }

        .info-box ul {
            margin-left: 20px;
        }

        .info-box li {
            margin-bottom: 8px;
        }

        .footer {
            background-color: #2c3e50;
            color: white;
            padding: 30px;
            text-align: center;
        }

        .footer p {
            margin-bottom: 10px;
            opacity: 0.8;
        }

        .footer .contact {
            font-size: 14px;
            color: #bdc3c7;
        }

        .highlight {
            background-color: #fff3cd;
            padding: 15px;
            border-left: 4px solid #ffc107;
            margin: 20px 0;
            border-radius: 5px;
        }

        .empresa-badge {
            display: inline-block;
            background-color: #6c757d;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 14px;
            margin-top: 10px;
        }

        @media (max-width: 600px) {
            .container {
                margin: 10px;
            }

            .header, .content, .footer {
                padding: 20px;
            }

            .token-code {
                font-size: 20px;
                letter-spacing: 2px;
            }

            .cta-button {
                padding: 12px 30px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>🏆 Invitación a ser Jurado</h1>
            <p>Sistema Escolar - Evaluación de Proyectos</p>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Saludo personalizado -->
            <div class="saludo">
                Estimado(a) <strong>{{ $datos['nombre_corto'] }}</strong>,
            </div>

            <!-- Mensaje principal -->
            <div class="mensaje">
                <p>
                    Nos complace enormemente invitarle a formar parte de nuestro distinguido panel de jurados en el Sistema Escolar.
                    Su valiosa experiencia y conocimientos en <strong>{{ $datos['especialidad'] }}</strong>
                    serían de inmenso beneficio para nuestros estudiantes y sus proyectos.
                </p>

                @if($datos['empresa'])
                    <p>
                        <span class="empresa-badge">
                            <i class="fas fa-building"></i> {{ $datos['empresa'] }}
                        </span>
                    </p>
                @endif

                @if($datos['mensaje'])
                    <div class="highlight">
                        <em>"{{ $datos['mensaje'] }}"</em>
                    </div>
                @endif

                <p>
                    Como jurado, tendrá la oportunidad de evaluar proyectos innovadores,
                    guiar a futuros profesionales y contribuir al desarrollo académico de nuestra comunidad.
                </p>
            </div>

            <!-- Token de registro -->
            <div class="token-box">
                <div class="token-label">
                    <i class="fas fa-key"></i> SU TOKEN DE ACCESO ÚNICO
                </div>
                <div class="token-code">{{ $datos['token'] }}</div>
                <div class="vigencia">
                    <strong>Importante:</strong> Este token tiene una vigencia de
                    <strong>{{ $datos['dias_vigencia'] }} días</strong> y expirará el
                    <strong>{{ $datos['fecha_expiracion'] }}</strong>
                </div>
            </div>

            <!-- Botón de llamada a la acción -->
            <div style="text-align: center;">
                <a href="{{ $datos['url_registro'] }}" class="cta-button">
                    <i class="fas fa-user-plus"></i> Completar Registro
                </a>
            </div>

            <!-- Información adicional -->
            @if($datos['eventos'])
                <div class="info-box">
                    <h4>📅 Eventos Sugeridos para Evaluación:</h4>
                    <p>Le invitamos especialmente a participar en:</p>
                    <ul>
                        @foreach(explode(',', $datos['eventos']) as $evento)
                            <li>{{ trim($evento) }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Pasos a seguir -->
            <div class="info-box">
                <h4>📋 Pasos para Registrarse:</h4>
                <ol>
                    <li>Haga clic en el botón "Completar Registro"</li>
                    <li>Complete el formulario con sus datos</li>
                    <li>Ingrese su token de acceso</li>
                    <li>Configure su contraseña y perfil profesional</li>
                    <li>¡Listo! Podrá comenzar a evaluar proyectos</li>
                </ol>
            </div>

            <!-- Información de contacto -->
            <p style="text-align: center; color: #666; font-size: 14px; margin-top: 30px;">
                Si tiene alguna pregunta o necesita asistencia, no dude en contactarnos.
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>Atentamente,</strong></p>
            <p>El Comité Organizador</p>
            <p>Sistema Escolar</p>
            <div class="contact">
                <p>📧 contacto@sistema-escolar.edu.mx</p>
                <p>📞 (55) 1234-5678</p>
                <p>🌐 www.sistema-escolar.edu.mx</p>
            </div>
        </div>
    </div>

    <!-- Fallback para clientes de correo que no soportan estilos -->
    <div style="display: none; max-height: 0; overflow: hidden;">
        <p>Invitación a ser Jurado - Sistema Escolar</p>
        <p>Hola {{ $datos['nombre_completo'] }},</p>
        <p>Su token de registro es: {{ $datos['token'] }}</p>
        <p>Vigencia: {{ $datos['dias_vigencia'] }} días (expira el {{ $datos['fecha_expiracion'] }})</p>
        <p>Regístrese en: {{ $datos['url_registro'] }}</p>
    </div>
</body>
</html>