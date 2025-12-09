@extends('layouts.app')

@section('title', 'Avances del Proyecto')

@section('content')

<div class="avances-page py-12">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('estudiante.proyecto.show-specific', $proyecto->id_proyecto) }}" class="back-link">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver al Proyecto
        </a>

        <div class="neuro-card-main">
            <div class="p-6 sm:p-8">
                <h1 class="font-bold text-3xl mb-4">Timeline de Avances</h1>

                <div class="project-info">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <strong>Proyecto:</strong>
                            <p class="text-lg mt-1">{{ $proyecto->nombre }}</p>
                        </div>
                        <div>
                            <strong>Equipo:</strong>
                            <p class="text-lg mt-1">{{ $inscripcion->equipo->nombre }}</p>
                        </div>
                        @if($inscripcion->evento)
                            <div>
                                <strong>Evento:</strong>
                                <p class="text-lg mt-1">{{ $inscripcion->evento->nombre }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Estadísticas -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="stat-number">{{ $avances->count() }}</div>
                        <div class="stat-label">Avances Totales</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="stat-number">{{ $avances->filter(fn($avance) => $avance->evaluaciones->isNotEmpty())->count() }}</div>
                        <div class="stat-label">Evaluados</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="stat-number">
                            @if($avances->isNotEmpty())
                                {{ round($avances->filter(fn($avance) => $avance->evaluaciones->isNotEmpty())->avg(fn($avance) => $avance->evaluaciones->avg('calificacion')), 1) }}/10
                            @else
                                -
                            @endif
                        </div>
                        <div class="stat-label">Promedio</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botón para registrar nuevo avance -->
        <div class="text-right mb-6">
            <a href="{{ route('estudiante.avances.create-specific', $proyecto->id_proyecto) }}" class="action-button btn-primary">
                <i class="fas fa-plus"></i>
                Registrar Nuevo Avance
            </a>
        </div>

        <!-- Timeline de Avances -->
        @if($avances->isNotEmpty())
            <div class="timeline">
                @foreach($avances as $avance)
                    <div class="timeline-item">
                        <div class="timeline-date">
                            <div>{{ $avance->created_at->format('d M') }}</div>
                            <small>{{ $avance->created_at->format('H:i') }}</small>
                        </div>
                        <div class="timeline-dot"></div>
                        <div class="timeline-content">
                            <div class="content-header">
                                <div>
                                    <div class="content-title">
                                        <a href="{{ route('estudiante.avances.show-specific', $avance) }}">
                                            {{ $avance->titulo }}
                                        </a>
                                    </div>
                                    <div class="content-meta">
                                        <div class="content-avatar">
                                            {{ strtoupper(substr($avance->usuarioRegistro->nombre, 0, 1)) }}
                                        </div>
                                        <span>por {{ $avance->usuarioRegistro->nombre }}</span>
                                    </div>
                                </div>
                                @if($avance->archivo_adjunto)
                                    <div>
                                        <a href="{{ asset('storage/' . $avance->archivo_adjunto) }}"
                                           target="_blank" class="file-attachment">
                                            <i class="fas fa-paperclip"></i>
                                            Ver Archivo Adjunto
                                        </a>
                                    </div>
                                @endif
                            </div>

                            @if($avance->descripcion)
                                <div class="content-description">
                                    {{ $avance->descripcion }}
                                </div>
                            @endif

                            @if($avance->evaluaciones->isNotEmpty())
                                <div class="evaluation-badge">
                                    <i class="fas fa-check-circle"></i>
                                    {{ $avance->evaluaciones->count() }} Evaluación(es)
                                    @if($avance->evaluaciones->whereNotNull('calificacion')->isNotEmpty())
                                        - Calificación: {{ $avance->evaluaciones->avg('calificacion') }}/10
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-chart-line"></i>
                <h5>Aún no hay avances registrados</h5>
                <p>Comienza documentando el progreso de tu proyecto registrando tu primer avance.</p>
                <div class="mt-4">
                    <a href="{{ route('estudiante.avances.create-specific', $proyecto->id_proyecto) }}" class="action-button btn-primary">
                        <i class="fas fa-plus"></i>
                        Registrar Primer Avance
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

@endsection