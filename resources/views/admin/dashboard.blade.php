@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
    
    :root {
        --admin-bg-primary: #ffffff;
        --admin-bg-secondary: #f8f9fa;
        --admin-bg-card: #ffffff;
        --admin-bg-card-hover: #f8f9fa;
        --admin-text-primary: #1a1a1a;
        --admin-text-secondary: #6b7280;
        --admin-text-muted: #9ca3af;
        --admin-border: #e5e7eb;
        --admin-accent-blue: #3b82f6;
        --admin-accent-purple: #a855f7;
        --admin-accent-green: #10b981;
        --admin-accent-orange: #f59e0b;
        --admin-accent-red: #ef4444;
        --admin-shadow: rgba(0, 0, 0, 0.08);
    }
    
    /* Fondo blanco */s
    .admin-dashboard-page {
        background: var(--admin-bg-primary);
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
    }
    
    /* Textos */
    .admin-dashboard-page h2,
    .admin-dashboard-page h3,
    .admin-dashboard-page h4 {
        font-family: 'Poppins', sans-serif;
        color: var(--admin-text-primary);
    }
    
    .admin-dashboard-page p,
    .admin-dashboard-page span,
    .admin-dashboard-page li {
        font-family: 'Poppins', sans-serif;
        color: var(--admin-text-secondary);
    }
    
    /* Stats cards con gradientes */
    .stat-card {
        border-radius: 16px;
        padding: 1.5rem;
        color: #ffffff;
        box-shadow: 0 4px 20px var(--admin-shadow);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: none;
        position: relative;
        overflow: hidden;
    }
    
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(255,255,255,0.15) 0%, transparent 100%);
        pointer-events: none;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 40px var(--admin-shadow);
    }
    
    .stat-card h4 {
        font-family: 'Poppins', sans-serif;
        color: rgba(255, 255, 255, 0.9);
        font-size: 0.875rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .stat-card p {
        font-family: 'Poppins', sans-serif;
        color: #ffffff;
        font-size: 2.5rem;
        font-weight: 700;
    }
    
    .stat-blue {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    }
    
    .stat-purple {
        background: linear-gradient(135deg, #a855f7, #7c3aed);
    }
    
    .stat-green {
        background: linear-gradient(135deg, #10b981, #059669);
    }
    
    .stat-orange {
        background: linear-gradient(135deg, #f59e0b, #d97706);
    }
    
    /* Quick action cards */
    .quick-action-card {
        background: var(--admin-bg-card);
        border: 1px solid var(--admin-border);
        border-radius: 12px;
        padding: 1.25rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
        box-shadow: 0 2px 8px var(--admin-shadow);
    }
    
    .quick-action-card:hover {
        background: var(--admin-bg-card-hover);
        border-color: var(--admin-border);
        transform: translateY(-4px);
        box-shadow: 0 8px 25px var(--admin-shadow);
    }
    
    .quick-action-card.border-indigo:hover {
        border-color: var(--admin-accent-blue);
        box-shadow: 0 10px 30px rgba(59, 130, 246, 0.2);
    }
    
    .quick-action-card.border-green:hover {
        border-color: var(--admin-accent-green);
        box-shadow: 0 10px 30px rgba(16, 185, 129, 0.2);
    }
    
    .quick-action-card.border-purple:hover {
        border-color: var(--admin-accent-purple);
        box-shadow: 0 10px 30px rgba(168, 85, 247, 0.2);
    }
    
    .quick-action-card span {
        font-family: 'Poppins', sans-serif;
        color: var(--admin-text-primary);
        font-weight: 600;
        font-size: 0.9rem;
    }
    
    /* Warning box */
    .warning-box {
        background: var(--admin-bg-card);
        border: 1px solid var(--admin-border);
        border-left: 4px solid var(--admin-accent-orange);
        border-radius: 12px;
        padding: 1.5rem;
    }
    
    .warning-box h4 {
        font-family: 'Poppins', sans-serif;
        color: var(--admin-accent-orange);
        font-weight: 600;
        font-size: 1rem;
        margin-bottom: 0.75rem;
    }
    
    .warning-box ul li {
        font-family: 'Poppins', sans-serif;
        font-size: 0.875rem;
    }
    
    .warning-box a {
        color: var(--admin-text-secondary);
        transition: all 0.2s ease;
    }
    
    .warning-box a:hover {
        color: var(--admin-accent-orange);
    }
    
    .warning-box .empty-text {
        color: var(--admin-text-muted);
    }
    
    /* =============================================== */
    /* TABLAS MODERNAS */
    /* =============================================== */
    .eventos-section-title {
        font-family: 'Poppins', sans-serif;
        color: var(--admin-text-primary);
        font-size: 1.25rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1rem;
    }
    
    .eventos-section-title .icon-wrapper {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .eventos-section-title .icon-wrapper.green {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.2), rgba(16, 185, 129, 0.1));
        color: var(--admin-accent-green);
    }
    
    .eventos-section-title .icon-wrapper.blue {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.2), rgba(59, 130, 246, 0.1));
        color: var(--admin-accent-blue);
    }
    
    .eventos-table-container {
        background: var(--admin-bg-card);
        border: 1px solid var(--admin-border);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 2px 12px var(--admin-shadow);
    }
    
    .eventos-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .eventos-table thead {
        background: var(--admin-bg-secondary);
    }
    
    .eventos-table thead th {
        font-family: 'Poppins', sans-serif;
        color: var(--admin-text-muted);
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 1rem 1.25rem;
        text-align: left;
        border-bottom: 1px solid var(--admin-border);
    }
    
    .eventos-table tbody tr {
        transition: all 0.2s ease;
        border-bottom: 1px solid var(--admin-border);
    }
    
    .eventos-table tbody tr:last-child {
        border-bottom: none;
    }
    
    .eventos-table tbody tr:hover {
        background: var(--admin-bg-card-hover);
    }
    
    .eventos-table tbody td {
        padding: 1rem 1.25rem;
        font-family: 'Poppins', sans-serif;
        vertical-align: middle;
    }
    
    .evento-name-cell {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .evento-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    
    .evento-icon.active {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.2), rgba(16, 185, 129, 0.1));
        color: var(--admin-accent-green);
    }
    
    .evento-icon.upcoming {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.2), rgba(59, 130, 246, 0.1));
        color: var(--admin-accent-blue);
    }
    
    .evento-name-text {
        color: var(--admin-text-primary);
        font-weight: 500;
        font-size: 0.95rem;
    }
    
    .evento-date-text {
        color: var(--admin-text-secondary);
        font-size: 0.875rem;
    }
    
    .evento-date-icon {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--admin-text-muted);
    }
    
    /* Status badges */
    .status-badge {
        font-family: 'Poppins', sans-serif;
        padding: 0.35rem 0.85rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }
    
    .status-activo {
        background: rgba(16, 185, 129, 0.12);
        color: #059669;
        border: 1px solid rgba(16, 185, 129, 0.25);
    }
    
    .status-activo::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #10b981;
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
    
    .status-proximo {
        background: rgba(59, 130, 246, 0.12);
        color: #2563eb;
        border: 1px solid rgba(59, 130, 246, 0.25);
    }
    
    .action-btn {
        background: transparent;
        border: 1px solid var(--admin-border);
        border-radius: 8px;
        padding: 0.5rem 0.75rem;
        color: var(--admin-text-secondary);
        font-size: 0.75rem;
        font-weight: 500;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }
    
    .action-btn:hover {
        background: var(--admin-accent-blue);
        border-color: var(--admin-accent-blue);
        color: #ffffff;
    }
    
    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 3rem 1.5rem;
        color: var(--admin-text-muted);
    }
    
    .empty-state svg {
        width: 48px;
        height: 48px;
        margin: 0 auto 1rem;
        opacity: 0.5;
    }
    
    .empty-state p {
        color: var(--admin-text-muted);
        font-size: 0.9rem;
    }
    
    /* Scrollbar personalizado */
    .eventos-table-wrapper {
        max-height: 320px;
        overflow-y: auto;
    }
    
    .eventos-table-wrapper::-webkit-scrollbar {
        width: 6px;
    }
    
    .eventos-table-wrapper::-webkit-scrollbar-track {
        background: var(--admin-bg-secondary);
    }
    
    .eventos-table-wrapper::-webkit-scrollbar-thumb {
        background: var(--admin-border);
        border-radius: 10px;
    }
    
    .eventos-table-wrapper::-webkit-scrollbar-thumb:hover {
        background: var(--admin-text-muted);
    }
    
    /* Section divider */
    .section-divider {
        border-top: 1px solid var(--admin-border);
        margin: 2rem 0;
    }
</style>

<div class="admin-dashboard-page py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold" style="color: var(--admin-text-primary);">Panel de Administración</h2>
            <p style="color: var(--admin-text-muted); font-size: 0.9rem;">Bienvenido al centro de control del sistema</p>
        </div>
        
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
            <div class="stat-card stat-blue flex items-center justify-between">
                <div>
                    <h4>Estudiantes Activos</h4>
                    <p>{{ $totalEstudiantesActivos }}</p>
                </div>
                <svg class="w-10 h-10 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>

            <div class="stat-card stat-purple flex items-center justify-between">
                <div>
                    <h4>Eventos en Curso</h4>
                    <p>{{ $eventosEnCursoCount }}</p>
                </div>
                <svg class="w-10 h-10 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>

            <div class="stat-card stat-green flex items-center justify-between">
                <div>
                    <h4>Equipos Registrados</h4>
                    <p>{{ $equiposRegistradosCount }}</p>
                </div>
                <svg class="w-10 h-10 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>

            <div class="stat-card stat-orange flex items-center justify-between">
                <div>
                    <h4>Jurados Registrados</h4>
                    <p>{{ $juradosAsignadosCount }}</p>
                </div>
                <svg class="w-10 h-10 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
            </div>
        </div>

        <!-- Acciones Rápidas -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold mb-4" style="color: var(--admin-text-primary);">Acciones Rápidas</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('admin.eventos.create') }}" class="quick-action-card border-indigo flex flex-col items-center justify-center py-5">
                    <svg class="w-8 h-8 mb-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    <span>Crear Evento</span>
                </a>
                <a href="{{ route('admin.users.index') }}" class="quick-action-card border-green flex flex-col items-center justify-center py-5">
                    <svg class="w-8 h-8 mb-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                    <span>Gestionar Usuarios</span>
                </a>
                <a href="{{ route('admin.equipos.index') }}" class="quick-action-card border-purple flex flex-col items-center justify-center py-5">
                    <svg class="w-8 h-8 mb-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span>Ver Equipos</span>
                </a>
            </div>
        </div>

        <!-- Eventos que Requieren Atención -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold mb-4 flex items-center gap-2" style="color: var(--admin-text-primary);">
                <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                Eventos que Requieren Atención
            </h3>
            <div class="warning-box">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Eventos por Iniciar -->
                    <div>
                        <h4>Próximos a Iniciar</h4>
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
                        <h4>Activos sin Jurados</h4>
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
                        <h4>Con Equipos Incompletos</h4>
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

        <!-- Tablas de Eventos -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-8">
            <!-- Eventos Activos -->
            <div>
                <div class="eventos-section-title">
                    <div class="icon-wrapper green">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    Eventos Activos
                </div>
                <div class="eventos-table-container">
                    <div class="eventos-table-wrapper">
                        <table class="eventos-table">
                            <thead>
                                <tr>
                                    <th>Evento</th>
                                    <th>Fechas</th>
                                    <th>Estado</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($eventosActivos as $evento)
                                    <tr>
                                        <td>
                                            <div class="evento-name-cell">
                                                <div class="evento-icon active">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                </div>
                                                <span class="evento-name-text">{{ $evento->nombre }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="evento-date-icon">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                <span class="evento-date-text">{{ $evento->fecha_inicio->format('d/m') }} - {{ $evento->fecha_fin->format('d/m/Y') }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="status-badge status-activo">Activo</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.eventos.show', $evento) }}" class="action-btn">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                Ver
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">
                                            <div class="empty-state">
                                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                <p>No hay eventos activos</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Eventos Próximos -->
            <div>
                <div class="eventos-section-title">
                    <div class="icon-wrapper blue">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    Eventos Próximos
                </div>
                <div class="eventos-table-container">
                    <div class="eventos-table-wrapper">
                        <table class="eventos-table">
                            <thead>
                                <tr>
                                    <th>Evento</th>
                                    <th>Inicia</th>
                                    <th>Estado</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($eventosProximos as $evento)
                                    <tr>
                                        <td>
                                            <div class="evento-name-cell">
                                                <div class="evento-icon upcoming">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                </div>
                                                <span class="evento-name-text">{{ $evento->nombre }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="evento-date-icon">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                <span class="evento-date-text">{{ $evento->fecha_inicio->format('d/m/Y') }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="status-badge status-proximo">Próximo</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.eventos.show', $evento) }}" class="action-btn">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                Ver
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">
                                            <div class="empty-state">
                                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                <p>No hay eventos próximos programados</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection