<x-guest-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

        /* Reset y base */
        * {
            font-family: 'Poppins', sans-serif;
        }

        /* Fondo exterior blanco/gris claro */
        body {
            background: linear-gradient(to bottom, #f7ebddff, #efe2d9ff);
        }

        /* Contenedor de formulario neuromórfico con fondo pastel */
        .forgot-password-container {
            background: linear-gradient(135deg, #FFEEE2 0%, #FFE5D3 100%);
            border-radius: 24px;
            padding: 2.5rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            max-width: 480px;
            margin: 0 auto;
        }

        /* Texto informativo */
        .info-text {
            font-family: 'Poppins', sans-serif;
            font-size: 0.875rem;
            color: #6b7280;
            line-height: 1.6;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        /* Alert de status */
        .status-alert {
            background: linear-gradient(135deg, rgba(209, 250, 229, 0.8), rgba(167, 243, 208, 0.8));
            border-left: 4px solid #10b981;
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            font-family: 'Poppins', sans-serif;
            font-size: 0.875rem;
            color: #059669;
            box-shadow: 4px 4px 8px rgba(16, 185, 129, 0.2);
        }

        /* Form group */
        .form-group {
            margin-bottom: 1.5rem;
        }

        /* Label más oscuro */
        .form-label {
            display: block;
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 0.625rem;
        }

        /* Input neuromórfico con fondo claro */
        .form-input {
            width: 100%;
            padding: 0.875rem 1rem;
            border: none;
            border-radius: 12px;
            background: rgba(255, 253, 244, 0.8);
            color: #2c2c2c;
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
            box-shadow: inset 2px 2px 5px rgba(230, 213, 201, 0.3), inset -2px -2px 5px rgba(255, 255, 255, 0.5);
            transition: all 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.9);
            box-shadow: inset 3px 3px 6px rgba(230, 213, 201, 0.4), inset -3px -3px 6px rgba(255, 255, 255, 0.6);
        }

        .form-input::placeholder {
            color: #9ca3af;
        }

        /* Error message */
        .error-message {
            font-family: 'Poppins', sans-serif;
            font-size: 0.75rem;
            color: #dc2626;
            margin-top: 0.5rem;
        }

        /* Botón submit con estilo sólido naranja */
        .submit-button {
            width: 100%;
            padding: 1rem 1.5rem;
            border: none;
            border-radius: 14px;
            background: linear-gradient(135deg, #e89a3c, #f5a847);
            color: white;
            font-family: 'Poppins', sans-serif;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(232, 154, 60, 0.3);
            transition: all 0.3s ease;
        }

        .submit-button:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(232, 154, 60, 0.4);
            background: linear-gradient(135deg, #f5a847, #e89a3c);
        }

        .submit-button:active {
            transform: translateY(0);
        }

        /* Iconos decorativos - más suave */
        .icon-wrapper {
            width: 3.5rem;
            height: 3.5rem;
            margin: 0 auto 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.6);
            box-shadow: 0 4px 10px rgba(232, 154, 60, 0.15);
        }

        .icon-wrapper svg {
            width: 1.75rem;
            height: 1.75rem;
            color: #e89a3c;
        }

        /* Responsive */
        @media (max-width: 640px) {
            .forgot-password-container {
                padding: 1.5rem;
            }
        }
    </style>

    <div class="forgot-password-container">
        <!-- Icono decorativo -->
        <div class="icon-wrapper">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
            </svg>
        </div>

        <!-- Texto informativo -->
        <div class="info-text">
            {{ __('Olvidaste tu contraseña, ingresa tu correo institucional para reestablecer tu contraseña') }}
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="status-alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div class="form-group">
                <label for="email" class="form-label">
                    {{ __('Correo Electrónico') }}
                </label>
                <input 
                    id="email" 
                    class="form-input" 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    required 
                    autofocus 
                    placeholder="tu-correo@ejemplo.com"
                />
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" class="submit-button">
                {{ __('Enviar Enlace de Recuperación') }}
            </button>
        </form>

        <!-- Link de regreso -->
        <div style="text-align: center; margin-top: 1.5rem;">
            <a href="{{ route('login') }}" 
               style="font-family: 'Poppins', sans-serif; font-size: 0.875rem; color: #e89a3c; text-decoration: none; font-weight: 500;">
                {{ __('Volver al inicio de sesión') }}
            </a>
        </div>
    </div>
</x-guest-layout>