@extends('jurado.layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
    
    .evaluacion-show-page {
        background: linear-gradient(135deg, #FFFDF4 0%, #FFF8EE 100%);
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
    }
    
    .calificacion-hero {
        background: linear-gradient(135deg, #2c2c2c 0%, #1a1a1a 100%);
        border-radius: 24px;
        position: relative;
        overflow: hidden;
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
        background: linear-gradient(135deg, #e89a3c, #f0bc7b);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        line-height: 1;
    }
    
    .criterio-show-card {
        background: linear-gradient(145deg, #ffffff, #fff8f0);
        border-radius: 16px;
        border: 1px solid rgba(232, 154, 60, 0.15);
        overflow: hidden;
    }
    
    .criterio-show-header {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid rgba(232, 154, 60, 0.1);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .criterio-score-badge {
        background: linear-gradient(135deg, #e89a3c, #d4842c);
        color: white;
        font-size: 1.5rem;
        font-weight: 700;
        padding: 0.5rem 1rem;
        border-radius: 12px;
        min-width: 80px;
        text-align: center;
    }
    
    .ponderacion-tag {
        background: linear-gradient(135deg, #2c2c2c, #1a1a1a);
        color: white;
        font-size: 0.7rem;
        font-weight: 600;
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
    }
    
    .progress-bar-container {
        height: 8px;
        background: rgba(0, 0, 0, 0.08);
        border-radius: 4px;
        overflow: hidden;
    }
    
    .progress-bar-fill {
        height: 100%;
        border-radius: 4px;
        transition: width 0.5s ease;
    }
    
    .feedback-show-card {
        background: white;
        border-radius: 16px;
        border: 1px solid rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }
    
    .feedback-show-header {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .feedback-show-body {
        padding: 1.25rem;
    }
</style>

<div class="evaluacion-show-page py-8 px-6 lg:px-12">
    <div class="max-w-6xl mx-auto">
        {{-- Header --}}
        <div class="mb-6">
            <a href="{{ route('jurado.eventos.equipo_evento', [$inscripcion->evento, $equipo]) }}" 
               class="inline-flex items-center gap-2 text-sm font-medium mb-4" style="color: #e89a3c;">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Volver al Equipo
            </a>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold" style="color: #2c2c2c;">Mi Evaluación del Proyecto</h1>
                    <p class="mt-1" style="color: #6b7280;">{{ $equipo->nombre }} - {{ $proyecto->nombre ?? 'Sin proyecto' }}</p>
                </div>
                {{-- Badge de estado --}}
                <div class="flex items-center gap-2 px-4 py-2 rounded-full" style="background-color: rgba(16, 185, 129, 0.15);">
                    <svg class="w-5 h-5" style="color: #059669;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="font-semibold" style="color: #059669;">Evaluación Finalizada</span>
                </div>
            </div>
        </div>

        {{-- Calificación Final Destacada --}}
        <div class="calificacion-hero p-8 mb-6">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6 relative z-10">
                <div class="flex items-center gap-6">
                    <div class="w-20 h-20 rounded-2xl flex items-center justify-center" style="background: rgba(232, 154, 60, 0.2);">
                        <svg class="w-10 h-10" style="color: #e89a3c;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
        <div class="rounded-2xl p-6 shadow-sm mb-6" style="background-color: #FFEFDC;">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #e89a3c, #d4842c);">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-semibold" style="color: #2c2c2c;">Desglose de Calificaciones</h2>
                    <p class="text-sm" style="color: #6b7280;">Calificación por cada criterio de evaluación</p>
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
                    <div class="criterio-show-card">
                        <div class="criterio-show-header">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-1">
                                    <h4 class="font-semibold" style="color: #2c2c2c;">{{ $criterio->nombre }}</h4>
                                    <span class="ponderacion-tag">{{ $criterio->ponderacion }}%</span>
                                </div>
                                @if($criterio->descripcion)
                                    <p class="text-xs" style="color: #6b7280;">{{ $criterio->descripcion }}</p>
                                @endif
                            </div>
                            <div class="criterio-score-badge">
                                {{ number_format($calificacion, 0) }}
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="progress-bar-container">
                                <div class="progress-bar-fill" style="width: {{ $calificacion }}%; background: {{ $barColor }};"></div>
                            </div>
                            <div class="flex justify-between mt-2">
                                <span class="text-xs" style="color: #9ca3af;">0</span>
                                <span class="text-xs font-medium" style="color: {{ $barColor }};">
                                    @if($calificacion >= 80) Excelente
                                    @elseif($calificacion >= 60) Bueno
                                    @elseif($calificacion >= 40) Regular
                                    @else Insuficiente
                                    @endif
                                </span>
                                <span class="text-xs" style="color: #9ca3af;">100</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Retroalimentación --}}
        <div class="rounded-2xl p-6 shadow-sm mb-6" style="background-color: #FFEFDC;">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #e89a3c, #d4842c);">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-semibold" style="color: #2c2c2c;">Retroalimentación Proporcionada</h2>
                    <p class="text-sm" style="color: #6b7280;">Comentarios para el equipo</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                {{-- Fortalezas --}}
                <div class="feedback-show-card">
                    <div class="feedback-show-header" style="background: rgba(16, 185, 129, 0.08);">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: #10b981;">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <span class="font-semibold" style="color: #059669;">Fortalezas del Proyecto</span>
                        </div>
                    </div>
                    <div class="feedback-show-body">
                        @if($evaluacion->comentarios_fortalezas)
                            <p style="color: #2c2c2c; white-space: pre-line;">{{ $evaluacion->comentarios_fortalezas }}</p>
                        @else
                            <p class="italic" style="color: #9ca3af;">No se proporcionaron comentarios sobre fortalezas.</p>
                        @endif
                    </div>
                </div>

                {{-- Áreas de Mejora --}}
                <div class="feedback-show-card">
                    <div class="feedback-show-header" style="background: rgba(245, 158, 11, 0.08);">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: #f59e0b;">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                            </div>
                            <span class="font-semibold" style="color: #d97706;">Áreas de Mejora</span>
                        </div>
                    </div>
                    <div class="feedback-show-body">
                        @if($evaluacion->comentarios_areas_mejora)
                            <p style="color: #2c2c2c; white-space: pre-line;">{{ $evaluacion->comentarios_areas_mejora }}</p>
                        @else
                            <p class="italic" style="color: #9ca3af;">No se proporcionaron comentarios sobre áreas de mejora.</p>
                        @endif
                    </div>
                </div>

                {{-- Comentarios Generales --}}
                @if($evaluacion->comentarios_generales)
                    <div class="feedback-show-card lg:col-span-2">
                        <div class="feedback-show-header" style="background: rgba(107, 114, 128, 0.08);">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: #6b7280;">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </div>
                                <span class="font-semibold" style="color: #4b5563;">Comentarios Generales</span>
                            </div>
                        </div>
                        <div class="feedback-show-body">
                            <p style="color: #2c2c2c; white-space: pre-line;">{{ $evaluacion->comentarios_generales }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Botón Volver --}}
        <div class="flex justify-end">
            <a href="{{ route('jurado.eventos.equipo_evento', [$inscripcion->evento, $equipo]) }}"
               class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-full font-semibold text-white transition-all hover:shadow-lg"
               style="background: linear-gradient(135deg, #e89a3c, #d4842c);">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Volver al Equipo
            </a>
        </div>
    </div>
</div>
@endsection
