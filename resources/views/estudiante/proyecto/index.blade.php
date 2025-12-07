@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
    
    .back-link {
        font-family: 'Poppins', sans-serif;
        display: inline-flex;
        align-items: center;
        color: black;
        font-size: 0.875rem;
        font-weight: 500;
        margin-bottom: 1rem;
        padding: 0.5rem 1rem;
        background: #FFEEE2;
        border-radius: 10px;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        transition: all 0.2s ease;
        text-decoration: none;
    }
    
    .back-link:hover {
        color: #4f46e5;
        box-shadow: 6px 6px 12px #e6d5c9, -6px -6px 12px #ffffff;
        transform: translateY(-2px);
    }
    
    .back-link svg {
        width: 1rem;
        height: 1rem;
        margin-right: 0.5rem;
    }
    
    /* Fondo degradado */
    .mis-proyectos-page {
        background: linear-gradient(to bottom, #FFFDF4, #FFEEE2);
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
    }
    
    /* Textos */
    .mis-proyectos-page h2,
    .mis-proyectos-page h3 {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
    }
    
    .mis-proyectos-page p {
        font-family: 'Poppins', sans-serif;
        color: #6b6b6b;
    }
    
    /* Project card */
    .project-card {
        background: #FFEEE2;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
        transition: all 0.3s ease;
    }
    
    .project-card:hover {
        box-shadow: 12px 12px 24px #e6d5c9, -12px -12px 24px #ffffff;
        transform: translateY(-5px);
    }
    
    /* Project header */
    .project-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid rgba(232, 154, 60, 0.2);
    }
    
    .project-name {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
        font-weight: 700;
        font-size: 1.25rem;
    }
    
    .project-icon {
        width: 3rem;
        height: 3rem;
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 4px 4px 8px rgba(99, 102, 241, 0.3);
    }
    
    .project-icon svg {
        width: 1.5rem;
        height: 1.5rem;
        color: white;
    }
    
    /* Badges */
    .badge-lider {
        font-family: 'Poppins', sans-serif;
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.5rem;
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        color: #92400e;
        font-size: 0.75rem;
        font-weight: 700;
        border-radius: 20px;
        margin-top: 0.25rem;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    /* Team box */
    .team-box {
        margin-bottom: 1rem;
        padding: 0.75rem;
        border-radius: 15px;
        background: linear-gradient(135deg, rgba(224, 231, 255, 0.5), rgba(199, 210, 254, 0.5));
        box-shadow: inset 2px 2px 4px #e6d5c9, inset -2px -2px 4px #ffffff;
    }
    
    .team-box p {
        font-size: 0.875rem;
        color: #1e3a8a;
        margin-bottom: 0.25rem;
    }
    
    .team-box strong {
        color: #2c2c2c;
    }
    
    /* Event box */
    .event-box {
        margin-bottom: 1rem;
        padding: 0.75rem;
        border-radius: 15px;
        box-shadow: inset 2px 2px 4px #e6d5c9, inset -2px -2px 4px #ffffff;
    }
    
    .event-box-active {
        background: linear-gradient(135deg, rgba(209, 250, 229, 0.5), rgba(167, 243, 208, 0.5));
    }
    
    .event-box-active p {
        color: #065f46;
    }
    
    .event-box-inactive {
        background: rgba(249, 250, 251, 0.5);
    }
    
    .event-box-inactive p {
        color: #6b6b6b;
    }
    
    .event-box-deleted {
        background: linear-gradient(135deg, rgba(254, 226, 226, 0.5), rgba(252, 165, 165, 0.5));
    }
    
    .event-box-deleted p {
        color: #991b1b;
    }
    
    .event-box p {
        font-size: 0.875rem;
        margin-bottom: 0.25rem;
    }
    
    .event-box strong {
        color: #2c2c2c;
    }
    
    /* Description */
    .project-description {
        font-size: 0.875rem;
        color: #6b6b6b;
        margin-bottom: 1rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    /* Stats grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.75rem;
        margin-bottom: 1rem;
    }
    
    .stat-item {
        padding: 0.75rem;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.5);
        box-shadow: 2px 2px 4px #e6d5c9, -2px -2px 4px #ffffff;
        text-align: center;
    }
    
    .stat-item p:first-child {
        font-size: 0.75rem;
        color: #6b6b6b;
        margin-bottom: 0.25rem;
    }
    
    .stat-item p:last-child {
        font-size: 1.125rem;
        font-weight: 700;
        color: #2c2c2c;
    }
    
    .stat-tareas {
        border-left: 3px solid #6366f1;
    }
    
    .stat-avances {
        border-left: 3px solid #10b981;
    }
    
    /* Progress bar */
    .progress-container {
        margin-bottom: 1rem;
    }
    
    .progress-label {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.5rem;
    }
    
    .progress-label span {
        font-size: 0.75rem;
        color: #6b6b6b;
    }
    
    .progress-label strong {
        font-size: 0.875rem;
        color: #2c2c2c;
    }
    
    .progress-bar-bg {
        height: 8px;
        background: rgba(255, 255, 255, 0.8);
        border-radius: 10px;
        box-shadow: inset 2px 2px 4px #e6d5c9;
        overflow: hidden;
    }
    
    .progress-bar-fill {
        height: 100%;
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        border-radius: 10px;
        transition: width 0.3s ease;
    }
    
    /* View details button */
    .btn-view-details {
        font-family: 'Poppins', sans-serif;
        display: block;
        width: 100%;
        text-align: center;
        padding: 0.75rem 1rem;
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: #ffffff;
        border-radius: 0.75rem;
        font-weight: 600;
        box-shadow: 4px 4px 8px rgba(99, 102, 241, 0.3);
        transition: all 0.3s ease;
        text-decoration: none;
    }
    
    .btn-view-details:hover {
        box-shadow: 6px 6px 12px rgba(99, 102, 241, 0.4);
        transform: translateY(-2px);
        color: #ffffff;
    }
    
    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: #FFEEE2;
        border-radius: 20px;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
    }
    
    .empty-state svg {
        width: 5rem;
        height: 5rem;
        color: #e89a3c;
        margin-bottom: 1.5rem;
    }
    
    .empty-state h3 {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .empty-state p {
        margin-bottom: 1.5rem;
    }
    
    .btn-go-teams {
        font-family: 'Poppins', sans-serif;
        display: inline-flex;
        align-items: center;
        padding: 0.75rem 1.5rem;
        background: linear-gradient(135deg, #e89a3c, #f5a847);
        color: #ffffff;
        border-radius: 0.75rem;
        font-weight: 600;
        box-shadow: 4px 4px 8px rgba(232, 154, 60, 0.3);
        transition: all 0.3s ease;
        text-decoration: none;
    }
    
    .btn-go-teams:hover {
        box-shadow: 6px 6px 12px rgba(232, 154, 60, 0.4);
        transform: translateY(-2px);
        color: #ffffff;
    }
    
    .btn-go-teams svg {
        width: 1.25rem;
        height: 1.25rem;
        margin-right: 0.5rem;
    }

    /* Hero Section Negro */
    .hero-section {
        background: linear-gradient(135deg, #0e0e0eff 0%, #434343ff 50%, #1d1d1dff 100%);
        border-radius: 24px;
        padding: 2.5rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: 8px 8px 16px rgba(200, 200, 200, 0.4), -8px -8px 16px rgba(255, 255, 255, 0.9);
    }

    .hero-content {
        position: relative;
        z-index: 1;
    }

    .hero-text h1 {
        color: #c1c1c1ff;
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
    }

    .hero-text h1 span {
        color: #e89a3c;
    }

    .hero-text p {
        color: #cfcfcfff;
        font-size: 1rem;
    }

    .back-link {
        font-family: 'Poppins', sans-serif;
        display: inline-flex;
        align-items: center;
        color: black;
        font-size: 0.875rem;
        font-weight: 500;
        margin-bottom: 1rem;
        padding: 0.5rem 1rem;
        background: #FFEEE2;
        border-radius: 10px;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        transition: all 0.2s ease;
        text-decoration: none;
    }
    
    .back-link:hover {
        color: #4f46e5;
        box-shadow: 6px 6px 12px #e6d5c9, -6px -6px 12px #ffffff;
        transform: translateY(-2px);
    }
    
    .back-link svg {
        width: 1rem;
        height: 1rem;
        margin-right: 0.5rem;
    }
</style>

<div class="mis-proyectos-page py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('estudiante.dashboard') }}" class="back-link">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver al Dashboard
        </a>

        <!-- Hero Section -->
        <div class="hero-section">
            <div class="hero-content">
                <div class="hero-text">
                    <h1><span>Proyectos</span></h1>
                    <p>Gestiona y visualiza todos los proyectos en los que participas.</p>
                </div>
            </div>
        </div>

        @if($proyectos->isEmpty())
            <div class="empty-state">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3>No tienes proyectos aún</h3>
                <p>Únete a un equipo y participa en un evento para crear tu primer proyecto.</p>
                <a href="{{ route('estudiante.equipo.index') }}" class="btn-go-teams">
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

                    <div class="project-card">
                        <div class="p-6">
                            {{-- Header del Proyecto --}}
                            <div class="project-header">
                                <div class="flex-1">
                                    <h3 class="project-name">{{ $proyecto->nombre }}</h3>
                                    @if($esLider)
                                        <span class="badge-lider">
                                            ⭐ Líder
                                        </span>
                                    @endif
                                </div>
                                <div class="project-icon">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                            </div>

                            {{-- Equipo --}}
                            <div class="team-box">
                                <p>
                                    <strong>Equipo:</strong> {{ $equipo->nombre }}
                                </p>
                            </div>

                            {{-- Evento --}}
                            @if($evento)
                                @if($evento->trashed())
                                    <div class="event-box event-box-deleted">
                                        <p>
                                            <strong>Evento:</strong> {{ $evento->nombre }} (Eliminado)
                                        </p>
                                    </div>
                                @else
                                    <div class="event-box event-box-active">
                                        <p>
                                            <strong>Evento:</strong> {{ $evento->nombre }}
                                        </p>
                                        <p style="font-size: 0.75rem;">
                                            Estado: {{ $evento->estado }}
                                        </p>
                                    </div>
                                @endif
                            @else
                                <div class="event-box event-box-inactive">
                                    <p>
                                        <strong>Sin evento asociado</strong>
                                    </p>
                                </div>
                            @endif

                            {{-- Descripción --}}
                            @if($proyecto->descripcion_tecnica)
                                <p class="project-description">
                                    {{ $proyecto->descripcion_tecnica }}
                                </p>
                            @endif

                            {{-- Estadísticas --}}
                            <div class="stats-grid">
                                <div class="stat-item stat-tareas">
                                    <p>Tareas</p>
                                    <p>{{ $tareasCompletadas }}/{{ $totalTareas }}</p>
                                </div>
                                <div class="stat-item stat-avances">
                                    <p>Avances</p>
                                    <p>{{ $totalAvances }}</p>
                                </div>
                            </div>

                            {{-- Barra de progreso --}}
                            <div class="progress-container">
                                <div class="progress-label">
                                    <span>Progreso de tareas</span>
                                    <strong>{{ $porcentajeTareas }}%</strong>
                                </div>
                                <div class="progress-bar-bg">
                                    <div class="progress-bar-fill" style="width: {{ $porcentajeTareas }}%;"></div>
                                </div>
                            </div>

                            {{-- Botones de Acción --}}
                            <div class="space-y-3">
                                <a href="{{ route('estudiante.proyecto.show-specific', $proyecto->id_proyecto) }}"
                                   class="btn-view-details">
                                    Ver Proyecto →
                                </a>

                                @if($esLider)
                                    <a href="{{ route('estudiante.proyecto.edit-specific', $proyecto->id_proyecto) }}"
                                       class="btn-view-details"
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
