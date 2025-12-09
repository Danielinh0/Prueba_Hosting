@extends('layouts.app')

@section('content')

<div class="mis-proyectos-page-pi py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('estudiante.dashboard') }}" class="back-link-pi">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver al Dashboard
        </a>

        <!-- Hero Section -->
        <div class="hero-section-pi">
            <div class="hero-content-pi">
                <div class="hero-text-pi">
                    <h1><span>Proyectos</span></h1>
                    <p>Gestiona y visualiza todos los proyectos en los que participas.</p>
                </div>
            </div>
        </div>

        @if($proyectos->isEmpty())
            <div class="empty-state-pi">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3>No tienes proyectos aún</h3>
                <p>Únete a un equipo y participa en un evento para crear tu primer proyecto.</p>
                <a href="{{ route('estudiante.equipo.index') }}" class="btn-go-teams-pi">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Ir a Mis Equipos
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($proyectos as $proyectoData)
                    @php
                        $proyecto = $proyectoData['proyecto'];
                        $equipo = $proyectoData['equipo'];
                        $evento = $proyectoData['evento'];
                        $esLider = $proyectoData['esLider'];
                        $totalTareas = $proyectoData['totalTareas'];
                        $tareasCompletadas = $proyectoData['tareasCompletadas'];
                        $porcentajeTareas = $proyectoData['porcentajeTareas'];
                        $totalAvances = $proyectoData['totalAvances'];
                    @endphp

                    <div class="project-card-pi">
                        <div class="p-6">
                            {{-- Header del Proyecto --}}
                            <div class="project-header-pi">
                                <div class="flex-1">
                                    <h3 class="project-name-pi">{{ $proyecto->nombre }}</h3>
                                    @if($esLider)
                                        <span class="badge-lider-pi">
                                            ⭐ Líder
                                        </span>
                                    @endif
                                </div>
                                <div class="project-icon-pi">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                            </div>

                            {{-- Equipo --}}
                            <div class="team-box-pi">
                                <p>
                                    <strong>Equipo:</strong> {{ $equipo->nombre }}
                                </p>
                            </div>

                            {{-- Evento --}}
                            @if($evento)
                                @if($evento->trashed())
                                    <div class="event-box-pi event-box-deleted-pi">
                                        <p>
                                            <strong>Evento:</strong> {{ $evento->nombre }} (Eliminado)
                                        </p>
                                    </div>
                                @else
                                    <div class="event-box-pi event-box-active-pi">
                                        <p>
                                            <strong>Evento:</strong> {{ $evento->nombre }}
                                        </p>
                                        <p style="font-size: 0.75rem;">
                                            Estado: {{ $evento->estado }}
                                        </p>
                                    </div>
                                @endif
                            @else
                                <div class="event-box-pi event-box-inactive-pi">
                                    <p>
                                        <strong>Sin evento asociado</strong>
                                    </p>
                                </div>
                            @endif

                            {{-- Descripción --}}
                            @if($proyecto->descripcion_tecnica)
                                <p class="project-description-pi">
                                    {{ $proyecto->descripcion_tecnica }}
                                </p>
                            @endif

                            {{-- Estadísticas --}}
                            <div class="stats-grid-pi">
                                <div class="stat-item-pi stat-tareas-pi">
                                    <p>Tareas</p>
                                    <p>{{ $tareasCompletadas }}/{{ $totalTareas }}</p>
                                </div>
                                <div class="stat-item-pi stat-avances-pi">
                                    <p>Avances</p>
                                    <p>{{ $totalAvances }}</p>
                                </div>
                            </div>

                            {{-- Barra de progreso --}}
                            <div class="progress-container-pi">
                                <div class="progress-label-pi">
                                    <span>Progreso de tareas</span>
                                    <strong>{{ $porcentajeTareas }}%</strong>
                                </div>
                                <div class="progress-bar-bg-pi">
                                    <div class="progress-bar-fill-pi" style="width: {{ $porcentajeTareas }}%;"></div>
                                </div>
                            </div>

                            {{-- Botones de Acción --}}
                            <div class="space-y-3">
                                <a href="{{ route('estudiante.proyecto.show-specific', $proyecto->id_proyecto) }}"
                                   class="btn-view-details-pi">
                                    Ver Proyecto →
                                </a>

                                @if($esLider)
                                    <a href="{{ route('estudiante.proyecto.edit-specific', $proyecto->id_proyecto) }}"
                                       class="btn-view-details-pi"
                                       style="background: linear-gradient(135deg, #e89a3c, #f5a847); box-shadow: 4px 4px 8px rgba(232, 154, 60, 0.3);">
                                        <i class="fas fa-edit mr-2"></i>
                                        Editar Proyecto
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>


@endsection