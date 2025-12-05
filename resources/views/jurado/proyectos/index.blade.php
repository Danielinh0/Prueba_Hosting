@extends('jurado.layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
    
    .proyectos-page {
        font-family: 'Poppins', sans-serif;
        padding: 2rem 0;
    }
    
    .page-header {
        margin-bottom: 2rem;
    }
    
    .page-title {
        font-size: 1.875rem;
        font-weight: 700;
        color: #2c2c2c;
    }
    
    .event-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
    
    .event-card:hover {
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        transform: translateY(-2px);
    }
    
    .event-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 1rem;
    }
    
    .event-name {
        font-size: 1.25rem;
        font-weight: 600;
        color: #2c2c2c;
    }
    
    .event-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        background: #dcfce7;
        color: #166534;
    }
    
    .event-info {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 1rem;
        margin-bottom: 1rem;
    }
    
    .info-item {
        font-size: 0.875rem;
        color: #6b7280;
    }
    
    .info-label {
        font-weight: 600;
        color: #374151;
    }
    
    .project-type-badge {
        display: inline-block;
        padding: 0.5rem 1rem;
        border-radius: 10px;
        font-size: 0.875rem;
        font-weight: 600;
        margin-top: 0.5rem;
    }
    
    .type-general {
        background: #dbeafe;
        color: #1e40af;
    }
    
    .type-individual {
        background: #fef3c7;
        color: #92400e;
    }
    
    .project-list {
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid #e5e7eb;
    }
    
    .project-item {
        padding: 0.75rem;
        background: #f9fafb;
        border-radius: 8px;
        margin-bottom: 0.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .project-title {
        font-weight: 500;
        color: #2c2c2c;
    }
    
    .project-team {
        font-size: 0.875rem;
        color: #6b7280;
    }
    
    .btn-view {
        padding: 0.5rem 1rem;
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: white;
        border-radius: 8px;
        text-decoration: none;
        font-size: 0.875rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-view:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(99, 102, 241, 0.3);
        color: white;
    }
    
    .empty-state {
        text-align: center;
        padding: 3rem;
        color: #9ca3af;
    }
    
    .empty-state-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
    }
</style>

<div class="proyectos-page">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Botón Volver al Dashboard -->
        <a href="{{ route('jurado.dashboard') }}" class="inline-flex items-center mb-4 px-4 py-2 rounded-lg font-semibold text-sm" style="background: linear-gradient(135deg, #e89a3c, #f5a847); color: white; box-shadow: 4px 4px 8px rgba(232, 154, 60, 0.3);">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Volver al Dashboard
        </a>
        
        <div class="page-header">
            <h1 class="page-title">Proyectos de Eventos</h1>
            <p style="color: #6b7280; margin-top: 0.5rem;">Revisa los proyectos de los eventos en los que participas como jurado</p>
        </div>

        @if($eventosEnProgreso->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon">📋</div>
                <h3 style="color: #4b5563; margin-bottom: 0.5rem;">No hay eventos en progreso</h3>
                <p>Los eventos aparecerán aquí cuando estén activos y tengan proyectos publicados.</p>
            </div>
        @else
            @foreach($eventosEnProgreso as $evento)
                <div class="event-card">
                    <div class="event-header">
                        <div>
                            <h2 class="event-name">{{ $evento->nombre }}</h2>
                            <span class="event-badge">En Progreso</span>
                        </div>
                    </div>

                    <div class="event-info">
                        <div class="info-item">
                            <span class="info-label">Fecha:</span><br>
                            {{ $evento->fecha_inicio->format('d/m/Y') }} - {{ $evento->fecha_fin->format('d/m/Y') }}
                        </div>
                        <div class="info-item">
                            <span class="info-label">Equipos:</span><br>
                            {{ $evento->inscripciones_count }} inscritos
                        </div>
                        <div class="info-item">
                            <span class="info-label">Tipo:</span><br>
                            <span class="project-type-badge {{ $evento->tipo_proyecto === 'general' ? 'type-general' : 'type-individual' }}">
                                {{ $evento->tipo_proyecto === 'general' ? '📋 Proyecto General' : '📁 Proyectos Individuales' }}
                            </span>
                        </div>
                    </div>

                    @if($evento->tipo_proyecto === 'general')
                        {{-- Proyecto General --}}
                        @if($evento->proyectoGeneral)
                            <div class="project-list">
                                <div class="project-item">
                                    <div>
                                        <div class="project-title">{{ $evento->proyectoGeneral->titulo }}</div>
                                        <div class="project-team">Todos los equipos trabajan en este proyecto</div>
                                    </div>
                                    <a href="{{ route('jurado.proyectos.show', $evento->proyectoGeneral) }}" class="btn-view">
                                        Ver Proyecto →
                                    </a>
                                </div>
                            </div>
                        @endif
                    @else
                        {{-- Proyectos Individuales --}}
                        <div class="project-list">
                            <p style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.75rem;">
                                <strong>{{ $evento->proyectosEventoIndividuales->count() }}</strong> proyectos asignados
                            </p>
                            
                            @foreach($evento->proyectosEventoIndividuales->take(3) as $proyecto)
                                <div class="project-item">
                                    <div>
                                        <div class="project-title">{{ $proyecto->titulo }}</div>
                                        <div class="project-team">Equipo: {{ $proyecto->inscripcion->equipo->nombre }}</div>
                                    </div>
                                    <a href="{{ route('jurado.proyectos.show', $proyecto) }}" class="btn-view">
                                        Ver →
                                    </a>
                                </div>
                            @endforeach

                            @if($evento->proyectosEventoIndividuales->count() > 3)
                                <div style="text-align: center; margin-top: 1rem;">
                                    <a href="{{ route('jurado.proyectos.evento', $evento) }}" class="btn-view">
                                        Ver todos los proyectos ({{ $evento->proyectosEventoIndividuales->count() }})
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            @endforeach
        @endif
    </div>
</div>
@endsection
