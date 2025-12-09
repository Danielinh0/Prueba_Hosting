@extends('layouts.app')

@section('title', 'Registrar Avance')

@section('content')

<div class="avance-form-page py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('estudiante.avances.index-specific', $proyecto->id_proyecto) }}" class="back-link">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver a Avances
        </a>

        <div class="mb-6">
            <h2 class="font-semibold text-2xl">Registrar Nuevo Avance</h2>
            <p class="mt-1">Documenta el progreso del proyecto</p>
        </div>

        <!-- Información del Proyecto -->
        <div class="project-info">
            <h4>
                <i class="fas fa-project-diagram mr-2"></i>
                Información del Proyecto
            </h4>
            <div class="project-details">
                <div>
                    <strong>Nombre del Proyecto</strong>
                    <span>{{ $proyecto->nombre }}</span>
                </div>
                <div>
                    <strong>Equipo</strong>
                    <span>{{ $inscripcion->equipo->nombre }}</span>
                </div>
                @if($inscripcion->evento)
                    <div>
                        <strong>Evento</strong>
                        <span>{{ $inscripcion->evento->nombre }}</span>
                    </div>
                @endif
                <div>
                    <strong>Fecha</strong>
                    <span>{{ now()->format('d/m/Y H:i') }}</span>
                </div>
            </div>
        </div>

        <!-- Formulario -->
        <div class="neuro-card-main">
            <div class="p-6 sm:p-8">
                <form action="{{ route('estudiante.avances.store-specific', $proyecto->id_proyecto) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Título -->
                    <div class="form-group">
                        <label class="form-label">
                            Título del Avance <span class="required">*</span>
                        </label>
                        <input type="text" name="titulo" required maxlength="200"
                               class="neuro-input"
                               placeholder="Ej: Implementación de módulo de autenticación"
                               value="{{ old('titulo') }}">
                        @error('titulo')
                            <div class="help-text text-red-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Descripción -->
                    <div class="form-group">
                        <label class="form-label">
                            Descripción Detallada <span class="required">*</span>
                        </label>
                        <textarea name="descripcion" rows="6" required
                                  class="neuro-textarea"
                                  placeholder="Describe qué has logrado en este avance, los desafíos enfrentados, próximos pasos...">{{ old('descripcion') }}</textarea>
                        @error('descripcion')
                            <div class="help-text text-red-600">{{ $message }}</div>
                        @enderror
                        <div class="help-text">
                            Sé lo más descriptivo posible para que los jurados puedan entender tu progreso
                        </div>
                    </div>

                    <!-- Archivo Adjunto -->
                    <div class="form-group">
                        <label class="form-label">
                            Archivo Adjunto
                        </label>
                        <div class="file-upload-area" id="fileUploadArea">
                            <input type="file" name="archivo_adjunto" id="archivoAdjunto"
                                   class="neuro-file hidden"
                                   accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.jpg,.jpeg,.png,.gif">
                            <div class="upload-icon">
                                <i class="fas fa-cloud-upload-alt"></i>
                            </div>
                            <div class="upload-text">
                                Arrastra un archivo aquí o haz clic para seleccionar
                            </div>
                            <div class="upload-hint">
                                PDF, Word, Excel, PowerPoint o imágenes (Máx: 10MB)
                            </div>
                        </div>
                        @error('archivo_adjunto')
                            <div class="help-text text-red-600 mt-2">{{ $message }}</div>
                        @enderror
                        <div class="help-text">
                            Puedes subir capturas de pantalla, diagramas, documentos técnicos o cualquier evidencia de tu avance
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="button-group">
                        <a href="{{ route('estudiante.avances.index-specific', $proyecto->id_proyecto) }}" class="action-button btn-secondary">
                            Cancelar
                        </a>
                        <button type="submit" class="action-button btn-primary" id="submitBtn">
                            <i class="fas fa-save"></i>
                            <span id="btnText">Registrar Avance</span>
                            <span class="loading" id="loadingIcon">
                                <i class="fas fa-spinner fa-spin"></i> Registrando...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // File upload handling
    const fileUploadArea = document.getElementById('fileUploadArea');
    const archivoAdjunto = document.getElementById('archivoAdjunto');

    fileUploadArea.addEventListener('click', () => {
        archivoAdjunto.click();
    });

    // Drag and drop
    fileUploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        fileUploadArea.classList.add('dragover');
    });

    fileUploadArea.addEventListener('dragleave', () => {
        fileUploadArea.classList.remove('dragover');
    });

    fileUploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        fileUploadArea.classList.remove('dragover');

        const files = e.dataTransfer.files;
        if (files.length > 0) {
            archivoAdjunto.files = files;
            updateFileName(files[0].name);
        }
    });

    archivoAdjunto.addEventListener('change', (e) => {
        if (e.target.files.length > 0) {
            updateFileName(e.target.files[0].name);
        }
    });

    function updateFileName(fileName) {
        const uploadText = document.querySelector('.upload-text');
        uploadText.textContent = `Archivo seleccionado: ${fileName}`;
    }

    // Form submission
    const form = document.querySelector('form');
    const submitBtn = document.getElementById('submitBtn');
    const btnText = document.getElementById('btnText');
    const loadingIcon = document.getElementById('loadingIcon');

    form.addEventListener('submit', (e) => {
        btnText.style.display = 'none';
        loadingIcon.classList.add('show');
        submitBtn.disabled = true;
    });
</script>


@endsection