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

@endsection