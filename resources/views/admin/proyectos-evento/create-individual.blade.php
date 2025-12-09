@extends('layouts.app')

@section('content')

<div class="proyecto-individual-page-acpi py-12">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('admin.proyectos-evento.asignar', $evento) }}" class="back-link-acpi">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver a Asignaciones
            </a>
            <h2 class="font-semibold text-2xl">
                Asignar Proyecto Individual
            </h2>
            <p class="mt-1">{{ $evento->nombre }}</p>
            
            {{-- Info del equipo --}}
            <div class="equipo-info-box-acpi">
                <div class="flex items-center justify-between">
                    <div>
                        <h3>{{ $inscripcion->equipo->nombre }}</h3>
                        <p class="mt-1">
                            {{ $inscripcion->equipo->miembros->count() }} integrantes
                        </p>
                    </div>
                    <div class="text-right">
                        <span class="codigo-label-acpi">Código de equipo:</span>
                        <div class="codigo-value-acpi">{{ $inscripcion->codigo_acceso_equipo }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="main-card-acpi">
            <form action="{{ route('admin.proyectos-evento.store-individual', [$evento, $inscripcion]) }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Título --}}
                <div class="mb-6 input-group-acpi">
                    <label for="titulo" class="form-label-acpi">
                        Título del Proyecto <span class="required-asterisk-acpi">*</span>
                    </label>
                    <input type="text" name="titulo" id="titulo" 
                           value="{{ old('titulo') }}"
                           class="neuro-input-acpi"
                           required maxlength="200"
                           placeholder="Ej: Desarrollar sistema de gestión de inventario">
                    <small class="input-help-acpi">Máximo 200 caracteres</small>
                    @error('titulo')
                        <p class="error-message-acpi">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Descripción Completa --}}
                <div class="mb-6 input-group-acpi">
                    <label for="descripcion_completa" class="form-label-acpi">
                        Descripción Completa
                    </label>
                    <textarea name="descripcion_completa" id="descripcion_completa" rows="6"
                              class="neuro-textarea-acpi"
                              maxlength="2000"
                              placeholder="Describe detalladamente el proyecto específico para este equipo...">{{ old('descripcion_completa') }}</textarea>
                    <small class="input-help-acpi">Máximo 2000 caracteres. Puedes usar Markdown para formatear el texto</small>
                    @error('descripcion_completa')
                        <p class="error-message-acpi">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Objetivo --}}
                <div class="mb-6 input-group-acpi">
                    <label for="objetivo" class="form-label-acpi">
                        Objetivo del Proyecto
                    </label>
                    <textarea name="objetivo" id="objetivo" rows="3"
                              class="neuro-textarea-acpi"
                              maxlength="500"
                              placeholder="¿Qué debe lograr este equipo con este proyecto?">{{ old('objetivo') }}</textarea>
                    <small class="input-help-acpi">Máximo 500 caracteres</small>
                    @error('objetivo')
                        <p class="error-message-acpi">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Requisitos --}}
                <div class="mb-6 input-group-acpi">
                    <label for="requisitos" class="form-label-acpi">
                        Requisitos Técnicos
                    </label>
                    <textarea name="requisitos" id="requisitos" rows="4"
                              class="neuro-textarea-acpi"
                              maxlength="1000"
                              placeholder="Tecnologías, herramientas, conocimientos específicos para este proyecto...">{{ old('requisitos') }}</textarea>
                    <small class="input-help-acpi">Máximo 1000 caracteres</small>
                    @error('requisitos')
                        <p class="error-message-acpi">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Premios --}}
                <div class="mb-6 input-group-acpi">
                    <label for="premios" class="form-label-acpi">
                        Premios y Reconocimientos
                    </label>
                    <textarea name="premios" id="premios" rows="3"
                              class="neuro-textarea-acpi"
                              maxlength="500"
                              placeholder="Premios si este equipo gana...">{{ old('premios') }}</textarea>
                    <small class="input-help-acpi">Máximo 500 caracteres</small>
                    @error('premios')
                        <p class="error-message-acpi">{{ $message }}</p>
                    @enderror
                </div>

                <hr class="section-divider-acpi">

                {{-- Archivo de Bases --}}
                <div class="mb-6">
                    <label for="archivo_bases" class="form-label-acpi">
                        📄 Archivo de Bases (PDF)
                    </label>

                    {{-- Área de drag and drop --}}
                    <div class="file-upload-area-acpi" id="fileUploadAreaBases">
                        <div class="file-upload-content-acpi">
                            <svg class="file-upload-icon-acpi" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p class="file-upload-text-acpi">
                                <strong>Arrastra un archivo aquí o haz clic para seleccionar</strong>
                            </p>
                            <p class="file-upload-hint-acpi">
                                PDF, DOC, DOCX - Máximo 20MB
                            </p>
                        </div>
                        <input type="file" 
                               name="archivo_bases" 
                               id="archivo_bases" 
                               accept=".pdf,.doc,.docx"
                               class="neuro-file-acpi"
                               onchange="handleFileSelectAcpi(this, 'Bases')">
                    </div>
                    
                    {{-- Preview del archivo seleccionado --}}
                    <div id="filePreviewBases" class="file-preview-acpi">
                        <div class="file-preview-icon-acpi">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div class="file-preview-info-acpi">
                            <div class="file-preview-name-acpi" id="fileNameBases"></div>
                            <div class="file-preview-size-acpi" id="fileSizeBases"></div>
                        </div>
                        <button type="button" class="file-preview-remove-acpi" onclick="removeFileAcpi('Bases')">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <p class="helper-text-acpi">PDF, DOC o DOCX - Máximo 20MB</p>
                    @error('archivo_bases')
                        <p class="error-message-acpi">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Archivo de Recursos --}}
                <div class="mb-6">
                    <label for="archivo_recursos" class="form-label-acpi">
                        📦 Recursos Específicos (ZIP)
                    </label>

                    {{-- Área de drag and drop --}}
                    <div class="file-upload-area-acpi" id="fileUploadAreaRecursos">
                        <div class="file-upload-content-acpi">
                            <svg class="file-upload-icon-acpi" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z"></path>
                            </svg>
                            <p class="file-upload-text-acpi">
                                <strong>Arrastra un archivo aquí o haz clic para seleccionar</strong>
                            </p>
                            <p class="file-upload-hint-acpi">
                                ZIP, RAR, PDF - Máximo 50MB
                            </p>
                        </div>
                        <input type="file" 
                               name="archivo_recursos" 
                               id="archivo_recursos" 
                               accept=".zip,.rar,.pdf"
                               class="neuro-file-acpi"
                               onchange="handleFileSelectAcpi(this, 'Recursos')">
                    </div>
                    
                    {{-- Preview del archivo seleccionado --}}
                    <div id="filePreviewRecursos" class="file-preview-acpi">
                        <div class="file-preview-icon-acpi">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div class="file-preview-info-acpi">
                            <div class="file-preview-name-acpi" id="fileNameRecursos"></div>
                            <div class="file-preview-size-acpi" id="fileSizeRecursos"></div>
                        </div>
                        <button type="button" class="file-preview-remove-acpi" onclick="removeFileAcpi('Recursos')">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <p class="helper-text-acpi">ZIP, RAR o PDF - Máximo 50MB</p>
                    @error('archivo_recursos')
                        <p class="error-message-acpi">{{ $message }}</p>
                    @enderror
                </div>

                {{-- URL Externa --}}
                <div class="mb-6 input-group-acpi">
                    <label for="url_externa" class="form-label-acpi">
                        🔗 URL a Recursos Externos
                    </label>
                    <input type="url" name="url_externa" id="url_externa" 
                           value="{{ old('url_externa') }}"
                           class="neuro-input-acpi"
                           maxlength="500"
                           placeholder="https://drive.google.com/...">
                    <small class="input-help-acpi">Google Drive, Dropbox, etc. Máximo 500 caracteres</small>
                    @error('url_externa')
                        <p class="error-message-acpi">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Botones --}}
                <div class="flex justify-end space-x-3 pt-6" style="border-top: 1px solid rgba(232, 154, 60, 0.2);">
                    <a href="{{ route('admin.proyectos-evento.asignar', $evento) }}" class="button-secondary-acpi">
                        Cancelar
                    </a>
                    <button type="submit" class="button-primary-acpi">
                        Asignar Proyecto
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- FontAwesome para iconos -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
    // ============================================
    // DRAG AND DROP FILE UPLOAD
    // ============================================
    
    // Setup para ambos archivos
    function setupDragAndDropAcpi(uploadAreaId, fileInputId) {
        const fileUploadArea = document.getElementById(uploadAreaId);
        const fileInput = document.getElementById(fileInputId);
        
        if (!fileUploadArea || !fileInput) return;
        
        // Prevenir comportamiento por defecto
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            fileUploadArea.addEventListener(eventName, preventDefaultsAcpi, false);
        });
        
        // Highlight en drag over
        ['dragenter', 'dragover'].forEach(eventName => {
            fileUploadArea.addEventListener(eventName, () => highlightAcpi(fileUploadArea), false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            fileUploadArea.addEventListener(eventName, () => unhighlightAcpi(fileUploadArea), false);
        });
        
        // Manejar el drop
        fileUploadArea.addEventListener('drop', (e) => handleDropAcpi(e, fileInput), false);
    }
    
    function preventDefaultsAcpi(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    function highlightAcpi(element) {
        element.classList.add('dragover');
    }
    
    function unhighlightAcpi(element) {
        element.classList.remove('dragover');
    }
    
    function handleDropAcpi(e, fileInput) {
        const dt = e.dataTransfer;
        const files = dt.files;
        
        if (files.length > 0) {
            fileInput.files = files;
            const tipo = fileInput.id.includes('bases') ? 'Bases' : 'Recursos';
            handleFileSelectAcpi(fileInput, tipo);
        }
    }
    
    // Manejar selección de archivo
    function handleFileSelectAcpi(input, tipo) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const size = (file.size / 1024 / 1024).toFixed(2); // Size in MB
            
            // Actualizar preview
            const fileNameElement = document.getElementById('fileName' + tipo);
            const fileSizeElement = document.getElementById('fileSize' + tipo);
            const filePreview = document.getElementById('filePreview' + tipo);
            const uploadArea = document.getElementById('fileUploadArea' + tipo);
            
            fileNameElement.textContent = file.name;
            fileSizeElement.textContent = `${size} MB`;
            filePreview.classList.add('show');
            
            // Ocultar área de upload
            uploadArea.style.display = 'none';
        }
    }
    
    // Remover archivo
    function removeFileAcpi(tipo) {
        const fileInput = document.getElementById('archivo_' + tipo.toLowerCase());
        const filePreview = document.getElementById('filePreview' + tipo);
        const uploadArea = document.getElementById('fileUploadArea' + tipo);
        
        fileInput.value = '';
        filePreview.classList.remove('show');
        uploadArea.style.display = 'block';
    }

    // ============================================
    // FUNCIONES DE VALIDACIÓN EN TIEMPO REAL
    // ============================================
    
    function showValidationMessageAcpi(input, message, isError = true) {
        let messageDiv = input.parentElement.querySelector('.validation-message-acpi');
        
        if (!messageDiv) {
            messageDiv = document.createElement('div');
            messageDiv.className = 'validation-message-acpi';
            input.parentElement.appendChild(messageDiv);
        }
        
        messageDiv.classList.remove('error', 'success', 'show', 'hide');
        messageDiv.className = `validation-message-acpi ${isError ? 'error' : 'success'} show`;
        messageDiv.innerHTML = `
            <i class="fas fa-${isError ? 'exclamation-circle' : 'check-circle'}"></i>
            <span>${message}</span>
        `;
        
        input.classList.remove('error', 'success');
        input.classList.add(isError ? 'error' : 'success');
        
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

    function hideValidationMessageAcpi(input) {
        const messageDiv = input.parentElement.querySelector('.validation-message-acpi');
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
        
        // Setup drag and drop para ambos archivos
        setupDragAndDropAcpi('fileUploadAreaBases', 'archivo_bases');
        setupDragAndDropAcpi('fileUploadAreaRecursos', 'archivo_recursos');
        
        // Validaciones de campos de texto (título, descripción, etc.)
        const titulo = document.getElementById('titulo');
        if (titulo) {
            titulo.addEventListener('input', function() {
                const value = this.value;
                clearTimeout(this.successDebounce);
                
                if (value.length > 200) {
                    this.value = value.substring(0, 200);
                    showValidationMessageAcpi(this, 'Máximo 200 caracteres permitidos', true);
                } else if (value) {
                    hideValidationMessageAcpi(this);
                    this.successDebounce = setTimeout(() => {
                        const remaining = 200 - value.length;
                        showValidationMessageAcpi(this, `${remaining} caracteres restantes`, false);
                    }, 500);
                } else {
                    hideValidationMessageAcpi(this);
                }
            });
        }

        const descripcion = document.getElementById('descripcion_completa');
        if (descripcion) {
            descripcion.addEventListener('input', function() {
                const value = this.value;
                clearTimeout(this.successDebounce);
                
                if (value.length > 2000) {
                    this.value = value.substring(0, 2000);
                    showValidationMessageAcpi(this, 'Máximo 2000 caracteres permitidos', true);
                } else if (value) {
                    hideValidationMessageAcpi(this);
                    this.successDebounce = setTimeout(() => {
                        const remaining = 2000 - value.length;
                        showValidationMessageAcpi(this, `${remaining} caracteres restantes`, false);
                    }, 500);
                } else {
                    hideValidationMessageAcpi(this);
                }
            });
        }

        const objetivo = document.getElementById('objetivo');
        if (objetivo) {
            objetivo.addEventListener('input', function() {
                const value = this.value;
                clearTimeout(this.successDebounce);
                
                if (value.length > 500) {
                    this.value = value.substring(0, 500);
                    showValidationMessageAcpi(this, 'Máximo 500 caracteres permitidos', true);
                } else if (value) {
                    hideValidationMessageAcpi(this);
                    this.successDebounce = setTimeout(() => {
                        const remaining = 500 - value.length;
                        showValidationMessageAcpi(this, `${remaining} caracteres restantes`, false);
                    }, 500);
                } else {
                    hideValidationMessageAcpi(this);
                }
            });
        }

        const requisitos = document.getElementById('requisitos');
        if (requisitos) {
            requisitos.addEventListener('input', function() {
                const value = this.value;
                clearTimeout(this.successDebounce);
                
                if (value.length > 1000) {
                    this.value = value.substring(0, 1000);
                    showValidationMessageAcpi(this, 'Máximo 1000 caracteres permitidos', true);
                } else if (value) {
                    hideValidationMessageAcpi(this);
                    this.successDebounce = setTimeout(() => {
                        const remaining = 1000 - value.length;
                        showValidationMessageAcpi(this, `${remaining} caracteres restantes`, false);
                    }, 500);
                } else {
                    hideValidationMessageAcpi(this);
                }
            });
        }

        const premios = document.getElementById('premios');
        if (premios) {
            premios.addEventListener('input', function() {
                const value = this.value;
                clearTimeout(this.successDebounce);
                
                if (value.length > 500) {
                    this.value = value.substring(0, 500);
                    showValidationMessageAcpi(this, 'Máximo 500 caracteres permitidos', true);
                } else if (value) {
                    hideValidationMessageAcpi(this);
                    this.successDebounce = setTimeout(() => {
                        const remaining = 500 - value.length;
                        showValidationMessageAcpi(this, `${remaining} caracteres restantes`, false);
                    }, 500);
                } else {
                    hideValidationMessageAcpi(this);
                }
            });
        }

        const urlExterna = document.getElementById('url_externa');
        if (urlExterna) {
            urlExterna.addEventListener('input', function() {
                const value = this.value;
                clearTimeout(this.successDebounce);
                
                if (value.length > 500) {
                    this.value = value.substring(0, 500);
                    showValidationMessageAcpi(this, 'Máximo 500 caracteres permitidos', true);
                } else if (value) {
                    hideValidationMessageAcpi(this);
                    this.successDebounce = setTimeout(() => {
                        const urlRegex = /^https?:\/\/.+/;
                        if (!urlRegex.test(value)) {
                            showValidationMessageAcpi(this, 'URL debe comenzar con http:// o https://', true);
                        } else {
                            showValidationMessageAcpi(this, 'URL válida', false);
                        }
                    }, 500);
                } else {
                    hideValidationMessageAcpi(this);
                }
            });
        }

        // Validación de archivos
        const archivoBasesInput = document.getElementById('archivo_bases');
        if (archivoBasesInput) {
            archivoBasesInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const file = this.files[0];
                    const size = file.size / 1024 / 1024;
                    
                    if (size > 20) {
                        alert('El archivo excede el tamaño máximo permitido de 20MB');
                        this.value = '';
                        removeFileAcpi('Bases');
                        return;
                    }
                    
                    const validTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
                    if (!validTypes.includes(file.type)) {
                        alert('Solo se permiten archivos PDF, DOC o DOCX');
                        this.value = '';
                        removeFileAcpi('Bases');
                    }
                }
            });
        }

        const archivoRecursosInput = document.getElementById('archivo_recursos');
        if (archivoRecursosInput) {
            archivoRecursosInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const file = this.files[0];
                    const size = file.size / 1024 / 1024;
                    
                    if (size > 50) {
                        alert('El archivo excede el tamaño máximo permitido de 50MB');
                        this.value = '';
                        removeFileAcpi('Recursos');
                        return;
                    }
                    
                    const validTypes = ['application/zip', 'application/x-rar-compressed', 'application/pdf'];
                    const validExtensions = ['.zip', '.rar', '.pdf'];
                    const fileName = file.name.toLowerCase();
                    const hasValidExtension = validExtensions.some(ext => fileName.endsWith(ext));
                    
                    if (!validTypes.includes(file.type) && !hasValidExtension) {
                        alert('Solo se permiten archivos ZIP, RAR o PDF');
                        this.value = '';
                        removeFileAcpi('Recursos');
                    }
                }
            });
        }
    });
</script>

@endsection