@extends('layouts.app')

@section('content')

<div class="detail-page py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <!-- Back Link -->
    <a href="{{ route('admin.proyectos-evaluaciones.index') }}" class="back-link">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Volver a Proyectos
    </a>
    <!-- Hero Header -->
    <div class="hero-header">
        <div class="hero-info">
            <h1 class="hero-title">
                {{ $inscripcion->proyecto->nombre ?? 'Sin nombre' }}
                @if($inscripcion->puesto_ganador)
                    <span class="winner-badge-large winner-{{ min($inscripcion->puesto_ganador, 3) }}-large">
                        <svg fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        Puesto #{{ $inscripcion->puesto_ganador }}
                    </span>
                @endif
            </h1>
            
            <div class="hero-meta">
                <span class="meta-item">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    {{ $inscripcion->equipo->nombre ?? 'Sin equipo' }}
                </span>
                <span class="meta-item">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    {{ $inscripcion->evento->nombre ?? 'Sin evento' }}
                </span>
                <span class="meta-item">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    {{ $evaluacionesFinalizadas->count() }} evaluaciones
                </span>
            </div>
        </div>

        <div class="score-circle {{ $promedioGeneral !== null ? ($promedioGeneral >= 80 ? 'score-circle-high' : ($promedioGeneral >= 60 ? 'score-circle-medium' : 'score-circle-low')) : 'score-circle-none' }}">
            <span class="score-value-large">
                {{ $promedioGeneral !== null ? number_format($promedioGeneral, 1) : 'N/A' }}
            </span>
            <span class="score-label-circle">Promedio Final</span>
        </div>
    </div>

    <div class="content-grid">
        <!-- Main Content -->
        <div>
            <!-- Criteria Section -->
            @if($inscripcion->evento->criteriosEvaluacion->count() > 0)
            <div class="section-card">
                <div class="section-header">
                    <span class="section-title">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        Resultados por Criterio
                    </span>
                </div>
                <div class="section-body">
                    <div class="criteria-grid">
                        @foreach($inscripcion->evento->criteriosEvaluacion as $criterio)
                            @php
                                $criterioData = $promediosPorCriterio[$criterio->id_criterio] ?? null;
                                $promedio = $criterioData['promedio'] ?? null;
                            @endphp
                            <div class="criteria-item">
                                <div class="criteria-header">
                                    <span class="criteria-name">{{ $criterio->nombre }}</span>
                                    <span class="criteria-ponderacion">{{ $criterio->ponderacion }}%</span>
                                </div>
                                <div class="criteria-score-row">
                                    <div class="criteria-score-display">
                                        <span class="criteria-score-value {{ $promedio !== null ? ($promedio >= 80 ? 'criteria-score-high' : ($promedio >= 60 ? 'criteria-score-medium' : 'criteria-score-low')) : 'criteria-score-none' }}">
                                            {{ $promedio !== null ? number_format($promedio, 1) : 'N/A' }}
                                        </span>
                                        <span class="criteria-score-label">/ 100</span>
                                    </div>
                                    <div class="criteria-progress">
                                        <div class="criteria-progress-bar {{ $promedio !== null ? ($promedio >= 80 ? 'progress-high' : ($promedio >= 60 ? 'progress-medium' : 'progress-low')) : '' }}" 
                                             style="width: {{ $promedio ?? 0 }}%"></div>
                                    </div>
                                </div>
                                @if($criterioData)
                                <div class="criteria-evaluaciones-count">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    {{ $criterioData['total_evaluaciones'] }} jurados han evaluado este criterio
                                </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Evaluations Section -->
            <div class="section-card">
                <div class="section-header">
                    <span class="section-title">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                        Evaluaciones de Jurados
                    </span>
                </div>
                <div class="section-body">
                    @if($inscripcion->evaluaciones->count() > 0)
                        <div class="evaluation-list">
                            @foreach($inscripcion->evaluaciones as $evaluacion)
                                <div class="evaluation-item">
                                    <div class="evaluation-header">
                                        <div class="evaluator-info">
                                            <img src="{{ $evaluacion->jurado->user->foto_perfil_url ?? asset('images/default-avatar.png') }}" 
                                                 alt="{{ $evaluacion->jurado->user->nombre ?? 'Jurado' }}" 
                                                 class="evaluator-avatar">
                                            <div>
                                                <div class="evaluator-name">{{ $evaluacion->jurado->user->nombre ?? 'Jurado' }} {{ $evaluacion->jurado->user->apellido ?? '' }}</div>
                                                <div class="evaluator-role">
                                                    <span class="status-badge {{ $evaluacion->estado === 'Finalizada' ? 'status-finalizada' : 'status-pendiente' }}">
                                                        @if($evaluacion->estado === 'Finalizada')
                                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                            </svg>
                                                        @else
                                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                            </svg>
                                                        @endif
                                                        {{ $evaluacion->estado }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="evaluation-score">
                                            <div class="eval-score-badge {{ $evaluacion->calificacion_final >= 80 ? 'score-badge-high' : ($evaluacion->calificacion_final >= 60 ? 'score-badge-medium' : 'score-badge-low') }}">
                                                {{ number_format($evaluacion->calificacion_final, 1) }}
                                            </div>
                                            <span class="eval-score-label">Calificación</span>
                                        </div>
                                    </div>

                                    <!-- Criteria Pills -->
                                    @if($evaluacion->criteriosCalificados->count() > 0)
                                        <div class="eval-criteria-list">
                                            @foreach($evaluacion->criteriosCalificados as $criterioEval)
                                                <span class="eval-criteria-pill">
                                                    <span class="pill-name">{{ $criterioEval->criterio->nombre ?? 'Criterio' }}</span>
                                                    <span class="pill-score {{ $criterioEval->calificacion >= 80 ? 'pill-score-high' : ($criterioEval->calificacion >= 60 ? 'pill-score-medium' : 'pill-score-low') }}">
                                                        {{ $criterioEval->calificacion }}
                                                    </span>
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif

                                    <!-- Comments -->
                                    @if($evaluacion->comentarios_generales || $evaluacion->comentarios_fortalezas || $evaluacion->comentarios_areas_mejora)
                                        <div class="eval-comments">
                                            @if($evaluacion->comentarios_fortalezas)
                                                <div class="comments-label">Fortalezas</div>
                                                <p class="comments-text">"{{ $evaluacion->comentarios_fortalezas }}"</p>
                                            @endif
                                            @if($evaluacion->comentarios_areas_mejora)
                                                <div class="comments-label" style="margin-top: 0.5rem;">Áreas de Mejora</div>
                                                <p class="comments-text">"{{ $evaluacion->comentarios_areas_mejora }}"</p>
                                            @endif
                                            @if($evaluacion->comentarios_generales)
                                                <div class="comments-label" style="margin-top: 0.5rem;">Comentarios Generales</div>
                                                <p class="comments-text">"{{ $evaluacion->comentarios_generales }}"</p>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-evaluations">
                            <div class="empty-icon">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <h3 class="empty-title">Sin evaluaciones</h3>
                            <p class="empty-text">Este proyecto aún no ha sido evaluado por ningún jurado</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div>
            <!-- Project Info -->
            <div class="section-card">
                <div class="section-header">
                    <span class="section-title">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Información del Proyecto
                    </span>
                </div>
                <div class="section-body">
                    <div class="info-item">
                        <div class="info-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                            </svg>
                        </div>
                        <div class="info-content">
                            <div class="info-label">Descripción Técnica</div>
                            <div class="info-value">{{ $inscripcion->proyecto->descripcion_tecnica ?? 'Sin descripción' }}</div>
                        </div>
                    </div>

                    @if($inscripcion->proyecto && $inscripcion->proyecto->repositorio_url)
                    <div class="info-item">
                        <div class="info-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                            </svg>
                        </div>
                        <div class="info-content">
                            <div class="info-label">Repositorio</div>
                            <div class="info-value">
                                <a href="{{ $inscripcion->proyecto->repositorio_url }}" target="_blank" style="color: #e89a3c; text-decoration: underline;">
                                    {{ $inscripcion->proyecto->repositorio_url }}
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Team Members -->
            @if($inscripcion->equipo && $inscripcion->equipo->miembros && $inscripcion->equipo->miembros->count() > 0)
            <div class="section-card">
                <div class="section-header">
                    <span class="section-title">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Miembros del Equipo
                    </span>
                </div>
                <div class="section-body">
                    <div class="team-list">
                        @foreach($inscripcion->equipo->miembros as $miembro)
                            <div class="team-member">
                                <img src="{{ $miembro->user->foto_perfil_url ?? asset('images/default-avatar.png') }}" 
                                     alt="{{ $miembro->user->nombre ?? 'Miembro' }}" 
                                     class="member-avatar">
                                <div>
                                    <div class="member-name">{{ $miembro->user->nombre ?? '' }} {{ $miembro->user->apellido ?? '' }}</div>
                                    <div class="member-role">{{ $miembro->rol->nombre ?? 'Miembro' }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
    </div>
</div>
@endsection
