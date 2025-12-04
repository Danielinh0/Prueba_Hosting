@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
    
    .equipos-page {
        background: linear-gradient(135deg, #FFFDF4 0%, #FFF8F0 50%, #FFEEE2 100%);
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
    }
    
    .equipos-page * {
        font-family: 'Poppins', sans-serif;
    }

    /* Hero Section */
    .hero-section {
        background: linear-gradient(135deg, #1a1a1a 0%, #2c2c2c 50%, #3d3d3d 100%);
        border-radius: 24px;
        padding: 2.5rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: -100px;
        right: -100px;
        width: 350px;
        height: 350px;
        background: radial-gradient(circle, rgba(232, 154, 60, 0.15) 0%, transparent 70%);
        pointer-events: none;
    }

    .hero-section::after {
        content: '';
        position: absolute;
        bottom: -80px;
        left: -80px;
        width: 250px;
        height: 250px;
        background: radial-gradient(circle, rgba(232, 154, 60, 0.1) 0%, transparent 70%);
        pointer-events: none;
    }

    .hero-content {
        position: relative;
        z-index: 1;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .hero-text h1 {
        color: #ffffff;
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
    }

    .hero-text h1 span {
        color: #e89a3c;
    }

    .hero-text p {
        color: rgba(255, 255, 255, 0.7);
        font-size: 1rem;
        max-width: 500px;
    }

    .hero-stats {
        display: flex;
        gap: 1.5rem;
    }

    .hero-stat {
        text-align: center;
        padding: 1rem 1.5rem;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 16px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
    }

    .hero-stat-number {
        color: #e89a3c;
        font-size: 2rem;
        font-weight: 800;
        line-height: 1;
    }

    .hero-stat-label {
        color: rgba(255, 255, 255, 0.6);
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-top: 0.25rem;
    }

    /* Teams Grid */
    .teams-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
        gap: 1.5rem;
    }

    @media (max-width: 480px) {
        .teams-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Team Card */
    .team-card {
        background: #ffffff;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        border: 1px solid rgba(0, 0, 0, 0.04);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        position: relative;
    }

    .team-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
    }

    .team-card-leader {
        border: 2px solid #e89a3c;
    }

    .team-card-leader::before {
        content: '👑 Eres el Líder';
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: linear-gradient(135deg, #e89a3c, #f5b76c);
        color: white;
        font-size: 0.7rem;
        font-weight: 700;
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
        z-index: 10;
        box-shadow: 0 4px 12px rgba(232, 154, 60, 0.3);
    }

    .team-card-header {
        background: linear-gradient(135deg, #1a1a1a, #2c2c2c);
        padding: 1.5rem;
        position: relative;
    }

    .team-card-header::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #e89a3c, #f5b76c, #e89a3c);
    }

    .team-name {
        color: #ffffff;
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        padding-right: 100px;
    }

    .team-event {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.85rem;
    }

    .team-event svg {
        width: 16px;
        height: 16px;
        color: #e89a3c;
    }

    .team-card-body {
        padding: 1.5rem;
    }

    /* Team Stats Row */
    .team-stats-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .team-stat-item {
        text-align: center;
        padding: 0.75rem;
        background: linear-gradient(135deg, rgba(232, 154, 60, 0.08), rgba(232, 154, 60, 0.03));
        border-radius: 12px;
    }

    .team-stat-value {
        font-size: 1.25rem;
        font-weight: 800;
        color: #1a1a1a;
    }

    .team-stat-label {
        font-size: 0.7rem;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    /* Members Preview */
    .members-preview {
        margin-bottom: 1.5rem;
    }

    .members-preview-title {
        font-size: 0.75rem;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.75rem;
    }

    .members-avatars {
        display: flex;
        align-items: center;
    }

    .member-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #e89a3c, #f5b76c);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 0.875rem;
        border: 3px solid #ffffff;
        margin-left: -10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        position: relative;
    }

    .member-avatar:first-child {
        margin-left: 0;
    }

    .member-avatar:hover {
        transform: scale(1.1) translateY(-4px);
        z-index: 10;
    }

    .member-avatar-leader {
        background: linear-gradient(135deg, #1a1a1a, #3d3d3d);
        border-color: #e89a3c;
    }

    .member-avatar-more {
        background: #f3f4f6;
        color: #6b7280;
        font-size: 0.75rem;
    }

    /* My Role Badge */
    .my-role-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: linear-gradient(135deg, rgba(232, 154, 60, 0.1), rgba(232, 154, 60, 0.05));
        color: #b37a2e;
        padding: 0.5rem 1rem;
        border-radius: 10px;
        font-size: 0.8rem;
        font-weight: 600;
        margin-bottom: 1.25rem;
    }

    .my-role-badge svg {
        width: 16px;
        height: 16px;
    }

    /* Team Actions */
    .team-actions {
        display: flex;
        gap: 0.75rem;
    }

    .team-action-btn {
        flex: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.85rem 1rem;
        border-radius: 12px;
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .team-action-btn svg {
        width: 18px;
        height: 18px;
    }

    .team-action-primary {
        background: linear-gradient(135deg, #1a1a1a, #2c2c2c);
        color: #ffffff;
    }

    .team-action-primary:hover {
        background: linear-gradient(135deg, #e89a3c, #f5b76c);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(232, 154, 60, 0.3);
        color: #ffffff;
    }

    .team-action-secondary {
        background: #f3f4f6;
        color: #4b5563;
    }

    .team-action-secondary:hover {
        background: #e5e7eb;
        color: #1f2937;
    }

    /* Pending Requests Indicator */
    .pending-requests {
        position: absolute;
        top: 1rem;
        left: 1rem;
        background: #ef4444;
        color: white;
        font-size: 0.7rem;
        font-weight: 700;
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
        display: flex;
        align-items: center;
        gap: 0.35rem;
        animation: pulse 2s infinite;
        z-index: 10;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }

    .pending-requests svg {
        width: 14px;
        height: 14px;
    }

    /* Event Status Badge */
    .event-status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
        margin-left: 0.5rem;
    }

    .status-en-progreso {
        background: rgba(16, 185, 129, 0.1);
        color: #059669;
    }

    .status-activo {
        background: rgba(59, 130, 246, 0.1);
        color: #2563eb;
    }

    .status-pendiente {
        background: rgba(245, 158, 11, 0.1);
        color: #d97706;
    }

    .status-finalizado {
        background: rgba(107, 114, 128, 0.1);
        color: #6b7280;
    }

    /* Empty State */
    .empty-state {
        background: #ffffff;
        border-radius: 24px;
        padding: 4rem 2rem;
        text-align: center;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        border: 1px solid rgba(0, 0, 0, 0.04);
    }

    .empty-state-icon {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, rgba(232, 154, 60, 0.1), rgba(232, 154, 60, 0.05));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
    }

    .empty-state-icon svg {
        width: 50px;
        height: 50px;
        color: #e89a3c;
    }

    .empty-state h3 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 0.75rem;
    }

    .empty-state p {
        color: #6b7280;
        font-size: 1rem;
        max-width: 400px;
        margin: 0 auto 2rem;
        line-height: 1.6;
    }

    .empty-state-actions {
        display: flex;
        justify-content: center;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .empty-state-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.875rem 1.75rem;
        border-radius: 12px;
        font-size: 0.9rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .empty-state-btn-primary {
        background: linear-gradient(135deg, #e89a3c, #f5b76c);
        color: #ffffff;
        box-shadow: 0 4px 16px rgba(232, 154, 60, 0.3);
    }

    .empty-state-btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(232, 154, 60, 0.4);
        color: #ffffff;
    }

    .empty-state-btn-secondary {
        background: #f3f4f6;
        color: #4b5563;
    }

    .empty-state-btn-secondary:hover {
        background: #e5e7eb;
        color: #1f2937;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .hero-content {
            flex-direction: column;
            text-align: center;
            gap: 1.5rem;
        }

        .hero-text h1 {
            font-size: 1.5rem;
        }

        .hero-stats {
            justify-content: center;
        }

        .team-stats-row {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="equipos-page py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <!-- Hero Section -->
        <div class="hero-section">
            <div class="hero-content">
                <div class="hero-text">
                    <h1>Mis <span>Equipos</span></h1>
                    <p>Gestiona tus equipos, revisa solicitudes pendientes y colabora con tus compañeros en los proyectos.</p>
                </div>
                <div style="display: flex; align-items: center; gap: 1.5rem;">
                    <a href="{{ route('estudiante.equipos.create-sin-evento') }}" 
                       style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.25rem; background: linear-gradient(135deg, #e89a3c, #f5b76c); color: white; border-radius: 12px; font-weight: 600; text-decoration: none; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(232, 154, 60, 0.3);">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Crear Equipo
                    </a>
                    <div class="hero-stats">
                        <div class="hero-stat">
                            <div class="hero-stat-number">{{ $equipos->count() }}</div>
                            <div class="hero-stat-label">Equipos</div>
                        </div>
                        <div class="hero-stat">
                            <div class="hero-stat-number">{{ $equipos->where('esLider', true)->count() }}</div>
                            <div class="hero-stat-label">Como Líder</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($equipos->count() > 0)
            <!-- Teams Grid -->
            <div class="teams-grid">
                @foreach($equipos as $equipoData)
                    @php
                        $inscripcion = $equipoData['inscripcion'];
                        $esLider = $equipoData['esLider'];
                        $solicitudes = $equipoData['solicitudes'];
                        $equipo = $inscripcion->equipo;
                        $miembros = $inscripcion->miembros;
                        $evento = $inscripcion->evento;
                        $miRol = $miembros->firstWhere('id_estudiante', Auth::user()->id_usuario)?->rol?->nombre ?? 'Miembro';
                    @endphp
                    
                    <div class="team-card {{ $esLider ? 'team-card-leader' : '' }}">
                        @if($esLider && $solicitudes->count() > 0)
                            <div class="pending-requests">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                                {{ $solicitudes->count() }} solicitud{{ $solicitudes->count() > 1 ? 'es' : '' }}
                            </div>
                        @endif

                        <div class="team-card-header">
                            <h3 class="team-name">{{ $equipo->nombre }}</h3>
                            <div class="team-event">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ $evento->nombre ?? 'Sin evento' }}
                                @if($evento)
                                    <span class="event-status-badge status-{{ strtolower(str_replace(' ', '-', $evento->estado)) }}">
                                        {{ $evento->estado }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="team-card-body">
                            <!-- Team Stats -->
                            <div class="team-stats-row">
                                <div class="team-stat-item">
                                    <div class="team-stat-value">{{ $miembros->count() }}</div>
                                    <div class="team-stat-label">Miembros</div>
                                </div>
                                <div class="team-stat-item">
                                    <div class="team-stat-value">{{ $esLider ? $solicitudes->count() : '-' }}</div>
                                    <div class="team-stat-label">Solicitudes</div>
                                </div>
                                <div class="team-stat-item">
                                    <div class="team-stat-value">0%</div>
                                    <div class="team-stat-label">Avance</div>
                                </div>
                            </div>

                            <!-- Members Preview -->
                            <div class="members-preview">
                                <div class="members-preview-title">Miembros del equipo</div>
                                <div class="members-avatars">
                                    @foreach($miembros->take(5) as $miembro)
                                        <div class="member-avatar {{ $miembro->es_lider ? 'member-avatar-leader' : '' }}" 
                                             title="{{ $miembro->user->name }} {{ $miembro->es_lider ? '(Líder)' : '' }}">
                                            {{ strtoupper(substr($miembro->user->name, 0, 2)) }}
                                        </div>
                                    @endforeach
                                    @if($miembros->count() > 5)
                                        <div class="member-avatar member-avatar-more">
                                            +{{ $miembros->count() - 5 }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- My Role -->
                            <div class="my-role-badge">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Mi rol: {{ $miRol }}
                            </div>

                            <!-- Actions -->
                            <div class="team-actions">
                                <a href="{{ route('estudiante.equipo.show-detalle', $inscripcion) }}" class="team-action-btn team-action-primary">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Ver Equipo
                                </a>
                                @if($esLider && $solicitudes->count() > 0)
                                    <a href="{{ route('estudiante.equipo.show-detalle', $inscripcion) }}#solicitudes" class="team-action-btn team-action-secondary">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                        </svg>
                                        Solicitudes
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="empty-state">
                <div class="empty-state-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <h3>Aún no tienes equipos</h3>
                <p>Únete a un equipo existente o crea uno nuevo para participar en los eventos y colaborar con otros estudiantes.</p>
                <div class="empty-state-actions">
                    <a href="{{ route('estudiante.equipos.create-sin-evento') }}" class="empty-state-btn empty-state-btn-primary">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Crear Nuevo Equipo
                    </a>
                    <a href="{{ route('estudiante.eventos.index') }}" class="empty-state-btn empty-state-btn-secondary">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Explorar Eventos
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
