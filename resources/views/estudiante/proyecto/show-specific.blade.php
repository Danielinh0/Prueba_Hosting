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

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

    :root {
        --primary: #e89a3c;
        --primary-dark: #d98a2c;
        --bg-base: #FFFDF4;
        --bg-card: #FFEEE2;
        --shadow-light: #ffffff;
        --shadow-dark: #e6d5c9;
        --text-primary: #2c2c2c;
        --text-secondary: #6b6b6b;
        --accent-purple: #6366f1;
        --accent-green: #10b981;
        --accent-red: #ef4444;
    }

    .proyecto-page {
        background: linear-gradient(135deg, var(--bg-base), var(--bg-card));
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
        padding: 2rem 0;
    }

    /* ========== BACK LINK ========== */
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--text-primary);
        font-weight: 500;
        font-size: 0.9rem;
        padding: 0.75rem 1.25rem;
        background: var(--bg-card);
        border-radius: 12px;
        box-shadow: 4px 4px 8px var(--shadow-dark), -4px -4px 8px var(--shadow-light);
        text-decoration: none;
        transition: all 0.3s ease;
        margin-bottom: 1.5rem;
    }

    .back-link:hover {
        transform: translateY(-2px);
        box-shadow: 6px 6px 12px var(--shadow-dark), -6px -6px 12px var(--shadow-light);
        color: var(--primary);
    }

    .back-link svg {
        width: 1.1rem;
        height: 1.1rem;
    }

    /* ========== HERO CARD ========== */
    .hero-card {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
        border-radius: 24px;
        padding: 2.5rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    .hero-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(232, 154, 60, 0.15) 0%, transparent 70%);
        border-radius: 50%;
    }

    .hero-card::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -10%;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(99, 102, 241, 0.1) 0%, transparent 70%);
        border-radius: 50%;
    }

    .hero-content {
        position: relative;
        z-index: 1;
    }

    .hero-badges {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
    }

    .hero-badge {
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-size: 0.8rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }

    .badge-event {
        background: linear-gradient(135deg, var(--accent-purple), #4f46e5);
        color: white;
    }

    .badge-leader {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
    }

    .hero-title {
        font-size: 2.5rem;
        font-weight: 800;
        color: white;
        margin-bottom: 0.75rem;
        line-height: 1.2;
    }

    .hero-subtitle {
        color: rgba(255, 255, 255, 0.7);
        font-size: 1rem;
        margin-bottom: 1.5rem;
    }

    .hero-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 2rem;
    }

    .hero-meta-item {
        display: flex;
        flex-direction: column;
    }

    .hero-meta-label {
        color: rgba(255, 255, 255, 0.5);
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.25rem;
    }

    .hero-meta-value {
        color: white;
        font-weight: 600;
        font-size: 1rem;
    }

    .hero-actions {
        margin-top: 2rem;
    }

    /* ========== STATS GRID ========== */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: var(--bg-card);
        border-radius: 20px;
        padding: 1.75rem;
        text-align: center;
        box-shadow: 8px 8px 16px var(--shadow-dark), -8px -8px 16px var(--shadow-light);
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 12px 12px 24px var(--shadow-dark), -12px -12px 24px var(--shadow-light);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        margin: 0 auto 1rem;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .stat-icon.purple { background: linear-gradient(135deg, var(--accent-purple), #4f46e5); color: white; }
    .stat-icon.green { background: linear-gradient(135deg, var(--accent-green), #059669); color: white; }
    .stat-icon.orange { background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: white; }

    .stat-value {
        font-size: 2.25rem;
        font-weight: 800;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
    }

    .stat-label {
        color: var(--text-secondary);
        font-size: 0.875rem;
        font-weight: 500;
    }

    .progress-bar {
        height: 8px;
        background: rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        margin-top: 0.75rem;
        overflow: hidden;
        box-shadow: inset 2px 2px 4px var(--shadow-dark);
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--accent-purple), #4f46e5);
        border-radius: 10px;
        transition: width 0.5s ease;
    }

    /* ========== CONTENT SECTIONS ========== */
    .content-section {
        background: var(--bg-card);
        border-radius: 24px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 8px 8px 16px var(--shadow-dark), -8px -8px 16px var(--shadow-light);
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid rgba(232, 154, 60, 0.15);
    }

    .section-title {
        font-size: 1.35rem;
        font-weight: 700;
        color: var(--text-primary);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .section-title i {
        color: var(--primary);
        font-size: 1.15rem;
    }

    /* ========== ITEM CARDS ========== */
    .item-grid {
        display: grid;
        gap: 1rem;
    }

    .item-card {
        background: rgba(255, 255, 255, 0.6);
        border-radius: 16px;
        padding: 1.25rem;
        border-left: 4px solid transparent;
        box-shadow: 4px 4px 8px var(--shadow-dark), -4px -4px 8px var(--shadow-light);
        transition: all 0.3s ease;
    }

    .item-card:hover {
        transform: translateX(5px);
        box-shadow: 6px 6px 12px var(--shadow-dark), -6px -6px 12px var(--shadow-light);
    }

    .item-card.completed {
        border-left-color: var(--accent-green);
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.05), rgba(5, 150, 105, 0.03));
    }

    .item-card.pending {
        border-left-color: var(--primary);
        background: linear-gradient(135deg, rgba(232, 154, 60, 0.05), rgba(245, 158, 11, 0.03));
    }

    .item-title {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        font-size: 1rem;
    }

    .item-description {
        color: var(--text-secondary);
        font-size: 0.875rem;
        line-height: 1.5;
    }

    .item-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 1rem;
    }

    .item-badge {
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.35rem 0.85rem;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
    }

    .badge-success {
        background: rgba(16, 185, 129, 0.15);
        color: #059669;
    }

    .badge-warning {
        background: rgba(232, 154, 60, 0.15);
        color: #d97706;
    }

    /* ========== BUTTONS ========== */
    .btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.85rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.9rem;
        text-decoration: none;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
        box-shadow: 0 4px 15px rgba(232, 154, 60, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(232, 154, 60, 0.4);
        color: white;
    }

    .btn-purple {
        background: linear-gradient(135deg, var(--accent-purple), #4f46e5);
        color: white;
        box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
    }

    .btn-purple:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4);
        color: white;
    }

    .btn-green {
        background: linear-gradient(135deg, var(--accent-green), #059669);
        color: white;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    }

    .btn-green:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        color: white;
    }

    .btn-outline {
        background: transparent;
        border: 2px solid var(--primary);
        color: var(--primary);
    }

    .btn-outline:hover {
        background: var(--primary);
        color: white;
    }

    /* ========== EVALUATIONS ========== */
    .evaluation-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
    }

    .evaluation-card {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.08), rgba(5, 150, 105, 0.05));
        border: 1px solid rgba(16, 185, 129, 0.15);
        border-radius: 20px;
        padding: 1.75rem;
        text-align: center;
        box-shadow: 4px 4px 8px var(--shadow-dark), -4px -4px 8px var(--shadow-light);
    }

    .evaluation-grade {
        font-size: 3rem;
        font-weight: 800;
        background: linear-gradient(135deg, var(--accent-green), #059669);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 0.5rem;
    }

    .evaluation-jurado {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
    }

    .evaluation-role {
        color: var(--text-secondary);
        font-size: 0.8rem;
        margin-bottom: 1rem;
    }

    .evaluation-comments {
        color: var(--text-secondary);
        font-size: 0.875rem;
        line-height: 1.6;
        font-style: italic;
    }

    /* ========== EMPTY STATE ========== */
    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
    }

    .empty-state i {
        font-size: 4rem;
        color: var(--primary);
        margin-bottom: 1.5rem;
        opacity: 0.6;
    }

    .empty-state h5 {
        font-size: 1.25rem;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: var(--text-secondary);
        font-size: 0.9rem;
    }

    /* ========== DESCRIPTION BOX ========== */
    .description-box {
        background: rgba(255, 255, 255, 0.5);
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: inset 2px 2px 4px var(--shadow-dark), inset -2px -2px 4px var(--shadow-light);
    }

    .description-box p {
        color: var(--text-secondary);
        line-height: 1.8;
    }

    /* ========== RESPONSIVE ========== */
    @media (max-width: 768px) {
        .hero-title {
            font-size: 1.75rem;
        }
        .hero-meta {
            gap: 1rem;
        }
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>
@endsection
