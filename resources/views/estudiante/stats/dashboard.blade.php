@extends('layouts.app')

@section('content')

<div class="stats-page py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('estudiante.dashboard') }}" class="back-link">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver al Dashboard
        </a>
        <!-- Header con Stats de Usuario -->
        <div class="neuro-header">
            <div class="neuro-header-gradient">
                <div class="flex items-center justify-between">
                    <div>
                        <h2>¡Hola, {{ Auth::user()->nombre }}!</h2>
                        <p class="mt-2">Panel de Estadísticas y Progreso</p>
                    </div>
                    
                    <!-- XP y Nivel -->
                    <div class="text-right">
                        <div class="text-5xl font-bold">Nivel {{ $stats->nivel ?? 1 }}</div>
                        <div class="text-sm mt-1" style="opacity: 0.9;">{{ number_format($stats->total_xp ?? 0) }} XP Total</div>
                    </div>
                </div>
                
                <!-- Barra de Progreso del Nivel -->
                <div class="mt-6">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium">Progreso al Nivel {{ ($stats->nivel ?? 1) + 1 }}</span>
                        <span class="text-sm">{{ number_format($stats->total_xp ?? 0) }} / {{ number_format($stats->xp_siguiente_nivel ?? 100) }} XP</span>
                    </div>
                    <div class="progress-bar-container">
                        <div class="progress-bar-fill" style="width: {{ $stats->progreso_nivel ?? 0 }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tarjetas de Estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Eventos Participados -->
            <div class="stat-card">
                <div class="flex items-center">
                    <div class="stat-icon-container stat-icon-blue">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p>Eventos Participados</p>
                        <p class="stat-value">{{ $stats->eventos_participados ?? 0 }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Proyectos Completados -->
            <div class="stat-card">
                <div class="flex items-center">
                    <div class="stat-icon-container stat-icon-green">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p>Proyectos Completados</p>
                        <p class="stat-value">{{ $stats->proyectos_completados ?? 0 }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Veces Líder -->
            <div class="stat-card">
                <div class="flex items-center">
                    <div class="stat-icon-container stat-icon-yellow">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p>Veces Líder</p>
                        <p class="stat-value">{{ $stats->veces_lider ?? 0 }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Logros Obtenidos -->
            <div class="stat-card">
                <div class="flex items-center">
                    <div class="stat-icon-container stat-icon-purple">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p>Logros Desbloqueados</p>
                        <p class="stat-value">{{ $logrosCount }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Gráfica de Progreso (Placeholder para Chart.js) -->
            <div class="content-card">
                <h3 class="mb-4">Progreso Mensual</h3>
                <div class="chart-placeholder">
                    <p>Gráfica de XP por mes (Chart.js pendiente)</p>
                </div>
            </div>
            
            <!-- Logros Recientes -->
            <div class="content-card">
                <div class="flex items-center justify-between mb-4">
                    <h3>Logros Recientes</h3>
                    <a href="{{ route('estudiante.habilidades.index') }}">Ver todos →</a>
                </div>
                
                @if($logrosRecientes->isEmpty())
                    <div class="text-center py-8">
                        <p style="color: #6b6b6b;">Aún no has desbloqueado logros</p>
                        <p style="color: #6b6b6b; font-size: 0.75rem; margin-top: 0.25rem;">Participa en eventos para obtener logros</p>
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach($logrosRecientes as $usuarioLogro)
                            <div class="logro-item flex items-center">
                                <span class="text-3xl mr-3">{{ $usuarioLogro->logro->icono }}</span>
                                <div class="flex-1">
                                    <h4>{{ $usuarioLogro->logro->nombre }}</h4>
                                    <p>{{ $usuarioLogro->logro->descripcion }}</p>
                                    <p style="color: #9ca3af; margin-top: 0.25rem;">{{ $usuarioLogro->fecha_obtencion->diffForHumans() }}</p>
                                </div>
                                <span class="logro-xp">+{{ $usuarioLogro->logro->puntos_xp }} XP</span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        
    </div>
</div>
@endsection