@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
    
    /* Fondo degradado */
    .admin-dashboard-page {
        background: linear-gradient(to bottom, #FFFDF4, #FFEEE2);
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
    }
    
    /* Textos */
    .admin-dashboard-page h2,
    .admin-dashboard-page h3,
    .admin-dashboard-page h4 {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
    }
    
    .admin-dashboard-page p,
    .admin-dashboard-page span,
    .admin-dashboard-page li {
        font-family: 'Poppins', sans-serif;
        color: #6b6b6b;
    }
    
    /* Stats cards con gradientes */
    .stat-card {
        border-radius: 20px;
        padding: 1.25rem;
        color: #ffffff;
        box-shadow: 8px 8px 16px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease;
    }
    
    .stat-card:hover {
        box-shadow: 10px 10px 20px rgba(0, 0, 0, 0.2);
        transform: translateY(-5px);
    }
    
    .stat-card h4 {
        font-family: 'Poppins', sans-serif;
        color: #ffffff;
        font-size: 1.125rem;
        font-weight: 600;
    }
    
    .stat-card p {
        font-family: 'Poppins', sans-serif;
        color: #ffffff;
        font-size: 1.875rem;
        font-weight: 700;
    }
    
    .stat-blue {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
    }
    
    .stat-purple {
        background: linear-gradient(135deg, #a855f7, #9333ea);
    }
    
    .stat-green {
        background: linear-gradient(135deg, #10b981, #059669);
    }
    
    .stat-yellow {
        background: linear-gradient(135deg, #f59e0b, #d97706);
    }
    
    /* Quick action cards */
    .quick-action-card {
        background: #FFEEE2;
        border: 2px solid transparent;
        border-radius: 15px;
        padding: 1rem;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }
    
    .quick-action-card:hover {
        box-shadow: 6px 6px 12px #e6d5c9, -6px -6px 12px #ffffff;
        transform: scale(1.05);
    }
    
    .quick-action-card.border-indigo:hover {
        border-color: #6366f1;
    }
    
    .quick-action-card.border-green:hover {
        border-color: #10b981;
    }
    
    .quick-action-card.border-purple:hover {
        border-color: #a855f7;
    }
    
    .quick-action-card span {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
        font-weight: 600;
    }
    
    /* Warning box */
    .warning-box {
        background: rgba(254, 243, 199, 0.8);
        border-left: 4px solid #f59e0b;
        padding: 1.5rem;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        backdrop-filter: blur(10px);
    }
    
    .warning-box h4 {
        font-family: 'Poppins', sans-serif;
        color: #92400e;
        font-weight: 700;
    }
    
    .warning-box ul li {
        font-family: 'Poppins', sans-serif;
        font-size: 0.875rem;
    }
    
    .warning-box a {
        color: #78350f;
        transition: all 0.2s ease;
    }
    
    .warning-box a:hover {
        text-decoration: underline;
    }
    
    .warning-box .empty-text {
        color: #6b6b6b;
    }
    
    /* Eventos list container */
    .eventos-container {
        background: #FFEEE2;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        height: 24rem;
        overflow-y: auto;
        backdrop-filter: blur(10px);
    }
    
    /* Scrollbar personalizado */
    .eventos-container::-webkit-scrollbar {
        width: 8px;
    }
    
    .eventos-container::-webkit-scrollbar-track {
        background: rgba(212, 193, 176, 0.3);
        border-radius: 10px;
    }
    
    .eventos-container::-webkit-scrollbar-thumb {
        background: #e89a3c;
        border-radius: 10px;
    }
    
    /* Evento item */
    .evento-item {
        padding: 1rem 0;
        border-bottom: 1px solid rgba(107, 107, 107, 0.2);
    }
    
    .evento-item:last-child {
        border-bottom: none;
    }
    
    .evento-item p.evento-name {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
        font-size: 1.125rem;
        font-weight: 600;
    }
    
    .evento-item p.evento-date {
        font-family: 'Poppins', sans-serif;
        color: #6b6b6b;
        font-size: 0.875rem;
    }
    
    /* Badges de estado */
    .status-badge {
        font-family: 'Poppins', sans-serif;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .status-activo {
        background: linear-gradient(135deg, #2c2c2c, #1a1a1a);
        color: #ffffff;
    }
    
    .status-proximo {
        background: rgba(191, 219, 254, 0.8);
        color: #1e40af;
    }
    
    .status-default {
        background: rgba(229, 231, 235, 0.8);
        color: #374151;
    }
</style>

<div class="admin-dashboard-page py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="font-semibold text-xl mb-6">Inicio</h2>
        
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="stat-card stat-blue flex items-center justify-between">
                <div>
                    <h4>Estudiantes Activos</h4>
                    <p>{{ $totalEstudiantesActivos }}</p>
                </div>
                <svg class="w-12 h-12 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354V4a2 2 0 10-4 0v.354M15 15H3a3 3 0 013-3h12a3 3 0 013 3v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-2zm12 0a3 3 0 00-3-3h-2a3 3 0 00-3 3v2a2 2 0 002 2h4a2 2 0 002-2v-2z"></path></svg>
            </div>

            <div class="stat-card stat-purple flex items-center justify-between">
                <div>
                    <h4>Eventos en Curso</h4>
                    <p>{{ $eventosEnCursoCount }}</p>
                </div>
                <svg class="w-12 h-12 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2zm7-2H7m7-4H7m7-4H7"></path></svg>
            </div>

            <div class="stat-card stat-green flex items-center justify-between">
                <div>
                    <h4>Equipos Registrados</h4>
                    <p>{{ $equiposRegistradosCount }}</p>
                </div>
                <svg class="w-12 h-12 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>

            <div class="stat-card stat-yellow flex items-center justify-between">
                <div>
                    <h4>Jurados Registrados</h4>
                    <p>{{ $juradosAsignadosCount }}</p>
                </div>
                <svg class="w-12 h-12 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-9 8h2m-2 4h2m4-4h2m-2 4h2m-6 2h6"></path></svg>
            </div>
        </div>

        <!-- Acciones Rápidas -->
        <div class="mb-8">
            <h3 class="text-2xl font-bold mb-4">Acciones Rápidas</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('admin.eventos.create') }}" class="quick-action-card border-indigo flex flex-col items-center justify-center">
                    <svg class="w-8 h-8 mb-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    <span>Crear Evento</span>
                </a>
                <a href="{{ route('admin.users.index') }}" class="quick-action-card border-green flex flex-col items-center justify-center">
                    <svg class="w-8 h-8 mb-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM12 14v.01M12 18v.01"></path></svg>
                    <span>Gestionar Usuarios</span>
                </a>
                <a href="{{ route('admin.equipos.index') }}" class="quick-action-card border-purple flex flex-col items-center justify-center">
                    <svg class="w-8 h-8 mb-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span>Ver Equipos</span>
                </a>
            </div>
        </div>

        <!-- Eventos que Requieren Atención -->
        <div class="mb-8">
            <h3 class="text-2xl font-bold mb-4">Eventos que Requieren Atención ⚠️</h3>
            <div class="warning-box">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Eventos por Iniciar -->
                    <div>
                        <h4 class="mb-2">Próximos a Iniciar</h4>
                        <ul class="space-y-2">
                            @forelse($eventosPorIniciar as $evento)
                                <li><a href="{{ route('admin.eventos.show', $evento) }}">{{ $evento->nombre }} <span class="text-xs">({{ $evento->fecha_inicio->diffForHumans() }})</span></a></li>
                            @empty
                                <li class="empty-text">No hay eventos iniciando pronto.</li>
                            @endforelse
                        </ul>
                    </div>
                    <!-- Eventos sin Jurados -->
                    <div>
                        <h4 class="mb-2">Activos sin Jurados</h4>
                        <ul class="space-y-2">
                            @forelse($eventosSinJurados as $evento)
                                <li><a href="{{ route('admin.eventos.show', $evento) }}">{{ $evento->nombre }}</a></li>
                            @empty
                                <li class="empty-text">Todos los eventos activos tienen jurados.</li>
                            @endforelse
                        </ul>
                    </div>
                    <!-- Eventos con Equipos Incompletos -->
                    <div>
                        <h4 class="mb-2">Con Equipos Incompletos</h4>
                        <ul class="space-y-2">
                            @forelse($eventosConEquiposIncompletos as $evento)
                                <li><a href="{{ route('admin.eventos.show', $evento) }}">{{ $evento->nombre }} <span class="font-bold">({{ $evento->inscripciones_count }})</span></a></li>
                            @empty
                                <li class="empty-text">No hay equipos incompletos en eventos activos.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Próximos y Actuales Eventos -->
        <div class="mt-8">
            <h3 class="text-2xl font-bold mb-4">Próximos y Actuales Eventos</h3>
            <div class="eventos-container">
                <ul>
                    @forelse ($eventosDashboard as $evento)
                        <li class="evento-item flex flex-col sm:flex-row justify-between items-start sm:items-center">
                            <div class="mb-2 sm:mb-0">
                                <p class="evento-name">{{ $evento->nombre }}</p>
                                <p class="evento-date">
                                    {{ $evento->fecha_inicio->format('d/m/Y') }} - {{ $evento->fecha_fin->format('d/m/Y') }}
                                </p>
                            </div>
                            <span class="status-badge 
                                @if ($evento->estado == 'Activo') status-activo
                                @elseif ($evento->estado == 'Próximo') status-proximo
                                @else status-default @endif">
                                {{ $evento->estado }}
                            </span>
                        </li>
                    @empty
                        <li class="py-4 text-center" style="color: #6b6b6b;">No hay eventos próximos o activos para mostrar.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection