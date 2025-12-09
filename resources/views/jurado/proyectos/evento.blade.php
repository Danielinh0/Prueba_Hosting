@extends('jurado.layouts.app')

@section('content')

<div class="evento-proyectos-page">
    <div class="max-w-7xl mx-auto px-4">
        <a href="{{ route('jurado.proyectos.index') }}" class="back-link">
            ← Volver a Proyectos
        </a>

        <div class="page-header">
            <h1 class="event-title">{{ $evento->nombre }}</h1>
            <p style="color: #6b7280; margin-top: 0.5rem;">
                {{ $proyectos->count() }} proyectos individuales
            </p>
        </div>

        <div class="project-grid">
            @foreach($proyectos as $proyecto)
                <div class="project-card">
                    <h3 class="project-title">{{ $proyecto->titulo }}</h3>
                    <p class="team-name">🏆 Equipo: {{ $proyecto->inscripcion->equipo->nombre }}</p>

                    @if($proyecto->inscripcion->proyecto)
                    <div class="project-stats">
                        <div class="stat-item">
                            <div class="stat-value">{{ $proyecto->inscripcion->proyecto->avances->count() }}</div>
                            <div class="stat-label">Avances</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">{{ $proyecto->inscripcion->proyecto->tareas->count() }}</div>
                            <div class="stat-label">Tareas</div>
                        </div>
                    </div>
                    @else
                    <div style="padding: 1rem; text-align: center; color: #9ca3af; font-size: 0.875rem;">
                        Sin avances aún
                    </div>
                    @endif

                    <a href="{{ route('jurado.proyectos.show', $proyecto) }}" class="btn-view-project">
                        Ver Detalles →
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
    
    .evento-proyectos-page {
        font-family: 'Poppins', sans-serif;
        padding: 2rem 0;
    }
    
    .back-link {
        color: #6366f1;
        font-size: 0.875rem;
        text-decoration: none;
    }
    
    .page-header {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .event-title {
        font-size: 1.875rem;
        font-weight: 700;
        color: #2c2c2c;
    }
    
    .project-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 1.5rem;
    }
    
    .project-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        border: 1px solid #e5e7eb;
        transition: all 0.3s ease;
    }
    
    .project-card:hover {
        border-color: #6366f1;
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.15);
        transform: translateY(-2px);
    }
    
    .project-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: #2c2c2c;
        margin-bottom: 0.5rem;
    }
    
    .team-name {
        font-size: 0.875rem;
        color: #6b7280;
        margin-bottom: 1rem;
    }
    
    .project-stats {
        display: flex;
        justify-content: space-around;
        padding: 1rem 0;
        border-top: 1px solid #e5e7eb;
        border-bottom: 1px solid #e5e7eb;
        margin: 1rem 0;
    }
    
    .stat-item {
        text-align: center;
    }
    
    .stat-value {
        font-size: 1.25rem;
        font-weight: 700;
        color: #6366f1;
    }
    
    .stat-label {
        font-size: 0.75rem;
        color: #9ca3af;
    }
    
    .btn-view-project {
        display: block;
        width: 100%;
        text-align: center;
        padding: 0.75rem;
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: white;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-view-project:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(99, 102, 241, 0.3);
        color: white;
    }
</style>
@endsection
