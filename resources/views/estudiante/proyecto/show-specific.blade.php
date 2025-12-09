@extends('layouts.app')

@section('title', 'Mi Proyecto')

@section('content')

<div class="proyecto-page">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <a href="{{ route('estudiante.proyectos.index') }}" class="back-link">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver a Mis Proyectos
        </a>

        <!-- ========== HERO CARD ========== -->
        <div class="hero-card">
            <div class="hero-content">
                <div class="hero-badges">
                    @if($evento)
                        <span class="hero-badge badge-event">
                            <i class="fas fa-calendar-alt"></i>
                            {{ $evento->nombre }}
                        </span>
                    @endif
                    @if($esLider)
                        <span class="hero-badge badge-leader">
                            <i class="fas fa-crown"></i>
                            Líder del Equipo
                        </span>
                    @endif
                </div>

                <h1 class="hero-title">{{ $proyecto->nombre }}</h1>
                <p class="hero-subtitle">{{ Str::limit($proyecto->descripcion_tecnica ?? 'Proyecto de desarrollo', 120) }}</p>

                <div class="hero-meta">
                    <div class="hero-meta-item">
                        <span class="hero-meta-label">Equipo</span>
                        <span class="hero-meta-value">{{ $inscripcion->equipo->nombre }}</span>
                    </div>
                    @if($evento)
                        <div class="hero-meta-item">
                            <span class="hero-meta-label">Estado Evento</span>
                            <span class="hero-meta-value">{{ $evento->estado }}</span>
                        </div>
                    @endif
                    @if($proyecto->repositorio_url)
                        <div class="hero-meta-item">
                            <span class="hero-meta-label">Repositorio</span>
                            <a href="{{ $proyecto->repositorio_url }}" target="_blank" class="hero-meta-value" style="color: #60a5fa;">
                                <i class="fab fa-github"></i> Ver en GitHub
                            </a>
                        </div>
                    @endif
                </div>

                @if($esLider)
                    <div class="hero-actions">
                        <a href="{{ route('estudiante.proyecto.edit-specific', $proyecto->id_proyecto) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i>
                            Editar Proyecto
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- ========== STATS GRID ========== -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon purple">
                    <i class="fas fa-tasks"></i>
                </div>
                <div class="stat-value">{{ $tareasCompletadas }}/{{ $totalTareas }}</div>
                <div class="stat-label">Tareas Completadas</div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: {{ $porcentajeTareas }}%;"></div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon green">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-value">{{ $avances->count() }}</div>
                <div class="stat-label">Avances Registrados</div>
            </div>

            @if($evaluacionesFinalizadas > 0)
                <div class="stat-card">
                    <div class="stat-icon orange">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="stat-value">{{ $promedioGeneral }}/100</div>
                    <div class="stat-label">Calificación Promedio</div>
                </div>
            @endif
        </div>

        <!-- ========== DESCRIPCIÓN ========== -->
        @if($proyecto->descripcion_tecnica)
            <div class="content-section">
                <div class="section-header">
                    <h3 class="section-title">
                        <i class="fas fa-file-alt"></i>
                        Descripción Técnica
                    </h3>
                </div>
                <div class="description-box">
                    <p>{{ $proyecto->descripcion_tecnica }}</p>
                </div>
            </div>
        @endif

        <!-- ========== TAREAS ========== -->
        <div class="content-section">
            <div class="section-header">
                <h3 class="section-title">
                    <i class="fas fa-tasks"></i>
                    Tareas del Proyecto
                </h3>
                @if($esLider)
                    <a href="{{ route('estudiante.tareas.index-specific', $proyecto->id_proyecto) }}" class="btn btn-purple">
                        <i class="fas fa-cog"></i>
                        Gestionar Tareas
                    </a>
                @endif
            </div>

            @if($tareas->isNotEmpty())
                <div class="item-grid">
                    @foreach($tareas->take(5) as $tarea)
                        <div class="item-card {{ $tarea->completada ? 'completed' : 'pending' }}">
                            <div class="item-title">{{ $tarea->nombre }}</div>
                            @if($tarea->descripcion)
                                <div class="item-description">{{ Str::limit($tarea->descripcion, 100) }}</div>
                            @endif
                            <div class="item-footer">
                                <span class="item-badge {{ $tarea->completada ? 'badge-success' : 'badge-warning' }}">
                                    <i class="fas {{ $tarea->completada ? 'fa-check-circle' : 'fa-clock' }}"></i>
                                    {{ $tarea->completada ? 'Completada' : 'Pendiente' }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if($tareas->count() > 5)
                    <p class="text-center mt-4" style="color: var(--text-secondary); font-size: 0.875rem;">
                        Mostrando 5 de {{ $tareas->count() }} tareas
                    </p>
                @endif
            @else
                <div class="empty-state">
                    <i class="fas fa-clipboard-list"></i>
                    <h5>No hay tareas registradas</h5>
                    <p>Comienza agregando tareas para organizar el proyecto</p>
                </div>
            @endif
        </div>

        <!-- ========== AVANCES ========== -->
        <div class="content-section">
            <div class="section-header">
                <h3 class="section-title">
                    <i class="fas fa-chart-line"></i>
                    Avances del Proyecto
                </h3>
                @if($esLider)
                    <a href="{{ route('estudiante.avances.create-specific', $proyecto->id_proyecto) }}" class="btn btn-green">
                        <i class="fas fa-plus"></i>
                        Registrar Avance
                    </a>
                @endif
            </div>

            @if($avances->isNotEmpty())
                <div class="item-grid">
                    @foreach($avances->take(3) as $avance)
                        <div class="item-card">
                            <div class="item-title">{{ $avance->titulo }}</div>
                            @if($avance->descripcion)
                                <div class="item-description">{{ Str::limit($avance->descripcion, 120) }}</div>
                            @endif
                            <div class="item-footer">
                                <span style="color: var(--text-secondary); font-size: 0.8rem;">
                                    <i class="fas fa-calendar"></i>
                                    {{ $avance->created_at->format('d M Y') }}
                                </span>
                                @if($avance->archivo_adjunto)
                                    <a href="{{ asset('storage/' . $avance->archivo_adjunto) }}" target="_blank" 
                                       style="color: var(--accent-purple); font-size: 0.85rem;">
                                        <i class="fas fa-paperclip"></i> Ver archivo
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                @if($avances->count() > 3)
                    <div class="text-center mt-4">
                        <a href="{{ route('estudiante.avances.index-specific', $proyecto->id_proyecto) }}" class="btn btn-outline">
                            Ver todos los avances ({{ $avances->count() }})
                        </a>
                    </div>
                @endif
            @else
                <div class="empty-state">
                    <i class="fas fa-chart-area"></i>
                    <h5>No hay avances registrados</h5>
                    <p>Registra avances para documentar el progreso del proyecto</p>
                </div>
            @endif
        </div>

        <!-- ========== EVALUACIONES ========== -->
        @if($evaluacionesFinales->isNotEmpty())
            <div class="content-section">
                <div class="section-header">
                    <h3 class="section-title">
                        <i class="fas fa-star"></i>
                        Evaluaciones de Jurados
                    </h3>
                </div>
                <div class="evaluation-grid">
                    @foreach($evaluacionesFinales as $evaluacion)
                        @if($evaluacion->estado === 'Finalizada')
                            <div class="evaluation-card">
                                <div class="evaluation-grade">{{ $evaluacion->calificacion_final }}/100</div>
                                <div class="evaluation-jurado">{{ $evaluacion->jurado->user->nombre }}</div>
                                <div class="evaluation-role">Jurado Evaluador</div>
                                @if($evaluacion->comentarios_finales)
                                    <div class="evaluation-comments">"{{ Str::limit($evaluacion->comentarios_finales, 150) }}"</div>
                                @endif
                            </div>
                        @endif
                    @endforeach
                </div>
                @if($evaluacionesFinalizadas < $totalEvaluaciones)
                    <p class="text-center mt-4" style="color: var(--text-secondary); font-size: 0.875rem;">
                        {{ $evaluacionesFinalizadas }} de {{ $totalEvaluaciones }} evaluaciones completadas
                    </p>
                @endif
            </div>
        @endif
    </div>
</div>

@endsection
