@extends('layouts.app')

@section('content')

<div class="equipos-page py-12">
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
                    <h1><span>Equipos</span></h1>
                    <p>Gestiona tus equipos, revisa solicitudes pendientes y colabora con tus compañeros en los proyectos.</p>
                </div>
                <div style="display: flex; align-items: center; gap: 1.5rem;">
                    <a href="{{ route('estudiante.equipos.create-sin-evento') }}" class="btn-crear-equipo">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
        
        <!-- Filtro de Búsqueda -->
        <div class="filter-card" style="background: #FFEEE2; border-radius: 20px; padding: 1rem; margin-bottom: 2rem; box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;">
            <form action="{{ route('estudiante.equipo.index') }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="md:col-span-3">
                        <input type="text" name="search" placeholder="Buscar por nombre de equipo o evento..." value="{{ $search ?? '' }}" 
                            style="font-family: 'Poppins', sans-serif; background: rgba(255, 255, 255, 0.5); border: none; box-shadow: inset 4px 4px 8px #e6d5c9, inset -4px -4px 8px #ffffff; color: #2c2c2c; width: 100%; padding: 0.5rem 1rem; border-radius: 0.375rem;"
                            class="w-full">
                    </div>
                    <div class="flex items-center space-x-2">
                        <button type="submit" style="font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #2c2c2c, #1a1a1a); color: #ffffff; font-weight: 600; padding: 0.5rem 1rem; border-radius: 0.375rem; box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.2); border: none; width: 100%;">Buscar</button>
                        <a href="{{ route('estudiante.equipo.index') }}" style="font-family: 'Poppins', sans-serif; background: rgba(255, 255, 255, 0.5); color: #2c2c2c; font-weight: 500; padding: 0.5rem 1rem; border-radius: 0.375rem; box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff; border: none; text-decoration: none; text-align: center; width: 100%;">Limpiar</a>
                    </div>
                </div>
            </form>
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

                        <!-- Imagen del equipo -->
                        <div class="team-image-container">
                            @if($equipo->ruta_imagen)
                                <img src="{{ asset('storage/' . $equipo->ruta_imagen) }}" alt="{{ $equipo->nombre }}" class="team-image">
                            @else
                                <div class="team-image-placeholder">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                            @endif
                            <div class="team-image-overlay"></div>
                        </div>

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
                                <!-- Ver Equipo -->
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
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Crear Nuevo Equipo
                    </a>
                    <a href="{{ route('estudiante.eventos.index') }}" class="empty-state-btn empty-state-btn-secondary">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Explorar Eventos
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>


<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
    
    .equipos-page {
        background: linear-gradient(to bottom, #FFFDF4, #FFEEE2);
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
    }
    
    .equipos-page * {
        font-family: 'Poppins', sans-serif;
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
    
    /* Hero Section Neuromórfica - Tonos Grises Pastel */
    .hero-section {
        background: linear-gradient(135deg, #0e0e0eff 0%, #434343ff 50%, #1d1d1dff 100%);
        border-radius: 24px;
        padding: 2.5rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: 8px 8px 16px rgba(200, 200, 200, 0.4), -8px -8px 16px rgba(255, 255, 255, 0.9);
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: -100px;
        right: -100px;
        width: 350px;
        height: 350px;
        background: radial-gradient(circle, rgba(232, 154, 60, 0.08) 0%, transparent 70%);
        pointer-events: none;
    }

    .hero-section::after {
        content: '';
        position: absolute;
        bottom: -80px;
        left: -80px;
        width: 250px;
        height: 250px;
        background: radial-gradient(circle, rgba(232, 154, 60, 0.05) 0%, transparent 70%);
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
        color: #c1c1c1ff;
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
        text-shadow: 1px 1px 2px rgba(235, 132, 72, 0.8);
    }

    .hero-text h1 span {
        color: #e89a3c;
        text-shadow: 1px 1px 2px rgba(232, 154, 60, 0.2);
    }

    .hero-text p {
        color: #cfcfcfff;
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
        background: rgba(248, 244, 244, 0.85);
        border-radius: 16px;
        box-shadow: inset 4px 4px 8px rgba(200, 200, 200, 0.3);
        backdrop-filter: blur(10px);
    }

    .hero-stat-number {
        color: #e89a3c;
        font-size: 2rem;
        font-weight: 800;
        line-height: 1;
        text-shadow: 1px 1px 2px rgba(232, 154, 60, 0.2);
    }

    .hero-stat-label {
        color: #47494cff;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-top: 0.25rem;
    }

    /* Botón Crear Equipo */
    .btn-crear-equipo {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.25rem;
        background: linear-gradient(135deg, #e89a3c, #f5a847);
        color: white;
        border-radius: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 4px 4px 8px rgba(232, 154, 60, 0.3);
    }

    .btn-crear-equipo:hover {
        box-shadow: 6px 6px 12px rgba(232, 154, 60, 0.4);
        transform: translateY(-2px);
        color: white;
    }

    .btn-crear-equipo svg {
        width: 20px;
        height: 20px;
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

    /* Team Card Neuromórfica */
    .team-card {
        background: #FFEEE2;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        position: relative;
        border: none;
    }

    .team-card:hover {
        transform: translateY(-8px);
        box-shadow: 12px 12px 24px #e6d5c9, -12px -12px 24px #ffffff;
    }

    .team-card-leader {
        border: 2px solid #e89a3c;
    }

    .team-card-leader::before {
        content: '👑 Eres el Líder';
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: linear-gradient(135deg, #e89a3c, #f5a847);
        color: white;
        font-size: 0.7rem;
        font-weight: 700;
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
        z-index: 10;
        box-shadow: 4px 4px 8px rgba(232, 154, 60, 0.3);
    }

    /* Team Image */
    .team-image-container {
        position: relative;
        height: 140px;
        overflow: hidden;
    }

    .team-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .team-card:hover .team-image {
        transform: scale(1.08);
    }

    .team-image-placeholder {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #e89a3c 0%, #f5a847 50%, #e89a3c 100%);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .team-image-placeholder svg {
        width: 50px;
        height: 50px;
        color: rgba(255, 255, 255, 0.6);
    }

    .team-image-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 60%;
        background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);
        pointer-events: none;
    }

    .team-card-header {
        background: linear-gradient(135deg, #2c2c2c, #1a1a1a);
        padding: 1.25rem 1.5rem;
        position: relative;
    }

    .team-card-header::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #e89a3c, #f5a847, #e89a3c);
    }

    .team-name {
        color: #ffffff;
        font-size: 1.15rem;
        font-weight: 700;
        margin-bottom: 0.4rem;
        padding-right: 100px;
    }

    .team-event {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.8rem;
    }

    .team-event svg {
        width: 14px;
        height: 14px;
        color: #e89a3c;
    }

    .team-card-body {
        padding: 1.25rem 1.5rem;
        background: #FFEEE2;
    }

    /* Team Stats Row */
    .team-stats-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
        margin-bottom: 1.25rem;
    }

    .team-stat-item {
        text-align: center;
        padding: 0.75rem;
        background: rgba(255, 255, 255, 0.4);
        border-radius: 12px;
        box-shadow: inset 3px 3px 6px #e6d5c9, inset -3px -3px 6px #ffffff;
    }

    .team-stat-value {
        font-size: 1.25rem;
        font-weight: 800;
        color: #2c2c2c;
    }

    .team-stat-label {
        font-size: 0.7rem;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-top: 0.25rem;
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
        background: linear-gradient(135deg, #e89a3c, #f5a847);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 0.875rem;
        border: 3px solid #FFEEE2;
        margin-left: -10px;
        box-shadow: 4px 4px 8px #e6d5c9;
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
        background: linear-gradient(135deg, #2c2c2c, #1a1a1a);
        border-color: #e89a3c;
    }

    .member-avatar-more {
        background: rgba(255, 255, 255, 0.6);
        color: #6b7280;
        font-size: 0.75rem;
        box-shadow: inset 2px 2px 4px #e6d5c9, inset -2px -2px 4px #ffffff;
    }

    /* My Role Badge */
    .my-role-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(255, 255, 255, 0.4);
        color: #b37a2e;
        padding: 0.5rem 1rem;
        border-radius: 10px;
        font-size: 0.8rem;
        font-weight: 600;
        margin-bottom: 1.25rem;
        box-shadow: inset 3px 3px 6px #e6d5c9, inset -3px -3px 6px #ffffff;
    }

    .my-role-badge svg {
        width: 16px;
        height: 16px;
        color: #e89a3c;
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
        background: linear-gradient(135deg, #2c2c2c, #1a1a1a);
        color: #ffffff;
        box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.2);
    }

    .team-action-primary:hover {
        background: linear-gradient(135deg, #e89a3c, #f5a847);
        transform: translateY(-2px);
        box-shadow: 6px 6px 12px rgba(232, 154, 60, 0.3);
        color: #ffffff;
    }

    .team-action-secondary {
        background: rgba(255, 255, 255, 0.6);
        color: #4b5563;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
    }

    .team-action-secondary:hover {
        background: rgba(255, 255, 255, 0.8);
        color: #2c2c2c;
        box-shadow: 6px 6px 12px #e6d5c9, -6px -6px 12px #ffffff;
        transform: translateY(-2px);
    }

    /* Pending Requests Indicator */
    .pending-requests {
        position: absolute;
        top: 1rem;
        left: 1rem;
        background: linear-gradient(135deg, #fca5a5, #ef4444);
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
        box-shadow: 4px 4px 8px rgba(239, 68, 68, 0.3);
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.8; }
    }

    .pending-requests svg {
        width: 14px;
        height: 14px;
    }

    /* Event Status Badge - Paleta Pastel */
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
        background: linear-gradient(135deg, rgba(167, 243, 208, 0.8), rgba(134, 239, 172, 0.8));
        color: #065f46;
        box-shadow: inset 2px 2px 4px rgba(16, 185, 129, 0.2);
    }

    .status-activo {
        background: linear-gradient(135deg, rgba(191, 219, 254, 0.8), rgba(147, 197, 253, 0.8));
        color: #1e40af;
        box-shadow: inset 2px 2px 4px rgba(59, 130, 246, 0.2);
    }

    .status-pendiente,
    .status-próximo {
        background: linear-gradient(135deg, rgba(254, 240, 138, 0.8), rgba(252, 211, 77, 0.8));
        color: #92400e;
        box-shadow: inset 2px 2px 4px rgba(245, 158, 11, 0.2);
    }

    .status-finalizado {
        background: linear-gradient(135deg, rgba(229, 231, 235, 0.8), rgba(209, 213, 219, 0.8));
        color: #4b5563;
        box-shadow: inset 2px 2px 4px rgba(107, 114, 128, 0.2);
    }

    /* Empty State Neuromórfico */
    .empty-state {
        background: #FFEEE2;
        border-radius: 24px;
        padding: 4rem 2rem;
        text-align: center;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
        border: none;
    }

    .empty-state-icon {
        width: 100px;
        height: 100px;
        background: rgba(255, 255, 255, 0.5);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        box-shadow: inset 4px 4px 8px #e6d5c9, inset -4px -4px 8px #ffffff;
    }

    .empty-state-icon svg {
        width: 50px;
        height: 50px;
        color: #e89a3c;
    }

    .empty-state h3 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2c2c2c;
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

    .empty-state-btn svg {
        width: 20px;
        height: 20px;
    }

    .empty-state-btn-primary {
        background: linear-gradient(135deg, #e89a3c, #f5a847);
        color: #ffffff;
        box-shadow: 4px 4px 8px rgba(232, 154, 60, 0.3);
    }

    .empty-state-btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 6px 6px 12px rgba(232, 154, 60, 0.4);
        color: #ffffff;
    }

    .empty-state-btn-secondary {
        background: rgba(255, 255, 255, 0.6);
        color: #4b5563;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
    }

    .empty-state-btn-secondary:hover {
        background: rgba(255, 255, 255, 0.8);
        color: #2c2c2c;
        transform: translateY(-2px);
        box-shadow: 6px 6px 12px #e6d5c9, -6px -6px 12px #ffffff;
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
@endsection