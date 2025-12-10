@extends('layouts.app')

@section('title', 'Mi Proyecto')

@section('content')

<div class="proyecto-page">
    <div class="container-compact">
        
        <a href="{{ route('estudiante.proyectos.index') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Mis Proyectos
        </a>

        {{-- ========== HERO SECTION ========== --}}
        <div class="hero-section">
            <div class="hero-badges">
                @if($evento)
                    <span class="badge badge-event">
                        <i class="fas fa-calendar"></i> {{ $evento->nombre }}
                    </span>
                @endif
                @if($esLider)
                    <span class="badge badge-leader">
                        <i class="fas fa-crown"></i> Líder
                    </span>
                @endif
            </div>

            <h1 class="hero-title">{{ $proyecto->nombre }}</h1>
            
            @if($proyecto->descripcion_tecnica)
                <p class="hero-desc">{{ Str::limit($proyecto->descripcion_tecnica, 100) }}</p>
            @endif

            <div class="hero-meta">
                <div class="meta-item">
                    <i class="fas fa-users"></i>
                    <span>{{ $inscripcion->equipo->nombre }}</span>
                </div>
                @if($proyecto->repositorio_url)
                    <a href="{{ $proyecto->repositorio_url }}" target="_blank" class="meta-item meta-link">
                        <i class="fab fa-github"></i>
                        <span>Repositorio</span>
                    </a>
                @endif
                @if($evento)
                    <div class="meta-item">
                        <i class="fas fa-flag"></i>
                        <span>{{ $evento->estado }}</span>
                    </div>
                @endif
            </div>

            @if($esLider)
                <a href="{{ route('estudiante.proyecto.edit-specific', $proyecto->id_proyecto) }}" class="btn-edit">
                    <i class="fas fa-edit"></i> Editar
                </a>
            @endif
        </div>

        {{-- ========== STATS ROW ========== --}}
        <div class="stats-row">
            <div class="stat-box">
                <div class="stat-icon purple"><i class="fas fa-tasks"></i></div>
                <div class="stat-info">
                    <span class="stat-num">{{ $tareasCompletadas }}/{{ $totalTareas }}</span>
                    <span class="stat-label">Tareas</span>
                </div>
                <div class="stat-bar"><div class="stat-fill" style="width: {{ $porcentajeTareas }}%"></div></div>
            </div>
            <div class="stat-box">
                <div class="stat-icon green"><i class="fas fa-chart-line"></i></div>
                <div class="stat-info">
                    <span class="stat-num">{{ $avances->count() }}</span>
                    <span class="stat-label">Avances</span>
                </div>
            </div>
            @if($evaluacionesFinalizadas > 0)
                <div class="stat-box">
                    <div class="stat-icon orange"><i class="fas fa-star"></i></div>
                    <div class="stat-info">
                        <span class="stat-num">{{ $promedioGeneral }}</span>
                        <span class="stat-label">Promedio</span>
                    </div>
                </div>
            @endif
        </div>

        {{-- ========== TAREAS ========== --}}
        <div class="section-card">
            <div class="section-head">
                <h3><i class="fas fa-tasks"></i> Tareas del Proyecto</h3>
                @if($esLider)
                    <a href="{{ route('estudiante.tareas.index-specific', $proyecto->id_proyecto) }}" class="btn-sm btn-purple">
                        <i class="fas fa-cog"></i> Gestionar
                    </a>
                @endif
            </div>

            @if($tareas->isNotEmpty())
                <div class="task-list">
                    @foreach($tareas->take(6) as $tarea)
                        <div class="task-item {{ $tarea->completada ? 'done' : 'pending' }}">
                            <div class="task-check">
                                <i class="fas {{ $tarea->completada ? 'fa-check-circle' : 'fa-circle' }}"></i>
                            </div>
                            <div class="task-content">
                                <div class="task-name">{{ $tarea->nombre }}</div>
                                @if($tarea->descripcion)
                                    <div class="task-desc">{{ Str::limit($tarea->descripcion, 80) }}</div>
                                @endif
                                @if($tarea->completada && $tarea->completadaPor)
                                    <div class="task-meta">
                                        <i class="fas fa-user-check"></i>
                                        {{ $tarea->completadaPor->nombre }} 
                                        <span class="sep">•</span>
                                        {{ $tarea->fecha_completada?->format('d M') }}
                                    </div>
                                @endif
                            </div>
                            <span class="task-badge {{ $tarea->completada ? 'badge-ok' : 'badge-wait' }}">
                                {{ $tarea->completada ? 'Hecho' : 'Pendiente' }}
                            </span>
                        </div>
                    @endforeach
                </div>
                @if($tareas->count() > 6)
                    <div class="section-footer">
                        <span>{{ $tareas->count() - 6 }} tareas más</span>
                    </div>
                @endif
            @else
                <div class="empty-mini">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Sin tareas registradas</span>
                </div>
            @endif
        </div>

        {{-- ========== AVANCES ========== --}}
        <div class="section-card">
            <div class="section-head">
                <h3><i class="fas fa-chart-line"></i> Avances del Proyecto</h3>
                <div class="head-actions">
                    @if($esLider)
                        <a href="{{ route('estudiante.avances.create-specific', $proyecto->id_proyecto) }}" class="btn-sm btn-green">
                            <i class="fas fa-plus"></i> Nuevo
                        </a>
                    @endif
                    <a href="{{ route('estudiante.avances.index-specific', $proyecto->id_proyecto) }}" class="btn-sm btn-outline">
                        <i class="fas fa-history"></i> Ver Timeline
                    </a>
                </div>
            </div>

            @if($avances->isNotEmpty())
                <div class="avance-list">
                    @foreach($avances->take(4) as $avance)
                        @php
                            $evaluaciones = $avance->evaluaciones;
                            $tieneEvaluaciones = $evaluaciones->isNotEmpty();
                        @endphp
                        <div class="avance-item {{ $tieneEvaluaciones ? 'graded' : 'pending' }}">
                            <div class="avance-header">
                                <h4 class="avance-title">{{ $avance->titulo }}</h4>
                                <span class="avance-status {{ $tieneEvaluaciones ? 'status-ok' : 'status-wait' }}">
                                    <i class="fas {{ $tieneEvaluaciones ? 'fa-check' : 'fa-clock' }}"></i>
                                    {{ $tieneEvaluaciones ? $evaluaciones->count() . ' evaluación(es)' : 'Sin calificar' }}
                                </span>
                            </div>
                            
                            @if($avance->descripcion)
                                <p class="avance-desc">{{ $avance->descripcion }}</p>
                            @endif

                            @if($tieneEvaluaciones)
                                <div class="eval-list">
                                    @foreach($evaluaciones as $evaluacion)
                                        <div class="eval-box">
                                            <div class="eval-score">
                                                <span class="score-num">{{ $evaluacion->calificacion }}</span>
                                                <span class="score-max">/100</span>
                                            </div>
                                            <div class="eval-info">
                                                <div class="eval-jurado">
                                                    <i class="fas fa-user-tie"></i>
                                                    {{ $evaluacion->jurado->user->nombre ?? 'Jurado' }} {{ $evaluacion->jurado->user->app_paterno ?? '' }}
                                                </div>
                                                <div class="eval-date">
                                                    <i class="fas fa-calendar"></i>
                                                    {{ $evaluacion->fecha_evaluacion?->format('d M Y') }}
                                                </div>
                                                @if($evaluacion->comentarios)
                                                    <div class="eval-comment">
                                                        <i class="fas fa-comment"></i>
                                                        "{{ Str::limit($evaluacion->comentarios, 80) }}"
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="avance-date">
                                    <i class="fas fa-calendar"></i> {{ $avance->created_at->format('d M Y') }}
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
                @if($avances->count() > 4)
                    <div class="section-footer">
                        <a href="{{ route('estudiante.avances.index-specific', $proyecto->id_proyecto) }}">
                            Ver todos los avances ({{ $avances->count() }}) →
                        </a>
                    </div>
                @endif
            @else
                <div class="empty-mini">
                    <i class="fas fa-chart-area"></i>
                    <span>Sin avances registrados</span>
                </div>
            @endif
        </div>

        {{-- ========== EVALUACIONES FINALES ========== --}}
        @if($evaluacionesFinales->isNotEmpty())
            <div class="section-card">
                <div class="section-head">
                    <h3><i class="fas fa-star"></i> Evaluaciones Finales de Jurados</h3>
                </div>
                <div class="eval-grid">
                    @foreach($evaluacionesFinales as $eval)
                        @if($eval->estado === 'Finalizada')
                            <div class="eval-card">
                                <div class="eval-grade">{{ $eval->calificacion_final }}<small>/100</small></div>
                                <div class="eval-name">{{ $eval->jurado->user->nombre }}</div>
                                <button class="btn-inspect" onclick="openModal({{ $eval->id_evaluacion }})">
                                    <i class="fas fa-search"></i> Inspeccionar
                                </button>
                                @if($eval->comentarios_generales)
                                    <div class="eval-feedback">"{{ Str::limit($eval->comentarios_generales, 100) }}"</div>
                                @endif
                            </div>
                        @endif
                    @endforeach
                </div>
                @if($evaluacionesFinalizadas < $totalEvaluaciones)
                    <div class="section-footer">
                        <span>{{ $evaluacionesFinalizadas }}/{{ $totalEvaluaciones }} evaluaciones completadas</span>
                    </div>
                @endif
            </div>
        @endif

    </div>
</div>

<!-- Modal para inspeccionar evaluación -->
<div id="inspectModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Detalles de Evaluación</h3>
            <span class="close" onclick="closeModal()">&times;</span>
        </div>
        <div class="modal-body" id="modalBody">
            <!-- Contenido dinámico -->
        </div>
    </div>
</div>

<style>
/* ========== NEUMORPHIC MODERN DESIGN ========== */
.proyecto-page {
    background: linear-gradient(135deg, #FFFDF4 0%, #FFEEE2 50%, #FFF5E8 100%);
    min-height: 100vh;
    padding: 1.25rem 1rem;
    font-family: 'Inter', -apple-system, sans-serif;
}

.container-compact {
    max-width: 800px;
    margin: 0 auto;
}

/* Back Link - Neumórfico */
.back-link {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    color: #6b7280;
    font-size: 0.8rem;
    font-weight: 500;
    text-decoration: none;
    margin-bottom: 1rem;
    padding: 0.5rem 1rem;
    background: #ffeee2;
    border-radius: 12px;
    box-shadow: 3px 3px 6px #e6d5c9, -3px -3px 6px rgba(255, 255, 255, 0.7);
    transition: all 0.3s ease;
}
.back-link:hover { 
    color: #e89a3c;
    box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px rgba(255, 255, 255, 0.8);
    transform: translateX(-3px);
}

/* Hero Section - Neumórfico Oscuro */
.hero-section {
    background: linear-gradient(135deg, #1a1a1a 0%, #2c2c2c 100%);
    border-radius: 16px;
    padding: 1.5rem;
    margin-bottom: 1rem;
    position: relative;
    box-shadow: 10px 10px 20px rgba(0, 0, 0, 0.15), 
                -8px -8px 16px rgba(255, 255, 255, 0.05),
                inset 0 1px 0 rgba(232, 154, 60, 0.2);
    border: 1px solid rgba(232, 154, 60, 0.3);
}

.hero-badges {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 0.75rem;
}

.badge {
    padding: 0.25rem 0.6rem;
    border-radius: 20px;
    font-size: 0.65rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.3rem;
    box-shadow: inset 1px 1px 2px rgba(0, 0, 0, 0.1), inset -1px -1px 2px rgba(255, 255, 255, 0.05);
}
.badge-event { 
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.2), rgba(99, 102, 241, 0.15));
    color: #a5b4fc;
    border: 1px solid rgba(99, 102, 241, 0.3);
}
.badge-leader { 
    background: linear-gradient(135deg, rgba(232, 154, 60, 0.2), rgba(245, 168, 71, 0.15));
    color: #fcd34d;
    border: 1px solid rgba(232, 154, 60, 0.3);
}

.hero-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: white;
    margin: 0 0 0.5rem 0;
}

.hero-desc {
    color: rgba(255,255,255,0.7);
    font-size: 0.85rem;
    margin-bottom: 1rem;
}

.hero-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    color: rgba(255,255,255,0.6);
    font-size: 0.8rem;
}
.meta-link { color: #93c5fd; text-decoration: none; }
.meta-link:hover { color: #60a5fa; }

.btn-edit {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: rgba(232, 154, 60, 0.15);
    color: #f5a847;
    padding: 0.4rem 0.8rem;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 500;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 0.3rem;
    border: 1px solid rgba(232, 154, 60, 0.3);
    transition: all 0.3s ease;
}
.btn-edit:hover { 
    background: rgba(232, 154, 60, 0.25);
    color: #f5a847;
}

/* Stats Row - Neumórfico */
.stats-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
    gap: 0.75rem;
    margin-bottom: 1rem;
}

.stat-box {
    background: #ffeee2;
    border-radius: 12px;
    padding: 1rem;
    box-shadow: 6px 6px 12px #e6d5c9, -6px -6px 12px rgba(255, 255, 255, 0.6);
    border: 1px solid rgba(232, 154, 60, 0.1);
    transition: all 0.3s ease;
}

.stat-box:hover {
    transform: translateY(-3px);
    box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px rgba(255, 255, 255, 0.7);
}

.stat-icon {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
    box-shadow: 3px 3px 6px rgba(0, 0, 0, 0.1), -2px -2px 4px rgba(255, 255, 255, 0.5);
}
.stat-icon.purple { 
    background: linear-gradient(135deg, #8b5cf6, #7c3aed);
    color: white;
}
.stat-icon.green { 
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
}
.stat-icon.orange { 
    background: linear-gradient(135deg, #e89a3c, #f5a847);
    color: white;
}

.stat-info { display: flex; flex-direction: column; }
.stat-num { font-size: 1.25rem; font-weight: 700; color: #111827; }
.stat-label { font-size: 0.7rem; color: #6b7280; }

.stat-bar {
    height: 4px;
    background: #ffffff;
    border-radius: 2px;
    margin-top: 0.5rem;
    overflow: hidden;
    box-shadow: inset 1px 1px 2px #e6d5c9, inset -1px -1px 2px rgba(255, 255, 255, 0.5);
}
.stat-fill {
    height: 100%;
    background: linear-gradient(90deg, #8b5cf6, #6366f1);
    border-radius: 2px;
}

/* Section Cards - Neumórfico */
.section-card {
    background: #ffeee2;
    border-radius: 14px;
    padding: 1.25rem;
    margin-bottom: 1rem;
    box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px rgba(255, 255, 255, 0.6);
    border: 1px solid rgba(232, 154, 60, 0.1);
}

.section-head {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
    padding-bottom: 0.75rem;
    border-bottom: 1px solid rgba(230, 213, 201, 0.5);
}

.section-head h3 {
    font-size: 0.95rem;
    font-weight: 700;
    color: #111827;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin: 0;
}
.section-head h3 i { color: #e89a3c; font-size: 0.85rem; }

.head-actions { display: flex; gap: 0.5rem; }

.btn-sm {
    padding: 0.5rem 1.25rem;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 600;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 0.4rem;
    transition: all 0.3s ease;
    border: none;
    white-space: nowrap;
    min-width: fit-content;
}
.btn-purple { 
    background: linear-gradient(135deg, #8b5cf6, #7c3aed);
    color: white;
    box-shadow: 2px 2px 4px rgba(124, 58, 237, 0.3), -1px -1px 3px rgba(255, 255, 255, 0.5);
}
.btn-purple:hover { 
    transform: translateY(-2px);
    box-shadow: 3px 3px 6px rgba(124, 58, 237, 0.4), -2px -2px 4px rgba(255, 255, 255, 0.6);
    color: white;
}
.btn-purple:active {
    transform: translateY(0);
    box-shadow: inset 2px 2px 4px rgba(0, 0, 0, 0.15);
}

.btn-green { 
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    box-shadow: 2px 2px 4px rgba(5, 150, 105, 0.3), -1px -1px 3px rgba(255, 255, 255, 0.5);
}
.btn-green:hover { 
    transform: translateY(-2px);
    box-shadow: 3px 3px 6px rgba(5, 150, 105, 0.4), -2px -2px 4px rgba(255, 255, 255, 0.6);
    color: white;
}
.btn-green:active {
    transform: translateY(0);
    box-shadow: inset 2px 2px 4px rgba(0, 0, 0, 0.15);
}

.btn-outline { 
    background: #ffffff;
    color: #374151;
    box-shadow: 2px 2px 4px #e6d5c9, -2px -2px 4px rgba(255, 255, 255, 0.7);
}
.btn-outline:hover { 
    color: #111827;
    box-shadow: 3px 3px 6px #e6d5c9, -3px -3px 6px rgba(255, 255, 255, 0.8);
}
.btn-outline:active {
    box-shadow: inset 2px 2px 4px #e6d5c9;
}

/* Task List - DISEÑO PLANO DESTACADO */
.task-list { display: flex; flex-direction: column; gap: 0.5rem; }

.task-item {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    padding: 0.75rem;
    background: #fafafa;
    border-radius: 10px;
    border-left: 3px solid #e5e7eb;
    border: 1px solid #f3f4f6;
    transition: all 0.2s ease;
}
.task-item:hover {
    background: #fcf5c5ff;
    border-color: #e5e7eb;
}
.task-item.done { 
    border-left: 3px solid #10b981;
    background: #f0fdf4;
    border-color: #d1fae5;
}
.task-item.pending { 
    border-left: 3px solid #f59e0b;
    border-color: #d6b223ff;
}

.task-check { 
    font-size: 1rem; 
    margin-top: 0.1rem;
}
.task-item.done .task-check { color: #10b981; }
.task-item.pending .task-check { color: #fdfdfdff; border-color: #000000ff; }

.task-content { flex: 1; min-width: 0; }
.task-name { font-weight: 600; font-size: 0.85rem; color: #111827; }
.task-desc { font-size: 0.75rem; color: #6b7280; margin-top: 0.15rem; }
.task-meta { 
    font-size: 0.7rem; 
    color: #9ca3af; 
    margin-top: 0.25rem;
    display: flex;
    align-items: center;
    gap: 0.3rem;
}
.task-meta .sep { color: #d1d5db; }

.task-badge {
    font-size: 0.65rem;
    font-weight: 600;
    padding: 0.2rem 0.5rem;
    border-radius: 4px;
}
.badge-ok { 
    background: #d1fae5;
    color: #065f46;
}
.badge-wait { 
    background: #fef3c7;
    color: #92400e;
}

/* Avance List - DISEÑO PLANO DESTACADO */
.avance-list { display: flex; flex-direction: column; gap: 0.75rem; }

.avance-item {
    padding: 1rem;
    background: #fafafa;
    border-radius: 10px;
    border-left: 3px solid #e5e7eb;
    border: 1px solid #f3f4f6;
    transition: all 0.2s ease;
}
.avance-item:hover {
    background: #f5f5f5;
    border-color: #e5e7eb;
}
.avance-item.graded { 
    border-left: 3px solid #10b981;
    background: #f0fdf4;
    border-color: #d1fae5;
}
.avance-item.pending { 
    border-left: 3px solid #6366f1;
    border-color: #e0e7ff;
}

.avance-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.5rem;
}

.avance-title { font-size: 0.9rem; font-weight: 600; color: #111827; margin: 0; }

.avance-status {
    font-size: 0.65rem;
    font-weight: 600;
    padding: 0.2rem 0.5rem;
    border-radius: 4px;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}
.status-ok { 
    background: #d1fae5;
    color: #065f46;
}
.status-wait { 
    background: #e0e7ff;
    color: #3730a3;
}

.avance-desc {
    font-size: 0.8rem;
    color: #6b7280;
    margin-bottom: 0.75rem;
    white-space: normal; /* permitir que el contenedor crezca en altura */
    word-break: break-word; /* evitar desbordes largos */
}
.avance-date { font-size: 0.75rem; color: #9ca3af; display: flex; align-items: center; gap: 0.3rem; }

/* Eval List */
.eval-list {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

/* Eval Box - Neumórfico */
.eval-box {
    display: flex;
    gap: 1rem;
    padding: 0.75rem;
    background: #ffffff;
    border-radius: 8px;
    box-shadow: 3px 3px 6px #e6d5c9, -3px -3px 6px rgba(255, 255, 255, 0.6);
    border: 1px solid rgba(16, 185, 129, 0.2);
}

.eval-score {
    display: flex;
    align-items: baseline;
    gap: 0.1rem;
}
.score-num { font-size: 1.5rem; font-weight: 800; color: #059669; }
.score-max { font-size: 0.8rem; color: #6b7280; }

.eval-info { flex: 1; font-size: 0.75rem; color: #6b7280; }
.eval-jurado, .eval-date, .eval-comment { 
    display: flex; 
    align-items: center; 
    gap: 0.3rem; 
    margin-bottom: 0.25rem;
}
.eval-comment { font-style: italic; color: #4b5563; }

/* Eval Grid - Neumórfico */
.eval-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 0.75rem;
}

.eval-card {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.08), #ffffff);
    border: 1px solid rgba(16, 185, 129, 0.2);
    border-radius: 12px;
    padding: 1rem;
    text-align: center;
    box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px rgba(255, 255, 255, 0.6);
    transition: all 0.3s ease;
}

.eval-card:hover {
    box-shadow: 5px 5px 10px #e6d5c9, -5px -5px 10px rgba(255, 255, 255, 0.7);
}

.eval-grade {
    font-size: 2rem;
    font-weight: 800;
    color: #059669;
}
.eval-grade small { font-size: 1rem; color: #6b7280; }

.eval-name { font-size: 0.85rem; font-weight: 600; color: #111827; margin-top: 0.25rem; }
.eval-feedback { font-size: 0.75rem; color: #6b7280; font-style: italic; margin-top: 0.5rem; }

/* Empty & Footer */
.empty-mini {
    text-align: center;
    padding: 2rem 1rem;
    color: #9ca3af;
}
.empty-mini i { font-size: 1.5rem; margin-bottom: 0.5rem; display: block; opacity: 0.5; }
.empty-mini span { font-size: 0.8rem; }

.section-footer {
    text-align: center;
    padding-top: 0.75rem;
    font-size: 0.75rem;
    color: #6b7280;
}
.section-footer a { color: #6366f1; text-decoration: none; font-weight: 500; }
.section-footer a:hover { color: #4f46e5; }

/* Modal Styles */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.5);
}

.modal-content {
    background: linear-gradient(180deg, #ffffff, #fbf8f4);
    margin: 5% auto;
    padding: 0;
    border-radius: 14px;
    width: 90%;
    max-width: 600px;
    /* Neuomorphic soft shadows */
    box-shadow: 12px 12px 24px rgba(16,24,40,0.06), -8px -8px 20px rgba(255,255,255,0.9);
    border: 1px solid rgba(0,0,0,0.04);
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 1.5rem;
    border-bottom: 1px solid rgba(0,0,0,0.04);
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: #ffffff;
    border-radius: 14px 14px 0 0;
    box-shadow: inset 0 -6px 16px rgba(0,0,0,0.06);
}

.modal-header h3 {
    margin: 0;
    font-size: 1.1rem;
    color: #ffffff;
}

.close {
    color: rgba(255,255,255,0.95);
    font-size: 1.5rem;
    font-weight: 700;
    cursor: pointer;
    background: rgba(255,255,255,0.08);
    padding: 0.25rem 0.5rem;
    border-radius: 8px;
}

.close:hover { color: #ffffff; background: rgba(255,255,255,0.12); }

.modal-body {
    padding: 1.5rem;
    max-height: 70vh;
    overflow-y: auto;
    background: linear-gradient(180deg, rgba(255,255,255,0.95), rgba(250,248,244,0.98));
    border-radius: 0 0 14px 14px;
    box-shadow: inset 0 6px 18px rgba(0,0,0,0.02);
}

/* Button Inspect */
.btn-inspect {
    background: #f59e0b;
    color: #ffffff;
    border: none;
    padding: 0.5rem 0.95rem;
    border-radius: 10px;
    font-size: 0.82rem;
    font-weight: 700;
    cursor: pointer;
    display: block;
    margin: 0.6rem auto;
    transition: transform 0.14s ease, box-shadow 0.14s ease, background 0.14s ease;
    box-shadow: 8px 12px 24px rgba(245,158,11,0.12), -6px -6px 14px rgba(255,255,255,0.9);
    align-items: center;
    gap: 0.4rem;
}

.btn-inspect:hover {
    background: #d97706;
    transform: translateY(-2px);
    box-shadow: 10px 16px 30px rgba(217,119,6,0.14), -6px -6px 14px rgba(255,255,255,0.9);
}

.btn-inspect i { color: rgba(255,255,255,0.95); }

/* Modal content formatting */
.modal-eval-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
    margin-bottom: 0.75rem;
}
.modal-eval-title {
    font-size: 1rem;
    font-weight: 700;
    color: #0f172a;
    margin: 0;
}
.modal-eval-score {
    text-align: right;
}
.modal-eval-score .score-big {
    font-size: 1.6rem;
    font-weight: 900;
    color: #d97706;
    background: linear-gradient(90deg, rgba(245,158,11,0.12), rgba(217,119,6,0.06));
    padding: 0.25rem 0.6rem;
    border-radius: 8px;
    display: inline-block;
}
.criteria-list {
    list-style: none;
    padding: 0;
    margin: 0.5rem 0 0 0;
    display: grid;
    gap: 0.5rem;
}
.criteria-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.6rem 0.75rem;
    background: linear-gradient(180deg, #ffffff, #faf7f2);
    border-radius: 10px;
    border-left: 4px solid #f59e0b;
    box-shadow: 8px 12px 22px rgba(245,158,11,0.06), -6px -6px 14px rgba(255,255,255,0.9);
}
.crit-name { font-weight: 600; color: #0f172a; }
.crit-score { font-weight: 800; color: #b45309; }
.modal-section { margin-top: 1rem; }
.modal-section h5 { margin: 0 0 0.5rem 0; color: #b45309; font-size: 0.85rem; font-weight: 700; }
.note-box {
.note-box {
    background: #fffaf0;
    border: 1px solid rgba(217,119,6,0.06);
    padding: 0.6rem 0.75rem;
    border-radius: 8px;
    color: #374151;
    box-sizing: border-box;
    max-height: 160px; /* limita altura para evitar que crezca fuera del modal */
    overflow-y: auto;   /* scroll interno cuando hay exceso de contenido */
    white-space: pre-wrap; /* conservar saltos de linea */
    word-break: break-word;
    -webkit-overflow-scrolling: touch;
}

/* Scrollbar ligero para compatibilidad visual */
.note-box::-webkit-scrollbar { width: 8px; }
.note-box::-webkit-scrollbar-track { background: transparent; }
.note-box::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.08); border-radius: 8px; }

/* Responsive */
@media (max-width: 640px) {
    .hero-title { font-size: 1.25rem; }
    .stats-row { grid-template-columns: repeat(2, 1fr); }
    .btn-edit { position: static; margin-top: 1rem; display: inline-flex; }
    .head-actions { 
        flex-direction: column;
        width: 100%;
    }
    .btn-sm {
        width: 100%;
        justify-content: center;
    }
}
</style>

<script>
const evaluacionesData = @json($evaluacionesFinales);

function escapeHtml(unsafe) {
    if (unsafe === null || unsafe === undefined) return '';
    return String(unsafe)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}

function openModal(evalId) {
    const evalData = evaluacionesData.find(e => e.id_evaluacion == evalId);
    if (!evalData) return;

    const modal = document.getElementById('inspectModal');
    const modalBody = document.getElementById('modalBody');

    // Header: judge name + big final score
    let content = `<div class="modal-eval-header">`;
    content += `<h4 class="modal-eval-title">Evaluación de ${escapeHtml(evalData.jurado?.user?.nombre ?? 'Jurado')}</h4>`;
    content += `<div class="modal-eval-score"><span class="score-big">${Number(evalData.calificacion_final || 0).toFixed(2)}</span><div style="font-size:0.85rem;color:#6b7280;">/100</div></div>`;
    content += `</div>`;

    // Criterios
    if (evalData.criterios_calificados && evalData.criterios_calificados.length > 0) {
        content += `<div class="modal-section"><h5>Criterios Evaluados</h5><ul class="criteria-list">`;
        evalData.criterios_calificados.forEach(criterio => {
            const nombre = criterio.criterio?.nombre ?? 'Criterio';
            const cal = Number(criterio.calificacion || 0).toFixed(2);
            content += `<li class="criteria-item"><div class="crit-name">${escapeHtml(nombre)}</div><div class="crit-score">${cal}/100</div></li>`;
        });
        content += `</ul></div>`;
    } else {
        content += `<div class="modal-section"><h5>Criterios Evaluados</h5><div class="note-box">No hay criterios calificados.</div></div>`;
    }

    // Comentarios generales
    content += `<div class="modal-section"><h5>Comentarios Generales</h5>`;
    content += `<div class="note-box">${escapeHtml(evalData.comentarios_generales ?? '—')}</div>`;
    content += `</div>`;

    // Fortalezas
    content += `<div class="modal-section"><h5>Fortalezas</h5>`;
    content += `<div class="note-box">${escapeHtml(evalData.comentarios_fortalezas ?? '—')}</div>`;
    content += `</div>`;

    // Áreas de mejora
    content += `<div class="modal-section"><h5>Áreas de Mejora</h5>`;
    content += `<div class="note-box">${escapeHtml(evalData.comentarios_areas_mejora ?? '—')}</div>`;
    content += `</div>`;

    modalBody.innerHTML = content;

    // Show modal
    modal.style.display = 'block';
}

function closeModal() {
    document.getElementById('inspectModal').style.display = 'none';
}

// Cerrar modal al hacer clic fuera
window.onclick = function(event) {
    const modal = document.getElementById('inspectModal');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}
</script>

@endsection
