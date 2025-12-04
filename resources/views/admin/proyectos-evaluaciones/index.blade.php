@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
    
    .proyectos-page {
        background: linear-gradient(to bottom, #FFFDF4, #FFEEE2);
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
    }
    
    .proyectos-page * {
        font-family: 'Poppins', sans-serif;
    }

    /* Hero Section */
    .hero-section {
        background: linear-gradient(135deg, #2c2c2c 0%, #1a1a1a 100%);
        border-radius: 25px;
        padding: 2.5rem;
        margin-bottom: 2rem;
        box-shadow: 12px 12px 24px rgba(0, 0, 0, 0.3), -6px -6px 12px rgba(60, 60, 60, 0.2);
        position: relative;
        overflow: hidden;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -30%;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(232, 154, 60, 0.15) 0%, transparent 70%);
        pointer-events: none;
    }

    .hero-title {
        color: #ffffff;
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
    }

    .hero-subtitle {
        color: rgba(255, 255, 255, 0.7);
        font-size: 1rem;
    }

    /* Stats Cards */
    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: #FFEEE2;
        border-radius: 20px;
        padding: 1.5rem;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
        text-align: center;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 12px 12px 24px #e6d5c9, -12px -12px 24px #ffffff;
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
    }

    .stat-icon svg {
        width: 24px;
        height: 24px;
    }

    .stat-icon-orange {
        background: linear-gradient(135deg, #e89a3c, #f5b76c);
        color: white;
    }

    .stat-icon-gray {
        background: linear-gradient(135deg, #6b7280, #9ca3af);
        color: white;
    }

    .stat-icon-green {
        background: linear-gradient(135deg, #10b981, #34d399);
        color: white;
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 800;
        color: #2c2c2c;
        margin-bottom: 0.25rem;
    }

    .stat-label {
        font-size: 0.875rem;
        color: #6b7280;
        font-weight: 500;
    }

    /* Filters Section */
    .filters-card {
        background: #FFEEE2;
        border-radius: 20px;
        padding: 1.5rem;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
        margin-bottom: 2rem;
    }

    .filters-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        align-items: end;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .filter-label {
        font-size: 0.75rem;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .filter-input {
        background: rgba(255, 253, 244, 0.8);
        border: 2px solid transparent;
        border-radius: 12px;
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
        color: #2c2c2c;
        box-shadow: inset 3px 3px 6px #e6d5c9, inset -3px -3px 6px #ffffff;
        transition: all 0.3s ease;
    }

    .filter-input:focus {
        outline: none;
        border-color: #e89a3c;
        box-shadow: inset 3px 3px 6px #e6d5c9, inset -3px -3px 6px #ffffff, 0 0 0 3px rgba(232, 154, 60, 0.2);
    }

    .filter-btn {
        background: linear-gradient(135deg, #e89a3c, #f5b76c);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        cursor: pointer;
        box-shadow: 4px 4px 8px #e6d5c9, -2px -2px 4px #ffffff;
        transition: all 0.3s ease;
    }

    .filter-btn:hover {
        transform: translateY(-2px);
        box-shadow: 6px 6px 12px #e6d5c9, -3px -3px 6px #ffffff;
    }

    .filter-btn-secondary {
        background: #2c2c2c;
    }

    /* Projects Table */
    .projects-card {
        background: #FFEEE2;
        border-radius: 20px;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
        overflow: hidden;
    }

    .projects-header {
        background: linear-gradient(135deg, #2c2c2c, #3d3d3d);
        padding: 1.25rem 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .projects-title {
        color: white;
        font-weight: 700;
        font-size: 1.125rem;
    }

    .projects-count {
        background: rgba(232, 154, 60, 0.2);
        color: #e89a3c;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
    }

    .projects-table {
        width: 100%;
        border-collapse: collapse;
    }

    .projects-table th {
        background: rgba(44, 44, 44, 0.05);
        padding: 1rem 1.25rem;
        text-align: left;
        font-size: 0.75rem;
        font-weight: 700;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 2px solid rgba(232, 154, 60, 0.2);
    }

    .projects-table td {
        padding: 1.25rem;
        border-bottom: 1px solid rgba(232, 154, 60, 0.1);
        vertical-align: top;
    }

    .projects-table tr:hover {
        background: rgba(232, 154, 60, 0.05);
    }

    .project-name {
        font-weight: 700;
        color: #2c2c2c;
        font-size: 1rem;
        margin-bottom: 0.25rem;
    }

    .project-team {
        font-size: 0.875rem;
        color: #6b7280;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .project-team svg {
        width: 14px;
        height: 14px;
        color: #e89a3c;
    }

    .event-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: linear-gradient(135deg, #2c2c2c, #3d3d3d);
        color: white;
        padding: 0.5rem 0.75rem;
        border-radius: 10px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .event-badge svg {
        width: 14px;
        height: 14px;
        color: #e89a3c;
    }

    /* Score Display */
    .score-display {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
    }

    .score-value {
        font-size: 1.5rem;
        font-weight: 800;
        width: 60px;
        height: 60px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
    }

    .score-high {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        color: #065f46;
    }

    .score-medium {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        color: #92400e;
    }

    .score-low {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        color: #991b1b;
    }

    .score-none {
        background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
        color: #6b7280;
        font-size: 0.75rem;
    }

    .score-label {
        font-size: 0.7rem;
        color: #6b7280;
        font-weight: 500;
    }

    /* Evaluation Status */
    .eval-status {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .eval-count {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
        font-weight: 600;
    }

    .eval-count svg {
        width: 16px;
        height: 16px;
    }

    .eval-count-green {
        color: #059669;
    }

    .eval-count-orange {
        color: #d97706;
    }

    .eval-count-gray {
        color: #6b7280;
    }

    .eval-progress {
        width: 100%;
        height: 6px;
        background: rgba(107, 114, 128, 0.2);
        border-radius: 3px;
        overflow: hidden;
    }

    .eval-progress-bar {
        height: 100%;
        border-radius: 3px;
        transition: width 0.5s ease;
    }

    .eval-progress-bar.green {
        background: linear-gradient(90deg, #10b981, #34d399);
    }

    .eval-progress-bar.orange {
        background: linear-gradient(90deg, #f59e0b, #fbbf24);
    }

    /* Criteria Pills */
    .criteria-pills {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .criteria-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        background: rgba(255, 253, 244, 0.8);
        padding: 0.35rem 0.6rem;
        border-radius: 8px;
        font-size: 0.7rem;
        box-shadow: 2px 2px 4px #e6d5c9, -2px -2px 4px #ffffff;
    }

    .criteria-name {
        color: #6b7280;
        font-weight: 500;
    }

    .criteria-score {
        color: #2c2c2c;
        font-weight: 700;
    }

    .criteria-score-high {
        color: #059669;
    }

    .criteria-score-medium {
        color: #d97706;
    }

    .criteria-score-low {
        color: #dc2626;
    }

    /* Action Button */
    .action-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: linear-gradient(135deg, #e89a3c, #f5b76c);
        color: white;
        padding: 0.6rem 1rem;
        border-radius: 10px;
        font-size: 0.8rem;
        font-weight: 600;
        text-decoration: none;
        box-shadow: 4px 4px 8px #e6d5c9, -2px -2px 4px #ffffff;
        transition: all 0.3s ease;
    }

    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 6px 6px 12px #e6d5c9, -3px -3px 6px #ffffff;
        color: white;
    }

    .action-btn svg {
        width: 16px;
        height: 16px;
    }

    /* Winner Badge */
    .winner-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        padding: 0.35rem 0.6rem;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 700;
    }

    .winner-1 {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        color: #92400e;
    }

    .winner-2 {
        background: linear-gradient(135deg, #e5e7eb, #d1d5db);
        color: #374151;
    }

    .winner-3 {
        background: linear-gradient(135deg, #fed7aa, #fdba74);
        color: #9a3412;
    }

    .winner-badge svg {
        width: 14px;
        height: 14px;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        background: rgba(107, 114, 128, 0.1);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
    }

    .empty-icon svg {
        width: 40px;
        height: 40px;
        color: #9ca3af;
    }

    .empty-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #2c2c2c;
        margin-bottom: 0.5rem;
    }

    .empty-text {
        color: #6b7280;
        font-size: 0.875rem;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .projects-table {
            display: block;
            overflow-x: auto;
        }
    }

    @media (max-width: 768px) {
        .hero-title {
            font-size: 1.5rem;
        }

        .stats-container {
            grid-template-columns: 1fr;
        }

        .filters-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="proyectos-page py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <!-- Hero Section -->
    <div class="hero-section">
        <h1 class="hero-title">Proyectos y Evaluaciones</h1>
        <p class="hero-subtitle">Gestiona y supervisa todos los proyectos y sus evaluaciones con criterios dinámicos</p>
    </div>

    <!-- Stats Cards -->
    <div class="stats-container">
        <div class="stat-card">
            <div class="stat-icon stat-icon-orange">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div class="stat-number">{{ $totalProyectos }}</div>
            <div class="stat-label">Total Proyectos</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-icon-gray">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="stat-number">{{ $proyectosSinEvaluar }}</div>
            <div class="stat-label">Sin Evaluar</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-icon-green">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="stat-number">{{ $proyectosEvaluados }}</div>
            <div class="stat-label">Evaluados</div>
        </div>
    </div>

    <!-- Filters -->
    <form method="GET" action="{{ route('admin.proyectos-evaluaciones.index') }}" class="filters-card">
        <div class="filters-grid">
            <div class="filter-group">
                <label class="filter-label">Buscar Proyecto</label>
                <input type="text" name="busqueda" value="{{ $busqueda }}" placeholder="Título o equipo..." class="filter-input">
            </div>

            <div class="filter-group">
                <label class="filter-label">Evento</label>
                <select name="evento" class="filter-input">
                    <option value="">Todos los eventos</option>
                    @foreach($eventos as $evento)
                        <option value="{{ $evento->id_evento }}" {{ $eventoId == $evento->id_evento ? 'selected' : '' }}>
                            {{ $evento->titulo }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="filter-group">
                <label class="filter-label">Estado Evaluación</label>
                <select name="estado_evaluacion" class="filter-input">
                    <option value="">Todos</option>
                    <option value="sin_evaluar" {{ $estadoEvaluacion === 'sin_evaluar' ? 'selected' : '' }}>Sin evaluar</option>
                    <option value="en_proceso" {{ $estadoEvaluacion === 'en_proceso' ? 'selected' : '' }}>En proceso</option>
                    <option value="evaluado" {{ $estadoEvaluacion === 'evaluado' ? 'selected' : '' }}>Evaluado</option>
                </select>
            </div>

            <div class="filter-group" style="flex-direction: row; gap: 0.5rem; align-items: end;">
                <button type="submit" class="filter-btn">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Filtrar
                </button>
                <a href="{{ route('admin.proyectos-evaluaciones.index') }}" class="filter-btn filter-btn-secondary">
                    Limpiar
                </a>
            </div>
        </div>
    </form>

    <!-- Projects Table -->
    <div class="projects-card">
        <div class="projects-header">
            <span class="projects-title">Lista de Proyectos</span>
            <span class="projects-count">{{ $proyectosConStats->count() }} proyectos</span>
        </div>

        @if($proyectosConStats->count() > 0)
            <table class="projects-table">
                <thead>
                    <tr>
                        <th>Proyecto / Equipo</th>
                        <th>Evento</th>
                        <th>Promedio</th>
                        <th>Evaluaciones</th>
                        <th>Criterios</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($proyectosConStats as $data)
                        <tr>
                            <td>
                                <div class="project-name">
                                    {{ $data['proyecto']->nombre ?? 'Sin nombre' }}
                                    @if($data['puesto_ganador'])
                                        <span class="winner-badge winner-{{ min($data['puesto_ganador'], 3) }}">
                                            <svg fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                            #{{ $data['puesto_ganador'] }}
                                        </span>
                                    @endif
                                </div>
                                <div class="project-team">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    {{ $data['equipo']->nombre ?? 'Sin equipo' }}
                                </div>
                            </td>
                            <td>
                                <div class="event-badge">
                                    {{ $data['evento']->nombre ?? 'Sin evento' }}
                                </div>
                            </td>
                            <td>
                                <div class="score-display">
                                    @if($data['promedio_general'] !== null)
                                        <div class="score-value {{ $data['promedio_general'] >= 80 ? 'score-high' : ($data['promedio_general'] >= 60 ? 'score-medium' : 'score-low') }}">
                                            {{ number_format($data['promedio_general'], 1) }}
                                        </div>
                                        <span class="score-label">de 100</span>
                                    @else
                                        <div class="score-value score-none">N/A</div>
                                        <span class="score-label">Sin calificación</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="eval-status">
                                    @if($data['total_evaluaciones'] > 0)
                                        <div class="eval-count {{ $data['evaluaciones_finalizadas'] === $data['total_evaluaciones'] ? 'eval-count-green' : 'eval-count-orange' }}">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                                            </svg>
                                            {{ $data['evaluaciones_finalizadas'] }} / {{ $data['total_evaluaciones'] }}
                                        </div>
                                        <div class="eval-progress">
                                            <div class="eval-progress-bar {{ $data['evaluaciones_finalizadas'] === $data['total_evaluaciones'] ? 'green' : 'orange' }}" 
                                                 style="width: {{ ($data['evaluaciones_finalizadas'] / $data['total_evaluaciones']) * 100 }}%"></div>
                                        </div>
                                    @else
                                        <div class="eval-count eval-count-gray">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Pendiente
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="criteria-pills">
                                    @if(count($data['promedios_criterio']) > 0)
                                        @foreach($data['promedios_criterio'] as $criterio)
                                            <span class="criteria-pill">
                                                <span class="criteria-name">{{ Str::limit($criterio['nombre'], 12) }}</span>
                                                <span class="criteria-score {{ $criterio['promedio'] >= 80 ? 'criteria-score-high' : ($criterio['promedio'] >= 60 ? 'criteria-score-medium' : 'criteria-score-low') }}">
                                                    {{ number_format($criterio['promedio'], 0) }}
                                                </span>
                                            </span>
                                        @endforeach
                                    @else
                                        <span class="criteria-pill">
                                            <span class="criteria-name">Sin datos</span>
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('admin.proyectos-evaluaciones.show', $data['inscripcion']->id_inscripcion) }}" class="action-btn">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Ver Detalle
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <h3 class="empty-title">No hay proyectos</h3>
                <p class="empty-text">No se encontraron proyectos con los filtros seleccionados</p>
            </div>
        @endif
    </div>
    </div>
</div>
@endsection
