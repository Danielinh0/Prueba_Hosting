@extends('layouts.app')

@section('content')

<div class="proyecto-individual-page py-12">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('admin.proyectos-evento.asignar', $evento) }}" class="back-link">
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
            <div class="equipo-info-box">
                <div class="flex items-center justify-between">
                    <div>
                        <h3>{{ $inscripcion->equipo->nombre }}</h3>
                        <p class="mt-1">
                            {{ $inscripcion->equipo->miembros->count() }} integrantes
                        </p>
                    </div>
                    <div class="text-right">
                        <span class="codigo-label">Código de equipo:</span>
                        <div class="codigo-value">{{ $inscripcion->codigo_acceso_equipo }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="main-card">
            <form action="{{ route('admin.proyectos-evento.store-individual', [$evento, $inscripcion]) }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Título --}}
                <div class="mb-6">
                    <label for="titulo" class="form-label">
                        Título del Proyecto <span class="required-asterisk">*</span>
                    </label>
                    <input type="text" name="titulo" id="titulo" 
                           value="{{ old('titulo') }}"
                           class="neuro-input"
                           required maxlength="200"
                           placeholder="Ej: Desarrollar sistema de gestión de inventario">
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
                              placeholder="Describe detalladamente el proyecto específico para este equipo...">{{ old('descripcion_completa') }}</textarea>
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
                              placeholder="¿Qué debe lograr este equipo con este proyecto?">{{ old('objetivo') }}</textarea>
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
                              placeholder="Tecnologías, herramientas, conocimientos específicos para este proyecto...">{{ old('requisitos') }}</textarea>
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
                              placeholder="Premios si este equipo gana...">{{ old('premios') }}</textarea>
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
                        📦 Recursos Específicos (ZIP)
                    </label>
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
                           value="{{ old('url_externa') }}"
                           class="neuro-input"
                           placeholder="https://drive.google.com/...">
                    <p class="helper-text">Google Drive, Dropbox, etc.</p>
                    @error('url_externa')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Botones --}}
                <div class="flex justify-end space-x-3 pt-6" style="border-top: 1px solid rgba(232, 154, 60, 0.2);">
                    <a href="{{ route('admin.proyectos-evento.asignar', $evento) }}" class="button-secondary">
                        Cancelar
                    </a>
                    <button type="submit" class="button-primary">
                        Asignar Proyecto
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection