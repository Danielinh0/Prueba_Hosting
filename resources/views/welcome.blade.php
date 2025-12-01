<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Figtree', sans-serif;
            overflow: hidden;
        }

        .welcome-container {
            position: relative;
            width: 100vw;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-image: url('/images/tecnm.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .background-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }

        .welcome-panel {
            position: relative;
            z-index: 2;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 3rem 2.5rem;
            max-width: 550px;
            width: 90%;
            text-align: center;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.2);
            animation: panelFadeIn 1s ease-out;
        }

        .logo {
            width: 120px;
            height: auto;
            margin: 0 auto 2rem;
            animation: logoSlideDown 0.8s ease-out;
        }

        .welcome-title {
            font-size: 3rem;
            font-weight: 700;
            color: white;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5);
            margin-bottom: 0.5rem;
            animation: titleScale 1s ease-out 0.3s backwards;
        }

        .welcome-subtitle {
            font-size: 1.2rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 2.5rem;
            text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.5);
            animation: subtitleFade 1s ease-out 0.5s backwards;
        }

        .button-group {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            animation: buttonsSlideUp 1.2s ease-out 0.6s backwards;
        }

        .btn {
            padding: 1rem 2rem;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 12px;
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
            border: 2px solid transparent;
            display: inline-block;
        }

        .btn-primary {
            background: #FF6B1A;
            color: white;
            box-shadow: 0 4px 15px rgba(255, 107, 26, 0.4);
        }

        .btn-primary:hover {
            background: #E55A0F;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 107, 26, 0.6);
        }

        .btn-secondary {
            background: transparent;
            color: white;
            border: 2px solid white;
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(255, 255, 255, 0.3);
        }

        .recovery-link {
            margin-top: 1.5rem;
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .recovery-link:hover {
            color: white;
            text-decoration: underline;
        }

        /* Animations */
        @keyframes panelFadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes logoSlideDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes titleScale {
            from {
                opacity: 0;
                transform: scale(0.8);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes subtitleFade {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes buttonsSlideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .welcome-panel {
                padding: 2rem 1.5rem;
                max-width: 90%;
            }

            .logo {
                width: 100px;
                margin-bottom: 1.5rem;
            }

            .welcome-title {
                font-size: 2.2rem;
            }

            .welcome-subtitle {
                font-size: 1rem;
                margin-bottom: 2rem;
            }

            .btn {
                padding: 0.9rem 1.5rem;
                font-size: 1rem;
            }
        }

        @media (max-width: 480px) {
            .welcome-panel {
                padding: 1.5rem 1rem;
            }

            .logo {
                width: 80px;
            }

            .welcome-title {
                font-size: 1.8rem;
            }

            .welcome-subtitle {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <div class="welcome-container">
        <div class="background-overlay"></div>
        
        <div class="welcome-panel">
            <!-- Logo -->
            <img src="/images/logito.png" alt="Logo Instituto" class="logo">
            
            <!-- el mensaje de bienvenida -->
            <h1 class="welcome-title">BIENVENIDO</h1>
            <p class="welcome-subtitle">Instituto Tecnológico de Oaxaca</p>
            
            <!-- los botones de inicio de sesión y registro -->
            <div class="button-group">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-primary">
                            Ir al Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary">
                            Iniciar Sesión
                        </a>
                        
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-secondary">
                                Registrarse
                            </a>
                        @endif
                    @endauth
                @endif
            </div>

            <!-- enlace de recuperacion de contraseña -->
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="recovery-link">
                    ¿Olvidaste tu contraseña?
                </a>
            @endif
        </div>
    </div>
</body>
</html>
