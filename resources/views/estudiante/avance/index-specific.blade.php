@extends('layouts.app')

@section('title', 'Avances del Proyecto')

@section('content')

    <div class="avances-page">
        <div class="container-compact">

            <a href="{{ route('estudiante.proyecto.show-specific', $proyecto->id_proyecto) }}" class="back-link">
                <i class="fas fa-arrow-left"></i> Volver al Proyecto
            </a>

            {{-- ========== HERO SECTION ========== --}}
            <div class="hero-section">
                <div class="hero-badges">
                    @if($inscripcion->evento)
                        <span class="badge badge-event">
                            <i class="fas fa-calendar"></i> {{ $inscripcion->evento->nombre }}
                        </span>
                    @endif
                    <span class="badge badge-timeline">
                        <i class="fas fa-history"></i> Timeline
                    </span>
                </div>

                <h1 class="hero-title">{{ $proyecto->nombre }}</h1>

                @if($proyecto->descripcion_tecnica)
                    <p class="hero-desc">{{ Str::limit($proyecto->descripcion_tecnica, 100) }}</p>
                @endif

                <div class="hero-meta">
                    <div class="meta-item">
                        <i class="fas fa-users"></i>
                        <span>{{ $inscripcion->equipo->nombre }}</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-chart-line"></i>
                        <span>{{ $avances->count() }} avances</span>
                    </div>
                </div>
            </div>

            {{-- ========== STATS ROW ========== --}}
            <div class="stats-row">
                <div class="stat-box">
                    <div class="stat-icon green"><i class="fas fa-chart-line"></i></div>
                    <div class="stat-info">
                        <span class="stat-num">{{ $avances->count() }}</span>
                        <span class="stat-label">Avances Totales</span>
                    </div>
                </div>
                <div class="stat-box">
                    <div class="stat-icon purple"><i class="fas fa-calendar-check"></i></div>
                    <div class="stat-info">
                        <span
                            class="stat-num">{{ $avances->filter(fn($avance) => $avance->evaluaciones->isNotEmpty())->count() }}</span>
                        <span class="stat-label">Evaluados</span>
                    </div>
                </div>
                <div class="stat-box">
                    <div class="stat-icon orange"><i class="fas fa-star"></i></div>
                    <div class="stat-info">
                        <span class="stat-num">
                            @if($avances->isNotEmpty() && $avances->filter(fn($avance) => $avance->evaluaciones->isNotEmpty())->isNotEmpty())
                                {{ round($avances->filter(fn($avance) => $avance->evaluaciones->isNotEmpty())->avg(fn($avance) => $avance->evaluaciones->avg('calificacion')), 1) }}/10
                            @else
                                -
                            @endif
                        </span>
                        <span class="stat-label">Promedio</span>
                    </div>
                </div>
            </div>

            {{-- ========== TIMELINE DE AVANCES ========== --}}
            <div class="section-card">
                <div class="section-head">
                    <h3><i class="fas fa-history"></i> Timeline de Avances</h3>
                    <div class="head-actions">
                        <a href="{{ route('estudiante.avances.create-specific', $proyecto->id_proyecto) }}"
                            class="btn-sm btn-green">
                            <i class="fas fa-plus"></i> Nuevo Avance
                        </a>
                    </div>
                </div>

                @if($avances->isNotEmpty())
                    <div class="timeline">
                        @foreach($avances as $avance)
                            <div class="timeline-item">
                                <div class="timeline-dot"></div>
                                <div class="timeline-content {{ $avance->evaluaciones->isNotEmpty() ? 'graded' : 'pending' }}">
                                    <div class="content-date">
                                        <i class="fas fa-clock"></i>
                                        {{ $avance->created_at->format('d M Y, H:i') }}
                                    </div>
                                    <div class="content-header">
                                        <div class="content-info">
                                            <a href="{{ route('estudiante.avances.show-specific', $avance) }}"
                                                class="content-title">
                                                {{ $avance->titulo }}
                                            </a>
                                            <div class="content-meta">
                                                <div class="content-avatar">
                                                    {{ strtoupper(substr($avance->usuarioRegistro->nombre, 0, 1)) }}
                                                </div>
                                                <span>{{ $avance->usuarioRegistro->nombre }}</span>
                                            </div>
                                        </div>
                                        <div class="content-actions">
                                            @php $archivo = $avance->archivo_evidencia ?? $avance->archivo_adjunto ?? null; @endphp
                                            @if($archivo)
                                                <a href="{{ asset('storage/' . $archivo) }}" target="_blank" class="file-attachment">
                                                    <i class="fas fa-paperclip"></i>
                                                    Archivo
                                                </a>
                                            @endif

                                        </div>
                                    </div>

                                    @if($avance->descripcion)
                                        <div class="content-description">
                                            {!! nl2br(e(Str::limit($avance->descripcion, 200))) !!}
                                        </div>
                                    @endif

                                    @if($avance->evaluaciones->isNotEmpty())
                                        <div class="evaluation-summary">
                                            <div class="eval-score-mini">
                                                <span
                                                    class="score-value">{{ round($avance->evaluaciones->avg('calificacion'), 1) }}</span>
                                            </div>
                                            <span class="eval-label">Calificación</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h4>Aún no hay avances registrados</h4>
                        <p>Comienza documentando el progreso de tu proyecto registrando tu primer avance.</p>
                        <a href="{{ route('estudiante.avances.create-specific', $proyecto->id_proyecto) }}"
                            class="btn-sm btn-green">
                            <i class="fas fa-plus"></i> Registrar Primer Avance
                        </a>
                    </div>
                @endif
            </div>

        </div>
    </div>

    <style>
        /* ========== NEUMORPHIC MODERN DESIGN ========== */
        .avances-page {
            background: linear-gradient(135deg, #FFFDF4 0%, #FFEEE2 50%, #FFF5E8 100%);
            min-height: 100vh;
            padding: 1.25rem 1rem;
            font-family: 'Inter', -apple-system, sans-serif;
        }

        .container-compact {
            max-width: 800px;
            margin: 0 auto;
        }

        /* Back Link - Neumórfico */
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            color: #6b7280;
            font-size: 0.8rem;
            font-weight: 500;
            text-decoration: none;
            margin-bottom: 1rem;
            padding: 0.5rem 1rem;
            background: #ffeee2;
            border-radius: 12px;
            box-shadow: 3px 3px 6px #e6d5c9, -3px -3px 6px rgba(255, 255, 255, 0.7);
            transition: all 0.3s ease;
        }

        .back-link:hover {
            color: #e89a3c;
            box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px rgba(255, 255, 255, 0.8);
            transform: translateX(-3px);
        }

        /* Hero Section - Neumórfico Oscuro */
        .hero-section {
            background: linear-gradient(135deg, #1a1a1a 0%, #2c2c2c 100%);
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            position: relative;
            box-shadow: 10px 10px 20px rgba(0, 0, 0, 0.15),
                -8px -8px 16px rgba(255, 255, 255, 0.05),
                inset 0 1px 0 rgba(232, 154, 60, 0.2);
            border: 1px solid rgba(232, 154, 60, 0.3);
        }

        .hero-badges {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 0.75rem;
        }

        .badge {
            padding: 0.25rem 0.6rem;
            border-radius: 20px;
            font-size: 0.65rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.3rem;
            box-shadow: inset 1px 1px 2px rgba(0, 0, 0, 0.1), inset -1px -1px 2px rgba(255, 255, 255, 0.05);
        }

        .badge-event {
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.2), rgba(99, 102, 241, 0.15));
            color: #a5b4fc;
            border: 1px solid rgba(99, 102, 241, 0.3);
        }

        .badge-timeline {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.2), rgba(16, 185, 129, 0.15));
            color: #6ee7b7;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .hero-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            margin: 0 0 0.5rem 0;
        }

        .hero-desc {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.85rem;
            margin-bottom: 1rem;
        }

        .hero-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.8rem;
        }

        /* Stats Row - Neumórfico */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .stat-box {
            background: #ffeee2;
            border-radius: 12px;
            padding: 1rem;
            box-shadow: 6px 6px 12px #e6d5c9, -6px -6px 12px rgba(255, 255, 255, 0.6);
            border: 1px solid rgba(232, 154, 60, 0.1);
            transition: all 0.3s ease;
        }

        .stat-box:hover {
            transform: translateY(-3px);
            box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px rgba(255, 255, 255, 0.7);
        }

        .stat-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
            box-shadow: 3px 3px 6px rgba(0, 0, 0, 0.1), -2px -2px 4px rgba(255, 255, 255, 0.5);
        }

        .stat-icon.purple {
            background: linear-gradient(135deg, #8b5cf6, #7c3aed);
            color: white;
        }

        .stat-icon.green {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
        }

        .stat-icon.orange {
            background: linear-gradient(135deg, #e89a3c, #f5a847);
            color: white;
        }

        .stat-info {
            display: flex;
            flex-direction: column;
        }

        .stat-num {
            font-size: 1.25rem;
            font-weight: 700;
            color: #111827;
        }

        .stat-label {
            font-size: 0.7rem;
            color: #6b7280;
        }

        /* Section Cards - Neumórfico */
        .section-card {
            background: #ffeee2;
            border-radius: 14px;
            padding: 1.25rem;
            margin-bottom: 1rem;
            box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px rgba(255, 255, 255, 0.6);
            border: 1px solid rgba(232, 154, 60, 0.1);
        }

        .section-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid rgba(230, 213, 201, 0.5);
        }

        .section-head h3 {
            font-size: 0.95rem;
            font-weight: 700;
            color: #111827;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin: 0;
        }

        .section-head h3 i {
            color: #e89a3c;
            font-size: 0.85rem;
        }

        .head-actions {
            display: flex;
            gap: 0.5rem;
        }

        .btn-sm {
            padding: 0.5rem 1.25rem;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.4rem;
            transition: all 0.3s ease;
            border: none;
            white-space: nowrap;
            min-width: fit-content;
        }

        .btn-green {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            box-shadow: 2px 2px 4px rgba(5, 150, 105, 0.3), -1px -1px 3px rgba(255, 255, 255, 0.5);
        }

        .btn-green:hover {
            transform: translateY(-2px);
            box-shadow: 3px 3px 6px rgba(5, 150, 105, 0.4), -2px -2px 4px rgba(255, 255, 255, 0.6);
            color: white;
        }

        .btn-green:active {
            transform: translateY(0);
            box-shadow: inset 2px 2px 4px rgba(0, 0, 0, 0.15);
        }

        /* Timeline Styles */
        .timeline {
            display: flex;
            flex-direction: column;
            gap: 0;
            position: relative;
            padding-left: 1.5rem;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 5px;
            top: 12px;
            bottom: 12px;
            width: 2px;
            background: linear-gradient(180deg, rgba(16, 185, 129, 0.4), rgba(232, 154, 60, 0.2));
            border-radius: 2px;
        }

        .timeline-item {
            display: flex;
            gap: 1rem;
            position: relative;
            padding-bottom: 1rem;
        }

        .timeline-item:last-child {
            padding-bottom: 0;
        }

        .timeline-dot {
            position: absolute;
            left: -1.5rem;
            top: 0.5rem;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: linear-gradient(135deg, #10b981, #059669);
            box-shadow: 0 0 0 3px #ffeee2, 3px 3px 6px rgba(5, 150, 105, 0.3);
            z-index: 2;
        }

        .timeline-content {
            flex: 1;
            min-width: 0;
            /* Permite que flex item se encoja correctamente */
            background: #fafafa;
            border-radius: 12px;
            padding: 1rem;
            border-left: 3px solid #e5e7eb;
            border: 1px solid #f3f4f6;
            transition: all 0.3s ease;
            overflow: hidden;
            /* Contener todo el contenido */
        }

        .timeline-content:hover {
            background: #f5f5f5;
            box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.05);
        }

        .timeline-content.graded {
            border-left: 3px solid #10b981;
            background: #f0fdf4;
            border-color: #d1fae5;
        }

        .timeline-content.pending {
            border-left: 3px solid #6366f1;
            border-color: #e0e7ff;
        }

        .content-date {
            font-size: 0.75rem;
            color: #9ca3af;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .content-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .content-info {
            flex: 1;
            min-width: 0;
        }

        .content-title {
            font-weight: 700;
            font-size: 0.95rem;
            color: #111827;
            text-decoration: none;
            display: block;
            margin-bottom: 0.5rem;
            transition: color 0.2s ease;
        }

        .content-title:hover {
            color: #e89a3c;
        }

        .content-meta {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #6b7280;
            font-size: 0.8rem;
        }

        .content-avatar {
            width: 28px;
            height: 28px;
            border-radius: 8px;
            background: linear-gradient(135deg, #f5a847, #e89a3c);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.75rem;
            box-shadow: 2px 2px 4px rgba(232, 154, 60, 0.2);
        }

        .content-actions {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .file-attachment {
            color: #d97706;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.75rem;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            padding: 0.25rem 0.5rem;
            background: rgba(217, 119, 6, 0.1);
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        .file-attachment:hover {
            background: rgba(217, 119, 6, 0.2);
            color: #b45309;
        }

        .evaluation-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            color: #065f46;
            font-weight: 600;
            font-size: 0.7rem;
            padding: 0.25rem 0.5rem;
            background: #d1fae5;
            border-radius: 6px;
        }

        .content-description {
            margin-top: 0.75rem;
            color: #4b5563;
            font-size: 0.8rem;
            line-height: 1.5;
            padding-top: 0.75rem;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            /* Contener texto dentro del contenedor */
            overflow: hidden;
            overflow-wrap: break-word;
            word-wrap: break-word;
            word-break: break-word;
            hyphens: auto;
            max-width: 100%;
        }

        .evaluation-summary {
            margin-top: 0.75rem;
            padding: 0.75rem;
            background: rgba(16, 185, 129, 0.08);
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .eval-score-mini {
            display: flex;
            align-items: baseline;
        }

        .score-value {
            font-size: 1.25rem;
            font-weight: 800;
            color: #059669;
        }

        .score-max {
            font-size: 0.75rem;
            color: #6b7280;
        }

        .eval-label {
            font-size: 0.75rem;
            color: #6b7280;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem 1.5rem;
        }

        .empty-icon {
            width: 64px;
            height: 64px;
            margin: 0 auto 1rem;
            background: rgba(232, 154, 60, 0.1);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px rgba(255, 255, 255, 0.6);
        }

        .empty-icon i {
            font-size: 1.5rem;
            color: #e89a3c;
        }

        .empty-state h4 {
            font-size: 1rem;
            font-weight: 600;
            color: #111827;
            margin: 0 0 0.5rem 0;
        }

        .empty-state p {
            font-size: 0.85rem;
            color: #6b7280;
            margin: 0 0 1.5rem 0;
        }

        /* Responsive */
        @media (max-width: 640px) {
            .content-header {
                flex-direction: column;
                gap: 0.75rem;
            }

            .content-actions {
                width: 100%;
                justify-content: flex-start;
            }

            .hero-title {
                font-size: 1.25rem;
            }

            .stats-row {
                grid-template-columns: 1fr;
            }
        }
    </style>

@endsection