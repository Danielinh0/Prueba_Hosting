@extends('layouts.prueba')

@section('title', 'Inicio')

@section('content')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
        
        /* =============================================== */
        /* PALETA DE COLORES: Naranja, Blanco y Negro */
        /* =============================================== */
        :root {
            --color-primary: #E67E22;      /* Naranja principal */
            --color-primary-light: #F39C12; /* Naranja claro */
            --color-primary-muted: #FAD7A0; /* Naranja muy suave */
            --color-white: #FFFFFF;
            --color-off-white: #FAFAFA;
            --color-light-gray: #F5F5F5;
            --color-gray: #E0E0E0;
            --color-dark-gray: #666666;
            --color-charcoal: #333333;
            --color-black: #1A1A1A;
        }
        
        /* Fondo limpio */
        body {
            background: var(--color-off-white);
            min-height: 100vh;
        }
        
        /* Configuración global */
        .left-col,
        .right-col {
            font-family: 'Poppins', sans-serif;
        }
        
        /* Títulos de sección */
        .section-title {
            font-family: 'Poppins', sans-serif;
            color: var(--color-black);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
        }

        .section-title i {
            color: var(--color-primary);
        }
        
        /* =============================================== */
        /* CARRUSEL STYLES - VANILLA CSS */
        /* =============================================== */
        .carousel-container {
            position: relative;
            width: 100%;
            overflow: visible;
            border-radius: 16px;
            margin-bottom: 2rem;
        }

        .carousel-track-container {
            overflow: hidden;
            border-radius: 16px;
        }

        .carousel-track {
            display: flex;
            transition: transform 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        .carousel-slide {
            min-width: 100%;
            flex-shrink: 0;
            padding: 0 0.25rem;
            box-sizing: border-box;
        }

        /* Carousel Navigation - DEBAJO del contenido */
        .carousel-nav {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            margin-top: 1rem;
        }

        .carousel-arrow {
            position: relative;
            top: auto;
            left: auto;
            right: auto;
            transform: none;
            width: 40px;
            height: 40px;
            background: var(--color-white);
            border: 2px solid var(--color-gray);
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            color: var(--color-charcoal);
            transition: all 0.3s ease;
        }

        .carousel-arrow:hover {
            background: var(--color-primary);
            border-color: var(--color-primary);
            color: var(--color-white);
            transform: scale(1.05);
        }

        .carousel-arrow:active {
            transform: scale(0.95);
        }

        /* Carousel Dots/Indicators */
        .carousel-dots {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
        }

        .carousel-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--color-gray);
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
        }

        .carousel-dot:hover {
            background: var(--color-primary-muted);
        }

        .carousel-dot.active {
            background: var(--color-primary);
            width: 24px;
            border-radius: 5px;
        }

        /* Progress Bar del carrusel */
        .carousel-progress {
            height: 3px;
            background: var(--color-gray);
            border-radius: 2px;
            margin-top: 0.5rem;
            overflow: hidden;
        }

        .carousel-progress-bar {
            height: 100%;
            background: var(--color-primary);
            border-radius: 2px;
            transition: width 0.1s linear;
            width: 0%;
        }

        /* =============================================== */
        /* Cards - Estilo limpio */
        /* =============================================== */
        .neu-card {
            background: var(--color-white);
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border: 1px solid var(--color-gray);
        }
        
        .neu-card:hover {
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            transform: translateY(-2px);
        }
        
        /* Event cards */
        .event-card-header {
            font-family: 'Poppins', sans-serif;
            background: var(--color-black);
            color: var(--color-white);
            position: relative;
            overflow: hidden;
            border-radius: 16px 16px 0 0;
            padding: 1.25rem;
        }

        .event-card-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--color-primary);
        }

        .event-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            background: var(--color-primary);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
            color: var(--color-white);
            z-index: 5;
        }
        
        .event-card-body {
            background: var(--color-white);
            padding: 1.25rem;
            border-radius: 0 0 16px 16px;
        }

        /* =============================================== */
        /* Event cards con imagen */
        /* =============================================== */
        .event-card-with-image {
            overflow: hidden;
        }

        .event-image {
            position: relative;
            width: 100%;
            height: 140px;
            overflow: hidden;
        }

        .event-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .event-card-with-image:hover .event-image img {
            transform: scale(1.05);
        }

        .event-image-placeholder {
            background: linear-gradient(135deg, var(--color-charcoal), var(--color-black));
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .event-image-placeholder i {
            font-size: 3rem;
            color: var(--color-dark-gray);
            opacity: 0.5;
        }

        .event-card-content {
            padding: 1rem;
        }

        .event-title {
            font-family: 'Poppins', sans-serif;
            font-size: 1rem;
            font-weight: 600;
            color: var(--color-black);
            margin: 0 0 0.5rem 0;
        }
        
        .event-desc {
            font-family: 'Poppins', sans-serif;
            color: var(--color-dark-gray);
            font-size: 0.85rem;
            line-height: 1.4;
            margin: 0 0 0.75rem 0;
        }

        .event-meta {
            display: flex;
            gap: 1rem;
            margin-bottom: 0.75rem;
        }
        
        .event-date,
        .event-participants {
            font-family: 'Poppins', sans-serif;
            color: var(--color-charcoal);
            display: flex;
            align-items: center;
            gap: 0.35rem;
            font-size: 0.75rem;
            margin: 0;
        }

        .event-date i,
        .event-participants i {
            color: var(--color-primary);
            width: 14px;
            font-size: 0.7rem;
        }
        
        .event-card-body a {
            font-family: 'Poppins', sans-serif;
            color: var(--color-primary);
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 500;
            text-decoration: none;
        }
        
        .event-card-body a:hover {
            color: var(--color-black);
            gap: 0.75rem;
        }

        .event-link {
            font-family: 'Poppins', sans-serif;
            color: var(--color-primary);
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            font-weight: 500;
            text-decoration: none;
            font-size: 0.8rem;
        }
        
        .event-link:hover {
            color: var(--color-black);
            gap: 0.5rem;
        }

        /* =============================================== */
        /* EQUIPOS CAROUSEL CARD */
        /* =============================================== */
        .team-card {
            background: var(--color-white);
            border-radius: 16px;
            padding: 1.5rem;
            border: 1px solid var(--color-gray);
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        }

        .team-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .team-avatar {
            width: 48px;
            height: 48px;
            background: var(--color-black);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--color-white);
            font-size: 1.25rem;
        }

        .team-info h4 {
            font-weight: 600;
            color: var(--color-black);
            margin: 0;
            font-size: 1rem;
        }

        .team-info p {
            font-size: 0.8rem;
            color: var(--color-dark-gray);
            margin: 0;
        }

        .team-members {
            display: flex;
            align-items: center;
            margin-top: 1rem;
        }

        .member-avatar {
            width: 32px;
            height: 32px;
            background: var(--color-charcoal);
            border-radius: 50%;
            border: 2px solid var(--color-white);
            margin-left: -8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--color-white);
            font-size: 0.7rem;
            font-weight: 600;
        }

        .member-avatar:first-child {
            margin-left: 0;
        }

        .member-avatar.more {
            background: var(--color-primary);
            font-size: 0.65rem;
        }

        .team-status {
            margin-top: 1rem;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 500;
            text-align: center;
        }

        .team-status.completo {
            background: var(--color-light-gray);
            color: var(--color-charcoal);
            border: 1px solid var(--color-gray);
        }

        .team-status.incompleto {
            background: var(--color-primary-muted);
            color: var(--color-primary);
            border: 1px solid var(--color-primary);
        }

        /* =============================================== */
        /* GRÁFICAS DE PROGRESO */
        /* =============================================== */
        .progress-charts-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .progress-chart-card {
            background: var(--color-white);
            border-radius: 16px;
            padding: 1.25rem;
            text-align: center;
            border: 1px solid var(--color-gray);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            transition: all 0.3s ease;
        }

        .progress-chart-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        }

        .circular-progress {
            position: relative;
            width: 90px;
            height: 90px;
            margin: 0 auto 0.75rem;
        }

        .circular-progress svg {
            transform: rotate(-90deg);
            width: 90px;
            height: 90px;
        }

        .circular-progress .bg {
            fill: none;
            stroke: var(--color-light-gray);
            stroke-width: 6;
        }

        .circular-progress .progress {
            fill: none;
            stroke-width: 6;
            stroke-linecap: round;
            stroke-dasharray: 251;
            stroke-dashoffset: 251;
            transition: stroke-dashoffset 1.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .circular-progress .progress.orange {
            stroke: var(--color-primary);
        }

        .circular-progress .progress.green {
            stroke: #2D3436;
        }

        .circular-progress .progress.purple {
            stroke: var(--color-charcoal);
        }

        .circular-progress .progress.blue {
            stroke: var(--color-black);
        }

        .circular-progress .percentage {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--color-black);
        }

        .progress-chart-card h5 {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--color-black);
            margin: 0;
        }

        .progress-chart-card p {
            font-size: 0.75rem;
            color: var(--color-dark-gray);
            margin: 0.25rem 0 0;
        }

        /* =============================================== */
        /* Progress card principal */
        /* =============================================== */
        .info-item {
            font-family: 'Poppins', sans-serif;
            background: var(--color-light-gray);
            color: var(--color-black);
            padding: 0.75rem 1rem;
            border-radius: 8px;
            border: 1px solid var(--color-gray);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .info-item i {
            color: var(--color-primary);
        }
        
        .progress-ring {
            background: conic-gradient(var(--color-primary) 0%, var(--color-primary) 50%, var(--color-light-gray) 50%, var(--color-light-gray) 100%);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .progress-ring::before {
            background: var(--color-white);
        }
        
        .progress-text span {
            font-family: 'Poppins', sans-serif;
            color: var(--color-dark-gray);
        }
        
        .progress-text strong {
            font-family: 'Poppins', sans-serif;
            color: var(--color-primary);
        }
        
        .progress-main-card a {
            font-family: 'Poppins', sans-serif;
            color: var(--color-primary);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .progress-main-card a:hover {
            color: var(--color-black);
        }
        
        /* Small cards */
        .small-card {
            background: var(--color-white);
            border: 1px solid var(--color-gray);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            transition: all 0.3s ease;
            border-radius: 12px;
        }
        
        .small-card:hover {
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            transform: translateY(-4px);
            border-color: var(--color-primary-muted);
        }
        
        .card-icon-box {
            box-shadow: none;
        }
        
        .icon-athena {
            background: var(--color-black);
        }

        .icon-projects {
            background: var(--color-charcoal);
        }
        
        .icon-const {
            background: var(--color-primary);
        }

        .icon-teams {
            background: var(--color-dark-gray);
        }
        
        .card-content-box h4 {
            font-family: 'Poppins', sans-serif;
            color: var(--color-black);
        }
        
        .card-content-box p {
            font-family: 'Poppins', sans-serif;
            color: var(--color-dark-gray);
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 2rem;
            color: var(--color-dark-gray);
        }

        .empty-state i {
            font-size: 3rem;
            color: var(--color-primary);
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        /* Animación de entrada */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-in {
            animation: fadeInUp 0.6s ease forwards;
        }

        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }
        .delay-4 { animation-delay: 0.4s; }
    </style>

    <!-- SVG Gradients for Charts -->
    <svg style="position: absolute; width: 0; height: 0;">
        <defs>
            <linearGradient id="gradientOrange" x1="0%" y1="0%" x2="100%" y2="0%">
                <stop offset="0%" stop-color="#e89a3c"/>
                <stop offset="100%" stop-color="#f5a847"/>
            </linearGradient>
            <linearGradient id="gradientGreen" x1="0%" y1="0%" x2="100%" y2="0%">
                <stop offset="0%" stop-color="#10b981"/>
                <stop offset="100%" stop-color="#059669"/>
            </linearGradient>
            <linearGradient id="gradientPurple" x1="0%" y1="0%" x2="100%" y2="0%">
                <stop offset="0%" stop-color="#8b5cf6"/>
                <stop offset="100%" stop-color="#6366f1"/>
            </linearGradient>
            <linearGradient id="gradientBlue" x1="0%" y1="0%" x2="100%" y2="0%">
                <stop offset="0%" stop-color="#3b82f6"/>
                <stop offset="100%" stop-color="#1d4ed8"/>
            </linearGradient>
        </defs>
    </svg>

    <section class="left-col">
        <h3 class="section-title animate-in">
            <i class="fas fa-calendar-check"></i>
            Evento Actual
        </h3>
        
        @if ($miInscripcion)
            {{-- Evento Activo --}}
            <div class="event-card-container neu-card animate-in delay-1">
                <div class="event-card-header">
                    <span class="event-badge">
                        <i class="fas fa-star"></i> Activo
                    </span>
                    {{ $miInscripcion->evento->nombre }}
                </div>
                <div class="event-card-body">
                    <p class="event-desc">{{ Str::limit($miInscripcion->evento->descripcion ?? 'Sin descripción disponible', 100) }}</p>
                    <p class="event-date">
                        <i class="fas fa-calendar-alt"></i>
                        {{ $miInscripcion->evento->fecha_inicio->format('d \d\e F, Y') }}
                    </p>
                    <p class="event-participants">
                        <i class="fas fa-users"></i>
                        Equipos que Participan: {{ $miInscripcion->evento->inscripciones->count() }}
                    </p>
                    <div class="mt-4">
                        <a href="{{ route('estudiante.eventos.show', $miInscripcion->evento) }}">
                            Ver detalles del evento <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="event-card-container neu-card animate-in delay-1">
                <div class="event-card-header">No hay eventos activos</div>
                <div class="event-card-body">
                    <p class="event-desc">Actualmente no estás participando en ningún evento. Explora los eventos disponibles para unirte.</p>
                </div>
            </div>
        @endif

        {{-- ============================================== --}}
        {{-- CARRUSEL DE EVENTOS DISPONIBLES --}}
        {{-- ============================================== --}}
        <h3 class="section-title animate-in delay-2">
            <i class="fas fa-calendar-star"></i>
            Eventos Disponibles
        </h3>
        
        @if($eventosDisponibles->count() > 0)
            <div class="carousel-container animate-in delay-2" id="eventosCarousel">
                <div class="carousel-track-container">
                    <div class="carousel-track" id="eventosTrack">
                        @foreach ($eventosDisponibles as $evento)
                            <div class="carousel-slide">
                                <div class="event-card-container neu-card event-card-with-image" style="margin-bottom: 0;">
                                    @if($evento->ruta_imagen)
                                        <div class="event-image">
                                            <img src="{{ asset('storage/' . $evento->ruta_imagen) }}" alt="{{ $evento->nombre }}">
                                            <span class="event-badge">
                                                <i class="fas fa-clock"></i> Próximo
                                            </span>
                                        </div>
                                    @else
                                        <div class="event-image event-image-placeholder">
                                            <i class="fas fa-calendar-alt"></i>
                                            <span class="event-badge">
                                                <i class="fas fa-clock"></i> Próximo
                                            </span>
                                        </div>
                                    @endif
                                    <div class="event-card-content">
                                        <h4 class="event-title">{{ $evento->nombre }}</h4>
                                        <p class="event-desc">{{ Str::limit($evento->descripcion ?? 'Sin descripción', 80) }}</p>
                                        <div class="event-meta">
                                            <p class="event-date">
                                                <i class="fas fa-calendar-alt"></i>
                                                {{ $evento->fecha_inicio->format('d M, Y') }}
                                            </p>
                                            <p class="event-participants">
                                                <i class="fas fa-users"></i>
                                                {{ $evento->inscripciones->count() }} equipos
                                            </p>
                                        </div>
                                        <a href="{{ route('estudiante.eventos.show', $evento) }}" class="event-link">
                                            Ver detalles <i class="fas fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Navegación debajo del contenido -->
                <div class="carousel-nav">
                    <button class="carousel-arrow prev" onclick="eventosCarousel.prev()">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <div class="carousel-dots" id="eventosDots"></div>
                    <button class="carousel-arrow next" onclick="eventosCarousel.next()">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
                <div class="carousel-progress">
                    <div class="carousel-progress-bar" id="eventosProgress"></div>
                </div>
            </div>
        @else
            <div class="event-card-container neu-card animate-in delay-2">
                <div class="empty-state">
                    <i class="fas fa-calendar-times"></i>
                    <p>No hay eventos disponibles en este momento.</p>
                </div>
            </div>
        @endif

        {{-- ============================================== --}}
        {{-- CARRUSEL DE EQUIPOS --}}
        {{-- ============================================== --}}
        <h3 class="section-title animate-in delay-3">
            <i class="fas fa-users-cog"></i>
            Equipos Disponibles
        </h3>
        
        @php
            // Obtener equipos disponibles (puedes ajustar esta query según tu lógica)
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
            <div class="carousel-container animate-in delay-3" id="equiposCarousel">
                <div class="carousel-track-container">
                    <div class="carousel-track" id="equiposTrack">
                        @foreach ($equiposDisponibles as $inscripcion)
                            <div class="carousel-slide">
                                <div class="team-card">
                                    <div class="team-header">
                                        <div class="team-avatar">
                                            <i class="fas fa-users"></i>
                                        </div>
                                        <div class="team-info">
                                            <h4>{{ $inscripcion->equipo->nombre }}</h4>
                                            <p>{{ $inscripcion->evento->nombre }}</p>
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
                                    
                                    <div class="team-status {{ $inscripcion->status_registro === 'Completo' ? 'completo' : 'incompleto' }}">
                                        <i class="fas {{ $inscripcion->status_registro === 'Completo' ? 'fa-check-circle' : 'fa-user-plus' }}"></i>
                                        {{ $inscripcion->status_registro === 'Completo' ? 'Equipo Completo' : 'Buscando Miembros' }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Navegación debajo del contenido -->
                <div class="carousel-nav">
                    <button class="carousel-arrow prev" onclick="equiposCarousel.prev()">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <div class="carousel-dots" id="equiposDots"></div>
                    <button class="carousel-arrow next" onclick="equiposCarousel.next()">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
                <div class="carousel-progress">
                    <div class="carousel-progress-bar" id="equiposProgress"></div>
                </div>
            </div>
        @else
            <div class="event-card-container neu-card animate-in delay-3">
                <div class="empty-state">
                    <i class="fas fa-users-slash"></i>
                    <p>No hay equipos buscando miembros en este momento.</p>
                </div>
            </div>
        @endif
    </section>

    <section class="right-col">
        {{-- ============================================== --}}
        {{-- GRÁFICAS DE PROGRESO DE PROYECTOS --}}
        {{-- ============================================== --}}
        <h3 class="section-title animate-in">
            <i class="fas fa-chart-pie"></i>
            Progreso de Proyectos
        </h3>
        
        {{-- Calcular progreso real del proyecto --}}
        @php
            $tieneProyecto = $miInscripcion && $miInscripcion->proyecto;
            $progressData = [];
            $totalTareas = 0;
            $tareasCompletadas = 0;
            $porcentajeGeneral = 0;

            if ($tieneProyecto) {
                $proyecto = $miInscripcion->proyecto;
                $tareas = $proyecto->tareas;
                $totalTareas = $tareas->count();
                $tareasCompletadas = $tareas->where('completada', true)->count();
                $porcentajeGeneral = $totalTareas > 0 ? round(($tareasCompletadas / $totalTareas) * 100) : 0;

                // Agrupar tareas por prioridad para las gráficas
                $tareasAlta = $tareas->where('prioridad', 'Alta');
                $tareasMedia = $tareas->where('prioridad', 'Media');
                $tareasBaja = $tareas->where('prioridad', 'Baja');

                $progressData = [
                    [
                        'name' => 'Alta Prioridad',
                        'total' => $tareasAlta->count(),
                        'completadas' => $tareasAlta->where('completada', true)->count(),
                        'percentage' => $tareasAlta->count() > 0 ? round(($tareasAlta->where('completada', true)->count() / $tareasAlta->count()) * 100) : 0,
                        'color' => 'orange',
                        'icon' => 'fa-exclamation-circle'
                    ],
                    [
                        'name' => 'Media Prioridad',
                        'total' => $tareasMedia->count(),
                        'completadas' => $tareasMedia->where('completada', true)->count(),
                        'percentage' => $tareasMedia->count() > 0 ? round(($tareasMedia->where('completada', true)->count() / $tareasMedia->count()) * 100) : 0,
                        'color' => 'green',
                        'icon' => 'fa-minus-circle'
                    ],
                    [
                        'name' => 'Baja Prioridad',
                        'total' => $tareasBaja->count(),
                        'completadas' => $tareasBaja->where('completada', true)->count(),
                        'percentage' => $tareasBaja->count() > 0 ? round(($tareasBaja->where('completada', true)->count() / $tareasBaja->count()) * 100) : 0,
                        'color' => 'purple',
                        'icon' => 'fa-arrow-down'
                    ],
                    [
                        'name' => 'Total',
                        'total' => $totalTareas,
                        'completadas' => $tareasCompletadas,
                        'percentage' => $porcentajeGeneral,
                        'color' => 'blue',
                        'icon' => 'fa-tasks'
                    ],
                ];
            }
        @endphp

        @if($tieneProyecto && $totalTareas > 0)
            <div class="progress-charts-container animate-in delay-1">
                @foreach($progressData as $index => $data)
                    @if($data['total'] > 0)
                        <div class="progress-chart-card" data-percentage="{{ $data['percentage'] }}" data-color="{{ $data['color'] }}">
                            <div class="circular-progress">
                                <svg viewBox="0 0 100 100">
                                    <circle class="bg" cx="50" cy="50" r="40"/>
                                    <circle class="progress {{ $data['color'] }}" cx="50" cy="50" r="40"/>
                                </svg>
                                <div class="percentage">
                                    <span style="font-size: 1.1rem; color: var(--color-black);">{{ $data['percentage'] }}%</span>
                                </div>
                            </div>
                            <h5>{{ $data['name'] }}</h5>
                            <p class="progress-value">{{ $data['completadas'] }}/{{ $data['total'] }} tareas</p>
                        </div>
                    @endif
                @endforeach
            </div>
        @else
            <div class="neu-card animate-in delay-1" style="padding: 2rem; text-align: center;">
                <div class="empty-state">
                    <i class="fas fa-clipboard-list"></i>
                    <p>@if(!$miInscripcion)
                        No estás inscrito en ningún evento activo.
                    @elseif(!$miInscripcion->proyecto)
                        Tu equipo aún no tiene un proyecto asignado.
                    @else
                        No hay tareas registradas en el proyecto.
                    @endif</p>
                </div>
            </div>
        @endif

        <h3 class="section-title animate-in delay-2">
            <i class="fas fa-tasks"></i>
            Progreso del Proyecto Actual
        </h3>
        
        <div class="progress-main-card neu-card animate-in delay-2">
            @if($miInscripcion && $miInscripcion->equipo)
                <div class="progress-info-items">
                    <div class="info-item">
                        <i class="fas fa-users"></i> {{ $miInscripcion->equipo->nombre }}
                    </div>
                    <div class="info-item">
                        <i class="fas fa-calendar"></i> {{ $miInscripcion->evento->nombre }}
                    </div>
                    <div class="info-item">
                        <i class="fas fa-user-tag"></i>
                        {{ $miInscripcion->equipo->miembros->where('id_estudiante', Auth::user()->estudiante->id_estudiante)->first()->rol->nombre ?? 'Miembro' }}
                    </div>
                </div>
                <div class="progress-circle-container">
                    <div class="progress-ring"></div>
                    <div class="progress-text">
                        <span>Avance</span>
                        <strong>0%</strong>
                    </div>
                </div>
                <div class="mt-4 text-center">
                    <a href="{{ route('estudiante.equipo.index') }}">
                        Ver detalles del equipo <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            @else
                <div class="progress-info-items">
                    <div class="info-item">Sin equipo asignado</div>
                    <div class="info-item">Sin evento activo</div>
                    <div class="info-item">Sin rol</div>
                </div>
                <div class="progress-circle-container">
                    <div class="progress-ring"></div>
                    <div class="progress-text">
                        <span>Avance</span>
                        <strong>0%</strong>
                    </div>
                </div>
            @endif
        </div>

        <div class="cards-grid animate-in delay-3">
            <a href="{{ route('estudiante.eventos.index') }}" class="small-card neu-card">
                <div class="card-icon-box icon-athena"><i class="fas fa-calendar-alt"></i></div>
                <div class="card-content-box">
                    <h4>EVENTOS ACTIVOS</h4>
                    <p>Verifica los eventos en curso</p>
                </div>
            </a>

            {{-- Card Proyecto del Evento --}}
            @if($miInscripcion && $miInscripcion->evento->estado === 'En Progreso')
                @php
                    $evento = $miInscripcion->evento;
                    $proyectoEvento = $evento->tipo_proyecto === 'general' 
                        ? $evento->proyectoGeneral 
                        : $miInscripcion->proyectoEvento;
                @endphp
                
                @if($proyectoEvento && $proyectoEvento->publicado)
                    <a href="{{ route('estudiante.proyecto-evento.show') }}" class="small-card neu-card">
                        <div class="card-icon-box icon-const"><i class="fas fa-clipboard-list"></i></div>
                        <div class="card-content-box">
                            <h4>PROYECTO DEL EVENTO</h4>
                            <p>{{ Str::limit($proyectoEvento->titulo, 30) }}</p>
                        </div>
                    </a>
                @else
                    <div class="small-card neu-card">
                        <div class="card-icon-box icon-const"><i class="fas fa-clipboard-list"></i></div>
                        <div class="card-content-box">
                            <h4>PROYECTO DEL EVENTO</h4>
                            <p>Esperando publicación...</p>
                        </div>
                    </div>
                @endif
            @else
            <a href="{{ route('estudiante.constancias.index') }}">
                <div class="small-card neu-card">
                    <div class="card-icon-box icon-const"><i class="fas fa-certificate"></i></div>
                    <div class="card-content-box">
                        <h4>CONSTANCIAS</h4>
                        <p>Genera tus constancias</p>
                    </div>
                </div>
            </a>
            @endif

            @if($miInscripcion && $miInscripcion->proyecto)
                <a href="#" class="small-card neu-card">
                    <div class="card-icon-box icon-projects"><i class="fas fa-cogs"></i></div>
                    <div class="card-content-box">
                        <h4>MIS PROYECTOS</h4>
                        <p>Verifica tus proyectos</p>
                    </div>
                </a>
            @else
                <div class="small-card neu-card">
                    <div class="card-icon-box icon-projects"><i class="fas fa-cogs"></i></div>
                    <div class="card-content-box">
                        <h4>MIS PROYECTOS</h4>
                        <p>Sin proyectos activos</p>
                    </div>
                </div>
            @endif

            <a href="{{ route('estudiante.equipo.index') }}" class="small-card neu-card">
                <div class="card-icon-box icon-teams"><i class="fas fa-users"></i></div>
                <div class="card-content-box">
                    <h4>EQUIPOS</h4>
                    <p>Verifica los equipos disponibles</p>
                </div>
            </a>
        </div>
    </section>

    {{-- ============================================== --}}
    {{-- JAVASCRIPT PARA CARRUSELES Y GRÁFICAS --}}
    {{-- ============================================== --}}
    <script>
        /**
         * Clase Carousel - Carrusel reutilizable con vanilla JS
         * @param {string} trackId - ID del contenedor del track
         * @param {string} dotsId - ID del contenedor de dots
         * @param {string} progressId - ID de la barra de progreso
         * @param {number} autoPlayDelay - Tiempo en ms para auto-slide (0 para desactivar)
         */
        class Carousel {
            constructor(trackId, dotsId, progressId, autoPlayDelay = 5000) {
                this.track = document.getElementById(trackId);
                this.dotsContainer = document.getElementById(dotsId);
                this.progressBar = document.getElementById(progressId);
                
                if (!this.track) return;
                
                this.slides = this.track.querySelectorAll('.carousel-slide');
                this.currentIndex = 0;
                this.autoPlayDelay = autoPlayDelay;
                this.autoPlayTimer = null;
                this.progressTimer = null;
                this.progressInterval = null;
                
                this.init();
            }
            
            init() {
                if (this.slides.length === 0) return;
                
                this.createDots();
                this.updateCarousel();
                
                if (this.autoPlayDelay > 0) {
                    this.startAutoPlay();
                }
                
                // Pausar en hover
                const container = this.track.closest('.carousel-container');
                if (container) {
                    container.addEventListener('mouseenter', () => this.pauseAutoPlay());
                    container.addEventListener('mouseleave', () => this.startAutoPlay());
                }
                
                // Soporte para touch/swipe
                this.initTouchSupport();
            }
            
            createDots() {
                if (!this.dotsContainer) return;
                
                this.dotsContainer.innerHTML = '';
                this.slides.forEach((_, index) => {
                    const dot = document.createElement('div');
                    dot.classList.add('carousel-dot');
                    if (index === 0) dot.classList.add('active');
                    dot.addEventListener('click', () => this.goTo(index));
                    this.dotsContainer.appendChild(dot);
                });
            }
            
            updateCarousel() {
                // Mover el track
                this.track.style.transform = `translateX(-${this.currentIndex * 100}%)`;
                
                // Actualizar dots
                if (this.dotsContainer) {
                    const dots = this.dotsContainer.querySelectorAll('.carousel-dot');
                    dots.forEach((dot, index) => {
                        dot.classList.toggle('active', index === this.currentIndex);
                    });
                }
            }
            
            next() {
                this.currentIndex = (this.currentIndex + 1) % this.slides.length;
                this.updateCarousel();
                this.resetProgress();
            }
            
            prev() {
                this.currentIndex = (this.currentIndex - 1 + this.slides.length) % this.slides.length;
                this.updateCarousel();
                this.resetProgress();
            }
            
            goTo(index) {
                this.currentIndex = index;
                this.updateCarousel();
                this.resetProgress();
            }
            
            startAutoPlay() {
                if (this.autoPlayDelay <= 0 || this.slides.length <= 1) return;
                
                this.pauseAutoPlay();
                this.startProgress();
                
                this.autoPlayTimer = setInterval(() => {
                    this.next();
                }, this.autoPlayDelay);
            }
            
            pauseAutoPlay() {
                if (this.autoPlayTimer) {
                    clearInterval(this.autoPlayTimer);
                    this.autoPlayTimer = null;
                }
                this.pauseProgress();
            }
            
            startProgress() {
                if (!this.progressBar) return;
                
                let progress = 0;
                const increment = 100 / (this.autoPlayDelay / 50);
                
                this.progressBar.style.width = '0%';
                
                this.progressInterval = setInterval(() => {
                    progress += increment;
                    if (progress >= 100) {
                        progress = 0;
                    }
                    this.progressBar.style.width = `${progress}%`;
                }, 50);
            }
            
            pauseProgress() {
                if (this.progressInterval) {
                    clearInterval(this.progressInterval);
                    this.progressInterval = null;
                }
            }
            
            resetProgress() {
                if (!this.progressBar) return;
                this.progressBar.style.width = '0%';
                this.pauseProgress();
                if (this.autoPlayTimer) {
                    this.startProgress();
                }
            }
            
            initTouchSupport() {
                let startX = 0;
                let endX = 0;
                
                this.track.addEventListener('touchstart', (e) => {
                    startX = e.touches[0].clientX;
                    this.pauseAutoPlay();
                }, { passive: true });
                
                this.track.addEventListener('touchmove', (e) => {
                    endX = e.touches[0].clientX;
                }, { passive: true });
                
                this.track.addEventListener('touchend', () => {
                    const diff = startX - endX;
                    const threshold = 50;
                    
                    if (Math.abs(diff) > threshold) {
                        if (diff > 0) {
                            this.next();
                        } else {
                            this.prev();
                        }
                    }
                    
                    this.startAutoPlay();
                });
            }
        }
        
        // Inicializar carruseles cuando el DOM esté listo
        let eventosCarousel, equiposCarousel;
        
        document.addEventListener('DOMContentLoaded', function() {
            // Carrusel de eventos - cambia cada 6 segundos
            eventosCarousel = new Carousel('eventosTrack', 'eventosDots', 'eventosProgress', 6000);
            
            // Carrusel de equipos - cambia cada 5 segundos
            equiposCarousel = new Carousel('equiposTrack', 'equiposDots', 'equiposProgress', 5000);
            
            // Animar las gráficas circulares
            animateProgressCharts();
        });
        
        /**
         * Animar las gráficas de progreso circular
         */
        function animateProgressCharts() {
            const charts = document.querySelectorAll('.progress-chart-card');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const card = entry.target;
                        const percentage = parseInt(card.dataset.percentage);
                        const progressCircle = card.querySelector('.progress');
                        
                        if (progressCircle) {
                            // Calcular el offset (circunferencia = 2 * PI * r = 2 * 3.14159 * 40 ≈ 251)
                            const circumference = 251;
                            const offset = circumference - (percentage / 100) * circumference;
                            
                            // Aplicar la animación después de un pequeño delay
                            setTimeout(() => {
                                progressCircle.style.strokeDashoffset = offset;
                            }, 300);
                        }
                        
                        observer.unobserve(card);
                    }
                });
            }, { threshold: 0.5 });
            
            charts.forEach(chart => observer.observe(chart));
        }
    </script>
@endsection