<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Instituto Tecnológico de Oaxaca</title>
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
            animation: backgroundZoom 20s ease-in-out infinite alternate;
        }

        @keyframes backgroundZoom {
            0% {
                transform: scale(1);
            }
            100% {
                transform: scale(1.1);
            }
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

        /* TARJETA DE REGISTRO */
        .register-card {
            position: relative;
            width: 500px;
            max-height: 90vh;
            overflow-y: auto;
            padding: 30px 25px;
            text-align: center;
            border-radius: 20px;
            background: linear-gradient(to bottom, rgba(203, 159, 130, 0.73), rgba(60, 30, 10, 0.9));
            backdrop-filter: blur(5px);
            box-shadow: 0 15px 25px rgba(0,0,0,0.5);
            color: white;
            animation: cardFadeIn 1s ease-out;
        }

        @keyframes cardFadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* LOGO */
        .logo img {
            width: 100px;
            margin-bottom: 10px;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.5));
            animation: logoBounce 1.2s ease-out 0.3s backwards;
        }

        @keyframes logoBounce {
            0% {
                opacity: 0;
                transform: translateY(-50px) scale(0.5);
            }
            60% {
                transform: translateY(10px) scale(1.05);
            }
            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        h2 {
            font-size: 1.8rem;
            margin-bottom: 15px;
            font-weight: 800;
            letter-spacing: 1px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.5);
            animation: titleFadeIn 1s ease-out 0.5s backwards;
        }

        @keyframes titleFadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* SELECTOR DE ROL */
        .role-selector {
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            border-radius: 10px;
            padding: 4px;
            margin-bottom: 20px;
            animation: inputSlideUp 0.8s ease-out 0.7s backwards;
        }

        @keyframes inputSlideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .role-option {
            flex: 1;
            padding: 10px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .role-option.active {
            background: white;
            color: #d35400;
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
        }

        .role-option:not(.active) {
            color: rgba(255, 255, 255, 0.7);
        }

        /* INPUTS */
        .input-group {
            margin-bottom: 15px;
            text-align: left;
        }

        .input-row {
            display: flex;
            gap: 10px;
        }

        .input-row .input-group {
            flex: 1;
        }

        .input-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            font-size: 0.85rem;
            margin-left: 5px;
        }

        .input-group input,
        .input-group select {
            width: 100%;
            padding: 10px 12px;
            background: transparent;
            border: 2px solid white;
            border-radius: 10px;
            color: white;
            font-size: 0.95rem;
            outline: none;
            transition: 0.3s;
        }

        .input-group select {
            cursor: pointer;
        }

        .input-group select option {
            background: #5a3a2a;
            color: white;
        }

        .input-group input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .input-group input:focus,
        .input-group select:focus {
            background: rgba(255,255,255,0.1);
            box-shadow: 0 0 10px rgba(255,255,255,0.2);
        }

        /* SECCIÓN ESPECÍFICA */
        .specific-section {
            border-top: 2px solid rgba(255, 255, 255, 0.3);
            padding-top: 15px;
            margin-top: 15px;
        }

        .specific-section h3 {
            font-size: 0.9rem;
            text-transform: uppercase;
            margin-bottom: 15px;
            letter-spacing: 1px;
        }

        /* ALERT */
        .alert-box {
            background: rgba(255, 193, 7, 0.2);
            border-left: 4px solid #ffc107;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 15px;
            text-align: left;
        }

        .alert-box p {
            font-size: 0.85rem;
            color: #fff3cd;
        }

        /* BOTÓN REGISTRARSE */
        .btn-register {
            width: 80%;
            padding: 12px;
            border: none;
            border-radius: 12px;
            background-color: #d35400;
            color: white;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            margin-top: 15px;
            margin-bottom: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.3);
            transition: background 0.3s, transform 0.2s;
            animation: buttonPulse 1s ease-out 1s backwards;
        }

        @keyframes buttonPulse {
            0% {
                opacity: 0;
                transform: scale(0.8);
            }
            70% {
                transform: scale(1.05);
            }
            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        .btn-register:hover {
            background-color: #e67e22;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.4);
        }

        /* ENLACES FOOTER */
        .footer-links {
            animation: footerFade 1s ease-out 1.2s backwards;
        }

        .footer-links a {
            color: #ddd;
            text-decoration: underline;
            font-size: 0.85rem;
            transition: color 0.3s, transform 0.2s;
        }

        @keyframes footerFade {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .footer-links a:hover {
            color: white;
            transform: translateX(5px);
        }

        /* MENSAJES DE ERROR */
        .input-error {
            color: #ffcccb;
            font-size: 0.75rem;
            margin-top: 5px;
            margin-left: 5px;
        }

        /* SCROLLBAR PERSONALIZADO */
        .register-card::-webkit-scrollbar {
            width: 8px;
        }

        .register-card::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }

        .register-card::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 10px;
        }

        .register-card::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
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

        .social-buttons .social-btn:nth-child(1) {
            animation: socialPop 0.6s ease-out 1.4s backwards;
        }

        .social-buttons .social-btn:nth-child(2) {
            animation: socialPop 0.6s ease-out 1.6s backwards;
        }

        @keyframes socialPop {
            0% {
                opacity: 0;
                transform: scale(0) rotate(-180deg);
            }
            70% {
                transform: scale(1.2) rotate(10deg);
            }
            100% {
                opacity: 1;
                transform: scale(1) rotate(0deg);
            }
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

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .overlay-diagonal {
                background: rgba(0,0,0,0.6);
            }
            .register-card {
                width: 95%;
                max-height: 85vh;
                padding: 20px 15px;
            }
            .social-buttons {
                display: none;
            }
            h2 {
                font-size: 1.5rem;
            }
            .logo img {
                width: 80px;
            }
        }
    </style>

    <!-- Alpine.js para interactividad -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body>

    <div class="bg-container"></div>
    <div class="overlay-diagonal"></div>

    <!-- Botones sociales -->
    <div class="social-buttons">
        <div class="social-btn fb"><i class="fab fa-facebook-f"></i></div>
        <div class="social-btn go"><i class="fab fa-google"></i></div>
    </div>

    <div class="register-card" x-data="{ role: 'estudiante' }">
        <div class="logo">
            <img src="{{ asset('images/logito.png') }}" alt="Logo ITO">
        </div>

        <h2>REGISTRO</h2>

        <!-- Selector de Rol -->
        <div class="role-selector">
            <div class="role-option" :class="{ 'active': role === 'estudiante' }" @click="role = 'estudiante'">
                Estudiante
            </div>
            <div class="role-option" :class="{ 'active': role === 'jurado' }" @click="role = 'jurado'">
                Jurado
            </div>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Campo hidden para el tipo de registro -->
            <input type="hidden" name="tipo_registro" :value="role">

            <!-- Nombre -->
            <div class="input-group">
                <label for="nombre">Nombre(s)</label>
                <input 
                    id="nombre" 
                    type="text" 
                    name="nombre" 
                    value="{{ old('nombre') }}" 
                    placeholder="Ingresa tu nombre" 
                    required 
                    autofocus
                >
                @error('nombre')
                    <div class="input-error">{{ $message }}</div>
                @enderror
            </div>

            <!-- Apellidos -->
            <div class="input-row">
                <div class="input-group">
                    <label for="app_paterno">Apellido Paterno</label>
                    <input 
                        id="app_paterno" 
                        type="text" 
                        name="app_paterno" 
                        value="{{ old('app_paterno') }}" 
                        placeholder="Paterno" 
                        required
                    >
                    @error('app_paterno')
                        <div class="input-error">{{ $message }}</div>
                    @enderror
                </div>
                <div class="input-group">
                    <label for="app_materno">Apellido Materno</label>
                    <input 
                        id="app_materno" 
                        type="text" 
                        name="app_materno" 
                        value="{{ old('app_materno') }}" 
                        placeholder="Materno"
                    >
                </div>
            </div>

            <!-- Email -->
            <div class="input-group">
                <label for="email">Correo Electrónico</label>
                <input 
                    id="email" 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    placeholder="correo@ejemplo.com" 
                    required
                >
                @error('email')
                    <div class="input-error">{{ $message }}</div>
                @enderror
            </div>

            <!-- Sección de Estudiante -->
            <div x-show="role === 'estudiante'" x-transition class="specific-section">
                <h3>Datos Escolares</h3>
                
                <div class="input-group">
                    <label for="numero_control">Número de Control</label>
                    <input 
                        id="numero_control" 
                        type="text" 
                        name="numero_control" 
                        value="{{ old('numero_control') }}" 
                        placeholder="Ej. 20200123"
                    >
                    @error('numero_control')
                        <div class="input-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="input-row">
                    <div class="input-group">
                        <label for="semestre">Semestre</label>
                        <select name="semestre" id="semestre">
                            @for ($i = 1; $i <= 14; $i++)
                                <option value="{{ $i }}">{{ $i }}°</option>
                            @endfor
                        </select>
                        @error('semestre')
                            <div class="input-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="input-group" style="flex: 2">
                        <label for="id_carrera">Carrera</label>
                        <select name="id_carrera" id="id_carrera">
                            <option value="" disabled selected>Selecciona...</option>
                            @foreach($carreras as $carrera)
                                <option value="{{ $carrera->id_carrera }}">{{ $carrera->nombre }}</option>
                            @endforeach
                        </select>
                        @error('id_carrera')
                            <div class="input-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Sección de Jurado -->
            <div x-show="role === 'jurado'" x-transition class="specific-section" style="display: none;">
                <h3>Acceso de Jurado</h3>
                
                <div class="alert-box">
                    <p>Ingrese el código de invitación proporcionado por la administración del evento.</p>
                </div>

                <div class="input-group">
                    <label for="token_acceso">Código de Invitación</label>
                    <input 
                        id="token_acceso" 
                        type="text" 
                        name="token_acceso" 
                        value="{{ old('token_acceso') }}" 
                        placeholder="XXXX-XXXX"
                        style="font-family: monospace; letter-spacing: 2px; text-transform: uppercase;"
                    >
                    @error('token_acceso')
                        <div class="input-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="input-group">
                    <label for="especialidad">Especialidad Técnica</label>
                    <input 
                        id="especialidad" 
                        type="text" 
                        name="especialidad" 
                        value="{{ old('especialidad') }}" 
                        placeholder="Ej. Inteligencia Artificial"
                    >
                    @error('especialidad')
                        <div class="input-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="input-group">
                    <label for="empresa_institucion">Empresa o Institución</label>
                    <input 
                        id="empresa_institucion" 
                        type="text" 
                        name="empresa_institucion" 
                        value="{{ old('empresa_institucion') }}" 
                        placeholder="Nombre de la empresa"
                    >
                </div>
            </div>

            <!-- Contraseñas -->
            <div class="specific-section">
                <div class="input-group">
                    <label for="password">Contraseña</label>
                    <input 
                        id="password" 
                        type="password" 
                        name="password" 
                        placeholder="Mínimo 8 caracteres" 
                        required 
                        autocomplete="new-password"
                    >
                    @error('password')
                        <div class="input-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="input-group">
                    <label for="password_confirmation">Confirmar Contraseña</label>
                    <input 
                        id="password_confirmation" 
                        type="password" 
                        name="password_confirmation" 
                        placeholder="Repite la contraseña" 
                        required 
                        autocomplete="new-password"
                    >
                    @error('password_confirmation')
                        <div class="input-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <button type="submit" class="btn-register">Registrarse</button>
        </form>

        <div class="footer-links">
            <a href="{{ route('login') }}">
                ¿Ya tienes cuenta? Inicia sesión
            </a>
        </div>
    </div>

</body>
</html>