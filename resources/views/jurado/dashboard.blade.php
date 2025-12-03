@extends('jurado.layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

    :root {
        --color-primary: #DB8C57;
        --color-secondary: #E77F30;
        --color-bg: #FFEFDC;
        --color-card-bg: #FFF8F0;
        --text-dark: #000000;
        --text-gray: #A4AEB7;
        --text-white: #FFFFFF;
    }

    body {
        font-family: 'Poppins', sans-serif;
        color: var(--text-dark);
    }

    .dashboard-container {
        padding: 30px;
        max-width: 1400px;
        margin: 0 auto;
    }

    .welcome-section {
        margin-bottom: 30px;
    }

    .welcome-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--text-dark);
    }

    .welcome-subtitle {
        color: var(--text-gray);
        font-size: 1rem;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: linear-gradient(135deg, #DB8C57, #E77F30);
        border-radius: 20px;
        padding: 25px;
        color: white;
        position: relative;
        overflow: hidden;
        box-shadow: 0 8px 20px rgba(219, 140, 87, 0.3);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .stat-card.alt {
        background: linear-gradient(135deg, #2D2A4A, #1a1a2e);
    }

    .stat-card.alt::before {
        background: rgba(255, 255, 255, 0.05);
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        line-height: 1;
        margin-bottom: 5px;
    }

    .stat-label {
        font-size: 0.9rem;
        font-weight: 500;
        opacity: 0.9;
    }

    .stat-icon {
        position: absolute;
        top: 20px;
        right: 20px;
        width: 40px;
        height: 40px;
        opacity: 0.3;
    }

    /* Section Titles */
    .section-title {
        font-size: 1.2rem;
        font-weight: 700;
        margin-bottom: 20px;
        color: var(--text-dark);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title svg {
        width: 24px;
        height: 24px;
        color: var(--color-primary);
    }

    /* Custom Card */
    .custom-card {
        background-color: var(--color-card-bg);
        border-radius: 20px;
        padding: 25px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        margin-bottom: 25px;
    }

    /* Pendientes List */
    .pendiente-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 15px;
        background: #FCFCFC;
        border-radius: 12px;
        margin-bottom: 12px;
        transition: all 0.2s ease;
        border-left: 4px solid var(--color-primary);
    }

    .pendiente-item:hover {
        transform: translateX(5px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    .pendiente-info {
        flex: 1;
    }

    .pendiente-equipo {
        font-weight: 600;
        font-size: 1rem;
        color: var(--text-dark);
        margin-bottom: 4px;
    }

    .pendiente-evento {
        font-size: 0.85rem;
        color: var(--text-gray);
    }

    .pendiente-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-right: 10px;
    }

    .badge-borrador {
        background-color: #FFF3E0;
        color: #E65100;
    }

    .badge-pendiente {
        background-color: #E3F2FD;
        color: #1565C0;
    }

    .btn-evaluar {
        background: linear-gradient(135deg, #DB8C57, #E77F30);
        color: white;
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.85rem;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-evaluar:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(219, 140, 87, 0.4);
        color: white;
    }

    .btn-retomar {
        background: linear-gradient(135deg, #FF9800, #F57C00);
    }

    /* Eventos List */
    .evento-item {
        display: flex;
        align-items: center;
        padding: 18px;
        background: #FCFCFC;
        border-radius: 15px;
        margin-bottom: 12px;
        transition: all 0.2s ease;
    }

    .evento-item:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    .evento-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
    }

    .evento-icon.activo {
        background: linear-gradient(135deg, #4CAF50, #2E7D32);
    }

    .evento-icon.progreso {
        background: linear-gradient(135deg, #2196F3, #1565C0);
    }

    .evento-icon.proximo {
        background: linear-gradient(135deg, #9C27B0, #7B1FA2);
    }

    .evento-icon.cerrado {
        background: linear-gradient(135deg, #607D8B, #455A64);
    }

    .evento-icon svg {
        width: 24px;
        height: 24px;
        color: white;
    }

    .evento-info {
        flex: 1;
    }

    .evento-nombre {
        font-weight: 600;
        font-size: 1rem;
        color: var(--text-dark);
        margin-bottom: 4px;
    }

    .evento-meta {
        font-size: 0.85rem;
        color: var(--text-gray);
    }

    .evento-estado {
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .estado-activo {
        background-color: #E8F5E9;
        color: #2E7D32;
    }

    .estado-progreso {
        background-color: #E3F2FD;
        color: #1565C0;
    }

    .estado-proximo {
        background-color: #F3E5F5;
        color: #7B1FA2;
    }

    .estado-cerrado {
        background-color: #ECEFF1;
        color: #455A64;
    }

    /* Evaluaciones Recientes */
    .evaluacion-item {
        display: flex;
        align-items: center;
        padding: 12px 15px;
        background: #FCFCFC;
        border-radius: 10px;
        margin-bottom: 10px;
    }

    .evaluacion-score {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1rem;
        margin-right: 15px;
        color: white;
    }

    .score-high {
        background: linear-gradient(135deg, #4CAF50, #2E7D32);
    }

    .score-medium {
        background: linear-gradient(135deg, #FF9800, #F57C00);
    }

    .score-low {
        background: linear-gradient(135deg, #f44336, #c62828);
    }

    .evaluacion-info {
        flex: 1;
    }

    .evaluacion-equipo {
        font-weight: 600;
        font-size: 0.95rem;
        color: var(--text-dark);
    }

    .evaluacion-fecha {
        font-size: 0.8rem;
        color: var(--text-gray);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: var(--text-gray);
    }

    .empty-state svg {
        width: 60px;
        height: 60px;
        margin-bottom: 15px;
        opacity: 0.5;
    }

    .empty-state p {
        font-size: 0.95rem;
    }

    /* Quick Actions */
    .quick-actions {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }

    .quick-action-btn {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 15px 25px;
        background: var(--color-card-bg);
        border-radius: 15px;
        text-decoration: none;
        color: var(--text-dark);
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .quick-action-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 15px rgba(0,0,0,0.1);
        color: var(--color-primary);
    }

    .quick-action-btn svg {
        width: 24px;
        height: 24px;
        color: var(--color-primary);
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .dashboard-container {
            padding: 20px;
        }
        
        .stats-grid {
            grid-template-columns: 1fr;
        }
        
        .pendiente-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }
        
        .pendiente-actions {
            width: 100%;
            display: flex;
            justify-content: space-between;
        }
    }
</style>

<div class="dashboard-container">
    <!-- Welcome Section -->
    <div class="welcome-section">
        <h1 class="welcome-title">¡Bienvenido, {{ Auth::user()->nombre }}!</h1>
        <p class="welcome-subtitle">Panel de control del jurado - {{ now()->format('d de F, Y') }}</p>
    </div>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number">{{ $estadisticas['eventosActivos'] }}</div>
            <div class="stat-label">Eventos Activos</div>
            <svg class="stat-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
        </div>

        <div class="stat-card alt">
            <div class="stat-number">{{ $estadisticas['totalEquipos'] }}</div>
            <div class="stat-label">Equipos Asignados</div>
            <svg class="stat-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </div>

        <div class="stat-card">
            <div class="stat-number">{{ $estadisticas['evaluacionesPendientes'] }}</div>
            <div class="stat-label">Evaluaciones Pendientes</div>
            <svg class="stat-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
        </div>

        <div class="stat-card alt">
            <div class="stat-number">{{ $estadisticas['evaluacionesCompletadas'] }}</div>
            <div class="stat-label">Evaluaciones Completadas</div>
            <svg class="stat-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mb-8">
        <div class="quick-actions">
            <a href="{{ route('jurado.eventos.index') }}" class="quick-action-btn">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Ver Eventos
            </a>
            <a href="{{ route('jurado.constancias.index') }}" class="quick-action-btn">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Constancias
            </a>
           
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Columna Izquierda -->
        <div>
            <!-- Evaluaciones Pendientes -->
            <h3 class="section-title">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Evaluaciones Pendientes
            </h3>
            <div class="custom-card">
                @if($evaluacionesPendientes->count() > 0)
                    @foreach($evaluacionesPendientes->take(5) as $pendiente)
                        <div class="pendiente-item">
                            <div class="pendiente-info">
                                <div class="pendiente-equipo">{{ $pendiente->equipo->nombre }}</div>
                                <div class="pendiente-evento">{{ $pendiente->evento->nombre }}</div>
                            </div>
                            <div class="pendiente-actions" style="display: flex; align-items: center;">
                                @if($pendiente->tieneBorrador)
                                    <span class="pendiente-badge badge-borrador">Borrador</span>
                                    <a href="{{ route('jurado.evaluaciones.create', $pendiente->inscripcion->id_inscripcion) }}" class="btn-evaluar btn-retomar">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                                        </svg>
                                        Retomar
                                    </a>
                                @else
                                    <span class="pendiente-badge badge-pendiente">Pendiente</span>
                                    <a href="{{ route('jurado.evaluaciones.create', $pendiente->inscripcion->id_inscripcion) }}" class="btn-evaluar">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125" />
                                        </svg>
                                        Evaluar
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                    
                    @if($evaluacionesPendientes->count() > 5)
                        <div class="text-center mt-4">
                            <a href="{{ route('jurado.eventos.index') }}" class="text-sm text-orange-600 hover:text-orange-800 font-medium">
                                Ver todas las evaluaciones pendientes ({{ $evaluacionesPendientes->count() }})
                            </a>
                        </div>
                    @endif
                @else
                    <div class="empty-state">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p>¡Excelente! No tienes evaluaciones pendientes.</p>
                    </div>
                @endif
            </div>

            <!-- Evaluaciones Recientes -->
            <h3 class="section-title">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
                Evaluaciones Recientes
            </h3>
            <div class="custom-card">
                @if($evaluacionesRecientes->count() > 0)
                    @foreach($evaluacionesRecientes as $evaluacion)
                        @php
                            $scoreClass = $evaluacion->calificacion_final >= 80 ? 'score-high' : ($evaluacion->calificacion_final >= 60 ? 'score-medium' : 'score-low');
                        @endphp
                        <div class="evaluacion-item">
                            <div class="evaluacion-score {{ $scoreClass }}">
                                {{ $evaluacion->calificacion_final }}
                            </div>
                            <div class="evaluacion-info">
                                <div class="evaluacion-equipo">{{ $evaluacion->inscripcion->equipo->nombre ?? 'Equipo' }}</div>
                                <div class="evaluacion-fecha">{{ $evaluacion->updated_at->diffForHumans() }}</div>
                            </div>
                            <a href="{{ route('jurado.evaluaciones.show', $evaluacion->id_evaluacion) }}" class="text-orange-600 hover:text-orange-800">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                            </a>
                        </div>
                    @endforeach
                @else
                    <div class="empty-state">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p>Aún no has realizado evaluaciones.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Columna Derecha -->
        <div>
            <!-- Eventos Asignados -->
            <h3 class="section-title">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Mis Eventos Asignados
            </h3>
            <div class="custom-card">
                @if($eventosAsignados->count() > 0)
                    @foreach($eventosAsignados->take(5) as $evento)
                        @php
                            $estadoClass = match($evento->estado) {
                                'Activo' => ['icon' => 'activo', 'badge' => 'estado-activo'],
                                'En Progreso' => ['icon' => 'progreso', 'badge' => 'estado-progreso'],
                                'Próximo' => ['icon' => 'proximo', 'badge' => 'estado-proximo'],
                                default => ['icon' => 'cerrado', 'badge' => 'estado-cerrado'],
                            };
                        @endphp
                        <a href="{{ route('jurado.eventos.show', $evento->id_evento) }}" class="evento-item block">
                            <div class="evento-icon {{ $estadoClass['icon'] }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="evento-info">
                                <div class="evento-nombre">{{ $evento->nombre }}</div>
                                <div class="evento-meta">{{ $evento->inscripciones_count }} equipos · {{ $evento->fecha_inicio->format('d M, Y') }}</div>
                            </div>
                            <span class="evento-estado {{ $estadoClass['badge'] }}">{{ $evento->estado }}</span>
                        </a>
                    @endforeach
                    
                    @if($eventosAsignados->count() > 5)
                        <div class="text-center mt-4">
                            <a href="{{ route('jurado.eventos.index') }}" class="text-sm text-orange-600 hover:text-orange-800 font-medium">
                                Ver todos los eventos ({{ $eventosAsignados->count() }})
                            </a>
                        </div>
                    @endif
                @else
                    <div class="empty-state">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p>No tienes eventos asignados actualmente.</p>
                    </div>
                @endif
            </div>

            <!-- Resumen de Actividad -->
            <h3 class="section-title">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                Resumen de Actividad
            </h3>
            <div class="custom-card">
                <div class="grid grid-cols-2 gap-4">
                    <div class="text-center p-4 bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl">
                        <div class="text-3xl font-bold text-orange-600">{{ $estadisticas['totalEventos'] }}</div>
                        <div class="text-sm text-gray-600 mt-1">Total Eventos</div>
                    </div>
                    <div class="text-center p-4 bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl">
                        <div class="text-3xl font-bold text-blue-600">{{ $estadisticas['avancesPorCalificar'] }}</div>
                        <div class="text-sm text-gray-600 mt-1">Avances por Calificar</div>
                    </div>
                </div>
                
                @if($estadisticas['totalEquipos'] > 0)
                    <div class="mt-6">
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-gray-600">Progreso de Evaluaciones</span>
                            <span class="font-semibold">{{ $estadisticas['evaluacionesCompletadas'] }}/{{ $estadisticas['totalEquipos'] }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            @php
                                $porcentaje = $estadisticas['totalEquipos'] > 0 
                                    ? round(($estadisticas['evaluacionesCompletadas'] / $estadisticas['totalEquipos']) * 100) 
                                    : 0;
                            @endphp
                            <div class="bg-gradient-to-r from-orange-400 to-orange-600 h-3 rounded-full transition-all duration-500" style="width: {{ $porcentaje }}%"></div>
                        </div>
                        <div class="text-right text-sm text-gray-500 mt-1">{{ $porcentaje }}% completado</div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

