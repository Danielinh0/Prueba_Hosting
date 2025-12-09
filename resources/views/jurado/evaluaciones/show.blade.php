@extends('jurado.layouts.app')

@section('content')

<div class="evaluacion-show-page">
    <div class="max-w-6xl mx-auto">
        {{-- Header --}}
        <div class="mb-6">
            <a href="{{ route('jurado.eventos.equipo_evento', [$inscripcion->evento, $equipo]) }}" class="back-link">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver al Equipo
            </a>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 page-header">
                <div>
                    <h1 class="page-title">Mi Evaluación del Proyecto</h1>
                    <p class="page-subtitle">{{ $equipo->nombre }} - {{ $proyecto->nombre ?? 'Sin proyecto' }}</p>
                </div>
                {{-- Badge de estado --}}
                <div class="status-badge">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Evaluación Finalizada</span>
                </div>
            </div>
        </div>

        {{-- Calificación Final Destacada - MANTENER OSCURO --}}
        <div class="calificacion-hero">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6 relative z-10">
                <div class="flex items-center gap-6">
                    <div class="hero-icon-box">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-white text-sm opacity-70 mb-1">Calificación Final Ponderada</p>
                        <div class="flex items-baseline gap-2">
                            <span class="hero-score">{{ number_format($evaluacion->calificacion_final, 1) }}</span>
                            <span class="text-2xl text-white opacity-50">/100</span>
                        </div>
                    </div>
                </div>
                <div class="text-center md:text-right">
                    <p class="text-white text-sm opacity-70">Fecha de evaluación</p>
                    <p class="text-white font-semibold text-lg">{{ $evaluacion->updated_at->translatedFormat('d \\d\\e F, Y') }}</p>
                    <p class="text-white text-sm opacity-70">{{ $evaluacion->updated_at->format('h:i A') }}</p>
                </div>
            </div>
        </div>

        {{-- Criterios de Evaluación Dinámicos --}}
        <div class="neu-card">
            <div class="section-header">
                <div class="section-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="section-title">Desglose de Calificaciones</h2>
                    <p class="section-subtitle">Calificación por cada criterio de evaluación</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                @foreach($criterios as $criterio)
                    @php
                        $calificacionCriterio = $calificacionesCriterios->get($criterio->id_criterio);
                        $calificacion = $calificacionCriterio ? $calificacionCriterio->calificacion : 0;
                        
                        // Determinar color según calificación
                        if ($calificacion >= 80) {
                            $barColor = '#10b981';
                        } elseif ($calificacion >= 60) {
                            $barColor = '#f59e0b';
                        } elseif ($calificacion >= 40) {
                            $barColor = '#f97316';
                        } else {
                            $barColor = '#ef4444';
                        }
                    @endphp
                    <div class="criterio-card">
                        <div class="criterio-header">
                            <div class="criterio-info">
                                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem;">
                                    <h4 class="criterio-name">{{ $criterio->nombre }}</h4>
                                    <span class="ponderacion-tag">{{ $criterio->ponderacion }}%</span>
                                </div>
                                @if($criterio->descripcion)
                                    <p class="criterio-desc">{{ $criterio->descripcion }}</p>
                                @endif
                            </div>
                            <div class="criterio-score-badge">
                                {{ number_format($calificacion, 0) }}
                            </div>
                        </div>
                        <div class="criterio-body">
                            <div class="progress-bar-container">
                                <div class="progress-bar-fill" style="width: {{ $calificacion }}%; background: {{ $barColor }};"></div>
                            </div>
                            <div class="progress-labels">
                                <span class="progress-label-start">0</span>
                                <span class="progress-label-center" style="color: {{ $barColor }};">
                                    @if($calificacion >= 80) Excelente
                                    @elseif($calificacion >= 60) Bueno
                                    @elseif($calificacion >= 40) Regular
                                    @else Insuficiente
                                    @endif
                                </span>
                                <span class="progress-label-end">100</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Retroalimentación --}}
        <div class="neu-card">
            <div class="section-header">
                <div class="section-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="section-title">Retroalimentación Proporcionada</h2>
                    <p class="section-subtitle">Comentarios para el equipo</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                {{-- Fortalezas --}}
                <div class="feedback-card">
                    <div class="feedback-header">
                        <div class="feedback-icon feedback-icon-green">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <span class="feedback-title feedback-title-green">Fortalezas del Proyecto</span>
                    </div>
                    <div class="feedback-body">
                        @if($evaluacion->comentarios_fortalezas)
                            <p>{{ $evaluacion->comentarios_fortalezas }}</p>
                        @else
                            <p class="empty">No se proporcionaron comentarios sobre fortalezas.</p>
                        @endif
                    </div>
                </div>

                {{-- Áreas de Mejora --}}
                <div class="feedback-card">
                    <div class="feedback-header">
                        <div class="feedback-icon feedback-icon-orange">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                        <span class="feedback-title feedback-title-orange">Áreas de Mejora</span>
                    </div>
                    <div class="feedback-body">
                        @if($evaluacion->comentarios_areas_mejora)
                            <p>{{ $evaluacion->comentarios_areas_mejora }}</p>
                        @else
                            <p class="empty">No se proporcionaron comentarios sobre áreas de mejora.</p>
                        @endif
                    </div>
                </div>

                {{-- Comentarios Generales --}}
                @if($evaluacion->comentarios_generales)
                    <div class="feedback-card lg:col-span-2">
                        <div class="feedback-header">
                            <div class="feedback-icon feedback-icon-gray">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </div>
                            <span class="feedback-title feedback-title-gray">Comentarios Generales</span>
                        </div>
                        <div class="feedback-body">
                            <p>{{ $evaluacion->comentarios_generales }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Botón Volver --}}
        <div class="flex justify-end">
            <a href="{{ route('jurado.eventos.equipo_evento', [$inscripcion->evento, $equipo]) }}"
               class="btn-volver">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Volver al Equipo
            </a>
        </div>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
    
    .evaluacion-show-page {
        background: linear-gradient(to bottom, #FFFDF4, #FFEEE2);
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
        padding: 2rem;
    }
    
    /* Back link neuromórfico */
    .back-link {
        font-family: 'Poppins', sans-serif;
        display: inline-flex;
        align-items: center;
        color: #e89a3c;
        font-size: 0.875rem;
        font-weight: 500;
        margin-bottom: 1rem;
        padding: 0.5rem 1rem;
        background: rgba(255, 253, 244, 0.9);
        border-radius: 10px;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        transition: all 0.2s ease;
        text-decoration: none;
    }
    
    .back-link:hover {
        color: #d98a2c;
        box-shadow: 6px 6px 12px #e6d5c9, -6px -6px 12px #ffffff;
        transform: translateY(-2px);
    }
    
    .back-link svg {
        width: 1rem;
        height: 1rem;
        margin-right: 0.5rem;
    }

    /* Header section */
    .page-header {
        margin-bottom: 1.5rem;
    }

    .page-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2c2c2c;
        margin-bottom: 0.25rem;
    }

    .page-subtitle {
        color: #6b7280;
        font-size: 0.875rem;
    }

    /* Badge de estado */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        background: linear-gradient(135deg, rgba(209, 250, 229, 0.8), rgba(167, 243, 208, 0.8));
        box-shadow: 4px 4px 8px rgba(16, 185, 129, 0.2);
    }

    .status-badge svg {
        width: 1.25rem;
        height: 1.25rem;
        color: #059669;
    }

    .status-badge span {
        font-weight: 600;
        color: #059669;
        font-family: 'Poppins', sans-serif;
    }

    /* Calificación Hero - MANTENER OSCURO */
    .calificacion-hero {
        background: linear-gradient(135deg, #2c2c2c 0%, #1a1a1a 100%);
        border-radius: 24px;
        position: relative;
        overflow: hidden;
        padding: 2rem;
        margin-bottom: 1.5rem;
    }
    
    .calificacion-hero::before {
        content: '';
        position: absolute;
        top: -30%;
        right: -20%;
        width: 50%;
        height: 160%;
        background: linear-gradient(135deg, rgba(232, 154, 60, 0.3) 0%, transparent 70%);
        border-radius: 50%;
    }
    
    .hero-score {
        font-size: 4.5rem;
        font-weight: 800;
        background: linear-gradient(135deg, #e89a3c, #f5a847);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        line-height: 1;
    }

    .hero-icon-box {
        width: 5rem;
        height: 5rem;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(232, 154, 60, 0.2);
    }

    .hero-icon-box svg {
        width: 2.5rem;
        height: 2.5rem;
        color: #e89a3c;
    }
    
    /* Cards neuromórficas */
    .neu-card {
        background: #FFEEE2;
        border-radius: 20px;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .section-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
    }

    .section-icon {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #e89a3c, #f5a847);
        box-shadow: 4px 4px 8px rgba(232, 154, 60, 0.3);
    }

    .section-icon svg {
        width: 1.25rem;
        height: 1.25rem;
        color: white;
    }

    .section-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: #2c2c2c;
        margin: 0;
        font-family: 'Poppins', sans-serif;
    }

    .section-subtitle {
        font-size: 0.875rem;
        color: #6b7280;
        margin: 0;
        font-family: 'Poppins', sans-serif;
    }

    /* Criterio card */
    .criterio-card {
        background: rgba(255, 255, 255, 0.5);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: inset 3px 3px 6px #e6d5c9, inset -3px -3px 6px #ffffff;
    }
    
    .criterio-header {
        padding: 1rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid rgba(232, 154, 60, 0.1);
    }

    .criterio-info {
        flex: 1;
    }

    .criterio-name {
        font-weight: 600;
        color: #2c2c2c;
        font-family: 'Poppins', sans-serif;
        font-size: 0.95rem;
        margin-bottom: 0.25rem;
    }

    .criterio-desc {
        font-size: 0.75rem;
        color: #6b7280;
        font-family: 'Poppins', sans-serif;
    }
    
    .ponderacion-tag {
        background: linear-gradient(135deg, #2c2c2c, #1a1a1a);
        color: white;
        font-size: 0.7rem;
        font-weight: 600;
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        margin-right: 0.5rem;
    }
    
    .criterio-score-badge {
        background: linear-gradient(135deg, #e89a3c, #f5a847);
        color: white;
        font-size: 1.5rem;
        font-weight: 700;
        padding: 0.5rem 1rem;
        border-radius: 12px;
        min-width: 80px;
        text-align: center;
        box-shadow: 4px 4px 8px rgba(232, 154, 60, 0.3);
    }
    
    .criterio-body {
        padding: 1rem;
    }

    .progress-bar-container {
        height: 8px;
        background: rgba(255, 255, 255, 0.6);
        border-radius: 4px;
        overflow: hidden;
        box-shadow: inset 2px 2px 4px #e6d5c9, inset -2px -2px 4px #ffffff;
    }
    
    .progress-bar-fill {
        height: 100%;
        border-radius: 4px;
        transition: width 0.5s ease;
    }

    .progress-labels {
        display: flex;
        justify-content: space-between;
        margin-top: 0.5rem;
    }

    .progress-labels span {
        font-size: 0.75rem;
        font-family: 'Poppins', sans-serif;
    }

    .progress-label-start,
    .progress-label-end {
        color: #9ca3af;
    }

    .progress-label-center {
        font-weight: 500;
    }
    
    /* Feedback cards */
    .feedback-card {
        background: rgba(255, 255, 255, 0.5);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: inset 3px 3px 6px #e6d5c9, inset -3px -3px 6px #ffffff;
    }
    
    .feedback-header {
        padding: 1rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .feedback-icon {
        width: 2rem;
        height: 2rem;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
    }

    .feedback-icon svg {
        width: 1rem;
        height: 1rem;
        color: white;
    }

    .feedback-icon-green {
        background: linear-gradient(135deg, #10b981, #059669);
    }

    .feedback-icon-orange {
        background: linear-gradient(135deg, #f59e0b, #d97706);
    }

    .feedback-icon-gray {
        background: linear-gradient(135deg, #6b7280, #4b5563);
    }

    .feedback-title {
        font-weight: 600;
        font-family: 'Poppins', sans-serif;
    }

    .feedback-title-green {
        color: #059669;
    }

    .feedback-title-orange {
        color: #d97706;
    }

    .feedback-title-gray {
        color: #4b5563;
    }
    
    .feedback-body {
        padding: 1rem;
    }

    .feedback-body p {
        color: #2c2c2c;
        white-space: pre-line;
        line-height: 1.6;
        font-family: 'Poppins', sans-serif;
        font-size: 0.875rem;
        margin: 0;
    }

    .feedback-body p.empty {
        font-style: italic;
        color: #9ca3af;
    }

    /* Botón volver inferior */
    .btn-volver {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        border-radius: 20px;
        font-weight: 600;
        font-family: 'Poppins', sans-serif;
        color: white;
        background: linear-gradient(135deg, #e89a3c, #f5a847);
        box-shadow: 4px 4px 8px rgba(232, 154, 60, 0.3);
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .btn-volver:hover {
        transform: translateY(-2px);
        box-shadow: 6px 6px 12px rgba(232, 154, 60, 0.4);
        color: white;
    }

    .btn-volver svg {
        width: 1.25rem;
        height: 1.25rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .evaluacion-show-page {
            padding: 1rem;
        }

        .hero-score {
            font-size: 3rem;
        }

        .calificacion-hero {
            padding: 1.5rem;
        }
    }
</style>
@endsection