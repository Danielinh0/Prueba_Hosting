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

        .input-help {
            display: block;
            margin-top: 5px;
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.6);
            margin-left: 5px;
        }

        .input-error {
            display: block;
            margin-top: 5px;
            font-size: 0.8rem;
            color: #ff6b6b;
            margin-left: 5px;
            background: rgba(255, 107, 107, 0.2);
            padding: 5px 10px;
            border-radius: 5px;
        }

        .success-message {
            background: rgba(40, 167, 69, 0.2);
            border-left: 4px solid #28a745;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 15px;
            text-align: left;
            color: #28a745;
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

        /* ESTILOS PARA VALIDACIÓN EN TIEMPO REAL */
        .validation-message {
            display: none;
            align-items: center;
            gap: 8px;
            margin-top: 8px;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 0.8rem;
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-8px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .validation-message.error {
            background: rgba(52, 152, 219, 0.2);
            border-left: 4px solid #3498db;
            color: #87CEEB;
        }

        .validation-message.error i {
            color: #3498db;
            font-size: 0.9rem;
        }

        .validation-message.success {
            background: rgba(40, 167, 69, 0.2);
            border-left: 4px solid #28a745;
            color: #90EE90;
        }

        .validation-message.success i {
            color: #28a745;
            font-size: 0.9rem;
        }

        /* ESTADOS DE INPUT */
        .input-group input.error {
            border-color: #3498db !important;
            background: rgba(52, 152, 219, 0.1) !important;
            animation: shake 0.5s ease-in-out;
        }

        .input-group input.success {
            border-color: #28a745 !important;
            background: rgba(40, 167, 69, 0.1) !important;
        }

        .input-group input.error:focus {
            border-color: #3498db !important;
            box-shadow: 0 0 10px rgba(52, 152, 219, 0.3) !important;
        }

        .input-group input.success:focus {
            border-color: #28a745 !important;
            box-shadow: 0 0 10px rgba(40, 167, 69, 0.3) !important;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-3px); }
            20%, 40%, 60%, 80% { transform: translateX(3px); }
        }

        /* BARRA DE PROGRESO DE CONTRASEÑA */
        .password-strength {
            display: none;
            margin-top: 8px;
            height: 6px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 3px;
            overflow: hidden;
        }

        .password-strength-bar {
            height: 100%;
            transition: width 0.3s ease, background-color 0.3s ease;
            border-radius: 3px;
        }

        .password-strength-bar.weak {
            background: #e74c3c;
            width: 33%;
        }

        .password-strength-bar.medium {
            background: #f39c12;
            width: 66%;
        }

        .password-strength-bar.strong {
            background: #27ae60;
            width: 100%;
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

    <script>
        // Validación de formato de correo
        function validateEmailFormat(email) {
            const validDomains = ['gmail.com', 'hotmail.com', 'outlook.com', 'live.com', 'edu.mx', 'tec.mx'];
            const domain = email.toLowerCase().split('@')[1];
            return validDomains.includes(domain);
        }

        // Validación de número de control
        function validateNumeroControl(numControl) {
            // Quitar espacios y convertir a mayúsculas
            numControl = numControl.trim().toUpperCase();

            // Validar formato básico
            if (!/^[CB]?\d{7,8}$/.test(numControl)) {
                return { valid: false, message: 'Formato inválido. Ej: 24010001 ó C24010001' };
            }

            // Extraer solo los números
            const numeros = numControl.replace(/[^\d]/, '');

            if (numeros.length < 7 || numeros.length > 8) {
                return { valid: false, message: 'Debe tener entre 7 y 8 dígitos numéricos' };
            }

            // Validar año
            const añoInscripcion = parseInt(numeros.substring(0, 2));
            const añoActual = parseInt(new Date().getFullYear().toString().substring(2));
            const añoCompleto = añoInscripcion > añoActual ? 1900 + añoInscripcion : 2000 + añoInscripcion;
            const añoCompletoActual = 2000 + añoActual;

            if (añoCompleto > añoCompletoActual + 1) {
                return { valid: false, message: 'El año de inscripción no puede ser futuro' };
            }

            if (añoCompleto < 2000) {
                return { valid: false, message: 'El año mínimo es 2000' };
            }

            // Validar código de plantel
            let codigoPlantel, esValido;
            if (numeros.length === 8) {
                codigoPlantel = numeros.substring(2, 5);
                esValido = ['100', '101', '102', '103', '104', '105', '106', '107', '108', '109'].includes(codigoPlantel);
            } else {
                codigoPlantel = numeros.substring(2, 4);
                esValido = ['10', '11', '12', '13', '14', '15', '16', '17', '18', '19'].includes(codigoPlantel);
            }

            if (!esValido) {
                return { valid: false, message: 'Código de plantel no válido' };
            }

            // Identificar tipo de estudiante
            const tipo = numControl.startsWith('C') ? 'Convalidación' : (numControl.startsWith('B') ? 'Regular' : 'Regular');

            return { valid: true, message: `Válido (${tipo})` };
        }

        // Validación de contraseña en tiempo real
        function validatePassword(password) {
            const minLength = 8;
            const maxLength = 16;
            const hasLetter = /[A-Za-z]/.test(password);
            const hasNumber = /\d/.test(password);
            const hasSpecial = /[@$!%*#?&]/.test(password);

            if (password.length < minLength) {
                return { valid: false, message: `Mínimo ${minLength} caracteres` };
            }

            if (password.length > maxLength) {
                return { valid: false, message: `Máximo ${maxLength} caracteres` };
            }

            if (!hasLetter) {
                return { valid: false, message: 'Debe contener al menos una letra' };
            }

            if (!hasNumber) {
                return { valid: false, message: 'Debe contener al menos un número' };
            }

            return { valid: true, message: 'Contraseña válida' };
        }

        // Validación de nombres
        function validateName(name) {
            return /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(name);
        }

        // Función para mostrar mensaje de validación
        function showValidationMessage(input, message, isError = true) {
            // Buscar o crear el contenedor del mensaje
            let messageDiv = input.parentElement.querySelector('.validation-message');

            if (!messageDiv) {
                messageDiv = document.createElement('div');
                messageDiv.className = 'validation-message';
                input.parentElement.appendChild(messageDiv);
            }

            // Actualizar contenido y estilo
            messageDiv.className = `validation-message ${isError ? 'error' : 'success'}`;
            messageDiv.innerHTML = `
                <i class="fas fa-${isError ? 'exclamation-circle' : 'check-circle'}"></i>
                <span>${message}</span>
            `;
            messageDiv.style.display = 'flex';

            // Actualizar estado del input
            input.classList.remove('error', 'success');
            input.classList.add(isError ? 'error' : 'success');

            // Temporizador para ocultar mensaje de error
            if (isError) {
                clearTimeout(input.validationTimeout);
                input.validationTimeout = setTimeout(() => {
                    if (messageDiv && messageDiv.classList.contains('error')) {
                        messageDiv.style.display = 'none';
                        input.classList.remove('error');
                    }
                }, 4000);
            }
        }

        // Función para ocultar mensaje de validación
        function hideValidationMessage(input) {
            const messageDiv = input.parentElement.querySelector('.validation-message');
            if (messageDiv) {
                messageDiv.style.display = 'none';
            }
            input.classList.remove('error', 'success');
            clearTimeout(input.validationTimeout);
        }

        // Cuando el DOM esté listo
        document.addEventListener('DOMContentLoaded', function() {
            // Validación de nombres y apellidos
            const nameInputs = document.querySelectorAll('input[name="nombre"], input[name="app_paterno"], input[name="app_materno"]');
            nameInputs.forEach(input => {
                input.addEventListener('input', function() {
                    const value = this.value;
                    const nameRegex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]*$/;

                    if (value && !nameRegex.test(value)) {
                        // Hay caracteres no válidos - ANIMACIÓN Y COLOR AZUL
                        this.classList.add('error');

                        // Limpiar caracteres no válidos
                        const cleanValue = value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
                        this.value = cleanValue;

                        // Mostrar mensaje de error
                        showValidationMessage(this, 'Solo se permiten letras, espacios y acentos', true);

                        // Temporizador para ocultar el error después de 3 segundos
                        clearTimeout(this.errorTimeout);
                        this.errorTimeout = setTimeout(() => {
                            this.classList.remove('error');
                            hideValidationMessage(this);
                        }, 3000);
                    } else if (value && nameRegex.test(value)) {
                        // Todo está bien
                        this.classList.remove('error');
                        showValidationMessage(this, 'Campo válido', false);
                    } else {
                        // Campo vacío
                        this.classList.remove('error');
                        hideValidationMessage(this);
                    }
                });

                // También validar al perder el foco
                input.addEventListener('blur', function() {
                    const value = this.value;
                    const errorMessage = this.parentElement.querySelector('.validation-message');

                    if (value && !/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(value)) {
                        this.classList.add('error');
                        showValidationMessage(this, 'Solo se permiten letras, espacios y acentos', true);
                    } else {
                        this.classList.remove('error');
                        if (value) {
                            showValidationMessage(this, 'Campo válido', false);
                        } else {
                            hideValidationMessage(this);
                        }
                    }
                });

                // Ocultar error al empezar a escribir de nuevo
                input.addEventListener('focus', function() {
                    if (this.classList.contains('error')) {
                        setTimeout(() => {
                            this.classList.remove('error');
                            hideValidationMessage(this);
                        }, 100);
                    }
                });
            });

            // Validación de email
            const emailInput = document.querySelector('input[name="email"]');
            if (emailInput) {
                emailInput.addEventListener('input', function() {
                    const email = this.value;
                    if (email) {
                        const validDomains = ['gmail.com', 'hotmail.com', 'outlook.com', 'live.com', 'edu.mx', 'tec.mx', 'itoaxaca.edu.mx'];
                        const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                        const domain = email.toLowerCase().split('@')[1];

                        if (!emailRegex.test(email)) {
                            showValidationMessage(this, 'Formato de correo inválido', true);
                        } else if (!validDomains.includes(domain)) {
                            showValidationMessage(this, 'Solo se permiten dominios: gmail.com, hotmail.com, outlook.com, live.com, edu.mx, tec.mx, itoaxaca.edu.mx', true);
                        } else {
                            showValidationMessage(this, 'Correo válido', false);
                        }
                    } else {
                        hideValidationMessage(this);
                    }
                });
            }

            // Validación de número de control
            const numControlInput = document.querySelector('input[name="numero_control"]');
            if (numControlInput) {
                numControlInput.addEventListener('input', function() {
                    const value = this.value.toUpperCase();
                    this.value = value;

                    if (value) {
                        const validation = validateNumeroControl(value);
                        if (!validation.valid) {
                            showValidationMessage(this, validation.message, true);
                        } else {
                            showValidationMessage(this, validation.message, false);
                        }
                    } else {
                        hideValidationMessage(this);
                    }
                });
            }

            // Validación de contraseña con barra de progreso
            const passwordInput = document.querySelector('input[name="password"]');
            const passwordConfirmInput = document.querySelector('input[name="password_confirmation"]');

            if (passwordInput) {
                // Agregar barra de progreso
                const strengthBar = document.createElement('div');
                strengthBar.className = 'password-strength';
                strengthBar.innerHTML = '<div class="password-strength-bar"></div>';
                passwordInput.parentElement.appendChild(strengthBar);

                passwordInput.addEventListener('input', function() {
                    const password = this.value;
                    const strengthBarDiv = this.parentElement.querySelector('.password-strength');
                    const strengthBarInner = strengthBarDiv.querySelector('.password-strength-bar');

                    if (password.length === 0) {
                        strengthBarDiv.style.display = 'none';
                        hideValidationMessage(this);
                        return;
                    }

                    strengthBarDiv.style.display = 'block';

                    // Calcular fortaleza
                    let strength = 0;
                    if (password.length >= 8) strength++;
                    if (password.length >= 12) strength++;
                    if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
                    if (/\d/.test(password)) strength++;
                    if (/[@$!%*#?&]/.test(password)) strength++;

                    // Actualizar barra de progreso
                    strengthBarInner.className = 'password-strength-bar';
                    if (strength <= 2) {
                        strengthBarInner.classList.add('weak');
                        showValidationMessage(this, 'Contraseña débil. Agregue más caracteres y símbolos', true);
                    } else if (strength <= 3) {
                        strengthBarInner.classList.add('medium');
                        showValidationMessage(this, 'Contraseña media. Puede mejorar', false);
                    } else {
                        strengthBarInner.classList.add('strong');
                        showValidationMessage(this, 'Contraseña fuerte', false);
                    }
                });
            }

            if (passwordConfirmInput) {
                passwordConfirmInput.addEventListener('input', function() {
                    const password = passwordInput ? passwordInput.value : '';
                    if (this.value) {
                        if (this.value !== password) {
                            showValidationMessage(this, 'Las contraseñas no coinciden', true);
                        } else {
                            showValidationMessage(this, 'Las contraseñas coinciden', false);
                        }
                    } else {
                        hideValidationMessage(this);
                    }
                });
            }
        });
    </script>
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
                    placeholder="Ej: Juan Carlos"
                    required
                    autofocus
                    pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+"
                    title="Solo se permiten letras y espacios"
                >
                @error('nombre')
                    <div class="input-error">{{ $message }}</div>
                @enderror
                <small class="input-help">Solo letras y espacios</small>
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
                        placeholder="Ej: Pérez"
                        required
                        pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+"
                        title="Solo se permiten letras y espacios"
                    >
                    @error('app_paterno')
                        <div class="input-error">{{ $message }}</div>
                    @enderror
                    <small class="input-help">Solo letras</small>
                </div>
                <div class="input-group">
                    <label for="app_materno">Apellido Materno</label>
                    <input
                        id="app_materno"
                        type="text"
                        name="app_materno"
                        value="{{ old('app_materno') }}"
                        placeholder="Ej: López (opcional)"
                        pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]*"
                        title="Solo se permiten letras y espacios"
                    >
                    @error('app_materno')
                        <div class="input-error">{{ $message }}</div>
                    @enderror
                    <small class="input-help">Opcional</small>
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
                        placeholder="Ej: 24010001 ó C24010001"
                        pattern="^[CB]?\d{7,8}$"
                        title="Formato: Opcional C/B + 7-8 dígitos. Ej: 24010001"
                        maxlength="9"
                    >
                    @error('numero_control')
                        <div class="input-error">{{ $message }}</div>
                    @enderror
                    <small class="input-help">Ej: 24010001 (Orizaba 2024) • Opcional: C24100001 (Convalidación)</small>
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