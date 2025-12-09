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


<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

    /* Fondo degradado */
    .avance-form-page {
        background: linear-gradient(to bottom, #FFFDF4, #FFEEE2);
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
    }

    /* Back button */
    .back-link {
        font-family: 'Poppins', sans-serif;
        display: inline-flex;
        align-items: center;
        color: black;
        font-size: 0.875rem;
        font-weight: 500;
        margin-bottom: 1rem;
        padding: 0.5rem 1rem;
        background: #FFEEE2;
        border-radius: 10px;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .back-link:hover {
        color: #4f46e5;
        box-shadow: 6px 6px 12px #e6d5c9, -6px -6px 12px #ffffff;
        transform: translateY(-2px);
    }

    .back-link svg {
        width: 1rem;
        height: 1rem;
        margin-right: 0.5rem;
    }

    /* Card principal neuromórfica */
    .neuro-card-main {
        background: #FFEEE2;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
        border-radius: 20px;
        overflow: hidden;
        margin-bottom: 2rem;
    }

    /* Content sections */
    .content-section {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.9), rgba(255, 238, 226, 0.9));
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
    }

    /* Project info */
    .project-info {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(139, 92, 246, 0.1));
        border: 1px solid rgba(99, 102, 241, 0.2);
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .project-info h4 {
        font-family: 'Poppins', sans-serif;
        color: #6366f1;
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .project-details {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    .project-details div {
        display: flex;
        flex-direction: column;
    }

    .project-details strong {
        color: #6b7280;
        font-size: 0.875rem;
        margin-bottom: 0.25rem;
    }

    .project-details span {
        color: #2c2c2c;
        font-weight: 500;
    }

    /* Form styles */
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        font-weight: 600;
        color: #2c2c2c;
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
    }

    .form-label .required {
        color: #ef4444;
    }

    .neuro-input,
    .neuro-textarea,
    .neuro-file {
        width: 100%;
        padding: 0.75rem 1rem;
        background: rgba(255, 255, 255, 0.7);
        border: 1px solid rgba(232, 154, 60, 0.2);
        border-radius: 10px;
        font-family: 'Poppins', sans-serif;
        transition: all 0.3s ease;
        box-shadow: 2px 2px 4px #e6d5c9, -2px -2px 4px #ffffff;
    }

    .neuro-input:focus,
    .neuro-textarea:focus,
    .neuro-file:focus {
        outline: none;
        border-color: #e89a3c;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
    }

    .neuro-input::placeholder,
    .neuro-textarea::placeholder {
        color: #9ca3af;
    }

    .help-text {
        font-size: 0.75rem;
        color: #6b7280;
        margin-top: 0.25rem;
    }

    /* Action button */
    .action-button {
        font-family: 'Poppins', sans-serif;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        box-shadow: 4px 4px 8px rgba(232, 154, 60, 0.3);
        border: none;
        cursor: pointer;
    }

    .action-button:hover {
        transform: translateY(-2px);
        box-shadow: 6px 6px 12px rgba(232, 154, 60, 0.4);
    }

    .btn-primary {
        background: linear-gradient(135deg, #e89a3c, #f5a847);
        color: #ffffff;
    }

    .btn-secondary {
        background: rgba(255, 255, 255, 0.7);
        color: #2c2c2c;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
    }

    /* File upload area */
    .file-upload-area {
        border: 2px dashed rgba(232, 154, 60, 0.3);
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        transition: all 0.3s ease;
        background: rgba(255, 255, 255, 0.3);
    }

    .file-upload-area:hover {
        border-color: rgba(232, 154, 60, 0.5);
        background: rgba(255, 255, 255, 0.5);
    }

    .file-upload-area.dragover {
        border-color: #e89a3c;
        background: rgba(232, 154, 60, 0.05);
    }

    .upload-icon {
        font-size: 3rem;
        color: #e89a3c;
        margin-bottom: 1rem;
    }

    .upload-text {
        color: #6b7280;
        margin-bottom: 0.5rem;
    }

    .upload-hint {
        font-size: 0.875rem;
        color: #9ca3af;
    }

    /* Button styles */
    .button-group {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        margin-top: 2rem;
    }

    /* Loading state */
    .loading {
        display: none;
    }

    .loading.show {
        display: inline-block;
    }
</style>
@endsection