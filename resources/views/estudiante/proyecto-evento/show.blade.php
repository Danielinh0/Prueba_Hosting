@extends('layouts.prueba')

@section('title', 'Proyecto del Evento')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
    
    .proyecto-evento-page {
        background: linear-gradient(to bottom, #FFFDF4, #FFEEE2);
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
        padding: 2rem 0;
    }
    
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
    
    .main-card {
        background: #FFEEE2;
        border-radius: 20px;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
        padding: 2rem;
        margin-bottom: 2rem;
    }
    
    .event-badge {
        display: inline-block;
        padding: 0.5rem 1rem;
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: white;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }
    
    .section-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2c2c2c;
        margin-bottom: 1rem;
    }
    
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin: 1.5rem 0;
    }
    
    .info-item {
        background: rgba(255, 255, 255, 0.5);
        padding: 1rem;
        border-radius: 10px;
        box-shadow: inset 2px 2px 4px #e6d5c9, inset -2px -2px 4px #ffffff;
    }
    
    .info-label {
        font-size: 0.75rem;
        color: #6b6b6b;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.25rem;
    }
    
    .info-value {
        font-size: 1rem;
        font-weight: 600;
        color: #2c2c2c;
    }
    
    .content-section {
        margin: 2rem 0;
    }
    
    .content-section h3 {
        font-size: 1.25rem;
        font-weight: 600;
        color: #2c2c2c;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid rgba(232, 154, 60, 0.3);
    }
    
    .content-text {
        color: #2c2c2c;
        line-height: 1.8;
        white-space: pre-wrap;
    }
    
    .download-section {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
        margin: 1.5rem 0;
    }
    
    .download-card {
        background: rgba(255, 255, 255, 0.5);
        padding: 1.5rem;
        border-radius: 15px;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        transition: all 0.3s ease;
    }
    
    .download-card:hover {
        transform: translateY(-3px);
        box-shadow: 6px 6px 12px #e6d5c9, -6px -6px 12px #ffffff;
    }
    
    .download-icon {
        font-size: 2rem;
        margin-bottom: 0.5rem;
    }
    
    .download-title {
        font-weight: 600;
        color: #2c2c2c;
        margin-bottom: 0.5rem;
    }
    
    .download-link {
        display: inline-block;
        margin-top: 0.5rem;
        color: #e89a3c;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    
    .download-link:hover {
        color: #d98a2c;
    }
    
    .action-button {
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: white;
        font-weight: 600;
        padding: 0.75rem 2rem;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        box-shadow: 4px 4px 8px rgba(99, 102, 241, 0.3);
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }
    
    .action-button:hover {
        transform: translateY(-2px);
        box-shadow: 6px 6px 12px rgba(99, 102, 241, 0.4);
        color: white;
    }
    
    .alert-info {
        background: rgba(59, 130, 246, 0.1);
        border-left: 4px solid #3b82f6;
        padding: 1rem;
        border-radius: 8px;
        margin: 1rem 0;
        color: #1e40af;
    }
</style>

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
