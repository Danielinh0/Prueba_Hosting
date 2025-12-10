@extends('layouts.app')

@section('title', 'Registrar Avance')

@section('content')

<div class="avance-create-page">
    <div class="container-form">
        
        <a href="{{ route('estudiante.avances.index-specific', $proyecto->id_proyecto) }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Volver a Avances
        </a>

        {{-- Header --}}
        <div class="page-header">
            <div class="header-icon">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="header-text">
                <h1>Registrar Nuevo Avance</h1>
                <p>Documenta el progreso de tu proyecto</p>
            </div>
        </div>

        {{-- Información del Proyecto --}}
        <div class="info-card">
            <div class="info-grid">
                <div class="info-item">
                    <i class="fas fa-project-diagram"></i>
                    <div>
                        <span class="info-label">Proyecto</span>
                        <span class="info-value">{{ $proyecto->nombre }}</span>
                    </div>
                </div>
                <div class="info-item">
                    <i class="fas fa-users"></i>
                    <div>
                        <span class="info-label">Equipo</span>
                        <span class="info-value">{{ $inscripcion->equipo->nombre }}</span>
                    </div>
                </div>
                @if($inscripcion->evento)
                <div class="info-item">
                    <i class="fas fa-calendar-alt"></i>
                    <div>
                        <span class="info-label">Evento</span>
                        <span class="info-value">{{ $inscripcion->evento->nombre }}</span>
                    </div>
                </div>
                @endif
                <div class="info-item">
                    <i class="fas fa-clock"></i>
                    <div>
                        <span class="info-label">Fecha</span>
                        <span class="info-value">{{ now()->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Formulario --}}
        <div class="form-card">
            <form action="{{ route('estudiante.avances.store-specific', $proyecto->id_proyecto) }}" 
                  method="POST" 
                  enctype="multipart/form-data"
                  id="avanceForm">
                @csrf

                {{-- Título --}}
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-heading"></i>
                        Título del Avance <span class="required">*</span>
                    </label>
                    <input type="text" 
                           name="titulo" 
                           id="titulo"
                           required 
                           minlength="20"
                           maxlength="200"
                           class="form-input"
                           placeholder="Describe brevemente qué lograste (mín. 20 caracteres)"
                           value="{{ old('titulo') }}">
                    <div class="input-footer">
                        <span class="char-count" id="tituloCount">0/200</span>
                        <span class="min-hint" id="tituloHint">Mínimo 20 caracteres</span>
                    </div>
                    @error('titulo')
                        <div class="error-msg"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                {{-- Descripción --}}
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-align-left"></i>
                        Descripción Detallada <span class="required">*</span>
                    </label>
                    <textarea name="descripcion" 
                              id="descripcion"
                              rows="6" 
                              required
                              minlength="100"
                              class="form-textarea"
                              placeholder="Explica detalladamente: qué lograste, desafíos enfrentados, soluciones implementadas, próximos pasos... (mín. 100 caracteres)">{{ old('descripcion') }}</textarea>
                    <div class="input-footer">
                        <span class="char-count" id="descripcionCount">0 caracteres</span>
                        <span class="min-hint" id="descripcionHint">Mínimo 100 caracteres</span>
                    </div>
                    @error('descripcion')
                        <div class="error-msg"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                    <div class="help-text">
                        <i class="fas fa-lightbulb"></i>
                        Sé descriptivo para que los jurados comprendan tu progreso
                    </div>
                </div>

                {{-- Archivo Adjunto (sin cambios) --}}
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-paperclip"></i>
                        Archivo Adjunto <span class="optional">(opcional)</span>
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
                        <div class="error-msg"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                {{-- Botones --}}
                <div class="button-group">
                    <a href="{{ route('estudiante.avances.index-specific', $proyecto->id_proyecto) }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <i class="fas fa-save" id="btnIcon"></i>
                        <span id="btnText">Registrar Avance</span>
                        <i class="fas fa-spinner fa-spin hidden" id="loadingIcon"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Character counters
    const tituloInput = document.getElementById('titulo');
    const tituloCount = document.getElementById('tituloCount');
    const tituloHint = document.getElementById('tituloHint');
    
    const descripcionInput = document.getElementById('descripcion');
    const descripcionCount = document.getElementById('descripcionCount');
    const descripcionHint = document.getElementById('descripcionHint');

    tituloInput.addEventListener('input', () => {
        const len = tituloInput.value.length;
        tituloCount.textContent = `${len}/200`;
        
        if (len >= 20) {
            tituloHint.textContent = '✓ Longitud válida';
            tituloHint.classList.add('valid');
        } else {
            tituloHint.textContent = `Faltan ${20 - len} caracteres`;
            tituloHint.classList.remove('valid');
        }
    });

    descripcionInput.addEventListener('input', () => {
        const len = descripcionInput.value.length;
        descripcionCount.textContent = `${len} caracteres`;
        
        if (len >= 100) {
            descripcionHint.textContent = '✓ Longitud válida';
            descripcionHint.classList.add('valid');
        } else {
            descripcionHint.textContent = `Faltan ${100 - len} caracteres`;
            descripcionHint.classList.remove('valid');
        }
    });

    // File upload handling
    const fileUploadArea = document.getElementById('fileUploadArea');
    const archivoAdjunto = document.getElementById('archivoAdjunto');

    fileUploadArea.addEventListener('click', () => {
        archivoAdjunto.click();
    });

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
        uploadText.innerHTML = `<i class="fas fa-file"></i> ${fileName}`;
        fileUploadArea.classList.add('has-file');
    }

    // Form submission
    const form = document.getElementById('avanceForm');
    const submitBtn = document.getElementById('submitBtn');
    const btnText = document.getElementById('btnText');
    const btnIcon = document.getElementById('btnIcon');
    const loadingIcon = document.getElementById('loadingIcon');

    form.addEventListener('submit', (e) => {
        // Validate minimum lengths
        if (tituloInput.value.length < 20) {
            e.preventDefault();
            tituloInput.focus();
            alert('El título debe tener al menos 20 caracteres.');
            return;
        }
        if (descripcionInput.value.length < 100) {
            e.preventDefault();
            descripcionInput.focus();
            alert('La descripción debe tener al menos 100 caracteres.');
            return;
        }

        btnText.textContent = 'Registrando...';
        btnIcon.classList.add('hidden');
        loadingIcon.classList.remove('hidden');
        submitBtn.disabled = true;
    });

    // Init counters
    if (tituloInput.value) tituloInput.dispatchEvent(new Event('input'));
    if (descripcionInput.value) descripcionInput.dispatchEvent(new Event('input'));
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

.avance-create-page {
    background: linear-gradient(135deg, #FFFDF4 0%, #FFEEE2 50%, #FFF5E8 100%);
    min-height: 100vh;
    padding: 1.5rem 1rem;
    font-family: 'Inter', -apple-system, sans-serif;
}

.container-form {
    max-width: 700px;
    margin: 0 auto;
}

/* Back Link - Neumórfico */
.back-link {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    color: #6b7280;
    font-size: 0.85rem;
    font-weight: 500;
    text-decoration: none;
    margin-bottom: 1.5rem;
    padding: 0.5rem 1rem;
    background: #ffeee2;
    border-radius: 12px;
    box-shadow: 3px 3px 6px #e6d5c9, -3px -3px 6px rgba(255, 255, 255, 0.7);
    transition: all 0.3s;
}
.back-link:hover { 
    color: #6366f1;
    box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px rgba(255, 255, 255, 0.8);
}

/* Page Header */
.page-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.header-icon {
    width: 56px;
    height: 56px;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    box-shadow: 4px 4px 8px rgba(99, 102, 241, 0.35), -2px -2px 6px rgba(255, 255, 255, 0.5);
}

.header-text h1 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #111827;
    margin: 0;
}
.header-text p {
    font-size: 0.875rem;
    color: #6b7280;
    margin: 0.25rem 0 0 0;
}

/* Info Card - Morado suave */
.info-card {
    background: linear-gradient(135deg, #ede9fe, #e0e7ff);
    border-radius: 14px;
    padding: 1rem 1.25rem;
    margin-bottom: 1.5rem;
    border: 1px solid #c7d2fe;
    box-shadow: 4px 4px 8px rgba(99, 102, 241, 0.15), -3px -3px 6px rgba(255, 255, 255, 0.6);
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 1rem;
}

.info-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}
.info-item i { color: #6366f1; font-size: 1rem; }
.info-label { font-size: 0.65rem; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; }
.info-value { font-size: 0.85rem; font-weight: 600; color: #111827; }

/* Form Card - Neumórfico cálido */
.form-card {
    background: #ffeee2;
    border-radius: 16px;
    padding: 1.75rem;
    margin-bottom: 1.5rem;
    box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px rgba(255, 255, 255, 0.6);
    border: 1px solid rgba(232, 154, 60, 0.1);
}

/* Form Groups */
.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
}
.form-label i { color: #6366f1; font-size: 0.8rem; }
.required { color: #ef4444; }
.optional { color: #9ca3af; font-weight: 400; font-size: 0.75rem; }

.form-input,
.form-textarea,
.form-select {
    width: 100%;
    padding: 0.875rem 1rem;
    border: none;
    border-radius: 12px;
    font-size: 0.9rem;
    font-family: inherit;
    background: #ffffff;
    box-shadow: inset 2px 2px 4px #e6d5c9, inset -2px -2px 4px rgba(255, 255, 255, 0.5);
    transition: all 0.2s;
}
.form-input:focus,
.form-textarea:focus,
.form-select:focus {
    outline: none;
    box-shadow: inset 3px 3px 6px #e6d5c9,
                inset -3px -3px 6px rgba(255, 255, 255, 0.5),
                0 0 0 3px rgba(99, 102, 241, 0.1);
}
.form-input::placeholder,
.form-textarea::placeholder {
    color: #9ca3af;
}
.form-textarea {
    resize: vertical;
    min-height: 140px;
}

.input-footer {
    display: flex;
    justify-content: space-between;
    margin-top: 0.4rem;
    font-size: 0.7rem;
}
.char-count { color: #9ca3af; }
.min-hint { color: #f59e0b; font-weight: 500; }
.min-hint.valid { color: #10b981; }

.error-msg {
    color: #ef4444;
    font-size: 0.8rem;
    margin-top: 0.4rem;
    display: flex;
    align-items: center;
    gap: 0.3rem;
}

.help-text {
    font-size: 0.7rem;
    color: #6b7280;
    margin-top: 0.4rem;
    display: flex;
    align-items: center;
    gap: 0.3rem;
}
.help-text i { color: #6366f1; }

/* ZONA DE SUBIR ARCHIVOS → PLANA CON BORDE PUNTEADO (sin neumorfismo) */
.file-upload-area {
    border: 2px dashed #d1d5db;
    border-radius: 12px;
    padding: 2.5rem 2rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    background: #ffffff;
    margin-bottom: 1.5rem;
}
.file-upload-area:hover {
    border-color: #6366f1;
    background: #f8f5ff;
}
.file-upload-area.dragover {
    border-color: #6366f1;
    background: #f3e8ff;
    transform: scale(1.02);
}
.file-upload-area.has-file {
    border-color: #10b981;
    background: #f0fdf4;
}
.upload-icon {
    font-size: 2.8rem;
    color: #9ca3af;
    margin-bottom: 0.75rem;
    transition: color 0.3s;
}
.file-upload-area:hover .upload-icon { color: #6366f1; }
.file-upload-area.has-file .upload-icon { color: #10b981; }

.upload-text {
    font-size: 0.95rem;
    color: #374151;
    font-weight: 600;
    margin-bottom: 0.3rem;
}
.upload-hint {
    font-size: 0.8rem;
    color: #9ca3af;
}

/* Button Group */
.button-group {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 1px solid rgba(230, 213, 201, 0.5);
}

.btn {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.875rem 1.5rem;
    border-radius: 12px;
    font-size: 0.9rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s;
    border: none;
    cursor: pointer;
}

.btn-secondary {
    background: #ffffff;
    color: #374151;
    box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px rgba(255, 255, 255, 0.7);
}
.btn-secondary:hover {
    color: #111827;
    box-shadow: 5px 5px 10px #e6d5c9, -5px -5px 10px rgba(255, 255, 255, 0.8);
}
.btn-secondary:active {
    box-shadow: inset 3px 3px 6px #e6d5c9, inset -3px -3px 6px rgba(255, 255, 255, 0.5);
}

.btn-primary {
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    color: white;
    box-shadow: 4px 4px 8px rgba(99, 102, 241, 0.35), -2px -2px 6px rgba(255, 255, 255, 0.5);
}
.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 6px 6px 12px rgba(99, 102, 241, 0.45), -3px -3px 8px rgba(255, 255, 255, 0.6);
}
.btn-primary:active {
    transform: translateY(0);
    box-shadow: inset 3px 3px 6px rgba(0,0,0,0.2);
}
.btn-primary:disabled {
    opacity: 0.7;
    cursor: not-allowed;
    transform: none;
}

/* Responsive */
@media (max-width: 640px) {
    .page-header { flex-direction: column; text-align: center; }
    .header-icon { margin-bottom: 0.5rem; }
    .info-grid { grid-template-columns: 1fr 1fr; }
    .button-group { flex-direction: column-reverse; }
}
</style>

@endsection