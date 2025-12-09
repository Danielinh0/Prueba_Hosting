@extends('layouts.app')

@section('content')

<div class="editar-equipo-page py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('admin.equipos.show', $equipo) }}" class="back-link">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver al equipo
        </a>

        <!-- Hero Section -->
        <div class="hero-section">
            <h1 class="hero-title">Editar Equipo</h1>
            <p class="hero-subtitle">{{ $equipo->nombre }}</p>
        </div>
        
        <div class="main-card">
            @if (session('error'))
                <div class="alert-error" role="alert">
                    <p class="font-bold">Error</p>
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert-error" role="alert">
                    <p class="font-bold">¡Ups! Hubo algunos problemas.</p>
                    <ul class="mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.equipos.update', $equipo) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Nombre del Equipo -->
                <div class="input-group-equipo">
                    <label for="nombre" class="form-label">Nombre del Equipo</label>
                    <input type="text" 
                           name="nombre" 
                           id="nombre" 
                           class="neuro-input" 
                           value="{{ old('nombre', $equipo->nombre) }}" 
                           maxlength="85"
                           required 
                           autofocus>
                    <small class="input-help-equipo">Máximo 85 caracteres</small>
                    <p class="help-text">Este es el nombre con el que el equipo será identificado.</p>
                </div>

                <div class="mt-6">
                    <label for="ruta_imagen" class="form-label">Imagen del Equipo (Opcional)</label>
                    
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
                    
                    <p class="help-text">Formatos permitidos: JPG, PNG, GIF. Tamaño máximo: 2MB.</p>
                </div>

                <!-- Botones de Acción -->
                <div class="action-buttons">
                    <a href="{{ route('admin.equipos.show', $equipo) }}" class="btn-cancel">
                        Cancelar
                    </a>
                    <button type="submit" class="btn-submit">
                        Actualizar Equipo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Estilos para validación */
    .input-group-equipo {
        position: relative;
    }

    .input-help-equipo {
        display: block;
        margin-top: 5px;
        font-size: 0.75rem;
        color: rgba(107, 114, 128, 0.8);
        margin-left: 5px;
        font-family: 'Poppins', sans-serif;
    }

    .validation-message-equipo {
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
    .validation-message-equipo.show {
        display: flex !important;
        animation: slideInEquipo 0.3s ease-out;
    }

    /* Animación de salida */
    .validation-message-equipo.hide {
        animation: slideOutEquipo 0.3s ease-out forwards;
    }

    @keyframes slideInEquipo {
        from {
            opacity: 0;
            transform: translateY(-8px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideOutEquipo {
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
    .validation-message-equipo.error {
        background: rgba(239, 68, 68, 0.2);
        border-left: 4px solid #ef4444;
        color: #fc7373ff;
    }

    .validation-message-equipo.error i {
        color: #ef4444;
        font-size: 0.9rem;
    }

    .validation-message-equipo.success {
        background: rgba(40, 167, 69, 0.2);
        border-left: 4px solid #28a745;
        color: #53a953ff;
    }

    .validation-message-equipo.success i {
        color: #28a745;
        font-size: 0.9rem;
    }

    /* Borde de error es ROJO */
    .neuro-input.error {
        border-color: #ef4444 !important;
        background: rgba(239, 68, 68, 0.1) !important;
        animation: shakeEquipo 0.5s ease-in-out;
    }

    .neuro-input.success {
        border-color: #28a745 !important;
        background: rgba(40, 167, 69, 0.1) !important;
    }

    @keyframes shakeEquipo {
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
    
    function showValidationMessageEquipo(input, message, isError = true) {
        let messageDiv = input.parentElement.querySelector('.validation-message-equipo');
        
        if (!messageDiv) {
            messageDiv = document.createElement('div');
            messageDiv.className = 'validation-message-equipo';
            input.parentElement.appendChild(messageDiv);
        }
        
        // Remover clases anteriores
        messageDiv.classList.remove('error', 'success', 'show', 'hide');
        
        // Agregar nuevas clases
        messageDiv.className = `validation-message-equipo ${isError ? 'error' : 'success'} show`;
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

    function hideValidationMessageEquipo(input) {
        const messageDiv = input.parentElement.querySelector('.validation-message-equipo');
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
    // CONFIGURACIÓN AL CARGAR EL DOM
    // ============================================
    
    document.addEventListener('DOMContentLoaded', function() {
        
        // ============================================
        // VALIDACIÓN: NOMBRE DEL EQUIPO
        // ============================================
        const nombreEquipo = document.getElementById('nombre');
        if (nombreEquipo) {
            nombreEquipo.addEventListener('input', function() {
                const value = this.value;
                
                clearTimeout(this.successDebounce);
                
                if (value.length > 85) {
                    this.value = value.substring(0, 85);
                    showValidationMessageEquipo(this, 'Máximo 85 caracteres permitidos', true);
                } else if (value) {
                    hideValidationMessageEquipo(this);
                    
                    // Mensaje de éxito con debounce (500ms después de dejar de teclear)
                    this.successDebounce = setTimeout(() => {
                        const remaining = 85 - value.length;
                        showValidationMessageEquipo(this, `${remaining} caracteres restantes`, false);
                    }, 500);
                } else {
                    hideValidationMessageEquipo(this);
                }
            });

            nombreEquipo.addEventListener('blur', function() {
                clearTimeout(this.successDebounce);
                if (this.value) {
                    const remaining = 85 - this.value.length;
                    showValidationMessageEquipo(this, `${remaining} caracteres restantes`, false);
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