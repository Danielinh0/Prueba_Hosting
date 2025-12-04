@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
    
    .detail-page {
        background: linear-gradient(to bottom, #FFFDF4, #FFEEE2);
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
    }
    
    .detail-page * {
        font-family: 'Poppins', sans-serif;
    }

    /* Back Link */
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: #e89a3c;
        font-size: 0.875rem;
        font-weight: 500;
        text-decoration: none;
        margin-bottom: 1.5rem;
        transition: all 0.2s ease;
    }

    .back-link:hover {
        color: #d98a2c;
        transform: translateX(-3px);
    }

    .back-link svg {
        width: 18px;
        height: 18px;
    }

    /* Hero Header */
    .hero-header {
        background: linear-gradient(135deg, #2c2c2c 0%, #1a1a1a 100%);
        border-radius: 25px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 12px 12px 24px rgba(0, 0, 0, 0.3), -6px -6px 12px rgba(60, 60, 60, 0.2);
        position: relative;
        overflow: hidden;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 2rem;
    }

    .hero-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(232, 154, 60, 0.2) 0%, transparent 70%);
        pointer-events: none;
    }

    .hero-info {
        z-index: 1;
    }

    .hero-title {
        color: #ffffff;
        font-size: 1.75rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
    }

    .hero-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        margin-top: 1rem;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.875rem;
    }

    .meta-item svg {
        width: 16px;
        height: 16px;
        color: #e89a3c;
    }

    /* Score Circle */
    .score-circle {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        box-shadow: 8px 8px 16px rgba(0, 0, 0, 0.3), -4px -4px 8px rgba(60, 60, 60, 0.2);
        z-index: 1;
    }

    .score-circle-high {
        background: linear-gradient(135deg, #10b981, #059669);
    }

    .score-circle-medium {
        background: linear-gradient(135deg, #f59e0b, #d97706);
    }

    .score-circle-low {
        background: linear-gradient(135deg, #ef4444, #dc2626);
    }

    .score-circle-none {
        background: linear-gradient(135deg, #6b7280, #4b5563);
    }

    .score-value-large {
        color: white;
        font-size: 2.5rem;
        font-weight: 800;
        line-height: 1;
    }

    .score-label-circle {
        color: rgba(255, 255, 255, 0.8);
        font-size: 0.75rem;
        font-weight: 500;
    }

    /* Content Grid */
    .content-grid {
        display: grid;
        grid-template-columns: 1fr 350px;
        gap: 2rem;
    }

    @media (max-width: 1024px) {
        .content-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Section Card */
    .section-card {
        background: #FFEEE2;
        border-radius: 20px;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .section-header {
        background: linear-gradient(135deg, #2c2c2c, #3d3d3d);
        padding: 1.25rem 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .section-title {
        color: white;
        font-weight: 700;
        font-size: 1.125rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .section-title svg {
        width: 20px;
        height: 20px;
        color: #e89a3c;
    }

    .section-body {
        padding: 1.5rem;
    }

    /* Criteria Card */
    .criteria-grid {
        display: grid;
        gap: 1rem;
    }

    .criteria-item {
        background: rgba(255, 253, 244, 0.8);
        border-radius: 15px;
        padding: 1.25rem;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
    }

    .criteria-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
    }

    .criteria-name {
        font-weight: 700;
        color: #2c2c2c;
        font-size: 1rem;
    }

    .criteria-ponderacion {
        background: linear-gradient(135deg, #e89a3c, #f5b76c);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
    }

    .criteria-score-row {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .criteria-score-display {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .criteria-score-value {
        font-size: 2rem;
        font-weight: 800;
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

    .criteria-score-none {
        color: #9ca3af;
    }

    .criteria-score-label {
        font-size: 0.875rem;
        color: #6b7280;
    }

    .criteria-progress {
        flex: 1;
        height: 10px;
        background: rgba(107, 114, 128, 0.2);
        border-radius: 5px;
        overflow: hidden;
    }

    .criteria-progress-bar {
        height: 100%;
        border-radius: 5px;
        transition: width 0.5s ease;
    }

    .progress-high {
        background: linear-gradient(90deg, #10b981, #34d399);
    }

    .progress-medium {
        background: linear-gradient(90deg, #f59e0b, #fbbf24);
    }

    .progress-low {
        background: linear-gradient(90deg, #ef4444, #f87171);
    }

    .criteria-evaluaciones-count {
        font-size: 0.75rem;
        color: #6b7280;
        margin-top: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .criteria-evaluaciones-count svg {
        width: 14px;
        height: 14px;
    }

    /* Evaluation List */
    .evaluation-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .evaluation-item {
        background: rgba(255, 253, 244, 0.8);
        border-radius: 15px;
        padding: 1.25rem;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
    }

    .evaluation-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
    }

    .evaluator-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .evaluator-avatar {
        width: 45px;
        height: 45px;
        border-radius: 12px;
        object-fit: cover;
        box-shadow: 3px 3px 6px #e6d5c9, -3px -3px 6px #ffffff;
    }

    .evaluator-name {
        font-weight: 600;
        color: #2c2c2c;
        font-size: 0.95rem;
    }

    .evaluator-role {
        font-size: 0.75rem;
        color: #6b7280;
    }

    .evaluation-score {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .eval-score-badge {
        font-size: 1.5rem;
        font-weight: 800;
        width: 55px;
        height: 55px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 3px 3px 6px #e6d5c9, -3px -3px 6px #ffffff;
    }

    .score-badge-high {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        color: #065f46;
    }

    .score-badge-medium {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        color: #92400e;
    }

    .score-badge-low {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        color: #991b1b;
    }

    .eval-score-label {
        font-size: 0.65rem;
        color: #6b7280;
        margin-top: 0.25rem;
    }

    /* Evaluation Criteria Pills */
    .eval-criteria-list {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .eval-criteria-pill {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(44, 44, 44, 0.05);
        padding: 0.4rem 0.75rem;
        border-radius: 8px;
        font-size: 0.75rem;
    }

    .pill-name {
        color: #6b7280;
        font-weight: 500;
    }

    .pill-score {
        font-weight: 700;
    }

    .pill-score-high {
        color: #059669;
    }

    .pill-score-medium {
        color: #d97706;
    }

    .pill-score-low {
        color: #dc2626;
    }

    /* Evaluation Comments */
    .eval-comments {
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px dashed rgba(232, 154, 60, 0.3);
    }

    .comments-label {
        font-size: 0.75rem;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.5rem;
    }

    .comments-text {
        font-size: 0.875rem;
        color: #4b5563;
        line-height: 1.6;
        font-style: italic;
    }

    /* Project Info Card */
    .info-item {
        display: flex;
        gap: 1rem;
        padding: 1rem 0;
        border-bottom: 1px solid rgba(232, 154, 60, 0.15);
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: linear-gradient(135deg, #e89a3c, #f5b76c);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .info-icon svg {
        width: 20px;
        height: 20px;
        color: white;
    }

    .info-content {
        flex: 1;
    }

    .info-label {
        font-size: 0.75rem;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .info-value {
        font-size: 0.95rem;
        color: #2c2c2c;
        font-weight: 500;
        margin-top: 0.25rem;
    }

    /* Team Members */
    .team-list {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .team-member {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem;
        background: rgba(255, 253, 244, 0.8);
        border-radius: 12px;
        box-shadow: 3px 3px 6px #e6d5c9, -3px -3px 6px #ffffff;
    }

    .member-avatar {
        width: 35px;
        height: 35px;
        border-radius: 10px;
        object-fit: cover;
    }

    .member-name {
        font-weight: 600;
        color: #2c2c2c;
        font-size: 0.875rem;
    }

    .member-role {
        font-size: 0.7rem;
        color: #6b7280;
    }

    /* Technologies */
    .tech-list {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .tech-badge {
        background: linear-gradient(135deg, #2c2c2c, #3d3d3d);
        color: white;
        padding: 0.35rem 0.75rem;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    /* Empty Evaluation */
    .empty-evaluations {
        text-align: center;
        padding: 3rem 2rem;
    }

    .empty-icon {
        width: 60px;
        height: 60px;
        background: rgba(107, 114, 128, 0.1);
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
    }

    .empty-icon svg {
        width: 30px;
        height: 30px;
        color: #9ca3af;
    }

    .empty-title {
        font-size: 1rem;
        font-weight: 700;
        color: #2c2c2c;
        margin-bottom: 0.25rem;
    }

    .empty-text {
        color: #6b7280;
        font-size: 0.875rem;
    }

    /* Winner Badge Large */
    .winner-badge-large {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 12px;
        font-weight: 700;
        margin-left: 1rem;
    }

    .winner-badge-large svg {
        width: 20px;
        height: 20px;
    }

    .winner-1-large {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        color: #92400e;
    }

    .winner-2-large {
        background: linear-gradient(135deg, #e5e7eb, #d1d5db);
        color: #374151;
    }

    .winner-3-large {
        background: linear-gradient(135deg, #fed7aa, #fdba74);
        color: #9a3412;
    }

    /* Status Badge */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.3rem 0.6rem;
        border-radius: 6px;
        font-size: 0.7rem;
        font-weight: 600;
    }

    .status-badge svg {
        width: 12px;
        height: 12px;
    }

    .status-finalizada {
        background: rgba(16, 185, 129, 0.1);
        color: #059669;
    }

    .status-pendiente {
        background: rgba(245, 158, 11, 0.1);
        color: #d97706;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .hero-header {
            flex-direction: column;
            text-align: center;
        }

        .hero-title {
            font-size: 1.5rem;
        }

        .hero-meta {
            justify-content: center;
        }
    }
</style>

<div class="detail-page py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <!-- Back Link -->
    <a href="{{ route('admin.proyectos-evaluaciones.index') }}" class="back-link">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
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
