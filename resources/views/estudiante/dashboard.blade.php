@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
    
    .student-dashboard {
        background: linear-gradient(135deg, #FFFDF4 0%, #FFF8F0 50%, #FFEEE2 100%);
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
    }
    
    .student-dashboard * {
        font-family: 'Poppins', sans-serif;
    }

    /* Hero Welcome Section */
    .welcome-hero {
        background: linear-gradient(135deg, #1a1a1a 0%, #2c2c2c 50%, #3d3d3d 100%);
        border-radius: 24px;
        padding: 2rem 2.5rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    .welcome-hero::before {
        content: '';
        position: absolute;
        top: -100px;
        right: -100px;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(232, 154, 60, 0.2) 0%, transparent 70%);
        pointer-events: none;
    }

    .welcome-hero::after {
        content: '';
        position: absolute;
        bottom: -50px;
        left: -50px;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(232, 154, 60, 0.1) 0%, transparent 70%);
        pointer-events: none;
    }

    .welcome-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
        z-index: 1;
    }

    .welcome-text h1 {
        color: #ffffff;
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .welcome-text h1 span {
        color: #e89a3c;
    }

    .welcome-text p {
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.95rem;
    }

    .welcome-stats {
        display: flex;
        gap: 1.5rem;
    }

    .welcome-stat {
        text-align: center;
        padding: 0.75rem 1.5rem;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 16px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
    }

    .welcome-stat-number {
        color: #e89a3c;
        font-size: 1.75rem;
        font-weight: 800;
        line-height: 1;
    }

    .welcome-stat-label {
        color: rgba(255, 255, 255, 0.6);
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-top: 0.25rem;
    }

    /* Main Grid Layout */
    .dashboard-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
    }

    @media (max-width: 1024px) {
        .dashboard-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Section Titles */
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.25rem;
    }

    .section-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: #1a1a1a;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .section-title-icon {
        width: 28px;
        height: 28px;
        background: linear-gradient(135deg, #e89a3c, #f5b76c);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .section-title-icon svg {
        width: 16px;
        height: 16px;
        color: white;
    }

    .section-link {
        color: #e89a3c;
        font-size: 0.875rem;
        font-weight: 500;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.25rem;
        transition: all 0.2s ease;
    }

    .section-link:hover {
        color: #d98a2c;
        transform: translateX(3px);
    }

    .section-link svg {
        width: 16px;
        height: 16px;
    }

    /* Event Cards */
    .event-card {
        background: #ffffff;
        border-radius: 20px;
        overflow: hidden;
        margin-bottom: 1.25rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        border: 1px solid rgba(0, 0, 0, 0.04);
        transition: all 0.3s ease;
    }

    .event-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.1);
    }

    .event-card-active {
        border: 2px solid #e89a3c;
    }

    .event-card-header {
        background: linear-gradient(135deg, #1a1a1a, #2c2c2c);
        padding: 1.25rem 1.5rem;
        position: relative;
    }

    .event-card-active .event-card-header {
        background: linear-gradient(135deg, #e89a3c, #f5b76c);
    }

    .event-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: rgba(255, 255, 255, 0.2);
        color: white;
        font-size: 0.7rem;
        font-weight: 600;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .event-card-active .event-badge {
        background: rgba(0, 0, 0, 0.2);
    }

    .event-title {
        color: #ffffff;
        font-size: 1.125rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
        padding-right: 80px;
    }

    .event-card-body {
        padding: 1.5rem;
    }

    .event-desc {
        color: #6b7280;
        font-size: 0.875rem;
        line-height: 1.6;
        margin-bottom: 1rem;
    }

    .event-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1.25rem;
    }

    .event-meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.8rem;
        color: #6b7280;
    }

    .event-meta-item svg {
        width: 16px;
        height: 16px;
        color: #e89a3c;
    }

    .event-action-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: linear-gradient(135deg, #1a1a1a, #2c2c2c);
        color: #ffffff;
        padding: 0.75rem 1.25rem;
        border-radius: 12px;
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .event-action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
        color: #ffffff;
    }

    .event-action-btn svg {
        width: 16px;
        height: 16px;
    }

    /* Progress Section */
    .progress-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 1.75rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        border: 1px solid rgba(0, 0, 0, 0.04);
        margin-bottom: 1.5rem;
    }

    .progress-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1.5rem;
    }

    .progress-info {
        flex: 1;
    }

    .progress-team-name {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 0.5rem;
    }

    .progress-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .progress-tag {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        background: linear-gradient(135deg, rgba(232, 154, 60, 0.1), rgba(232, 154, 60, 0.05));
        color: #b37a2e;
        padding: 0.375rem 0.75rem;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .progress-tag svg {
        width: 12px;
        height: 12px;
    }

    .progress-circle {
        position: relative;
        width: 100px;
        height: 100px;
    }

    .progress-circle-bg {
        fill: none;
        stroke: #f3f4f6;
        stroke-width: 8;
    }

    .progress-circle-fill {
        fill: none;
        stroke: url(#progressGradient);
        stroke-width: 8;
        stroke-linecap: round;
        stroke-dasharray: 251.2;
        stroke-dashoffset: 251.2;
        transform: rotate(-90deg);
        transform-origin: center;
        transition: stroke-dashoffset 1s ease;
    }

    .progress-circle-text {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
    }

    .progress-percentage {
        font-size: 1.5rem;
        font-weight: 800;
        color: #e89a3c;
        line-height: 1;
    }

    .progress-label {
        font-size: 0.65rem;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .progress-details {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
        padding-top: 1.5rem;
        border-top: 1px solid #f3f4f6;
    }

    .progress-detail-item {
        text-align: center;
    }

    .progress-detail-value {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1a1a1a;
    }

    .progress-detail-label {
        font-size: 0.7rem;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .progress-link {
        display: flex;
        justify-content: center;
        margin-top: 1.25rem;
    }

    .progress-link a {
        color: #e89a3c;
        font-size: 0.875rem;
        font-weight: 500;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.25rem;
        transition: all 0.2s ease;
    }

    .progress-link a:hover {
        color: #d98a2c;
    }

    /* Quick Actions Grid */
    .quick-actions {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }

    .quick-action-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 1.25rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        text-decoration: none;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
        border: 1px solid rgba(0, 0, 0, 0.04);
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .quick-action-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
        border-color: #e89a3c;
    }

    .quick-action-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .quick-action-icon svg {
        width: 24px;
        height: 24px;
        color: white;
    }

    .icon-events {
        background: linear-gradient(135deg, #e89a3c, #f5b76c);
    }

    .icon-project {
        background: linear-gradient(135deg, #1a1a1a, #3d3d3d);
    }

    .icon-certificates {
        background: linear-gradient(135deg, #059669, #34d399);
    }

    .icon-team {
        background: linear-gradient(135deg, #7c3aed, #a78bfa);
    }

    .quick-action-content h4 {
        font-size: 0.9rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 0.125rem;
    }

    .quick-action-content p {
        font-size: 0.75rem;
        color: #9ca3af;
    }

    .quick-action-disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    .quick-action-disabled:hover {
        transform: none;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
        border-color: rgba(0, 0, 0, 0.04);
    }

    /* Empty State */
    .empty-state {
        background: #ffffff;
        border-radius: 20px;
        padding: 2.5rem;
        text-align: center;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        border: 1px solid rgba(0, 0, 0, 0.04);
    }

    .empty-state-icon {
        width: 64px;
        height: 64px;
        background: linear-gradient(135deg, rgba(232, 154, 60, 0.1), rgba(232, 154, 60, 0.05));
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
    }

    .empty-state-icon svg {
        width: 32px;
        height: 32px;
        color: #e89a3c;
    }

    .empty-state h3 {
        font-size: 1.125rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: #6b7280;
        font-size: 0.875rem;
        margin-bottom: 1.5rem;
    }

    .empty-state-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: linear-gradient(135deg, #e89a3c, #f5b76c);
        color: #ffffff;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-size: 0.875rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .empty-state-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(232, 154, 60, 0.3);
        color: #ffffff;
    }

    /* No Progress State */
    .no-progress-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }

    .no-progress-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
    }

    .no-progress-icon svg {
        width: 40px;
        height: 40px;
        color: #9ca3af;
    }

    .no-progress-text {
        text-align: center;
    }

    .no-progress-text h4 {
        font-size: 1rem;
        font-weight: 600;
        color: #4b5563;
        margin-bottom: 0.25rem;
    }

    .no-progress-text p {
        font-size: 0.875rem;
        color: #9ca3af;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .welcome-content {
            flex-direction: column;
            text-align: center;
            gap: 1.5rem;
        }

        .welcome-stats {
            justify-content: center;
        }

        .quick-actions {
            grid-template-columns: 1fr;
        }

        .progress-header {
            flex-direction: column;
            align-items: center;
            text-align: center;
            gap: 1.5rem;
        }

        .progress-details {
            grid-template-columns: 1fr;
            gap: 0.75rem;
        }
    }

        /* Carousel Styles */
        .carousel-container {
            position: relative;
            width: 100%;
            overflow: hidden;
            border-radius: 12px;
            background: #FFEEE2;
            box-shadow: 8px 8px 16px rgba(230, 213, 201, 0.5);
        }

        .carousel-track-container {
            overflow: hidden;
            border-radius: 12px;
            width: 100%;
        }

        .carousel-track {
            display: flex;
            transition: transform 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            width: 100%;
        }

        .carousel-slide {
            min-width: 100%;
            width: 100%;
            flex-shrink: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .carousel-nav {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            margin-top: 1rem;
        }

        .carousel-arrow {
            position: relative;
            width: 28px;
            height: 28px;
            background: rgba(255, 255, 255, 0.8);
            border: none;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2c2c2c;
            transition: all 0.3s ease;
            box-shadow: 4px 4px 8px rgba(230, 213, 201, 0.5);
        }

        .carousel-arrow:hover {
            color: #e89a3c;
            box-shadow: 6px 6px 12px rgba(230, 213, 201, 0.3);
            transform: translateY(-2px);
        }

        .carousel-dots {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
        }

        .carousel-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: rgba(232, 154, 60, 0.3);
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
        }

        .carousel-dot.active {
            background: #e89a3c;
            width: 16px;
            border-radius: 3px;
        }

        .carousel-progress {
            height: 4px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 4px;
            margin-top: 0.75rem;
            overflow: hidden;
        }

        .carousel-progress-bar {
            height: 100%;
            background: #e89a3c;
            border-radius: 4px;
            transition: width 0.1s linear;
            width: 0%;
        }

        .team-card {
            background: #FFEEE2;
            border-radius: 12px;
            padding: 1rem;
            box-shadow: 4px 4px 8px rgba(230, 213, 201, 0.5);
            transition: transform 0.3s ease;
        }

        .team-card:hover {
            transform: translateY(-2px);
            box-shadow: 6px 6px 12px rgba(230, 213, 201, 0.3);
        }

        .team-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 0.75rem;
        }

        .team-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #2c2c2c, #1a1a1a);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .team-members {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 0.75rem;
        }

        .member-avatar {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, #e89a3c, #f5a847);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .member-avatar.more {
            background: linear-gradient(135deg, #6b7280, #4b5563);
        }

        .team-status {
            display: flex;
            align-items: center;
            padding: 0.5rem;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .team-status.incompleto {
            background: rgba(34, 197, 94, 0.1);
            color: #16a34a;
        }

        .team-status.completo {
            background: rgba(107, 114, 128, 0.1);
            color: #6b7280;
        }
</style>

<div class="student-dashboard py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <!-- Welcome Hero Section -->
        <div class="welcome-hero">
            <div class="welcome-content">
                <div class="welcome-text">
                    <h1>¡Hola, <span>{{ Auth::user()->name }}</span>!</h1>
                    <p>Bienvenido a tu panel de control. Aquí puedes ver tus eventos, proyectos y progreso.</p>
                </div>
                <div class="welcome-stats">
                    <div class="welcome-stat">
                        <div class="welcome-stat-number">{{ $miInscripcion ? 1 : 0 }}</div>
                        <div class="welcome-stat-label">Evento Activo</div>
                    </div>
                    <div class="welcome-stat">
                        <div class="welcome-stat-number">{{ $eventosDisponibles->count() }}</div>
                        <div class="welcome-stat-label">Disponibles</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Equipos Disponibles Carousel -->
        <div class="section-header">
            <h3 class="section-title">
                <span class="section-title-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </span>
                Equipos Disponibles
            </h3>
            <a href="{{ route('estudiante.eventos.index') }}" class="section-link">
                Ver todos
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        @php
            $equiposDisponibles = \App\Models\InscripcionEvento::whereHas('evento', function($q) {
                $q->where('estado', 'Próximo')
                  ->orWhere('estado', 'Activo');
            })
            ->where('status_registro', 'Incompleto')
            ->with(['equipo', 'evento', 'miembros.rol'])
            ->take(6)
            ->get();
        @endphp

        @if($equiposDisponibles->count() > 0)
            <div style="margin-bottom: 2rem;">
                <div class="carousel-container animate-in delay-3" id="equiposCarousel">
                    <div class="carousel-track-container">
                        <div class="carousel-track" id="equiposTrack">
                            @foreach ($equiposDisponibles as $inscripcion)
                                <div class="carousel-slide">
                                    <a href="{{ route('estudiante.equipos.show', $inscripcion->equipo) }}" class="team-card" style="text-decoration: none; color: inherit; display: block;">
                                        <div class="team-header">
                                            <div class="team-avatar">
                                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #fff;">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                </svg>
                                            </div>
                                            <div class="team-info">
                                                <h4 style="color: #2c2c2c; margin: 0; font-size: 0.95rem;">{{ $inscripcion->equipo->nombre }}</h4>
                                                <p style="color: #9ca3af; margin: 0; font-size: 0.8rem;">{{ $inscripcion->evento->nombre }}</p>
                                            </div>
                                        </div>

                                        <div class="team-members">
                                            @foreach($inscripcion->miembros->take(4) as $miembro)
                                                <div class="member-avatar" title="{{ $miembro->estudiante->user->nombre ?? 'Miembro' }}">
                                                    {{ strtoupper(substr($miembro->estudiante->user->nombre ?? 'M', 0, 1)) }}
                                                </div>
                                            @endforeach
                                            @if($inscripcion->miembros->count() > 4)
                                                <div class="member-avatar more">
                                                    +{{ $inscripcion->miembros->count() - 4 }}
                                                </div>
                                            @endif
                                        </div>

                                        <div class="team-status {{ $inscripcion->miembros->count() >= 5 ? 'completo' : 'incompleto' }}">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 14px; height: 14px; margin-right: 0.25rem;">
                                                @if($inscripcion->miembros->count() >= 5)
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                @else
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                                @endif
                                            </svg>
                                            {{ $inscripcion->miembros->count() >= 5 ? 'Equipo Completo' : (5 - $inscripcion->miembros->count()) . ' espacio' . ((5 - $inscripcion->miembros->count()) != 1 ? 's' : '') . ' disponible' }}
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="carousel-nav">
                        <button class="carousel-arrow prev" onclick="equiposCarousel.prev()">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 14px; height: 14px;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </button>
                        <div class="carousel-dots" id="equiposDots"></div>
                        <button class="carousel-arrow next" onclick="equiposCarousel.next()">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 14px; height: 14px;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </div>
                    <div class="carousel-progress">
                        <div class="carousel-progress-bar" id="equiposProgress"></div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Main Grid -->
        <div class="dashboard-grid">
            
            <!-- Left Column - Events -->
            <div class="left-column">
                
                <!-- Active Event -->
                @if ($miInscripcion)
                <div class="section-header">
                    <h3 class="section-title">
                        <span class="section-title-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </span>
                        Evento Activo
                    </h3>
                </div>
                
                <div class="event-card event-card-active">
                    <div class="event-card-header">
                        <span class="event-badge">Participando</span>
                        <h4 class="event-title">{{ $miInscripcion->evento->nombre }}</h4>
                    </div>
                    <div class="event-card-body">
                        <p class="event-desc">{{ Str::limit($miInscripcion->evento->descripcion ?? 'Sin descripción disponible', 120) }}</p>
                        <div class="event-meta">
                            <div class="event-meta-item">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ $miInscripcion->evento->fecha_inicio->format('d M, Y') }}
                            </div>
                            <div class="event-meta-item">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ $miInscripcion->evento->inscripciones->count() }} equipos
                            </div>
                        </div>
                        <a href="{{ route('estudiante.eventos.show', $miInscripcion->evento) }}" class="event-action-btn">
                            Ver detalles
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                </div>
                @endif

                <!-- Available Events -->
                <div class="section-header">
                    <h3 class="section-title">
                        <span class="section-title-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </span>
                        Eventos Disponibles
                    </h3>
                    <a href="{{ route('estudiante.eventos.index') }}" class="section-link">
                        Ver todos
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>

                @forelse ($eventosDisponibles->take(2) as $evento)
                <div class="event-card">
                    <div class="event-card-header">
                        <span class="event-badge">{{ $evento->estado }}</span>
                        <h4 class="event-title">{{ $evento->nombre }}</h4>
                    </div>
                    <div class="event-card-body">
                        <p class="event-desc">{{ Str::limit($evento->descripcion ?? 'Sin descripción', 100) }}</p>
                        <div class="event-meta">
                            <div class="event-meta-item">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Inicia: {{ $evento->fecha_inicio->format('d M, Y') }}
                            </div>
                            <div class="event-meta-item">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ $evento->inscripciones->count() }} participantes
                            </div>
                        </div>
                        <a href="{{ route('estudiante.eventos.show', $evento) }}" class="event-action-btn">
                            Ver detalles
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                </div>
                @empty
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3>Sin eventos disponibles</h3>
                    <p>No hay eventos disponibles en este momento. Vuelve pronto para ver nuevas oportunidades.</p>
                    <a href="{{ route('estudiante.eventos.index') }}" class="empty-state-btn">
                        Explorar eventos
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
                @endforelse
            </div>

            <!-- Right Column - Progress & Actions -->
            <div class="right-column">
                
                <!-- Progress Section -->
                <div class="section-header">
                    <h3 class="section-title">
                        <span class="section-title-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </span>
                        Progreso del Proyecto
                    </h3>
                </div>

                <div class="progress-card">
                    @if($miInscripcion && $miInscripcion->equipo)
                        @php
                            $equipo = $miInscripcion->equipo;
                            $miembro = $equipo->miembros->where('id_estudiante', Auth::user()->estudiante->id_estudiante)->first();
                            $progreso = 0; // Aquí puedes calcular el progreso real
                        @endphp
                        
                        <div class="progress-header">
                            <div class="progress-info">
                                <h4 class="progress-team-name">{{ $equipo->nombre }}</h4>
                                <div class="progress-tags">
                                    <span class="progress-tag">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                        </svg>
                                        {{ $miInscripcion->evento->nombre }}
                                    </span>
                                    <span class="progress-tag">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        {{ $miembro->rol->nombre ?? 'Miembro' }}
                                    </span>
                                </div>
                            </div>
                            <div class="progress-circle">
                                <svg width="100" height="100" viewBox="0 0 100 100">
                                    <defs>
                                        <linearGradient id="progressGradient" x1="0%" y1="0%" x2="100%" y2="0%">
                                            <stop offset="0%" style="stop-color:#e89a3c"/>
                                            <stop offset="100%" style="stop-color:#f5b76c"/>
                                        </linearGradient>
                                    </defs>
                                    <circle class="progress-circle-bg" cx="50" cy="50" r="40"/>
                                    <circle class="progress-circle-fill" cx="50" cy="50" r="40" style="stroke-dashoffset: {{ 251.2 - (251.2 * $progreso / 100) }}"/>
                                </svg>
                                <div class="progress-circle-text">
                                    <span class="progress-percentage">{{ $progreso }}%</span>
                                    <span class="progress-label">Avance</span>
                                </div>
                            </div>
                        </div>

                        <div class="progress-details">
                            <div class="progress-detail-item">
                                <div class="progress-detail-value">{{ $equipo->miembros->count() }}</div>
                                <div class="progress-detail-label">Miembros</div>
                            </div>
                            <div class="progress-detail-item">
                                <div class="progress-detail-value">0</div>
                                <div class="progress-detail-label">Tareas</div>
                            </div>
                            <div class="progress-detail-item">
                                <div class="progress-detail-value">0</div>
                                <div class="progress-detail-label">Avances</div>
                            </div>
                        </div>

                        <div class="progress-link">
                            <a href="{{ route('estudiante.equipo.index') }}">
                                Ver detalles del equipo
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </a>
                        </div>
                    @else
                        <div class="no-progress-state">
                            <div class="no-progress-icon">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div class="no-progress-text">
                                <h4>Sin equipo asignado</h4>
                                <p>Únete a un equipo para comenzar tu proyecto</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Quick Actions -->
                <div class="section-header">
                    <h3 class="section-title">
                        <span class="section-title-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </span>
                        Acciones Rápidas
                    </h3>
                </div>

                <div class="quick-actions">
                    <a href="{{ route('estudiante.eventos.index') }}" class="quick-action-card">
                        <div class="quick-action-icon icon-events">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="quick-action-content">
                            <h4>Eventos</h4>
                            <p>Explora eventos activos</p>
                        </div>
                    </a>

                    @if($miInscripcion && $miInscripcion->evento->estado === 'En Progreso')
                        @php
                            $evento = $miInscripcion->evento;
                            $proyectoEvento = $evento->tipo_proyecto === 'general' 
                                ? $evento->proyectoGeneral 
                                : $miInscripcion->proyectoEvento;
                        @endphp
                        
                        @if($proyectoEvento && $proyectoEvento->publicado)
                            <a href="{{ route('estudiante.proyecto-evento.show') }}" class="quick-action-card">
                                <div class="quick-action-icon icon-project">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <div class="quick-action-content">
                                    <h4>Proyecto del Evento</h4>
                                    <p>{{ Str::limit($proyectoEvento->titulo, 20) }}</p>
                                </div>
                            </a>
                        @else
                            <div class="quick-action-card quick-action-disabled">
                                <div class="quick-action-icon icon-project">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <div class="quick-action-content">
                                    <h4>Proyecto del Evento</h4>
                                    <p>Esperando publicación...</p>
                                </div>
                            </div>
                        @endif
                    @else
                        <a href="{{ route('estudiante.constancias.index') }}" class="quick-action-card">
                            <div class="quick-action-icon icon-certificates">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                </svg>
                            </div>
                            <div class="quick-action-content">
                                <h4>Constancias</h4>
                                <p>Genera tus constancias</p>
                            </div>
                        </a>
                    @endif

                    @if($miInscripcion && $miInscripcion->proyecto)
                        <a href="#" class="quick-action-card">
                            <div class="quick-action-icon icon-project">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div class="quick-action-content">
                                <h4>Mi Proyecto</h4>
                                <p>Ver mi proyecto actual</p>
                            </div>
                        </a>
                    @else
                        <div class="quick-action-card quick-action-disabled">
                            <div class="quick-action-icon icon-project">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div class="quick-action-content">
                                <h4>Mi Proyecto</h4>
                                <p>Sin proyectos activos</p>
                            </div>
                        </div>
                    @endif

                    <a href="{{ route('estudiante.equipo.index') }}" class="quick-action-card">
                        <div class="quick-action-icon icon-team">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div class="quick-action-content">
                            <h4>Mi Equipo</h4>
                            <p>Gestiona tu equipo</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Carousel functionality for equipos
class Carousel {
    constructor(trackId, dotsId, progressBarId) {
        this.track = document.getElementById(trackId);
        this.dotsContainer = document.getElementById(dotsId);
        this.progressBar = document.getElementById(progressBarId);
        this.currentIndex = 0;
        this.slides = this.track.querySelectorAll('.carousel-slide');
        this.totalSlides = this.slides.length;

        this.init();
    }

    init() {
        if (this.totalSlides <= 1) return;

        // Create dots
        this.createDots();

        // Set initial state
        this.updateCarousel();

        // Auto-play
        this.startAutoPlay();

        // Pause on hover
        this.track.addEventListener('mouseenter', () => this.stopAutoPlay());
        this.track.addEventListener('mouseleave', () => this.startAutoPlay());
    }

    createDots() {
        for (let i = 0; i < this.totalSlides; i++) {
            const dot = document.createElement('button');
            dot.className = 'carousel-dot';
            dot.setAttribute('aria-label', `Go to slide ${i + 1}`);
            dot.onclick = () => this.goToSlide(i);
            this.dotsContainer.appendChild(dot);
        }
    }

    goToSlide(index) {
        this.currentIndex = index;
        this.updateCarousel();
    }

    next() {
        this.currentIndex = (this.currentIndex + 1) % this.totalSlides;
        this.updateCarousel();
    }

    prev() {
        this.currentIndex = (this.currentIndex - 1 + this.totalSlides) % this.totalSlides;
        this.updateCarousel();
    }

    updateCarousel() {
        // Update position
        this.track.style.transform = `translateX(-${this.currentIndex * 100}%)`;

        // Update dots
        const dots = this.dotsContainer.querySelectorAll('.carousel-dot');
        dots.forEach((dot, index) => {
            dot.classList.toggle('active', index === this.currentIndex);
        });

        // Update progress bar
        const progress = ((this.currentIndex + 1) / this.totalSlides) * 100;
        this.progressBar.style.width = `${progress}%`;
    }

    startAutoPlay() {
        this.stopAutoPlay();
        this.autoPlayInterval = setInterval(() => this.next(), 5000);
    }

    stopAutoPlay() {
        if (this.autoPlayInterval) {
            clearInterval(this.autoPlayInterval);
        }
    }
}

// Initialize carousels
document.addEventListener('DOMContentLoaded', function() {
    const equiposCarousel = new Carousel('equiposTrack', 'equiposDots', 'equiposProgress');
});
</script>
@endsection
