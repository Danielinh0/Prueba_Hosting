@extends('jurado.layouts.app')

@section('content')

<div class="proyecto-detalle-page">
    <div class="max-w-6xl mx-auto px-4">
        <a href="{{ route('jurado.proyectos.index') }}" class="back-link">
            ← Volver a Proyectos
        </a>

        {{-- Header del Proyecto --}}
        <div class="project-header">
            <h1 class="project-title">{{ $proyectoEvento->titulo }}</h1>
            
            <div class="project-badges">
                <span class="badge badge-event">{{ $evento->nombre }}</span>
                <span class="badge badge-type">
                    {{ $proyectoEvento->esGeneral() ? 'Proyecto General' : 'Proyecto Individual' }}
                </span>
            </div>
        </div>

        {{-- Descripción --}}
        @if($proyectoEvento->descripcion_completa)
        <div class="content-section">
            <h2 class="section-title"> Descripción</h2>
            <div class="section-content">{{ $proyectoEvento->descripcion_completa }}</div>
        </div>
        @endif

        {{-- Objetivo --}}
        @if($proyectoEvento->objetivo)
        <div class="content-section">
            <h2 class="section-title"> Objetivo</h2>
            <div class="section-content">{{ $proyectoEvento->objetivo }}</div>
        </div>
        @endif

        {{-- Requisitos --}}
        @if($proyectoEvento->requisitos)
        <div class="content-section">
            <h2 class="section-title"> Requisitos Técnicos</h2>
            <div class="section-content">{{ $proyectoEvento->requisitos }}</div>
        </div>
        @endif

        {{-- Premios --}}
        @if($proyectoEvento->premios)
        <div class="content-section">
            <h2 class="section-title"> Premios</h2>
            <div class="section-content">{{ $proyectoEvento->premios }}</div>
        </div>
        @endif

        {{-- Recursos --}}
        @if($proyectoEvento->archivo_bases || $proyectoEvento->archivo_recursos || $proyectoEvento->url_externa)
        <div class="content-section">
            <h2 class="section-title">📦 Recursos</h2>
            <div class="download-grid">
                @if($proyectoEvento->archivo_bases)
                <div class="download-item">
                    <div class="download-icon">📄</div>
                    <div class="download-title">Bases del Proyecto</div>
                    <a href="{{ Storage::url($proyectoEvento->archivo_bases) }}" target="_blank" class="download-link">
                        Descargar →
                    </a>
                </div>
                @endif

                @if($proyectoEvento->archivo_recursos)
                <div class="download-item">
                    <div class="download-icon">📦</div>
                    <div class="download-title">Recursos Adicionales</div>
                    <a href="{{ Storage::url($proyectoEvento->archivo_recursos) }}" target="_blank" class="download-link">
                        Descargar →
                    </a>
                </div>
                @endif

                @if($proyectoEvento->url_externa)
                <div class="download-item">
                    <div class="download-icon">🔗</div>
                    <div class="download-title">Enlace Externo</div>
                    <a href="{{ $proyectoEvento->url_externa }}" target="_blank" class="download-link">
                        Abrir →
                    </a>
                </div>
                @endif
            </div>
        </div>
        @endif

        {{-- Equipos Trabajando en Este Proyecto --}}
        <div class="teams-section">
            <h2 class="section-title">👥 Equipos ({{ $equipos->count() }})</h2>
            
            @foreach($equipos as $inscripcion)
                <div class="team-card">
                    <div class="team-header">
                        <div>
                            <h3 class="team-name">{{ $inscripcion->equipo->nombre }}</h3>
                            <p style="font-size: 0.875rem; color: #6b7280; margin-top: 0.25rem;">
                                {{ $inscripcion->equipo->miembros->count() }} integrantes
                            </p>
                        </div>
                        {{-- Aquí podrías agregar link para evaluar --}}
                        @if($inscripcion->proyecto)
                            <a href="#" class="btn-evaluate">
                                Evaluar Avances
                            </a>
                        @endif
                    </div>

                    @if($inscripcion->proyecto)
                    <div class="team-stats">
                        <div class="stat-item">
                            <div class="stat-value">{{ $inscripcion->proyecto->avances->count() }}</div>
                            <div class="stat-label">Avances</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">
                                @if($inscripcion->proyecto->tareas->count() > 0)
                                    {{ round(($inscripcion->proyecto->tareas->where('completada', true)->count() / $inscripcion->proyecto->tareas->count()) * 100) }}%
                                @else
                                    0%
                                @endif
                            </div>
                            <div class="stat-label">Progreso</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">{{ $inscripcion->proyecto->tareas->count() }}</div>
                            <div class="stat-label">Tareas</div>
                        </div>
                    </div>
                    @else
                        <p style="color: #9ca3af; font-size: 0.875rem; text-align: center; padding: 1rem 0;">
                            Este equipo aún no ha iniciado su proyecto
                        </p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>


<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
    
    .proyecto-detalle-page {
        font-family: 'Poppins', sans-serif;
        padding: 2rem 0;
    }
    
    .back-link {
        color: #6366f1;
        font-size: 0.875rem;
        text-decoration: none;
        display: inline-block;
        margin-bottom: 1rem;
    }
    
    .back-link:hover {
        text-decoration: underline;
    }
    
    .project-header {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    .project-title {
        font-size: 2rem;
        font-weight: 700;
        color: #2c2c2c;
        margin-bottom: 1rem;
    }
    
    .project-badges {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    
    .badge {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .badge-event {
        background: #dbeafe;
        color: #1e40af;
    }
    
    .badge-type {
        background: #fef3c7;
        color: #92400e;
    }
    
    .content-section {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .section-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #2c2c2c;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #e5e7eb;
    }
    
    .section-content {
        color: #4b5563;
        line-height: 1.8;
        white-space: pre-wrap;
    }
    
    .download-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
    }
    
    .download-item {
        padding: 1rem;
        background: #f9fafb;
        border-radius: 10px;
        border: 1px solid #e5e7eb;
        transition: all 0.3s ease;
    }
    
    .download-item:hover {
        background: #f3f4f6;
        border-color: #d1d5db;
    }
    
    .download-icon {
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
    }
    
    .download-title {
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.25rem;
    }
    
    .download-link {
        color: #6366f1;
        font-size: 0.875rem;
        text-decoration: none;
        font-weight: 500;
    }
    
    .download-link:hover {
        text-decoration: underline;
    }
    
    .teams-section {
        margin-top: 2rem;
    }
    
    .team-card {
        background: white;
        border-radius: 12px;
        padding: 1.25rem;
        margin-bottom: 1rem;
        border: 1px solid #e5e7eb;
        transition: all 0.3s ease;
    }
    
    .team-card:hover {
        border-color: #6366f1;
        box-shadow: 0 4px 6px rgba(99, 102, 241, 0.1);
    }
    
    .team-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.75rem;
    }
    
    .team-name {
        font-size: 1.125rem;
        font-weight: 600;
        color: #2c2c2c;
    }
    
    .team-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
        font-size: 0.875rem;
    }
    
    .stat-item {
        text-align: center;
    }
    
    .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #6366f1;
    }
    
    .stat-label {
        color: #6b7280;
        font-size: 0.75rem;
    }
    
    .btn-evaluate {
        padding: 0.5rem 1.5rem;
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        display: inline-block;
        transition: all 0.3s ease;
    }
    
    .btn-evaluate:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(16, 185, 129, 0.3);
        color: white;
    }
</style>
@endsection
