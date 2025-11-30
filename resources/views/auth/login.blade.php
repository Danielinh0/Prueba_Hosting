<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Instituto Tecnológico de Oaxaca</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        /* RESET BÁSICO */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            height: 100vh;
            width: 100%;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #333;
        }

        /* FONDO E IMAGEN */
        .bg-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background-image: url('{{ asset('images/imgFondo.jpg') }}');
            background-size: cover;
            background-position: center;
        }

        /* CAPA OSCURA DIAGONAL */
        .overlay-diagonal {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(105deg, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0.85) 25%, transparent 25.1%);
            pointer-events: none;
        }

        /* TARJETA DE LOGIN */
        .login-card {
            position: absolute;
            right: 10%;
            width: 400px;
            padding: 40px 30px;
            text-align: center;
            border-radius: 20px;
            background: linear-gradient(to bottom, rgba(203, 159, 130, 0.73), rgba(60, 30, 10, 0.9));
            backdrop-filter: blur(5px);
            box-shadow: 0 15px 25px rgba(0,0,0,0.5);
            color: white;
        }

        /* LOGO */
        .logo img {
            width: 150px;
            margin-bottom: 10px;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.5));
        }

        h2 {
            font-size: 2rem;
            margin-bottom: 20px;
            font-weight: 800;
            letter-spacing: 1px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.5);
        }

        /* INPUTS */
        .input-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .input-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            font-size: 0.9rem;
            margin-left: 5px;
        }

        .input-group input {
            width: 90%;
            padding: 12px 15px;
            background: transparent;
            border: 2px solid white;
            border-radius: 10px;
            color: white;
            font-size: 1rem;
            outline: none;
            transition: 0.3s;
        }

        .input-group input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .input-group input:focus {
            background: rgba(255,255,255,0.1);
            box-shadow: 0 0 10px rgba(255,255,255,0.2);
        }

        /* BOTÓN INGRESAR */
        .btn-ingresar {
            width: 80%;
            padding: 12px;
            border: none;
            border-radius: 12px;
            background-color: #d35400;
            color: white;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.3);
            transition: background 0.3s;
        }

        .btn-ingresar:hover {
            background-color: #e67e22;
        }

        /* ENLACES FOOTER */
        .footer-links a {
            display: block;
            color: #ddd;
            text-decoration: none;
            font-size: 0.85rem;
            margin-bottom: 8px;
            text-decoration: underline;
        }

        .footer-links a:hover {
            color: white;
        }

        /* BOTONES SOCIALES */
        .social-buttons {
            position: absolute;
            bottom: 30px;
            left: 50px;
            display: flex;
            gap: 15px;
            z-index: 10;
        }

        .social-btn {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0,0,0,0.4);
            transition: transform 0.2s;
        }

        .social-btn.fb { background-color: #e67e22; }
        .social-btn.go { background-color: #d35400; }

        .social-btn:hover {
            transform: scale(1.1);
        }

        /* MENSAJES DE ERROR */
        .error-message {
            color: #ffcccb;
            font-size: 0.9rem;
            margin-bottom: 10px;
            text-align: center;
        }

        .input-error {
            color: #ffcccb;
            font-size: 0.8rem;
            margin-top: 5px;
            margin-left: 5px;
        }

        @media (max-width: 768px) {
            .overlay-diagonal {
                background: rgba(0,0,0,0.6);
            }
            .login-card {
                right: auto;
                width: 90%;
            }
            .social-buttons {
                display: none;
            }
        }
    </style>
</head>
<body>

    <div class="bg-container"></div>
    <div class="overlay-diagonal"></div>

    <!-- Session Status -->
    @if (session('status'))
        <div style="display: none;">
            <x-auth-session-status :status="session('status')" />
        </div>
    @endif

    <div class="social-buttons">
        <div class="social-btn fb"><i class="fab fa-facebook-f"></i></div>
        <div class="social-btn go"><i class="fab fa-google"></i></div>
    </div>

    <div class="login-card">
        <div class="logo">
            <img src="{{ asset('images/logito.png') }}" alt="Logo ITO">
        </div>

        <h2>BIENVENIDO</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="input-group">
                <label for="email">Usuario</label>
                <input 
                    id="email" 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    placeholder="Correo electrónico" 
                    required 
                    autofocus 
                    autocomplete="username"
                >
                @error('email')
                    <div class="input-error">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="input-group">
                <label for="password">Contraseña</label>
                <input 
                    id="password" 
                    type="password" 
                    name="password" 
                    placeholder="Ingresa tu contraseña" 
                    required 
                    autocomplete="current-password"
                >
                @error('password')
                    <div class="input-error">{{ $message }}</div>
                @enderror
            </div>

            <!-- Mostrar errores generales -->
            @if ($errors->any())
                <div class="error-message">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <button type="submit" class="btn-ingresar">Ingresar</button>
        </form>

        <div class="footer-links">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">
                    {{ __('¿Olvidaste tu contraseña?') }}
                </a>
            @endif
            
            @if (Route::has('register'))
                <a href="{{ route('register') }}">
                    {{ __('Registrarse') }}
                </a>
            @endif
        </div>
    </div>

</body>
</html>