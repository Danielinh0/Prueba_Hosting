@extends('layouts.app')

@section('content')

<div class="evento-edit-page py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('admin.eventos.index') }}" class="back-link">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver a Gestión de Eventos
        </a>
        <div class="flex items-center mb-6">
            <h2 class="font-semibold text-xl ml-2">
                {{ __('Editar Evento') }}
            </h2>
        </div>
        
        <div class="main-card">
            @if ($errors->any())
                <div class="alert-error">
                    <strong>¡Ups!</strong> Hubo algunos problemas con tus datos.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.eventos.update', $evento) }}" method="POST" enctype="multipart/form-data"
                  x-data="{
                      criterios: {{ json_encode($evento->criteriosEvaluacion->map(fn($c) => ['nombre' => $c->nombre, 'descripcion' => $c->descripcion ?? '', 'ponderacion' => $c->ponderacion])->values()->toArray()) }},
                      get totalPonderacion() {
                          return this.criterios.reduce((sum, c) => sum + (parseFloat(c.ponderacion) || 0), 0);
                      },
                      agregarCriterio() {
                          this.criterios.push({ nombre: '', descripcion: '', ponderacion: 0 });
                          setTimeout(() => {
                              setupCriterioValidations();
                          }, 100);
                      },
                      eliminarCriterio(index) {
                          if (this.criterios.length > 1) {
                              this.criterios.splice(index, 1);
                          }
                      }
                  }">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nombre del Evento -->
                    <div class="input-group-eventos">
                        <label for="nombre" class="form-label">Nombre del Evento</label>
                        <input type="text" 
                               name="nombre" 
                               id="nombre" 
                               class="neuro-input" 
                               value="{{ old('nombre', $evento->nombre) }}" 
                               maxlength="85"
                               required>
                        <small class="input-help-eventos">Máximo 85 caracteres</small>
                    </div>

                    <!-- Cupo Máximo de Equipos -->
                    <div class="input-group-eventos">
                        <label for="cupo_max_equipos" class="form-label">Cupo Máximo de Equipos</label>
                        <input type="number" 
                               name="cupo_max_equipos" 
                               id="cupo_max_equipos" 
                               class="neuro-input" 
                               value="{{ old('cupo_max_equipos', $evento->cupo_max_equipos) }}" 
                               required 
                               min="1"
                               max="999">
                        <small class="input-help-eventos">Mínimo 1, máximo 999 equipos</small>
                    </div>

                    <!-- Fecha de Inicio -->
                    <div class="input-group-eventos">
                        <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                        <input type="date" 
                               name="fecha_inicio" 
                               id="fecha_inicio" 
                               class="neuro-input" 
                               value="{{ old('fecha_inicio', $evento->fecha_inicio->format('Y-m-d')) }}" 
                               required>
                        <small class="input-help-eventos">Debe ser posterior a hoy</small>
                    </div>

                    <!-- Fecha de Fin -->
                    <div class="input-group-eventos">
                        <label for="fecha_fin" class="form-label">Fecha de Fin</label>
                        <input type="date" 
                               name="fecha_fin" 
                               id="fecha_fin" 
                               class="neuro-input" 
                               value="{{ old('fecha_fin', $evento->fecha_fin->format('Y-m-d')) }}" 
                               required>
                        <small class="input-help-eventos">Debe ser posterior a la fecha de inicio</small>
                    </div>
                </div>

                <!-- Descripción -->
                <div class="mt-6 input-group-eventos">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea name="descripcion" 
                              id="descripcion" 
                              rows="4" 
                              class="neuro-textarea"
                              maxlength="500">{{ old('descripcion', $evento->descripcion) }}</textarea>
                    <small class="input-help-eventos">Máximo 500 caracteres</small>
                </div>

                <!-- Imagen del Evento -->
                <div class="mt-6">
                    <label for="ruta_imagen" class="form-label">Nueva Imagen del Evento (Opcional)</label>
                    
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

                <!-- Imagen Actual -->
                @if ($evento->ruta_imagen)
                <div class="image-preview-current">
                    <label class="form-label">Imagen Actual del Evento</label>
                    <div class="current-image-container">
                        <img src="{{ asset('storage/' . $evento->ruta_imagen) }}" alt="Imagen actual del evento">
                        <p class="current-image-label">Esta imagen se mantendrá si no subes una nueva</p>
                    </div>
                </div>
                @endif

                <!-- Criterios de Evaluación -->
                <div class="criterios-section">
                    <div class="criterios-header">
                        <h3 class="criterios-title">📋 Criterios de Evaluación</h3>
                        @if($evento->puedeCambiarCriterios())
                            <div class="ponderacion-counter">
                                <span>Total:</span>
                                <span class="ponderacion-value" 
                                      :class="{
                                          'ponderacion-ok': Math.abs(totalPonderacion - 100) < 0.01,
                                          'ponderacion-warning': totalPonderacion > 0 && totalPonderacion < 100,
                                          'ponderacion-error': totalPonderacion > 100
                                      }"
                                      x-text="totalPonderacion.toFixed(0) + '%'">0%</span>
                            </div>
                        @endif
                    </div>

                    @if($evento->puedeCambiarCriterios())
                        <div class="info-box">
                            <p><strong>💡 Ponderación:</strong> Cada criterio tiene un porcentaje que indica su peso en la calificación final. La suma de todos los criterios debe ser exactamente <strong>100%</strong>.</p>
                        </div>

                        <!-- Lista de criterios dinámicos -->
                        <template x-for="(criterio, index) in criterios" :key="index">
                            <div class="criterio-item">
                                <div class="criterio-header">
                                    <span class="criterio-number" x-text="'Criterio #' + (index + 1)"></span>
                                    <button type="button" 
                                            class="remove-criterio-btn" 
                                            x-show="criterios.length > 1"
                                            @click="eliminarCriterio(index)">
                                        ✕ Eliminar
                                    </button>
                                </div>
                                <div class="criterio-row">
                                    <div class="input-group-eventos criterio-input-wrapper">
                                        <label class="form-label">Nombre *</label>
                                        <input type="text" 
                                               :name="'criterios[' + index + '][nombre]'"
                                               :id="'criterio_nombre_' + index"
                                               x-model="criterio.nombre"
                                               class="neuro-input criterio-nombre-input"
                                               placeholder="Ej: Innovación"
                                               maxlength="85"
                                               required>
                                        <small class="input-help-eventos">Solo letras y espacios, máximo 85 caracteres</small>
                                    </div>
                                    <div class="input-group-eventos criterio-input-wrapper">
                                        <label class="form-label">Descripción</label>
                                        <input type="text" 
                                               :name="'criterios[' + index + '][descripcion]'"
                                               :id="'criterio_descripcion_' + index"
                                               x-model="criterio.descripcion"
                                               class="neuro-input criterio-descripcion-input"
                                               placeholder="Descripción opcional del criterio"
                                               maxlength="250">
                                        <small class="input-help-eventos">Máximo 250 caracteres</small>
                                    </div>
                                    <div class="input-group-eventos criterio-input-wrapper">
                                        <label class="form-label">Pond. %</label>
                                        <input type="number" 
                                               :name="'criterios[' + index + '][ponderacion]'"
                                               :id="'criterio_ponderacion_' + index"
                                               x-model.number="criterio.ponderacion"
                                               class="neuro-input criterio-ponderacion-input"
                                               min="1"
                                               max="100"
                                               step="1"
                                               required>
                                        <small class="input-help-eventos">Entre 1% y 100%</small>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <!-- Botón agregar criterio -->
                        <button type="button" 
                                class="add-criterio-btn"
                                @click="agregarCriterio()">
                            + Agregar Criterio
                        </button>

                        <!-- Validación visual -->
                        <div x-show="totalPonderacion !== 100" class="mt-4">
                            <p class="text-sm" :class="totalPonderacion > 100 ? 'text-red-600' : 'text-amber-600'" style="font-family: 'Poppins', sans-serif;">
                                <span x-show="totalPonderacion < 100">⚠️ Faltan <span x-text="(100 - totalPonderacion).toFixed(0)"></span>% para completar el 100%</span>
                                <span x-show="totalPonderacion > 100">❌ Excediste por <span x-text="(totalPonderacion - 100).toFixed(0)"></span>% el límite del 100%</span>
                            </p>
                        </div>
                        <div x-show="totalPonderacion === 100" class="mt-4">
                            <p class="text-sm text-green-600" style="font-family: 'Poppins', sans-serif;">✅ ¡Perfecto! Los criterios suman exactamente 100%</p>
                        </div>
                    @else
                        <div class="warning-box">
                            <p><strong>⚠️ Criterios bloqueados:</strong> No se pueden modificar los criterios porque el evento ya no está en estado "Próximo". Solo se pueden editar criterios cuando el evento aún no ha comenzado.</p>
                        </div>

                        <div class="readonly-criterios">
                            @forelse($evento->criteriosEvaluacion as $criterio)
                                <div class="readonly-criterio">
                                    <div>
                                        <span class="readonly-criterio-name">{{ $criterio->nombre }}</span>
                                        @if($criterio->descripcion)
                                            <span class="text-gray-500 text-sm ml-2">- {{ $criterio->descripcion }}</span>
                                        @endif
                                    </div>
                                    <span class="readonly-criterio-pond">{{ $criterio->ponderacion }}%</span>
                                </div>
                            @empty
                                <p class="text-gray-500 text-sm text-center py-4" style="font-family: 'Poppins', sans-serif;">No hay criterios definidos para este evento.</p>
                            @endforelse
                        </div>
                    @endif
                </div>

                <!-- Botón de Envío -->
                <div class="flex items-center justify-end mt-6">
                    <button type="submit" class="submit-button"
                            @if($evento->puedeCambiarCriterios())
                            :disabled="Math.abs(totalPonderacion - 100) >= 0.01"
                            :class="{ 'opacity-50 cursor-not-allowed': Math.abs(totalPonderacion - 100) >= 0.01 }"
                            @endif>
                        Actualizar Evento
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Estilos para validación */
    .input-group-eventos {
        position: relative;
    }

    .input-help-eventos {
        display: block;
        margin-top: 5px;
        font-size: 0.75rem;
        color: rgba(107, 114, 128, 0.8);
        margin-left: 5px;
        font-family: 'Poppins', sans-serif;
    }

    .validation-message-eventos {
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
    .validation-message-eventos.show {
        display: flex !important;
        animation: slideInEvento 0.3s ease-out;
    }

    /* Animación de salida */
    .validation-message-eventos.hide {
        animation: slideOutEvento 0.3s ease-out forwards;
    }

    @keyframes slideInEvento {
        from {
            opacity: 0;
            transform: translateY(-8px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideOutEvento {
        from {
            opacity: 1;
            transform: translateY(0);
        }
        to {
            opacity: 0;
            transform: translateY(-8px);
        }
    }

    /* Error ahora es ROJO */
    .validation-message-eventos.error {
        background: rgba(239, 68, 68, 0.2);
        border-left: 4px solid #ef4444;
        color: #fc7373ff;
    }

    .validation-message-eventos.error i {
        color: #ef4444;
        font-size: 0.9rem;
    }

    .validation-message-eventos.success {
        background: rgba(40, 167, 69, 0.2);
        border-left: 4px solid #28a745;
        color: #53a953ff;
    }

    .validation-message-eventos.success i {
        color: #28a745;
        font-size: 0.9rem;
    }

    /* Borde de error ahora es ROJO */
    .neuro-input.error, .neuro-textarea.error {
        border-color: #ef4444 !important;
        background: rgba(239, 68, 68, 0.1) !important;
        animation: shakeEvento 0.5s ease-in-out;
    }

    .neuro-input.success, .neuro-textarea.success {
        border-color: #28a745 !important;
        background: rgba(40, 167, 69, 0.1) !important;
    }

    @keyframes shakeEvento {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-3px); }
        20%, 40%, 60%, 80% { transform: translateX(3px); }
    }

    .criterio-input-wrapper {
        flex: 1;
    }
</style>

<!-- FontAwesome para iconos -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
    // ============================================
    // FUNCIONES DE VALIDACIÓN EN TIEMPO REAL
    // ============================================
    
    function showValidationMessageEvento(input, message, isError = true) {
        let messageDiv = input.parentElement.querySelector('.validation-message-eventos');
        
        if (!messageDiv) {
            messageDiv = document.createElement('div');
            messageDiv.className = 'validation-message-eventos';
            input.parentElement.appendChild(messageDiv);
        }
        
        // Remover clases anteriores
        messageDiv.classList.remove('error', 'success', 'show', 'hide');
        
        // Agregar nuevas clases
        messageDiv.className = `validation-message-eventos ${isError ? 'error' : 'success'} show`;
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

    function hideValidationMessageEvento(input) {
        const messageDiv = input.parentElement.querySelector('.validation-message-eventos');
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
    
    function setupCriterioValidations() {
        // Validar nombres de criterios en TIEMPO REAL
        document.querySelectorAll('.criterio-nombre-input').forEach(input => {
            // Remover listeners anteriores clonando el elemento
            const newInput = input.cloneNode(true);
            input.parentNode.replaceChild(newInput, input);
            
            newInput.addEventListener('input', function(e) {
                const value = this.value;
                const nameRegex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]*$/;

                // Limpiar debounce de éxito anterior
                clearTimeout(this.successDebounce);

                if (value && !nameRegex.test(value)) {
                    this.classList.add('error');
                    const cleanValue = value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
                    this.value = cleanValue;
                    this.dispatchEvent(new Event('input', { bubbles: true }));
                    showValidationMessageEvento(this, 'Solo se permiten letras, espacios y acentos', true);
                } else if (value.length > 85) {
                    const truncated = value.substring(0, 85);
                    this.value = truncated;
                    this.dispatchEvent(new Event('input', { bubbles: true }));
                    showValidationMessageEvento(this, 'Máximo 85 caracteres permitidos', true);
                } else if (value && nameRegex.test(value)) {
                    // CAMBIO: Mensaje de éxito con debounce
                    this.classList.remove('error');
                    hideValidationMessageEvento(this);
                    
                    this.successDebounce = setTimeout(() => {
                        showValidationMessageEvento(this, 'Nombre válido', false);
                    }, 500);
                } else {
                    this.classList.remove('error');
                    hideValidationMessageEvento(this);
                }
            });

            newInput.addEventListener('blur', function() {
                clearTimeout(this.successDebounce);
                const value = this.value;
                if (value && !/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(value)) {
                    this.classList.add('error');
                    showValidationMessageEvento(this, 'Solo se permiten letras, espacios y acentos', true);
                } else if (value) {
                    showValidationMessageEvento(this, 'Nombre válido', false);
                } else {
                    hideValidationMessageEvento(this);
                }
            });

            newInput.addEventListener('focus', function() {
                if (this.classList.contains('error')) {
                    setTimeout(() => {
                        this.classList.remove('error');
                        hideValidationMessageEvento(this);
                    }, 100);
                }
            });
        });

        // Validar descripciones de criterios
        document.querySelectorAll('.criterio-descripcion-input').forEach(input => {
            const newInput = input.cloneNode(true);
            input.parentNode.replaceChild(newInput, input);
            
            newInput.addEventListener('input', function() {
                const value = this.value;
                
                clearTimeout(this.successDebounce);
                
                if (value.length > 250) {
                    this.value = value.substring(0, 250);
                    this.dispatchEvent(new Event('input', { bubbles: true }));
                    showValidationMessageEvento(this, 'Máximo 250 caracteres permitidos', true);
                } else if (value) {
                    const remaining = 250 - value.length;
                    hideValidationMessageEvento(this);
                    
                    // CAMBIO: Mensaje de éxito con debounce
                    this.successDebounce = setTimeout(() => {
                        showValidationMessageEvento(this, `${remaining} caracteres restantes`, false);
                    }, 500);
                } else {
                    hideValidationMessageEvento(this);
                }
            });
        });

        // Validar ponderaciones
        document.querySelectorAll('.criterio-ponderacion-input').forEach(input => {
            const newInput = input.cloneNode(true);
            input.parentNode.replaceChild(newInput, input);
            
            newInput.addEventListener('input', function() {
                let value = parseInt(this.value);
                
                clearTimeout(this.successDebounce);
                
                if (isNaN(value)) {
                    hideValidationMessageEvento(this);
                    return;
                }
                
                if (value < 1) {
                    this.value = 1;
                    this.dispatchEvent(new Event('input', { bubbles: true }));
                    showValidationMessageEvento(this, 'El valor mínimo es 1%', true);
                } else if (value > 100) {
                    this.value = 100;
                    this.dispatchEvent(new Event('input', { bubbles: true }));
                    showValidationMessageEvento(this, 'El valor máximo es 100%', true);
                } else {
                    // CAMBIO: Mensaje de éxito con debounce
                    hideValidationMessageEvento(this);
                    
                    this.successDebounce = setTimeout(() => {
                        showValidationMessageEvento(this, 'Porcentaje válido', false);
                    }, 500);
                }
            });

            newInput.addEventListener('blur', function() {
                clearTimeout(this.successDebounce);
                if (!this.value || parseInt(this.value) < 1) {
                    this.value = 1;
                    this.dispatchEvent(new Event('input', { bubbles: true }));
                }
            });
        });
    }

    // ============================================
    // CONFIGURACIÓN AL CARGAR EL DOM
    // ============================================
    
    document.addEventListener('DOMContentLoaded', function() {
        
        // Configurar validaciones iniciales de criterios
        setupCriterioValidations();
        
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
                    showValidationMessageEvento(this, 'Máximo 85 caracteres permitidos', true);
                } else if (value) {
                    // CAMBIO: Mensaje de éxito con debounce
                    hideValidationMessageEvento(this);
                    
                    this.successDebounce = setTimeout(() => {
                        showValidationMessageEvento(this, 'Nombre válido', false);
                    }, 500);
                } else {
                    hideValidationMessageEvento(this);
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
                    hideValidationMessageEvento(this);
                    return;
                }
                
                if (value < 1) {
                    this.value = 1;
                    showValidationMessageEvento(this, 'El cupo mínimo es 1 equipo', true);
                } else if (value > 999) {
                    this.value = 999;
                    showValidationMessageEvento(this, 'El cupo máximo es 999 equipos', true);
                } else {
                    // CAMBIO: Mensaje de éxito con debounce
                    hideValidationMessageEvento(this);
                    
                    this.successDebounce = setTimeout(() => {
                        showValidationMessageEvento(this, 'Cupo válido', false);
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
                    showValidationMessageEvento(this, 'La fecha de inicio debe ser posterior a hoy', true);
                } else {
                    showValidationMessageEvento(this, 'Fecha de inicio válida', false);
                    
                    if (fechaFin) {
                        const fechaInicioObj = new Date(this.value);
                        const diaDesp = new Date(fechaInicioObj);
                        diaDesp.setDate(diaDesp.getDate() + 1);
                        const diaDespStr = diaDesp.toISOString().split('T')[0];
                        
                        fechaFin.setAttribute('min', diaDespStr);
                        
                        if (fechaFin.value && fechaFin.value <= this.value) {
                            fechaFin.value = '';
                            showValidationMessageEvento(fechaFin, 'La fecha de fin debe ser posterior a la de inicio', true);
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
                        showValidationMessageEvento(this, 'La fecha de fin debe ser posterior a la fecha de inicio', true);
                    } else {
                        showValidationMessageEvento(this, 'Fecha de fin válida', false);
                    }
                } else {
                    showValidationMessageEvento(this, 'Primero selecciona la fecha de inicio', true);
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
                    showValidationMessageEvento(this, 'Máximo 500 caracteres permitidos', true);
                } else if (value) {
                    const remaining = 500 - value.length;
                    hideValidationMessageEvento(this);
                    
                    // CAMBIO: Mensaje de éxito con debounce
                    this.successDebounce = setTimeout(() => {
                        showValidationMessageEvento(this, `${remaining} caracteres restantes`, false);
                    }, 500);
                } else {
                    hideValidationMessageEvento(this);
                }
            });
        }

    });

    // ============================================
    // FUNCIONES PARA MANEJO DE ARCHIVOS
    // ============================================
    
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
</script>

@endsection