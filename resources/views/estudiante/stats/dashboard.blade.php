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
    .stats-page {
        background: linear-gradient(to bottom, #FFFDF4, #FFEEE2);
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
    }
    
    /* Header neuromórfico */
    .neuro-header {
        background: #FFEEE2;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
    }
    
    .neuro-header-gradient {
        background: linear-gradient(135deg, #e89a3c, #f5a847);
        border-radius: 15px;
        padding: 2rem;
        color: #ffffff;
        box-shadow: 4px 4px 8px rgba(232, 154, 60, 0.3);
    }
    
    .neuro-header h2 {
        font-family: 'Poppins', sans-serif;
        font-size: 1.875rem;
        font-weight: 700;
    }
    
    .neuro-header p {
        font-family: 'Poppins', sans-serif;
        opacity: 0.9;
    }
    
    /* Barra de progreso */
    .progress-bar-container {
        background: rgba(255, 255, 255, 0.3);
        border-radius: 15px;
        height: 0.75rem;
        box-shadow: inset 2px 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .progress-bar-fill {
        background: #ffffff;
        height: 0.75rem;
        border-radius: 15px;
        box-shadow: 2px 2px 4px rgba(255, 255, 255, 0.5);
        transition: all 0.5s ease;
    }
    
    /* Stats cards */
    .stat-card {
        background: #FFEEE2;
        border-radius: 20px;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
        padding: 1.5rem;
        transition: all 0.3s ease;
    }
    
    .stat-card:hover {
        box-shadow: 10px 10px 20px #e6d5c9, -10px -10px 20px #ffffff;
        transform: translateY(-5px);
    }
    
    .stat-icon-container {
        border-radius: 12px;
        padding: 0.75rem;
        box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.05);
    }
    
    .stat-icon-blue {
        background: linear-gradient(135deg, #60a5fa, #3b82f6);
    }
    
    .stat-icon-green {
        background: linear-gradient(135deg, #34d399, #10b981);
    }
    
    .stat-icon-yellow {
        background: linear-gradient(135deg, #fbbf24, #f59e0b);
    }
    
    .stat-icon-purple {
        background: linear-gradient(135deg, #a78bfa, #8b5cf6);
    }
    
    .stat-card p {
        font-family: 'Poppins', sans-serif;
        color: #6b6b6b;
        font-size: 0.875rem;
    }
    
    .stat-card .stat-value {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
        font-size: 1.5rem;
        font-weight: 700;
    }
    
    /* Content cards */
    .content-card {
        background: #FFEEE2;
        border-radius: 20px;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
        padding: 1.5rem;
    }
    
    .content-card h3 {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
        font-size: 1.125rem;
        font-weight: 600;
    }
    
    .content-card a {
        font-family: 'Poppins', sans-serif;
        color: #e89a3c;
        font-weight: 600;
        transition: all 0.2s ease;
    }
    
    .content-card a:hover {
        color: #d98a2c;
        opacity: 0.8;
    }
    
    /* Logros items */
    .logro-item {
        background: rgba(255, 255, 255, 0.5);
        border-radius: 15px;
        padding: 0.75rem;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        transition: all 0.2s ease;
        backdrop-filter: blur(10px);
    }
    
    .logro-item:hover {
        box-shadow: 6px 6px 12px #e6d5c9, -6px -6px 12px #ffffff;
        transform: translateY(-2px);
    }
    
    .logro-item h4 {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
        font-weight: 600;
    }
    
    .logro-item p {
        font-family: 'Poppins', sans-serif;
        color: #6b6b6b;
        font-size: 0.75rem;
    }
    
    .logro-xp {
        font-family: 'Poppins', sans-serif;
        color: #e89a3c;
        font-weight: 700;
        font-size: 0.875rem;
    }
    
    /* Habilidades badges */
    .habilidad-badge {
        font-family: 'Poppins', sans-serif;
        display: inline-flex;
        align-items: center;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 500;
        color: #ffffff;
        box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.15);
    }
    
    /* Placeholder */
    .chart-placeholder {
        background: rgba(255, 255, 255, 0.3);
        border-radius: 15px;
        height: 16rem;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: inset 4px 4px 8px #e6d5c9, inset -4px -4px 8px #ffffff;
    }
    
    .chart-placeholder p {
        font-family: 'Poppins', sans-serif;
        color: #6b6b6b;
    }
</style>

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