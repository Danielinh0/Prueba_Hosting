@extends('layouts.app')

@section('content')

<div class="evento-create-page py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('admin.eventos.index') }}" class="back-link">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver a Gestión de Eventos
        </a>
        <div class="flex items-center mb-6">
            <h2 class="font-semibold text-xl ml-2">
                Crear Nuevo Evento
            </h2>
        </div>
        
        <div class="main-card">
            @if ($errors->any())
                <div class="alert-error">
                    <strong>¡Ups!</strong> Hubo algunos problemas con tus datos.
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.eventos.store') }}" method="POST" enctype="multipart/form-data" id="eventoForm">
                @csrf

                {{-- SECCIÓN: Información del Evento --}}
                <div class="section-card" id="sol1" style="margin-top: 0;">
                    <div class="section-header-crear-evento" id="sol1-1">
                        <div class="section-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="section-title">Información del Evento</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="input-group-crear">
                            <label for="nombre" class="form-label">Nombre del Evento</label>
                            <input type="text" 
                                   name="nombre" 
                                   id="nombre" 
                                   class="neuro-input" 
                                   value="{{ old('nombre') }}" 
                                   required 
                                   maxlength="85"
                                   placeholder="Ej: Hackathon 2025">
                            <small class="input-help-crear">Máximo 85 caracteres</small>
                        </div>

                        <div class="input-group-crear">
                            <label for="cupo_max_equipos" class="form-label">Cupo Máximo de Equipos</label>
                            <input type="number" 
                                   name="cupo_max_equipos" 
                                   id="cupo_max_equipos" 
                                   class="neuro-input" 
                                   value="{{ old('cupo_max_equipos') }}" 
                                   required 
                                   min="1"
                                   max="999"
                                   placeholder="Ej: 20">
                            <small class="input-help-crear">Mínimo 1, máximo 999 equipos</small>
                        </div>

                        <div class="input-group-crear">
                            <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                            <input type="date" 
                                   name="fecha_inicio" 
                                   id="fecha_inicio" 
                                   class="neuro-input" 
                                   value="{{ old('fecha_inicio') }}" 
                                   required>
                            <small class="input-help-crear">Debe ser posterior a hoy</small>
                        </div>

                        <div class="input-group-crear">
                            <label for="fecha_fin" class="form-label">Fecha de Fin</label>
                            <input type="date" 
                                   name="fecha_fin" 
                                   id="fecha_fin" 
                                   class="neuro-input" 
                                   value="{{ old('fecha_fin') }}" 
                                   required>
                            <small class="input-help-crear">Debe ser posterior a la fecha de inicio</small>
                        </div>
                    </div>

                    <div class="mt-5 input-group-crear">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea name="descripcion" 
                                  id="descripcion" 
                                  rows="3" 
                                  class="neuro-textarea"
                                  maxlength="500"
                                  placeholder="Describe brevemente el evento...">{{ old('descripcion') }}</textarea>
                        <small class="input-help-crear">Máximo 500 caracteres</small>
                    </div>

                    <div class="mt-5">
                        <label for="ruta_imagen" class="form-label">Imagen del Evento</label>
                        
                        {{-- Área de drag and drop --}}
                        <div class="file-upload-area" id="fileUploadArea">
                            <div class="file-upload-content">
                                <svg class="file-upload-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                <p class="file-upload-text">
                                    <strong>Arrastra un archivo aquí o haz clic para seleccionar</strong>
                                </p>
                                <p class="file-upload-hint">
                                    JPG, PNG, GIF - Máximo 2MB
                                </p>
                            </div>
                            <input type="file" 
                                   name="ruta_imagen" 
                                   id="ruta_imagen" 
                                   accept="image/jpeg,image/png,image/jpg,image/gif"
                                   class="neuro-file"
                                   onchange="handleFileSelect(this)">
                        </div>
                        
                        {{-- Preview del archivo seleccionado --}}
                        <div id="filePreview" class="file-preview">
                            <div class="file-preview-icon">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="file-preview-info">
                                <div class="file-preview-name" id="fileName"></div>
                                <div class="file-preview-size" id="fileSize"></div>
                            </div>
                            <button type="button" class="file-preview-remove" onclick="removeFile()">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- SECCIÓN: Criterios de Evaluación --}}
                <div class="section-card">
                    <div class="section-header-crear-evento">
                        <div class="section-icon" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed);">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <h3 class="section-title">Criterios de Evaluación</h3>
                    </div>

                    <div class="info-box">
                        <p>
                            <strong>¿Cómo funciona?</strong> Define los aspectos que los jurados evaluarán en cada proyecto. 
                            Cada criterio tiene un <strong>porcentaje</strong> que indica su importancia en la calificación final.
                        </p>
                        <p class="mt-2">
                            <strong>Importante:</strong> La suma de todos los porcentajes debe ser exactamente <strong>100%</strong>.
                            Por ejemplo: Innovación (30%) + Funcionalidad (25%) + Presentación (20%) + Impacto (25%) = 100%
                        </p>
                    </div>

                    <div id="criterios-container">
                        {{-- Criterio 1 (por defecto) --}}
                        <div class="criterio-card" data-criterio="1">
                            <span class="criterio-number">Criterio 1</span>
                            <div class="criterio-grid">
                                <div class="input-group-crear">
                                    <label class="form-label">Nombre del criterio</label>
                                    <input type="text" 
                                           name="criterios[0][nombre]" 
                                           class="neuro-input criterio-nombre-crear" 
                                           required 
                                           maxlength="85"
                                           placeholder="Ej: Innovación y Creatividad">
                                    <small class="input-help-crear">Solo letras y espacios, máximo 85 caracteres</small>
                                </div>
                                <div class="input-group-crear">
                                    <label class="form-label">Descripción (opcional)</label>
                                    <input type="text" 
                                           name="criterios[0][descripcion]" 
                                           class="neuro-input criterio-descripcion-crear" 
                                           maxlength="250"
                                           placeholder="Ej: Originalidad del proyecto">
                                    <small class="input-help-crear">Máximo 250 caracteres</small>
                                </div>
                                <div class="input-group-crear">
                                    <label class="form-label">Porcentaje</label>
                                    <div class="ponderacion-input-wrapper">
                                        <input type="number" 
                                               name="criterios[0][ponderacion]" 
                                               class="neuro-input ponderacion-input criterio-ponderacion-crear" 
                                               required 
                                               min="1" 
                                               max="100" 
                                               placeholder="25" 
                                               oninput="calcularTotal()">
                                        <span class="ponderacion-suffix">%</span>
                                    </div>
                                    <small class="input-help-crear">Entre 1% y 100%</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn-add-criterio" onclick="agregarCriterio()">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Agregar otro criterio
                    </button>

                    <div class="ponderacion-total">
                        <span class="ponderacion-total-label">Total de porcentajes:</span>
                        <div>
                            <span id="ponderacion-total-value" class="ponderacion-total-value incomplete">0%</span>
                            <span id="ponderacion-status" class="ponderacion-status text-red-500">(Debe ser 100%)</span>
                        </div>
                    </div>
                </div>

                {{-- Botón de Envío --}}
                <div class="flex items-center justify-end mt-8">
                    <button type="submit" class="submit-button" id="submitBtn">
                        <span class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Crear Evento
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Estilos para validación */
    .input-group-crear {
        position: relative;
    }

    .input-help-crear {
        display: block;
        margin-top: 5px;
        font-size: 0.75rem;
        color: rgba(107, 114, 128, 0.8);
        margin-left: 5px;
        font-family: 'Poppins', sans-serif;
    }

    .validation-message-crear {
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
    .validation-message-crear.show {
        display: flex !important;
        animation: slideInCrear 0.3s ease-out;
    }

    /* Animación de salida */
    .validation-message-crear.hide {
        animation: slideOutCrear 0.3s ease-out forwards;
    }

    @keyframes slideInCrear {
        from {
            opacity: 0;
            transform: translateY(-8px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideOutCrear {
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
    .validation-message-crear.error {
        background: rgba(239, 68, 68, 0.2);
        border-left: 4px solid #ef4444;
        color: #fc7373ff;
    }

    .validation-message-crear.error i {
        color: #ef4444;
        font-size: 0.9rem;
    }

    .validation-message-crear.success {
        background: rgba(40, 167, 69, 0.2);
        border-left: 4px solid #28a745;
        color: #53a953ff;
    }

    .validation-message-crear.success i {
        color: #28a745;
        font-size: 0.9rem;
    }

    /* Borde de error es ROJO */
    .neuro-input.error, .neuro-textarea.error {
        border-color: #ef4444 !important;
        background: rgba(239, 68, 68, 0.1) !important;
        animation: shakeCrear 0.5s ease-in-out;
    }

    .neuro-input.success, .neuro-textarea.success {
        border-color: #28a745 !important;
        background: rgba(40, 167, 69, 0.1) !important;
    }

    @keyframes shakeCrear {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-3px); }
        20%, 40%, 60%, 80% { transform: translateX(3px); }
    }
</style>

<!-- FontAwesome para iconos -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
    let criterioCount = 1;

    // ============================================
    // FUNCIONES DE VALIDACIÓN EN TIEMPO REAL
    // ============================================
    
    function showValidationMessageCrear(input, message, isError = true) {
        let messageDiv = input.parentElement.querySelector('.validation-message-crear');
        
        if (!messageDiv) {
            messageDiv = document.createElement('div');
            messageDiv.className = 'validation-message-crear';
            input.parentElement.appendChild(messageDiv);
        }
        
        // Remover clases anteriores
        messageDiv.classList.remove('error', 'success', 'show', 'hide');
        
        // Agregar nuevas clases
        messageDiv.className = `validation-message-crear ${isError ? 'error' : 'success'} show`;
        messageDiv.innerHTML = `
            <i class="fas fa-${isError ? 'exclamation-circle' : 'check-circle'}"></i>
            <span>${message}</span>
        `;
        
        input.classList.remove('error', 'success');
        input.classList.add(isError ? 'error' : 'success');
        
        // Limpiar timeout anterior
        clearTimeout(input.validationTimeout);
        
        // Ocultar después de 2 segundos con animación
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
        }, 2000);
    }

    function hideValidationMessageCrear(input) {
        const messageDiv = input.parentElement.querySelector('.validation-message-crear');
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

    // ============================================
    // CONFIGURAR VALIDACIONES DE CRITERIOS
    // ============================================
    
    function setupCriterioValidationsCrear() {
        // Validar nombres de criterios
        document.querySelectorAll('.criterio-nombre-crear').forEach(input => {
            input.addEventListener('input', function() {
                const value = this.value;
                const nameRegex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]*$/;

                // Limpiar debounce de éxito anterior
                clearTimeout(this.successDebounce);

                if (value && !nameRegex.test(value)) {
                    this.classList.add('error');
                    const cleanValue = value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
                    this.value = cleanValue;
                    showValidationMessageCrear(this, 'Solo se permiten letras, espacios y acentos', true);
                } else if (value.length > 85) {
                    const truncated = value.substring(0, 85);
                    this.value = truncated;
                    showValidationMessageCrear(this, 'Máximo 85 caracteres permitidos', true);
                } else if (value && nameRegex.test(value)) {
                    // CAMBIO: Mensaje de éxito con debounce (espera 500ms después de dejar de teclear)
                    this.classList.remove('error');
                    hideValidationMessageCrear(this);
                    
                    this.successDebounce = setTimeout(() => {
                        showValidationMessageCrear(this, 'Nombre válido', false);
                    }, 500);
                } else {
                    this.classList.remove('error');
                    hideValidationMessageCrear(this);
                }
            });

            input.addEventListener('blur', function() {
                clearTimeout(this.successDebounce);
                const value = this.value;
                if (value && !/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(value)) {
                    this.classList.add('error');
                    showValidationMessageCrear(this, 'Solo se permiten letras, espacios y acentos', true);
                } else if (value) {
                    showValidationMessageCrear(this, 'Nombre válido', false);
                } else {
                    hideValidationMessageCrear(this);
                }
            });

            input.addEventListener('focus', function() {
                if (this.classList.contains('error')) {
                    setTimeout(() => {
                        this.classList.remove('error');
                        hideValidationMessageCrear(this);
                    }, 100);
                }
            });
        });

        // Validar descripciones
        document.querySelectorAll('.criterio-descripcion-crear').forEach(input => {
            input.addEventListener('input', function() {
                const value = this.value;
                
                clearTimeout(this.successDebounce);
                
                if (value.length > 250) {
                    this.value = value.substring(0, 250);
                    showValidationMessageCrear(this, 'Máximo 250 caracteres permitidos', true);
                } else if (value) {
                    const remaining = 250 - value.length;
                    hideValidationMessageCrear(this);
                    
                    // CAMBIO: Mensaje de éxito con debounce
                    this.successDebounce = setTimeout(() => {
                        showValidationMessageCrear(this, `${remaining} caracteres restantes`, false);
                    }, 500);
                } else {
                    hideValidationMessageCrear(this);
                }
            });
        });

        // Validar ponderaciones
        document.querySelectorAll('.criterio-ponderacion-crear').forEach(input => {
            input.addEventListener('input', function() {
                let value = parseInt(this.value);
                
                clearTimeout(this.successDebounce);
                
                if (isNaN(value)) {
                    hideValidationMessageCrear(this);
                    return;
                }
                
                if (value < 1) {
                    this.value = 1;
                    showValidationMessageCrear(this, 'El valor mínimo es 1%', true);
                } else if (value > 100) {
                    this.value = 100;
                    showValidationMessageCrear(this, 'El valor máximo es 100%', true);
                } else {
                    // CAMBIO: Mensaje de éxito con debounce
                    hideValidationMessageCrear(this);
                    
                    this.successDebounce = setTimeout(() => {
                        showValidationMessageCrear(this, 'Porcentaje válido', false);
                    }, 500);
                }
            });

            input.addEventListener('blur', function() {
                clearTimeout(this.successDebounce);
                if (!this.value || parseInt(this.value) < 1) {
                    this.value = 1;
                }
            });
        });
    }

    // ============================================
    // INICIALIZACIÓN AL CARGAR DOM
    // ============================================
    
    document.addEventListener('DOMContentLoaded', function() {
        
        // Configurar validaciones iniciales
        setupCriterioValidationsCrear();
        calcularTotal();
        
        // ============================================
        // VALIDACIÓN: NOMBRE DEL EVENTO
        // ============================================
        const nombreEvento = document.getElementById('nombre');
        if (nombreEvento) {
            nombreEvento.addEventListener('input', function() {
                const value = this.value;
                
                clearTimeout(this.successDebounce);
                
                if (value.length > 85) {
                    this.value = value.substring(0, 85);
                    showValidationMessageCrear(this, 'Máximo 85 caracteres permitidos', true);
                } else if (value) {
                    // CAMBIO: Mensaje de éxito con debounce
                    hideValidationMessageCrear(this);
                    
                    this.successDebounce = setTimeout(() => {
                        showValidationMessageCrear(this, 'Nombre válido', false);
                    }, 500);
                } else {
                    hideValidationMessageCrear(this);
                }
            });
        }

        // ============================================
        // VALIDACIÓN: CUPO MÁXIMO
        // ============================================
        const cupoMax = document.getElementById('cupo_max_equipos');
        if (cupoMax) {
            cupoMax.addEventListener('input', function() {
                let value = parseInt(this.value);
                
                clearTimeout(this.successDebounce);
                
                if (isNaN(value)) {
                    hideValidationMessageCrear(this);
                    return;
                }
                
                if (value < 1) {
                    this.value = 1;
                    showValidationMessageCrear(this, 'El cupo mínimo es 1 equipo', true);
                } else if (value > 999) {
                    this.value = 999;
                    showValidationMessageCrear(this, 'El cupo máximo es 999 equipos', true);
                } else {
                    // CAMBIO: Mensaje de éxito con debounce
                    hideValidationMessageCrear(this);
                    
                    this.successDebounce = setTimeout(() => {
                        showValidationMessageCrear(this, 'Cupo válido', false);
                    }, 500);
                }
            });

            cupoMax.addEventListener('blur', function() {
                clearTimeout(this.successDebounce);
                if (!this.value || parseInt(this.value) < 1) {
                    this.value = 1;
                }
            });
        }

        // ============================================
        // VALIDACIÓN: FECHAS
        // ============================================
        const fechaInicio = document.getElementById('fecha_inicio');
        const fechaFin = document.getElementById('fecha_fin');
        
        // Obtener mañana (un día después de hoy)
        const hoy = new Date();
        const manana = new Date(hoy);
        manana.setDate(manana.getDate() + 1);
        const mananaStr = manana.toISOString().split('T')[0];

        if (fechaInicio) {
            fechaInicio.setAttribute('min', mananaStr);
            
            fechaInicio.addEventListener('change', function() {
                const fechaSeleccionada = new Date(this.value);
                const fechaManana = new Date(mananaStr);
                
                if (fechaSeleccionada < fechaManana) {
                    this.value = mananaStr;
                    showValidationMessageCrear(this, 'La fecha de inicio debe ser posterior a hoy', true);
                } else {
                    showValidationMessageCrear(this, 'Fecha de inicio válida', false);
                    
                    if (fechaFin) {
                        const fechaInicioObj = new Date(this.value);
                        const diaDesp = new Date(fechaInicioObj);
                        diaDesp.setDate(diaDesp.getDate() + 1);
                        const diaDespStr = diaDesp.toISOString().split('T')[0];
                        
                        fechaFin.setAttribute('min', diaDespStr);
                        
                        if (fechaFin.value && fechaFin.value <= this.value) {
                            fechaFin.value = '';
                            showValidationMessageCrear(fechaFin, 'La fecha de fin debe ser posterior a la de inicio', true);
                        }
                    }
                }
            });
        }

        if (fechaFin) {
            fechaFin.addEventListener('change', function() {
                if (fechaInicio && fechaInicio.value) {
                    const inicio = new Date(fechaInicio.value);
                    const fin = new Date(this.value);
                    
                    if (fin <= inicio) {
                        this.value = '';
                        showValidationMessageCrear(this, 'La fecha de fin debe ser posterior a la fecha de inicio', true);
                    } else {
                        showValidationMessageCrear(this, 'Fecha de fin válida', false);
                    }
                } else {
                    showValidationMessageCrear(this, 'Primero selecciona la fecha de inicio', true);
                    this.value = '';
                }
            });
        }

        // ============================================
        // VALIDACIÓN: DESCRIPCIÓN
        // ============================================
        const descripcion = document.getElementById('descripcion');
        if (descripcion) {
            descripcion.addEventListener('input', function() {
                const value = this.value;
                
                clearTimeout(this.successDebounce);
                
                if (value.length > 500) {
                    this.value = value.substring(0, 500);
                    showValidationMessageCrear(this, 'Máximo 500 caracteres permitidos', true);
                } else if (value) {
                    const remaining = 500 - value.length;
                    hideValidationMessageCrear(this);
                    
                    // CAMBIO: Mensaje de éxito con debounce
                    this.successDebounce = setTimeout(() => {
                        showValidationMessageCrear(this, `${remaining} caracteres restantes`, false);
                    }, 500);
                } else {
                    hideValidationMessageCrear(this);
                }
            });
        }
    });

    // ========== FILE UPLOAD DRAG & DROP ==========
    const fileUploadArea = document.getElementById('fileUploadArea');
    const fileInput = document.getElementById('ruta_imagen');
    const filePreview = document.getElementById('filePreview');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');
    
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        fileUploadArea.addEventListener(eventName, preventDefaults, false);
        document.body.addEventListener(eventName, preventDefaults, false);
    });
    
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    ['dragenter', 'dragover'].forEach(eventName => {
        fileUploadArea.addEventListener(eventName, highlight, false);
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        fileUploadArea.addEventListener(eventName, unhighlight, false);
    });
    
    function highlight() {
        fileUploadArea.classList.add('dragover');
    }
    
    function unhighlight() {
        fileUploadArea.classList.remove('dragover');
    }
    
    fileUploadArea.addEventListener('drop', handleDrop, false);
    
    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        
        if (files.length > 0) {
            fileInput.files = files;
            handleFileSelect(fileInput);
        }
    }
    
    function handleFileSelect(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const size = (file.size / 1024 / 1024).toFixed(2);
            
            // Validar tamaño máximo (2MB)
            if (parseFloat(size) > 2) {
                alert('El archivo excede el tamaño máximo permitido de 2MB');
                removeFile();
                return;
            }
            
            // Validar tipo de archivo
            const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
            if (!validTypes.includes(file.type)) {
                alert('Solo se permiten archivos JPG, PNG o GIF');
                removeFile();
                return;
            }
            
            fileName.textContent = file.name;
            fileSize.textContent = `${size} MB`;
            filePreview.classList.add('show');
            fileUploadArea.style.display = 'none';
        }
    }
    
    function removeFile() {
        fileInput.value = '';
        filePreview.classList.remove('show');
        fileUploadArea.style.display = 'block';
    }

    // ========== CRITERIOS DINÁMICOS ==========
    function agregarCriterio() {
        criterioCount++;
        const container = document.getElementById('criterios-container');
        
        const criterioHtml = `
            <div class="criterio-card" data-criterio="${criterioCount}">
                <span class="criterio-number">Criterio ${criterioCount}</span>
                <div class="criterio-grid">
                    <div class="input-group-crear">
                        <label class="form-label">Nombre del criterio</label>
                        <input type="text" 
                               name="criterios[${criterioCount - 1}][nombre]" 
                               class="neuro-input criterio-nombre-crear" 
                               required 
                               maxlength="85"
                               placeholder="Ej: Funcionalidad">
                        <small class="input-help-crear">Solo letras y espacios, máximo 85 caracteres</small>
                    </div>
                    <div class="input-group-crear">
                        <label class="form-label">Descripción (opcional)</label>
                        <input type="text" 
                               name="criterios[${criterioCount - 1}][descripcion]" 
                               class="neuro-input criterio-descripcion-crear" 
                               maxlength="250"
                               placeholder="Ej: Calidad del código">
                        <small class="input-help-crear">Máximo 250 caracteres</small>
                    </div>
                    <div class="input-group-crear">
                        <label class="form-label">Porcentaje</label>
                        <div class="ponderacion-input-wrapper">
                            <input type="number" 
                                   name="criterios[${criterioCount - 1}][ponderacion]" 
                                   class="neuro-input ponderacion-input criterio-ponderacion-crear" 
                                   required 
                                   min="1" 
                                   max="100" 
                                   placeholder="25" 
                                   oninput="calcularTotal()">
                            <span class="ponderacion-suffix">%</span>
                        </div>
                        <small class="input-help-crear">Entre 1% y 100%</small>
                    </div>
                    <button type="button" class="btn-remove-criterio" onclick="eliminarCriterio(this)">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        <p>Eliminar Criterio</p>
                    </button>
                </div>
            </div>
        `;
        
        container.insertAdjacentHTML('beforeend', criterioHtml);
        setupCriterioValidationsCrear();
        calcularTotal();
    }

    function eliminarCriterio(button) {
        const card = button.closest('.criterio-card');
        card.remove();
        renumerarCriterios();
        calcularTotal();
    }

    function renumerarCriterios() {
        const cards = document.querySelectorAll('.criterio-card');
        cards.forEach((card, index) => {
            card.querySelector('.criterio-number').textContent = `Criterio ${index + 1}`;
            card.querySelectorAll('input').forEach(input => {
                const name = input.getAttribute('name');
                if (name) {
                    input.setAttribute('name', name.replace(/criterios\[\d+\]/, `criterios[${index}]`));
                }
            });
        });
        criterioCount = cards.length;
    }

    function calcularTotal() {
        const inputs = document.querySelectorAll('.ponderacion-input');
        let total = 0;
        
        inputs.forEach(input => {
            const value = parseInt(input.value) || 0;
            total += value;
        });

        const totalElement = document.getElementById('ponderacion-total-value');
        const statusElement = document.getElementById('ponderacion-status');
        const submitBtn = document.getElementById('submitBtn');

        totalElement.textContent = total + '%';

        if (total === 100) {
            totalElement.className = 'ponderacion-total-value complete';
            statusElement.textContent = '✓ ¡Perfecto!';
            statusElement.className = 'ponderacion-status text-green-600';
            submitBtn.disabled = false;
        } else if (total > 100) {
            totalElement.className = 'ponderacion-total-value incomplete';
            statusElement.textContent = `(Excede por ${total - 100}%)`;
            statusElement.className = 'ponderacion-status text-red-500';
            submitBtn.disabled = true;
        } else {
            totalElement.className = 'ponderacion-total-value incomplete';
            statusElement.textContent = `(Faltan ${100 - total}%)`;
            statusElement.className = 'ponderacion-status text-red-500';
            submitBtn.disabled = true;
        }
    }
</script>
@endsection