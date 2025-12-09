@extends('layouts.app')

@section('content')

<div class="crear-equipo-page-eqcse">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="header-section-eqcse">
            <a href="{{ route('estudiante.equipo.index') }}" class="back-link-eqcse">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver a mis Equipos
            </a>
            <h2>Crear Equipo</h2>
            <p>Crea tu equipo con anticipación y regístralo a un evento cuando esté disponible</p>
        </div>

        <div class="main-card-eqcse">
            <form action="{{ route('estudiante.equipos.store-sin-evento') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Nombre del Equipo --}}
                <div class="form-section-eqcse">
                    <label for="nombre" class="form-label-eqcse">
                        Nombre del Equipo <span class="required-eqcse">*</span>
                    </label>
                    <input type="text" 
                           name="nombre" 
                           id="nombre" 
                           value="{{ old('nombre') }}"
                           class="neuro-input-eqcse @error('nombre') error-eqcse @enderror"
                           required 
                           maxlength="100"
                           placeholder="Ej: Caballeros del Código">
                    @error('nombre')
                        <span class="error-text-eqcse">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Descripción --}}
                <div class="form-section-eqcse">
                    <label for="descripcion" class="form-label-eqcse">
                        Descripción del Equipo
                    </label>
                    <textarea name="descripcion" 
                              id="descripcion" 
                              rows="4"
                              class="neuro-textarea-eqcse @error('descripcion') error-eqcse @enderror"
                              maxlength="1000"
                              placeholder="Describe a tu equipo, habilidades, intereses...">{{ old('descripcion') }}</textarea>
                    <span class="help-text-eqcse">Máximo 1000 caracteres</span>
                    @error('descripcion')
                        <span class="error-text-eqcse">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Imagen del Equipo - NUEVO DISEÑO --}}
                <div class="form-section-eqcse">
                    <label for="ruta_imagen" class="form-label-eqcse">
                        Logo/Imagen del Equipo
                    </label>
                    
                    {{-- Área de drag and drop --}}
                    <div class="file-upload-area-eqcse" id="fileUploadArea">
                        <div class="file-upload-content-eqcse">
                            <svg class="file-upload-icon-eqcse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            <p class="file-upload-text-eqcse">
                                <strong>Arrastra un archivo aquí o haz clic para seleccionar</strong>
                            </p>
                            <p class="file-upload-hint-eqcse">
                                JPG, PNG, SVG (Máx: 10MB)
                            </p>
                        </div>
                        <input type="file" 
                               name="ruta_imagen" 
                               id="ruta_imagen" 
                               accept="image/jpeg,image/png,image/jpg,image/gif"
                               class="neuro-file-eqcse @error('ruta_imagen') error-eqcse @enderror"
                               onchange="handleFileSelect(this)">
                    </div>
                    
                    {{-- Preview del archivo seleccionado --}}
                    <div id="filePreview" class="file-preview-eqcse">
                        <div class="file-preview-icon-eqcse">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div class="file-preview-info-eqcse">
                            <div class="file-preview-name-eqcse" id="fileName"></div>
                            <div class="file-preview-size-eqcse" id="fileSize"></div>
                        </div>
                        <button type="button" class="file-preview-remove-eqcse" onclick="removeFile()">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <span class="help-text-eqcse">Sube aqui una imagen para darle identidad a tu equipo</span>
                    @error('ruta_imagen')
                        <span class="error-text-eqcse">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Información Importante --}}
                <div class="info-box-eqcse">
                    <h3>
                        <span class="icon-eqcse">📌</span>
                        Importante:
                    </h3>
                    <ul>
                        <li>Serás automáticamente el <strong>líder</strong> del equipo</li>
                        <li>Podrás registrar este equipo a eventos cuando estén disponibles</li>
                        <li>El equipo quedará en tu "pool" de equipos disponibles</li>
                        <li>Puedes tener múltiples equipos diferentes</li>
                    </ul>
                </div>

                {{-- Botones --}}
                <div class="button-container-eqcse">
                    <a href="{{ route('estudiante.dashboard') }}" class="btn-cancel-eqcse">
                        Cancelar
                    </a>
                    <button type="submit" class="btn-submit-eqcse">
                        Crear Equipo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Elementos del DOM
    const fileUploadArea = document.getElementById('fileUploadArea');
    const fileInput = document.getElementById('ruta_imagen');
    const filePreview = document.getElementById('filePreview');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');
    
    // Prevenir comportamiento por defecto en drag and drop
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        fileUploadArea.addEventListener(eventName, preventDefaults, false);
        document.body.addEventListener(eventName, preventDefaults, false);
    });
    
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    // Highlight en drag over
    ['dragenter', 'dragover'].forEach(eventName => {
        fileUploadArea.addEventListener(eventName, highlight, false);
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        fileUploadArea.addEventListener(eventName, unhighlight, false);
    });
    
    function highlight() {
        fileUploadArea.classList.add('dragover-eqcse');
    }
    
    function unhighlight() {
        fileUploadArea.classList.remove('dragover-eqcse');
    }
    
    // Manejar el drop
    fileUploadArea.addEventListener('drop', handleDrop, false);
    
    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        
        if (files.length > 0) {
            fileInput.files = files;
            handleFileSelect(fileInput);
        }
    }
    
    // Manejar selección de archivo
    function handleFileSelect(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const size = (file.size / 1024 / 1024).toFixed(2); // Size in MB
            
            // Actualizar preview
            fileName.textContent = file.name;
            fileSize.textContent = `${size} MB`;
            filePreview.classList.add('show-eqcse');
            
            // Ocultar área de upload
            fileUploadArea.style.display = 'none';
        }
    }
    
    // Remover archivo
    function removeFile() {
        fileInput.value = '';
        filePreview.classList.remove('show-eqcse');
        fileUploadArea.style.display = 'block';
    }
</script>

@endsection