@extends('layouts.prueba')

@section('title', 'Proyecto del Evento')

@section('content')

<div class="proyecto-evento-page">
    <div class="max-w-6xl mx-auto px-4">
        <a href="{{ route('estudiante.dashboard') }}" class="back-link">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver al Dashboard
        </a>

        <div class="main-card">
            @if($proyectoEvento && $proyectoEvento->publicado)
                {{-- Header --}}
                <div class="mb-4">
                    <span class="event-badge">{{ $inscripcion->evento->nombre }}</span>
                    <h1 class="section-title">{{ $proyectoEvento->titulo }}</h1>
                    
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Tu Equipo</div>
                            <div class="info-value">{{ $inscripcion->equipo->nombre }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Tipo de Proyecto</div>
                            <div class="info-value">{{ $inscripcion->evento->tipo_proyecto === 'general' ? 'Proyecto General' : 'Proyecto Individual' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Publicado</div>
                            <div class="info-value">{{ $proyectoEvento->fecha_publicacion->format('d/m/Y') }}</div>
                        </div>
                    </div>
                </div>

                {{-- Descripción --}}
                @if($proyectoEvento->descripcion_completa)
                <div class="content-section">
                    <h3>Descripción del Proyecto</h3>
                    <div class="content-text">{{ $proyectoEvento->descripcion_completa }}</div>
                </div>
                @endif

                {{-- Objetivo --}}
                @if($proyectoEvento->objetivo)
                <div class="content-section">
                    <h3>Objetivo</h3>
                    <div class="content-text">{{ $proyectoEvento->objetivo }}</div>
                </div>
                @endif

                {{-- Requisitos --}}
                @if($proyectoEvento->requisitos)
                <div class="content-section">
                    <h3>Requisitos Técnicos</h3>
                    <div class="content-text">{{ $proyectoEvento->requisitos }}</div>
                </div>
                @endif

                {{-- Premios --}}
                @if($proyectoEvento->premios)
                <div class="content-section">
                    <h3>Premios y Reconocimientos</h3>
                    <div class="content-text">{{ $proyectoEvento->premios }}</div>
                </div>
                @endif

                {{-- Archivos y Recursos --}}
                @if($proyectoEvento->archivo_bases || $proyectoEvento->archivo_recursos || $proyectoEvento->url_externa)
                <div class="content-section">
                    <h3>Recursos y Archivos</h3>
                    
                    <div class="download-section">
                        @if($proyectoEvento->archivo_bases)
                        <div class="download-card">
                            <div class="download-title">Bases del Proyecto</div>
                            <p style="font-size: 0.875rem; color: #6b6b6b;">Documento con las bases y reglas</p>
                            <a href="{{ Storage::url($proyectoEvento->archivo_bases) }}" target="_blank" class="download-link">
                                Descargar
                            </a>
                        </div>
                        @endif

                        @if($proyectoEvento->archivo_recursos)
                        <div class="download-card">
                            <div class="download-title">Recursos Adicionales</div>
                            <p style="font-size: 0.875rem; color: #6b6b6b;">Archivos y materiales de apoyo</p>
                            <a href="{{ Storage::url($proyectoEvento->archivo_recursos) }}" target="_blank" class="download-link">
                                Descargar
                            </a>
                        </div>
                        @endif

                        @if($proyectoEvento->url_externa)
                        <div class="download-card">
                            <div class="download-title">Recursos Externos</div>
                            <p style="font-size: 0.875rem; color: #6b6b6b;">Enlaces a Drive, repositorios, etc.</p>
                            <a href="{{ $proyectoEvento->url_externa }}" target="_blank" class="download-link">
                                Abrir enlace
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                {{-- Estado del Proyecto del Equipo --}}
                <div class="content-section">
                    @if(!$proyecto)
                        <div class="alert-info">
                            <strong>Es hora de empezar</strong><br>
                            Tu equipo aún no ha creado su solución para este proyecto. 
                            @if($esLider)
                                Como líder, puedes crear el proyecto del equipo.
                            @else
                                El líder del equipo debe crear el proyecto.
                            @endif
                        </div>
                        
                        @if($esLider)
                        <div class="mt-4">
                            <a href="{{ route('estudiante.proyecto.create-from-evento', $inscripcion->evento->id_evento) }}" class="action-button">
                                 Crear Proyecto para este Evento
                            </a>
                        </div>
                        @endif
                    @else
                        <div class="alert-info" style="background: rgba(34, 197, 94, 0.1); border-left-color: #22c55e; color: #166534;">
                            <strong>Proyecto en Progreso</strong><br>
                            Tu equipo ya tiene un proyecto creado: <strong>{{ $proyecto->nombre }}</strong>
                        </div>
                        
                        <div class="mt-4">
                            <a href="{{ route('estudiante.proyecto.show') }}" class="action-button">
                                Ver Nuestro Proyecto
                            </a>
                        </div>
                    @endif
                </div>
            @else
                <div class="text-center">
                    <h1 class="section-title">Proyecto No Disponible</h1>
                    <p class="mt-4 text-secondary-neuro">
                        El proyecto para este evento aún no ha sido publicado por un administrador.
                    </p>
                    <p class="mt-2 text-sm text-gray-500">
                        Por favor, vuelve a consultar más tarde.
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
