@extends('layouts.app')

@section('content')

<div class="user-edit-page py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('admin.users.index') }}" class="back-link">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver a Usuarios
            </a>
        <div class="flex items-center mb-6">
            <h2 class="font-semibold text-xl ml-2">
                Editar Usuario: {{ $user->nombre }}
            </h2>
        </div>
        
        <div class="main-card">
            @if (session('success'))
                <div class="alert-success" role="alert">
                    <p class="font-bold">Éxito</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert-error" role="alert">
                    <p class="font-bold">¡Ups! Hubo algunos problemas con tus datos.</p>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PATCH')

                <h3 class="section-header-editar-usuario">Datos Personales</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="input-group-user">
                        <label for="nombre" class="form-label">Nombre(s)</label>
                        <input type="text" 
                               name="nombre" 
                               id="nombre" 
                               class="neuro-input" 
                               value="{{ old('nombre', $user->nombre) }}" 
                               maxlength="85"
                               required>
                        <small class="input-help-user">Solo letras y espacios, máximo 85 caracteres</small>
                    </div>
                    <div class="input-group-user">
                        <label for="app_paterno" class="form-label">Apellido Paterno</label>
                        <input type="text" 
                               name="app_paterno" 
                               id="app_paterno" 
                               class="neuro-input" 
                               value="{{ old('app_paterno', $user->app_paterno) }}" 
                               maxlength="85"
                               required>
                        <small class="input-help-user">Solo letras y espacios, máximo 85 caracteres</small>
                    </div>
                    <div class="input-group-user">
                        <label for="app_materno" class="form-label">Apellido Materno</label>
                        <input type="text" 
                               name="app_materno" 
                               id="app_materno" 
                               class="neuro-input" 
                               value="{{ old('app_materno', $user->app_materno) }}"
                               maxlength="85">
                        <small class="input-help-user">Opcional, solo letras y espacios</small>
                    </div>
                    <div class="input-group-user">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" 
                               name="email" 
                               id="email" 
                               class="neuro-input" 
                               value="{{ old('email', $user->email) }}" 
                               required>
                        <small class="input-help-user">Dominios permitidos: gmail.com, hotmail.com, outlook.com, live.com, edu.mx, tec.mx</small>
                    </div>
                </div>

                <h3 class="section-header-editar-usuario">Rol del Sistema</h3>
                <div>
                    <label for="id_rol_sistema" class="form-label">Rol</label>
                    <select name="id_rol_sistema" id="id_rol_sistema" class="neuro-select">
                        @foreach($roles as $rol)
                            <option value="{{ $rol->id_rol_sistema }}" {{ $user->id_rol_sistema == $rol->id_rol_sistema ? 'selected' : '' }}>
                                {{ ucfirst($rol->nombre) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                @if($user->estudiante)
                    <h3 class="section-header-editar-usuario">Datos de Estudiante</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="input-group-user">
                            <label for="numero_control" class="form-label">Número de Control</label>
                            <input type="text" 
                                   name="numero_control" 
                                   id="numero_control" 
                                   class="neuro-input" 
                                   value="{{ old('numero_control', $user->estudiante->numero_control) }}"
                                   maxlength="9"
                                   pattern="^[CB]?\d{7,8}$">
                            <small class="input-help-user">Ej: 24010001 o C24010001 (Opcional C/B + 7-8 dígitos)</small>
                        </div>
                        <div class="input-group-user">
                            <label for="semestre" class="form-label">Semestre</label>
                            <input type="number" 
                                   name="semestre" 
                                   id="semestre" 
                                   class="neuro-input" 
                                   value="{{ old('semestre', $user->estudiante->semestre) }}"
                                   min="1"
                                   max="14">
                            <small class="input-help-user">Entre 1° y 14° semestre</small>
                        </div>
                        <div>
                            <label for="carrera" class="form-label">Carrera</label>
                            <input type="text" id="carrera" class="neuro-input" value="{{ $user->estudiante->carrera->nombre ?? 'N/A' }}" readonly>
                        </div>
                    </div>
                @elseif($user->jurado)
                     <h3 class="section-header-editar-usuario">Datos de Jurado</h3>
                     <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="input-group-user">
                            <label for="especialidad" class="form-label">Especialidad</label>
                            <input type="text" 
                                   name="especialidad" 
                                   id="especialidad" 
                                   class="neuro-input" 
                                   value="{{ old('especialidad', $user->jurado->especialidad) }}"
                                   maxlength="100">
                            <small class="input-help-user">Máximo 100 caracteres</small>
                        </div>
                     </div>
                @endif

                <div class="flex items-center justify-end mt-8">
                    <button type="submit" class="submit-button">
                        Actualizar Usuario
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Estilos para validación */
    .input-group-user {
        position: relative;
    }

    .input-help-user {
        display: block;
        margin-top: 5px;
        font-size: 0.75rem;
        color: rgba(107, 114, 128, 0.8);
        margin-left: 5px;
        font-family: 'Poppins', sans-serif;
    }

    .validation-message-user {
        display: none;
        align-items: center;
        gap: 8px;
        margin-top: 8px;
        padding: 8px 12px;
        border-radius: 8px;
        font-size: 0.8rem;
        font-family: 'Poppins', sans-serif;
    }

    /* Animación de entrada */
    .validation-message-user.show {
        display: flex !important;
        animation: slideInUser 0.3s ease-out;
    }

    /* Animación de salida */
    .validation-message-user.hide {
        animation: slideOutUser 0.3s ease-out forwards;
    }

    @keyframes slideInUser {
        from {
            opacity: 0;
            transform: translateY(-8px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideOutUser {
        from {
            opacity: 1;
            transform: translateY(0);
        }
        to {
            opacity: 0;
            transform: translateY(-8px);
        }
    }

    /* Error es ROJO */
    .validation-message-user.error {
        background: rgba(239, 68, 68, 0.2);
        border-left: 4px solid #ef4444;
        color: #fc7373ff;
    }

    .validation-message-user.error i {
        color: #ef4444;
        font-size: 0.9rem;
    }

    .validation-message-user.success {
        background: rgba(40, 167, 69, 0.2);
        border-left: 4px solid #28a745;
        color: #53a953ff;
    }

    .validation-message-user.success i {
        color: #28a745;
        font-size: 0.9rem;
    }

    /* Borde de error es ROJO */
    .neuro-input.error, .neuro-select.error {
        border-color: #ef4444 !important;
        background: rgba(239, 68, 68, 0.1) !important;
        animation: shakeUser 0.5s ease-in-out;
    }

    .neuro-input.success {
        border-color: #28a745 !important;
        background: rgba(40, 167, 69, 0.1) !important;
    }

    @keyframes shakeUser {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-3px); }
        20%, 40%, 60%, 80% { transform: translateX(3px); }
    }
</style>

<!-- FontAwesome para iconos -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
    // ============================================
    // FUNCIONES DE VALIDACIÓN EN TIEMPO REAL
    // ============================================
    
    function showValidationMessageUser(input, message, isError = true) {
        let messageDiv = input.parentElement.querySelector('.validation-message-user');
        
        if (!messageDiv) {
            messageDiv = document.createElement('div');
            messageDiv.className = 'validation-message-user';
            input.parentElement.appendChild(messageDiv);
        }
        
        // Remover clases anteriores
        messageDiv.classList.remove('error', 'success', 'show', 'hide');
        
        // Agregar nuevas clases
        messageDiv.className = `validation-message-user ${isError ? 'error' : 'success'} show`;
        messageDiv.innerHTML = `
            <i class="fas fa-${isError ? 'exclamation-circle' : 'check-circle'}"></i>
            <span>${message}</span>
        `;
        
        input.classList.remove('error', 'success');
        input.classList.add(isError ? 'error' : 'success');
        
        // Limpiar timeout anterior
        clearTimeout(input.validationTimeout);
        
        input.validationTimeout = setTimeout(() => {
            if (messageDiv) {
                messageDiv.classList.remove('show');
                messageDiv.classList.add('hide');
                
                setTimeout(() => {
                    messageDiv.style.display = 'none';
                    messageDiv.classList.remove('hide');
                }, 300);
            }
            input.classList.remove('error', 'success');
        }, 1800);
    }

    function hideValidationMessageUser(input) {
        const messageDiv = input.parentElement.querySelector('.validation-message-user');
        if (messageDiv) {
            messageDiv.classList.remove('show');
            messageDiv.classList.add('hide');
            
            setTimeout(() => {
                messageDiv.style.display = 'none';
                messageDiv.classList.remove('hide');
            }, 300);
        }
        input.classList.remove('error', 'success');
        clearTimeout(input.validationTimeout);
        clearTimeout(input.successDebounce);
    }

    // Validación de número de control
    function validateNumeroControl(numControl) {
        numControl = numControl.trim().toUpperCase();

        if (!/^[CB]?\d{7,8}$/.test(numControl)) {
            return { valid: false, message: 'Formato inválido. Ej: 24010001 ó C24010001' };
        }

        const numeros = numControl.replace(/[^\d]/g, '');

        if (numeros.length < 7 || numeros.length > 8) {
            return { valid: false, message: 'Debe tener entre 7 y 8 dígitos numéricos' };
        }

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

        const tipo = numControl.startsWith('C') ? 'Convalidación' : (numControl.startsWith('B') ? 'Regular' : 'Regular');
        return { valid: true, message: `Válido (${tipo})` };
    }

    // ============================================
    // CONFIGURACIÓN AL CARGAR EL DOM
    // ============================================
    
    document.addEventListener('DOMContentLoaded', function() {
        
        // ============================================
        // VALIDACIÓN: NOMBRES Y APELLIDOS
        // ============================================
        const nameInputs = ['nombre', 'app_paterno', 'app_materno'];
        
        nameInputs.forEach(inputId => {
            const input = document.getElementById(inputId);
            if (input) {
                input.addEventListener('input', function() {
                    const value = this.value;
                    const nameRegex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]*$/;

                    clearTimeout(this.successDebounce);

                    if (value && !nameRegex.test(value)) {
                        this.classList.add('error');
                        const cleanValue = value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
                        this.value = cleanValue;
                        showValidationMessageUser(this, 'Solo se permiten letras, espacios y acentos', true);
                    } else if (value.length > 85) {
                        const truncated = value.substring(0, 85);
                        this.value = truncated;
                        showValidationMessageUser(this, 'Máximo 85 caracteres permitidos', true);
                    } else if (value && nameRegex.test(value)) {
                        this.classList.remove('error');
                        hideValidationMessageUser(this);
                        
                        this.successDebounce = setTimeout(() => {
                            showValidationMessageUser(this, 'Campo válido', false);
                        }, 500);
                    } else {
                        this.classList.remove('error');
                        hideValidationMessageUser(this);
                    }
                });

                input.addEventListener('blur', function() {
                    clearTimeout(this.successDebounce);
                    const value = this.value;
                    if (value && !/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(value)) {
                        this.classList.add('error');
                        showValidationMessageUser(this, 'Solo se permiten letras, espacios y acentos', true);
                    } else if (value) {
                        showValidationMessageUser(this, 'Campo válido', false);
                    } else {
                        hideValidationMessageUser(this);
                    }
                });

                input.addEventListener('focus', function() {
                    if (this.classList.contains('error')) {
                        setTimeout(() => {
                            this.classList.remove('error');
                            hideValidationMessageUser(this);
                        }, 100);
                    }
                });
            }
        });

        // ============================================
        // VALIDACIÓN: EMAIL
        // ============================================
        const emailInput = document.getElementById('email');
        if (emailInput) {
            emailInput.addEventListener('input', function() {
                const email = this.value;
                
                clearTimeout(this.successDebounce);
                
                if (email) {
                    const validDomains = ['gmail.com', 'hotmail.com', 'outlook.com', 'live.com', 'edu.mx', 'tec.mx'];
                    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                    const domain = email.toLowerCase().split('@')[1];

                    if (!emailRegex.test(email)) {
                        showValidationMessageUser(this, 'Formato de correo inválido', true);
                    } else if (!validDomains.includes(domain)) {
                        showValidationMessageUser(this, 'Solo se permiten dominios: gmail.com, hotmail.com, outlook.com, live.com, edu.mx, tec.mx', true);
                    } else {
                        hideValidationMessageUser(this);
                        
                        this.successDebounce = setTimeout(() => {
                            showValidationMessageUser(this, 'Correo válido', false);
                        }, 500);
                    }
                } else {
                    hideValidationMessageUser(this);
                }
            });
        }

        // ============================================
        // VALIDACIÓN: NÚMERO DE CONTROL
        // ============================================
        const numControlInput = document.getElementById('numero_control');
        if (numControlInput) {
            numControlInput.addEventListener('input', function() {
                const value = this.value.toUpperCase();
                this.value = value;

                clearTimeout(this.successDebounce);

                if (value) {
                    const validation = validateNumeroControl(value);
                    if (!validation.valid) {
                        showValidationMessageUser(this, validation.message, true);
                    } else {
                        hideValidationMessageUser(this);
                        
                        this.successDebounce = setTimeout(() => {
                            showValidationMessageUser(this, validation.message, false);
                        }, 500);
                    }
                } else {
                    hideValidationMessageUser(this);
                }
            });
        }

        // ============================================
        // VALIDACIÓN: SEMESTRE
        // ============================================
        const semestreInput = document.getElementById('semestre');
        if (semestreInput) {
            semestreInput.addEventListener('input', function() {
                let value = parseInt(this.value);
                
                clearTimeout(this.successDebounce);
                
                if (isNaN(value)) {
                    hideValidationMessageUser(this);
                    return;
                }
                
                if (value < 1) {
                    this.value = 1;
                    showValidationMessageUser(this, 'El semestre mínimo es 1°', true);
                } else if (value > 14) {
                    this.value = 14;
                    showValidationMessageUser(this, 'El semestre máximo es 14°', true);
                } else {
                    hideValidationMessageUser(this);
                    
                    this.successDebounce = setTimeout(() => {
                        showValidationMessageUser(this, 'Semestre válido', false);
                    }, 500);
                }
            });

            semestreInput.addEventListener('blur', function() {
                clearTimeout(this.successDebounce);
                if (!this.value || parseInt(this.value) < 1) {
                    this.value = 1;
                }
            });
        }

        // ============================================
        // VALIDACIÓN: ESPECIALIDAD (JURADO)
        // ============================================
        const especialidadInput = document.getElementById('especialidad');
        if (especialidadInput) {
            especialidadInput.addEventListener('input', function() {
                const value = this.value;
                
                clearTimeout(this.successDebounce);
                
                if (value.length > 100) {
                    this.value = value.substring(0, 100);
                    showValidationMessageUser(this, 'Máximo 100 caracteres permitidos', true);
                } else if (value) {
                    const remaining = 100 - value.length;
                    hideValidationMessageUser(this);
                    
                    this.successDebounce = setTimeout(() => {
                        showValidationMessageUser(this, `${remaining} caracteres restantes`, false);
                    }, 500);
                } else {
                    hideValidationMessageUser(this);
                }
            });
        }
    });
</script>

@endsection