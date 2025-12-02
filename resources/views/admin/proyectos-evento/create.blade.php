@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
    
    /* Fondo degradado */
    .proyecto-edit-page {
        background: linear-gradient(to bottom, #FFFDF4, #FFEEE2);
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
    }
    
    /* Textos */
    .proyecto-edit-page h2,
    .proyecto-edit-page h3 {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
    }
    
    .proyecto-edit-page p,
    .proyecto-edit-page label {
        font-family: 'Poppins', sans-serif;
        color: #6b6b6b;
    }
    
    /* Back link */
    .back-link {
        font-family: 'Poppins', sans-serif;
        color: #e89a3c;
        font-size: 0.875rem;
        transition: all 0.2s ease;
    }
    
    .back-link:hover {
        color: #d98a2c;
    }
    
    /* Main card */
    .main-card {
        background: #FFEEE2;
        border-radius: 20px;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
        padding: 2rem;
    }
    
    /* Labels */
    .form-label {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
        font-size: 0.875rem;
        font-weight: 600;
        display: block;
        margin-bottom: 0.5rem;
    }
    
    .required-asterisk {
        color: #ef4444;
    }
    
    /* Inputs y textareas */
    .neuro-input,
    .neuro-textarea,
    .neuro-file {
        font-family: 'Poppins', sans-serif;
        background: rgba(255, 255, 255, 0.5);
        border: none;
        box-shadow: inset 4px 4px 8px #e6d5c9, inset -4px -4px 8px #ffffff;
        transition: all 0.2s ease;
        backdrop-filter: blur(10px);
        color: #2c2c2c;
        width: 100%;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
    }
    
    .neuro-input::placeholder,
    .neuro-textarea::placeholder {
        color: #9ca3af;
    }
    
    .neuro-input:focus,
    .neuro-textarea:focus,
    .neuro-file:focus {
        outline: none;
        box-shadow: inset 6px 6px 12px #e6d5c9, inset -6px -6px 12px #ffffff;
    }
    
    /* Helper text */
    .helper-text {
        font-family: 'Poppins', sans-serif;
        color: #6b6b6b;
        font-size: 0.75rem;
        margin-top: 0.25rem;
    }
    
    /* Error messages */
    .error-message {
        font-family: 'Poppins', sans-serif;
        color: #dc2626;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
    
    /* File info box */
    .file-info-box {
        background: rgba(209, 250, 229, 0.8);
        border: 1px solid #10b981;
        border-radius: 15px;
        padding: 0.75rem;
        margin-bottom: 0.75rem;
        box-shadow: 2px 2px 4px rgba(16, 185, 129, 0.1);
    }
    
    .file-info-box p {
        font-family: 'Poppins', sans-serif;
        color: #065f46;
        font-size: 0.875rem;
    }
    
    .file-info-box .file-name {
        font-weight: 600;
    }
    
    .file-info-box .file-hint {
        font-size: 0.75rem;
        color: #059669;
        margin-top: 0.25rem;
    }
    
    /* Divider */
    .section-divider {
        border-top: 1px solid rgba(232, 154, 60, 0.2);
        margin: 2rem 0;
    }
    
    /* Buttons */
    .button-secondary {
        font-family: 'Poppins', sans-serif;
        background: rgba(255, 255, 255, 0.5);
        color: #2c2c2c;
        font-weight: 500;
        padding: 0.5rem 1.5rem;
        border-radius: 0.5rem;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        transition: all 0.3s ease;
        border: none;
        backdrop-filter: blur(10px);
    }
    
    .button-secondary:hover {
        box-shadow: 6px 6px 12px #e6d5c9, -6px -6px 12px #ffffff;
        transform: translateY(-2px);
    }
    
    .button-primary {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: #ffffff;
        font-weight: 600;
        padding: 0.5rem 1.5rem;
        border-radius: 0.5rem;
        box-shadow: 4px 4px 8px rgba(99, 102, 241, 0.3);
        transition: all 0.3s ease;
        border: none;
    }
    
    .button-primary:hover {
        box-shadow: 6px 6px 12px rgba(99, 102, 241, 0.4);
        transform: translateY(-2px);
    }
</style>

<div class="proyecto-edit-page py-12">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('admin.eventos.show', $evento) }}" class="back-link mb-2 inline-block">
                ← Volver al Evento
            </a>
            <h2 class="font-semibold text-2xl">
                {{ $proyectoEvento ? 'Editar' : 'Crear' }} Proyecto del Evento
            </h2>
            <p class="mt-1">{{ $evento->nombre }}</p>
        </div>

        <div class="main-card">
            <form action="{{ $proyectoEvento ? route('admin.proyectos-evento.update', $proyectoEvento) : route('admin.proyectos-evento.store', $evento) }}" 
                  method="POST" 
                  enctype="multipart/form-data">
                @csrf
                @if($proyectoEvento)
                    @method('PATCH')
                @endif

                {{-- Título --}}
                <div class="mb-6">
                    <label for="titulo" class="form-label">
                        Título del Proyecto <span class="required-asterisk">*</span>
                    </label>
                    <input type="text" name="titulo" id="titulo" 
                           value="{{ old('titulo', $proyectoEvento->titulo ?? '') }}"
                           class="neuro-input"
                           required maxlength="200"
                           placeholder="Ej: Desarrollar solución educativa innovadora">
                    @error('titulo')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Descripción Completa --}}
                <div class="mb-6">
                    <label for="descripcion_completa" class="form-label">
                        Descripción Completa
                    </label>
                    <textarea name="descripcion_completa" id="descripcion_completa" rows="6"
                              class="neuro-textarea"
                              placeholder="Describe detalladamente el proyecto, contexto, tecnologías recomendadas...">{{ old('descripcion_completa', $proyectoEvento->descripcion_completa ?? '') }}</textarea>
                    <p class="helper-text">Puedes usar Markdown para formatear el texto</p>
                    @error('descripcion_completa')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Objetivo --}}
                <div class="mb-6">
                    <label for="objetivo" class="form-label">
                        Objetivo del Proyecto
                    </label>
                    <textarea name="objetivo" id="objetivo" rows="3"
                              class="neuro-textarea"
                              placeholder="¿Qué se espera lograr con este proyecto?">{{ old('objetivo', $proyectoEvento->objetivo ?? '') }}</textarea>
                    @error('objetivo')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Requisitos --}}
                <div class="mb-6">
                    <label for="requisitos" class="form-label">
                        Requisitos Técnicos
                    </label>
                    <textarea name="requisitos" id="requisitos" rows="4"
                              class="neuro-textarea"
                              placeholder="Tecnologías, herramientas, conocimientos previos necesarios...">{{ old('requisitos', $proyectoEvento->requisitos ?? '') }}</textarea>
                    @error('requisitos')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Premios --}}
                <div class="mb-6">
                    <label for="premios" class="form-label">
                        Premios y Reconocimientos
                    </label>
                    <textarea name="premios" id="premios" rows="3"
                              class="neuro-textarea"
                              placeholder="Premios para los ganadores...">{{ old('premios', $proyectoEvento->premios ?? '') }}</textarea>
                    @error('premios')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <hr class="section-divider">

                {{-- Archivo de Bases --}}
                <div class="mb-6">
                    <label for="archivo_bases" class="form-label">
                        📄 Archivo de Bases (PDF)
                    </label>
                    @if($proyectoEvento && $proyectoEvento->archivo_bases)
                        <div class="file-info-box">
                            <p>
                                ✓ Archivo actual: <span class="file-name">{{ basename($proyectoEvento->archivo_bases) }}</span>
                            </p>
                            <p class="file-hint">Sube un nuevo archivo si deseas reemplazarlo</p>
                        </div>
                    @endif
                    <input type="file" name="archivo_bases" id="archivo_bases" 
                           accept=".pdf,.doc,.docx"
                           class="neuro-file">
                    <p class="helper-text">PDF, DOC o DOCX - Máximo 20MB</p>
                    @error('archivo_bases')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Archivo de Recursos --}}
                <div class="mb-6">
                    <label for="archivo_recursos" class="form-label">
                        📦 Recursos Adicionales (ZIP)
                    </label>
                    @if($proyectoEvento && $proyectoEvento->archivo_recursos)
                        <div class="file-info-box">
                            <p>
                                ✓ Archivo actual: <span class="file-name">{{ basename($proyectoEvento->archivo_recursos) }}</span>
                            </p>
                            <p class="file-hint">Sube un nuevo archivo si deseas reemplazarlo</p>
                        </div>
                    @endif
                    <input type="file" name="archivo_recursos" id="archivo_recursos" 
                           accept=".zip,.rar,.pdf"
                           class="neuro-file">
                    <p class="helper-text">ZIP, RAR o PDF - Máximo 50MB</p>
                    @error('archivo_recursos')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                {{-- URL Externa --}}
                <div class="mb-6">
                    <label for="url_externa" class="form-label">
                        🔗 URL a Recursos Externos
                    </label>
                    <input type="url" name="url_externa" id="url_externa" 
                           value="{{ old('url_externa', $proyectoEvento->url_externa ?? '') }}"
                           class="neuro-input"
                           placeholder="https://drive.google.com/...">
                    <p class="helper-text">Google Drive, Dropbox, etc.</p>
                    @error('url_externa')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Botones --}}
                <div class="flex justify-end space-x-3 pt-6" style="border-top: 1px solid rgba(232, 154, 60, 0.2);">
                    <a href="{{ route('admin.eventos.show', $evento) }}" class="button-secondary">
                        Cancelar
                    </a>
                    <button type="submit" class="button-primary">
                        {{ $proyectoEvento ? 'Actualizar' : 'Crear' }} Proyecto
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection