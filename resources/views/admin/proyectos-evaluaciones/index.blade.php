@extends('layouts.app')

@section('content')

<div class="proyectos-page py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <a href="{{ route('dashboard') }}" class="back-link">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Volver al Dashboard
    </a>
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
