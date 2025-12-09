@extends('layouts.app')

@section('title', 'Posiciones del Evento')

@section('content')

<div class="posiciones-page py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 content-wrapper">
        <a href="{{ route('estudiante.eventos.show', $evento) }}" class="back-link">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver al Evento
        </a>

        <div class="page-header">
            <div class="trophy-icon">🏆</div>
            <h1 class="page-title">Posiciones Finales</h1>
            <p class="event-name">{{ $evento->nombre }}</p>
            <p class="event-date">Finalizado el {{ $evento->fecha_fin->format('d/m/Y') }}</p>
        </div>

        @if($inscripciones->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-trophy"></i>
                </div>
                <h3 class="empty-title">No hay posiciones asignadas</h3>
                <p class="empty-text">Las posiciones de los equipos aún no han sido determinadas por el administrador.</p>
            </div>
        @else
            <!-- Podium de los 3 primeros lugares -->
            @if($inscripciones->count() >= 3)
                <div class="podium-section">
                    @php
                        $top3 = $inscripciones->take(3);
                        $rest = $inscripciones->skip(3);
                    @endphp

                    @foreach($top3 as $inscripcion)
                        <div class="podium-item rank-{{ $inscripcion->puesto_ganador }}">
                            <div class="position-badge">
                                {{ $inscripcion->puesto_ganador }}°
                            </div>
                            <div class="podium-card">
                                <h3 class="team-name">{{ $inscripcion->equipo->nombre }}</h3>
                                <div class="members-list">
                                    @foreach($inscripcion->miembros->take(5) as $miembro)
                                        <div class="member-chip">
                                            <div class="member-avatar">
                                                {{ strtoupper(substr($miembro->user->nombre ?? 'U', 0, 1)) }}
                                            </div>
                                            <span class="member-name">{{ $miembro->user->nombre ?? 'Miembro' }}</span>
                                        </div>
                                    @endforeach
                                    @if($inscripcion->miembros->count() > 5)
                                        <div class="more-members">
                                            +{{ $inscripcion->miembros->count() - 5 }} más
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @elseif($inscripciones->count() > 0 && $inscripciones->count() < 3)
                <!-- Si hay menos de 3 equipos, mostrarlos en linea -->
                <div class="podium-section" style="align-items: center;">
                    @foreach($inscripciones as $inscripcion)
                        <div class="podium-item rank-{{ $inscripcion->puesto_ganador }}">
                            <div class="position-badge">
                                {{ $inscripcion->puesto_ganador }}°
                            </div>
                            <div class="podium-card">
                                <h3 class="team-name">{{ $inscripcion->equipo->nombre }}</h3>
                                <div class="members-list">
                                    @foreach($inscripcion->miembros->take(5) as $miembro)
                                        <div class="member-chip">
                                            <div class="member-avatar">
                                                {{ strtoupper(substr($miembro->user->nombre ?? 'U', 0, 1)) }}
                                            </div>
                                            <span class="member-name">{{ $miembro->user->nombre ?? 'Miembro' }}</span>
                                        </div>
                                    @endforeach
                                    @if($inscripcion->miembros->count() > 5)
                                        <div class="more-members">
                                            +{{ $inscripcion->miembros->count() - 5 }} más
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Resto de posiciones (4+) -->
            @if($inscripciones->count() > 3)
                <div class="rest-section">
                    <h2 class="rest-title">Otras Posiciones</h2>
                    
                    @foreach($inscripciones->skip(3) as $inscripcion)
                        <div class="position-row {{ $miInscripcion && $miInscripcion->id_inscripcion === $inscripcion->id_inscripcion ? 'my-team' : '' }}">
                            <div class="row-position">{{ $inscripcion->puesto_ganador }}°</div>
                            <div class="row-team-info">
                                <div class="row-team-name">
                                    {{ $inscripcion->equipo->nombre }}
                                    @if($miInscripcion && $miInscripcion->id_inscripcion === $inscripcion->id_inscripcion)
                                        <span class="my-team-tag">Mi Equipo</span>
                                    @endif
                                </div>
                                <div class="row-team-members">
                                    <i class="fas fa-users" style="margin-right: 0.25rem;"></i>
                                    {{ $inscripcion->miembros->count() }} integrantes
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        @endif
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

    /* Base - Tema Claro */
    .posiciones-page {
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 50%, #f3f4f6 100%);
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
        position: relative;
        overflow: hidden;
    }

    .posiciones-page::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle at 50% 50%, rgba(232, 154, 60, 0.05) 0%, transparent 50%);
        animation: pulse-bg 15s ease-in-out infinite;
    }

    @keyframes pulse-bg {
        0%, 100% { transform: scale(1); opacity: 0.5; }
        50% { transform: scale(1.1); opacity: 0.8; }
    }

    .content-wrapper {
        position: relative;
        z-index: 1;
    }

    /* Back button */
    .back-link {
        display: inline-flex;
        align-items: center;
        color: #4b5563;
        font-size: 0.875rem;
        font-weight: 500;
        padding: 0.625rem 1.25rem;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .back-link:hover {
        color: #e89a3c;
        background: rgba(232, 154, 60, 0.05);
        border-color: rgba(232, 154, 60, 0.3);
        transform: translateX(-5px);
    }

    .back-link svg {
        width: 1rem;
        height: 1rem;
        margin-right: 0.5rem;
    }

    /* Header */
    .page-header {
        text-align: center;
        margin-bottom: 3rem;
        padding: 2rem;
    }

    .trophy-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
        animation: trophy-float 3s ease-in-out infinite;
    }

    @keyframes trophy-float {
        0%, 100% { transform: translateY(0) rotate(-5deg); }
        50% { transform: translateY(-10px) rotate(5deg); }
    }

    .page-title {
        font-size: 2.5rem;
        font-weight: 800;
        background: linear-gradient(135deg, #1a1a1a 0%, #e89a3c 50%, #1a1a1a 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 3px;
    }

    .event-name {
        color: #4b5563;
        font-size: 1.125rem;
        font-weight: 500;
    }

    .event-date {
        color: #9ca3af;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    /* Podium Container */
    .podium-section {
        display: flex;
        justify-content: center;
        align-items: flex-end;
        gap: 1.5rem;
        margin: 3rem 0;
        padding: 2rem;
        perspective: 1000px;
    }

    /* Individual Podium Items */
    .podium-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .podium-item:hover {
        transform: translateY(-15px) scale(1.02);
    }

    /* Position badge */
    .position-badge {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        font-weight: 800;
        margin-bottom: 1rem;
        position: relative;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    }

    .position-badge::after {
        content: '';
        position: absolute;
        inset: -3px;
        border-radius: 50%;
        padding: 3px;
        background: inherit;
        -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        -webkit-mask-composite: xor;
        mask-composite: exclude;
        opacity: 0.5;
    }

    /* Gold - 1st place */
    .rank-1 { order: 2; }
    .rank-1 .position-badge {
        background: linear-gradient(135deg, #FFD700, #FFA500, #FFD700);
        color: #1a1a1a;
        width: 90px;
        height: 90px;
        font-size: 2.25rem;
        animation: gold-glow 2s ease-in-out infinite alternate;
    }

    @keyframes gold-glow {
        0% { box-shadow: 0 0 30px rgba(255, 215, 0, 0.3), 0 10px 40px rgba(0, 0, 0, 0.1); }
        100% { box-shadow: 0 0 50px rgba(255, 215, 0, 0.5), 0 10px 40px rgba(0, 0, 0, 0.1); }
    }

    /* Silver - 2nd place */
    .rank-2 { order: 1; }
    .rank-2 .position-badge {
        background: linear-gradient(135deg, #e8e8e8, #b8b8b8, #e8e8e8);
        color: #1a1a1a;
    }

    /* Bronze - 3rd place */
    .rank-3 { order: 3; }
    .rank-3 .position-badge {
        background: linear-gradient(135deg, #CD7F32, #8B4513, #CD7F32);
        color: #ffffff;
    }

    /* Podium Card */
    .podium-card {
        width: 220px;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 20px;
        padding: 1.5rem;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        position: relative;
        overflow: hidden;
    }

    .podium-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
    }

    .rank-1 .podium-card::before {
        background: linear-gradient(90deg, transparent, #FFD700, transparent);
    }

    .rank-2 .podium-card::before {
        background: linear-gradient(90deg, transparent, #C0C0C0, transparent);
    }

    .rank-3 .podium-card::before {
        background: linear-gradient(90deg, transparent, #CD7F32, transparent);
    }

    .rank-1 .podium-card {
        min-height: 280px;
        border-color: rgba(255, 215, 0, 0.3);
    }

    .rank-2 .podium-card,
    .rank-3 .podium-card {
        min-height: 240px;
    }

    /* Team name */
    .team-name {
        font-size: 1.125rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 1rem;
        text-align: center;
        line-height: 1.3;
    }

    /* Members list */
    .members-list {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .member-chip {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 0.75rem;
        background: #f8f9fa;
        border-radius: 10px;
        transition: all 0.2s ease;
    }

    .member-chip:hover {
        background: rgba(232, 154, 60, 0.1);
    }

    .member-avatar {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: linear-gradient(135deg, #e89a3c, #f5a847);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.7rem;
    }

    .member-name {
        color: #4b5563;
        font-size: 0.8rem;
        font-weight: 500;
        flex: 1;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .more-members {
        color: #9ca3af;
        font-size: 0.75rem;
        text-align: center;
        padding: 0.25rem;
    }

    /* Rest positions section */
    .rest-section {
        margin-top: 3rem;
        padding: 2rem;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 24px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05);
    }

    .rest-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 1.5rem;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
    }

    .rest-title::before,
    .rest-title::after {
        content: '';
        flex: 1;
        max-width: 100px;
        height: 2px;
        background: linear-gradient(90deg, transparent, #e89a3c, transparent);
    }

    /* Position row */
    .position-row {
        display: flex;
        align-items: center;
        padding: 1rem 1.25rem;
        background: #f8f9fa;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        margin-bottom: 0.75rem;
        transition: all 0.3s ease;
    }

    .position-row:hover {
        background: rgba(232, 154, 60, 0.05);
        border-color: rgba(232, 154, 60, 0.2);
        transform: translateX(5px);
    }

    .position-row.my-team {
        background: linear-gradient(135deg, rgba(232, 154, 60, 0.1), rgba(232, 154, 60, 0.05));
        border-color: rgba(232, 154, 60, 0.4);
        border-width: 2px;
    }

    .row-position {
        font-size: 1.5rem;
        font-weight: 800;
        color: #e89a3c;
        min-width: 60px;
        text-align: center;
    }

    .row-team-info {
        flex: 1;
        margin-left: 1rem;
    }

    .row-team-name {
        font-size: 1rem;
        font-weight: 600;
        color: #1a1a1a;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .row-team-members {
        color: #6b7280;
        font-size: 0.8rem;
        margin-top: 0.25rem;
    }

    .my-team-tag {
        background: linear-gradient(135deg, #e89a3c, #f5a847);
        color: #ffffff;
        padding: 0.2rem 0.6rem;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 5rem 2rem;
    }

    .empty-icon {
        font-size: 5rem;
        color: #d1d5db;
        margin-bottom: 1.5rem;
    }

    .empty-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #4b5563;
        margin-bottom: 0.5rem;
    }

    .empty-text {
        color: #9ca3af;
        font-size: 0.95rem;
    }

    /* Responsive */
    @media (max-width: 900px) {
        .podium-section {
            flex-direction: column;
            align-items: center;
        }

        .podium-item { order: unset !important; }
        .rank-1 { order: -1 !important; }

        .podium-card {
            width: 100%;
            max-width: 300px;
        }

        .rank-1 .podium-card,
        .rank-2 .podium-card,
        .rank-3 .podium-card {
            min-height: auto;
        }
    }

    @media (max-width: 480px) {
        .page-title {
            font-size: 1.75rem;
        }

        .position-badge {
            width: 60px;
            height: 60px;
            font-size: 1.5rem;
        }

        .rank-1 .position-badge {
            width: 75px;
            height: 75px;
            font-size: 1.75rem;
        }
    }
</style>
@endsection