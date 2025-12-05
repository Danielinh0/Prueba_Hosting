@extends('layouts.prueba')

@section('title', 'Inicio')

@section('content')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
        
        /* =============================================== */
        /* COLORES NEUROMÓRFICOS */
        /* =============================================== */
        :root {
            --color-primary: #e89a3c;
            --color-primary-dark: #d98a2c;
            --color-bg-base: #FFFDF4;
            --color-bg-secondary: #FFEEE2;
            --color-card: #FFEEE2;
            --color-white: #FFFFFF;
            --color-text-primary: #2c2c2c;
            --color-text-secondary: #6b6b6b;
            --color-text-muted: #9ca3af;
            --shadow-light: #ffffff;
            --shadow-dark: #e6d5c9;
        }
        
        /* Fondo degradado */
        body {
            background: linear-gradient(to bottom, #FFFDF4, #FFEEE2) !important;
            min-height: 100vh;
        }

        

        .habilidades-page {
        background: linear-gradient(to bottom, #FFFDF4, #FFEEE2);
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
    }
        
        /* Configuración global */
        .left-col,
        .right-col {
            font-family: 'Poppins', sans-serif;
        }
        
        /* Títulos de sección */
        .section-title {
            font-family: 'Poppins', sans-serif;
            color: var(--color-text-primary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
            font-size: 1rem;
            margin-bottom: 0.75rem;
        }

        .section-title i {
            color: var(--color-primary);
            font-size: 1rem;
        }
        
        /* =============================================== */
        /* CARRUSEL NEUROMÓRFICO */
        /* =============================================== */
        .carousel-container {
            position: relative;
            width: 100%;
            overflow: hidden;
            border-radius: 12px;
            margin-bottom: 1rem;
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

        /* Carousel Navigation */
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
            background: rgba(255, 253, 244, 0.9);
            border: none;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            color: var(--color-text-primary);
            transition: all 0.3s ease;
            box-shadow: 2px 2px 4px var(--shadow-dark), -2px -2px 4px var(--shadow-light);
        }

        .carousel-arrow:hover {
            color: var(--color-primary);
            box-shadow: 6px 6px 12px var(--shadow-dark), -6px -6px 12px var(--shadow-light);
            transform: translateY(-2px);
        }

        .carousel-arrow:active {
            transform: scale(0.95);
        }

        /* Carousel Dots */
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
            box-shadow: inset 1px 1px 2px var(--shadow-dark), inset -1px -1px 2px var(--shadow-light);
        }

        .carousel-dot:hover {
            background: rgba(232, 154, 60, 0.5);
        }

        .carousel-dot.active {
            background: var(--color-primary);
            width: 16px;
            border-radius: 3px;
            box-shadow: 2px 2px 4px rgba(232, 154, 60, 0.3);
        }

        /* Progress Bar */
        .carousel-progress {
            height: 4px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 4px;
            margin-top: 0.75rem;
            overflow: hidden;
            box-shadow: inset 2px 2px 4px var(--shadow-dark), inset -2px -2px 4px var(--shadow-light);
        }

        .carousel-progress-bar {
            height: 100%;
            background: linear-gradient(90deg, var(--color-primary), var(--color-primary-dark));
            border-radius: 4px;
            transition: width 0.1s linear;
            width: 0%;
        }

        /* =============================================== */
        /* CARDS NEUROMÓRFICAS */
        /* =============================================== */
        .neu-card {
            background: var(--color-card);
            border-radius: 12px;
            box-shadow: 4px 4px 8px var(--shadow-dark), -4px -4px 8px var(--shadow-light);
            transition: all 0.3s ease;
            border: none;
        }
        
        .neu-card:hover {
            box-shadow: 6px 6px 12px var(--shadow-dark), -6px -6px 12px var(--shadow-light);
            transform: translateY(-2px);
        }
        
        /* Event cards */
        .event-card-header {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #2c2c2c, #1a1a1a);
            color: var(--color-white);
            position: relative;
            overflow: hidden;
            border-radius: 12px 12px 0 0;
            padding: 0.75rem;
            font-weight: 600;
        }

        .event-card-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--color-primary), var(--color-primary-dark));
        }

        .event-badge {
            position: absolute;
            top: 6px;
            right: 6px;
            background: linear-gradient(135deg, var(--color-primary), var(--color-primary-dark));
            padding: 3px 8px;
            border-radius: 10px;
            font-size: 0.6rem;
            font-weight: 600;
            color: var(--color-white);
            z-index: 5;
            box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }
        
        .event-card-body {
            background: var(--color-card);
            padding: 0.75rem;
            border-radius: 0 0 12px 12px;
        }

        /* Event cards con imagen */
        .event-card-with-image {
            overflow: hidden;
        }

        .event-image {
            position: relative;
            width: 100%;
            height: 100px;
            overflow: hidden;
            border-radius: 12px 12px 0 0;
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
            background: linear-gradient(135deg, #2c2c2c, #1a1a1a);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .event-image-placeholder i {
            font-size: 3rem;
            color: var(--color-text-muted);
            opacity: 0.3;
        }

        .event-card-content {
            padding: 0.75rem;
            background: var(--color-card);
            border-radius: 0 0 12px 12px;
        }

        .event-title {
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--color-text-primary);
            margin: 0 0 0.35rem 0;
            line-height: 1.3;
        }
        
        .event-desc {
            font-family: 'Poppins', sans-serif;
            color: var(--color-text-secondary);
            font-size: 0.8rem;
            line-height: 1.4;
            margin: 0 0 0.5rem 0;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .event-meta {
            display: flex;
            gap: 0.75rem;
            margin-bottom: 0.5rem;
        }
        
        .event-date,
        .event-participants {
            font-family: 'Poppins', sans-serif;
            color: var(--color-text-secondary);
            display: flex;
            align-items: center;
            gap: 0.35rem;
            font-size: 0.75rem;
            margin: 0;
        }

        .event-date i,
        .event-participants i {
            color: var(--color-primary);
            width: 12px;
            font-size: 0.7rem;
        }
        
        .event-card-body a,
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
        
        .event-card-body a:hover,
        .event-link:hover {
            color: var(--color-primary-dark);
            gap: 0.75rem;
        }

        /* =============================================== */
        /* TEAM CARD NEUROMÓRFICA */
        /* =============================================== */
        .team-card {
            background: var(--color-card);
            border-radius: 12px;
            padding: 0.875rem;
            border: none;
            box-shadow: 4px 4px 8px var(--shadow-dark), -4px -4px 8px var(--shadow-light);
        }

        .team-header {
            display: flex;
            align-items: center;
            gap: 0.625rem;
            margin-bottom: 0.5rem;
        }

        .team-avatar {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #2c2c2c, #1a1a1a);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--color-white);
            font-size: 0.9rem;
            box-shadow: 2px 2px 4px var(--shadow-dark), -2px -2px 4px var(--shadow-light);
        }

        .team-info h4 {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            color: var(--color-text-primary);
            margin: 0;
            font-size: 0.9rem;
        }

        .team-info p {
            font-family: 'Poppins', sans-serif;
            font-size: 0.75rem;
            color: var(--color-text-secondary);
            margin: 0;
        }

        .team-members {
            display: flex;
            align-items: center;
            margin-top: 0.625rem;
        }

        .member-avatar {
            width: 28px;
            height: 28px;
            background: linear-gradient(135deg, #2c2c2c, #1a1a1a);
            border-radius: 50%;
            border: 1px solid var(--color-card);
            margin-left: -4px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--color-white);
            font-size: 0.65rem;
            font-weight: 600;
            box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.15);
        }

        .member-avatar:first-child {
            margin-left: 0;
        }

        .member-avatar.more {
            background: linear-gradient(135deg, var(--color-primary), var(--color-primary-dark));
            font-size: 0.6rem;
        }

        .team-status {
            margin-top: 0.625rem;
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 500;
            text-align: center;
            font-family: 'Poppins', sans-serif;
        }

        .team-status.completo {
            background: linear-gradient(135deg, rgba(209, 250, 229, 0.8), rgba(167, 243, 208, 0.8));
            color: #065f46;
            box-shadow: inset 1px 1px 2px rgba(16, 185, 129, 0.2), inset -1px -1px 2px rgba(255, 255, 255, 0.5);
        }

        .team-status.incompleto {
            background: linear-gradient(135deg, rgba(254, 240, 138, 0.8), rgba(252, 211, 77, 0.8));
            color: #92400e;
            box-shadow: inset 1px 1px 2px rgba(245, 158, 11, 0.2), inset -1px -1px 2px rgba(255, 255, 255, 0.5);
        }

        /* =============================================== */
        /* GRÁFICAS DE PROGRESO NEUROMÓRFICAS */
        /* =============================================== */
        .progress-charts-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .progress-chart-card {
            background: var(--color-card);
            border-radius: 16px;
            padding: 1.25rem;
            text-align: center;
            border: none;
            box-shadow: 8px 8px 16px var(--shadow-dark), -8px -8px 16px var(--shadow-light);
            transition: all 0.3s ease;
        }

        .progress-chart-card:hover {
            transform: translateY(-4px);
            box-shadow: 12px 12px 24px var(--shadow-dark), -12px -12px 24px var(--shadow-light);
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
            stroke: rgba(255, 255, 255, 0.3);
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
            stroke: #10b981;
        }

        .circular-progress .progress.purple {
            stroke: #8b5cf6;
        }

        .circular-progress .progress.blue {
            stroke: #3b82f6;
        }

        .circular-progress .percentage {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--color-text-primary);
            font-family: 'Poppins', sans-serif;
        }

        .progress-chart-card h5 {
            font-family: 'Poppins', sans-serif;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--color-text-primary);
            margin: 0;
        }

        .progress-chart-card p {
            font-family: 'Poppins', sans-serif;
            font-size: 0.75rem;
            color: var(--color-text-secondary);
            margin: 0.25rem 0 0;
        }

        /* =============================================== */
        /* INFO ITEMS NEUROMÓRFICAS */
        /* =============================================== */
        .info-item {
            font-family: 'Poppins', sans-serif;
            background: rgba(255, 255, 255, 0.3);
            color: var(--color-text-primary);
            padding: 0.75rem 1rem;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: inset 4px 4px 8px var(--shadow-dark), inset -4px -4px 8px var(--shadow-light);
            font-size: 0.875rem;
        }

        .info-item i {
            color: var(--color-primary);
        }
        
        .progress-ring {
            background: conic-gradient(var(--color-primary) 0%, var(--color-primary) 50%, rgba(0, 0, 0, 0.3) 50%, rgba(0, 0, 0, 0.89) 100%);
            box-shadow: 4px 4px 8px var(--shadow-dark);
        }
        
        .progress-ring::before {
            background: var(--color-card);
        }
        
        .progress-text span {
            font-family: 'Poppins', sans-serif;
            color: var(--color-text-secondary);
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
            transition: all 0.2s ease;
        }
        
        .progress-main-card a:hover {
            color: var(--color-primary-dark);
            gap: 0.75rem;
        }
        
        /* Small cards */
        .small-card {
            background: var(--color-card);
            border: none;
            box-shadow: 8px 8px 16px var(--shadow-dark), -8px -8px 16px var(--shadow-light);
            transition: all 0.3s ease;
            border-radius: 16px;
            text-decoration: none;
            display: block;
        }
        
        .small-card:hover {
            box-shadow: 12px 12px 24px var(--shadow-dark), -12px -12px 24px var(--shadow-light);
            transform: translateY(-4px);
        }
        
        .card-icon-box {
            box-shadow: 4px 4px 8px var(--shadow-dark), -4px -4px 8px var(--shadow-light);
            border-radius: 12px;
        }
        
        .icon-athena {
            background: linear-gradient(135deg, #6366f1, #4f46e5);
        }

        .icon-projects {
            background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        }
        
        .icon-const {
            background: linear-gradient(135deg, var(--color-primary), var(--color-primary-dark));
        }

        .icon-teams {
            background: linear-gradient(135deg, #10b981, #059669);
        }
        
        .card-content-box h4 {
            font-family: 'Poppins', sans-serif;
            color: var(--color-text-primary);
        }
        
        .card-content-box p {
            font-family: 'Poppins', sans-serif;
            color: var(--color-text-secondary);
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 2.5rem 1rem;
            color: var(--color-text-muted);
        }

        .empty-state i {
            font-size: 3rem;
            color: var(--color-primary);
            margin-bottom: 1rem;
            opacity: 0.4;
        }

        .empty-state p {
            font-family: 'Poppins', sans-serif;
            color: var(--color-text-muted);
            font-size: 0.9375rem;
        }

        #titulodescuadrado {
            margin-top: 2rem;
            
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

        .delay-1 { animation-delay: 0.1s; opacity: 0; }
        .delay-2 { animation-delay: 0.2s; opacity: 0; }
        .delay-3 { animation-delay: 0.3s; opacity: 0; }
        .delay-4 { animation-delay: 0.4s; opacity: 0; }

        /* Welcome Banner */
        .welcome-banner {
            background: linear-gradient(135deg, #F5B97A, #e89a3c);
            border-radius: 16px;
            padding: 1.25rem 1.5rem;
            margin-bottom: 1.5rem;
            color: white;
            position: relative;
            overflow: hidden;
            box-shadow: 6px 6px 12px var(--shadow-dark), -6px -6px 12px var(--shadow-light);
        }

        .welcome-banner::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, var(--color-primary), var(--color-primary-dark));
            border-radius: 50%;
            transform: translate(40%, -40%);
            opacity: 0.3;
        }

        .welcome-banner .welcome-svg {
            position: absolute;
            bottom: -5px;
            left: 15px;
            width: 70px;
            height: 70px;
            opacity: 0.2;
        }

        .welcome-banner h2 {
            font-family: 'Poppins', sans-serif;
            font-size: 1.25rem;
            font-weight: 700;
            margin: 0 0 0.25rem;
            position: relative;
            z-index: 1;
        }

        .welcome-banner p {
            font-family: 'Poppins', sans-serif;
            font-size: 0.8rem;
            opacity: 0.9;
            margin: 0;
            position: relative;
            z-index: 1;
        }

        .welcome-highlight {
            color: #2c2c2c;
        }
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

    <!-- Welcome Banner -->
    <div class="welcome-banner animate-in" style="grid-column: 1 / -1;">
        <svg class="welcome-svg" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="50" cy="50" r="45" stroke="white" stroke-width="2"/>
            <path d="M35 50 L45 60 L65 40" stroke="white" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <h2>¡Hola, <span class="welcome-highlight">{{ Auth::user()->nombre }}</span>!</h2>
        <p>Panel de estudiante — {{ now()->translatedFormat('d \\d\\e F, Y') }}</p>
    </div>

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

        {{-- CARRUSEL DE EVENTOS DISPONIBLES --}}
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

        {{-- CARRUSEL DE EQUIPOS --}}
        <h3 class="section-title animate-in delay-3">
            <i class="fas fa-users-cog"></i>
            Equipos Disponibles
        </h3>
        
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
        {{-- ACCESO RÁPIDO --}}
        <h3 class="section-title animate-in">
            <i class="fas fa-bolt"></i>
            Acceso Rápido
        </h3>

        <div class="cards-grid animate-in delay-1">
            <a href="{{ route('estudiante.eventos.index') }}" class="small-card neu-card">
                <div class="card-icon-box icon-athena"><i class="fas fa-calendar-alt"></i></div>
                <div class="card-content-box">
                    <h4>EVENTOS ACTIVOS</h4>
                    <p>Verifica los eventos en curso</p>
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
                        <p>Aquí puedes generar constancias de tus eventos</p>
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

        {{-- GRÁFICAS DE PROGRESO DE PROYECTOS --}}
        <h3 class="section-title animate-in delay-2">
            <i class="fas fa-chart-pie"></i>
            Progreso de Proyectos
        </h3>
        
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
                                    <span>{{ $data['percentage'] }}%</span>
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

        <h3 class="section-title animate-in delay-2" id="titulodescuadrado">
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
    </section>

    <script>
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
                
                const container = this.track.closest('.carousel-container');
                if (container) {
                    container.addEventListener('mouseenter', () => this.pauseAutoPlay());
                    container.addEventListener('mouseleave', () => this.startAutoPlay());
                }
                
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
                this.track.style.transform = `translateX(-${this.currentIndex * 100}%)`;
                
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
        
        let eventosCarousel, equiposCarousel;
        
        document.addEventListener('DOMContentLoaded', function() {
            eventosCarousel = new Carousel('eventosTrack', 'eventosDots', 'eventosProgress', 6000);
            equiposCarousel = new Carousel('equiposTrack', 'equiposDots', 'equiposProgress', 5000);
            animateProgressCharts();
        });
        
        function animateProgressCharts() {
            const charts = document.querySelectorAll('.progress-chart-card');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const card = entry.target;
                        const percentage = parseInt(card.dataset.percentage);
                        const progressCircle = card.querySelector('.progress');
                        
                        if (progressCircle) {
                            const circumference = 251;
                            const offset = circumference - (percentage / 100) * circumference;
                            
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
