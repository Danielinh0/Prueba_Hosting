@extends('layouts.app')

@section('content')

<div class="equipo-publico-page py-12">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('estudiante.eventos.equipos.index', $evento) }}" class="back-link">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver a Equipos del Evento
        </a>

        <!-- Hero Card -->
        <div class="hero-card">
            <div class="hero-image-container">
                @if ($inscripcion->equipo->ruta_imagen)
                    <img src="{{ asset('storage/' . $inscripcion->equipo->ruta_imagen) }}" alt="{{ $inscripcion->equipo->nombre }}" class="hero-image">
                @else
                    <div class="hero-image-placeholder">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                @endif
            </div>
            <div class="hero-content">
                <div class="hero-badge">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    {{ $inscripcion->miembros->count() }} Miembros
                </div>
                <h1 class="hero-title">{{ $inscripcion->equipo->nombre }}</h1>
                <a href="{{ route('estudiante.eventos.show', $inscripcion->evento) }}" class="hero-event-link">
                    Participando en <span>{{ $inscripcion->evento->nombre }}</span>
                </a>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-value">{{ $inscripcion->miembros->count() }}</div>
                <div class="stat-label">Miembros Actuales</div>
            </div>
            <?php $miembrosCount = $inscripcion->miembros->count(); ?>
            <div class="stat-card {{ $miembrosCount >= 5 ? 'status-complete' : 'status-looking' }}">
                <div class="stat-value">
                    @if($miembrosCount >= 5)
                        ✓
                    @else
                        🔍
                    @endif
                </div>
                <div class="stat-label">
                    {{ $miembrosCount >= 5 ? 'Equipo Completo' : (5 - $miembrosCount) . ' espacio' . ((5 - $miembrosCount) != 1 ? 's' : '') . ' disponible' }}
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ $inscripcion->evento->estado }}</div>
                <div class="stat-label">Estado del Evento</div>
            </div>
        </div>

        <div class="content-grid">
            <!-- Left: Members -->
            <div>
                <div class="content-card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            Miembros del Equipo
                        </h3>
                    </div>
                    <div class="members-list">
                        @foreach($inscripcion->miembros as $miembro)
                            <div class="member-item">
                                <a href="{{ route('perfil.show', $miembro->user) }}" class="member-avatar {{ $miembro->es_lider ? 'member-avatar-leader' : '' }}">
                                    {{ strtoupper(substr($miembro->user->nombre ?? 'U', 0, 1)) }}{{ strtoupper(substr($miembro->user->app_paterno ?? '', 0, 1)) }}
                                </a>
                                <div class="member-details">
                                    <div>
                                        <a href="{{ route('perfil.show', $miembro->user) }}" class="member-name">
                                            {{ $miembro->user->nombre }} {{ $miembro->user->app_paterno }}
                                        </a>
                                        @if($miembro->es_lider)
                                            <span class="badge-leader">👑 Líder</span>
                                        @endif
                                    </div>
                                    <p class="member-career">{{ $miembro->user->estudiante->carrera->nombre ?? 'Carrera no disponible' }}</p>
                                    <span class="badge-role">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                        </svg>
                                        {{ $miembro->rol->nombre ?? 'Sin rol' }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Right: Description & Actions -->
            <div>
                @if($inscripcion->equipo->descripcion)
                <div class="content-card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Sobre el Equipo
                        </h3>
                    </div>
                    <div class="description-box">
                        <p>{{ $inscripcion->equipo->descripcion }}</p>
                    </div>
                </div>
                @endif

                <!-- Action Section -->
                <div class="content-card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                            Unirse al Equipo
                        </h3>
                    </div>
                    
                    @if (in_array($evento->estado, ['Activo', 'En Progreso']) && $inscripcion->status_registro !== 'Completo')
                        @if ($miInscripcionDeEquipoId)
                            @if ($miInscripcionDeEquipoId === $inscripcion->equipo->id_equipo)
                                <div class="alert-box alert-success">
                                    <p class="font-semibold">✓ Ya eres miembro de este equipo</p>
                                    <a href="{{ route('estudiante.equipo.index') }}">
                                        Ir a Mi Equipo →
                                    </a>
                                </div>
                            @else
                                <div class="alert-box alert-warning">
                                    <p class="font-semibold">Ya perteneces a otro equipo</p>
                                    <p style="font-size: 0.85rem; margin-top: 0.25rem;">No puedes estar en dos equipos simultáneamente.</p>
                                </div>
                            @endif
                        @else
                            @if ($solicitudActual)
                                @if ($solicitudActual->status === 'pendiente')
                                    <div class="alert-box alert-info">
                                        <p class="font-semibold">⏳ Solicitud enviada</p>
                                        <p style="font-size: 0.85rem; margin-top: 0.25rem;">El líder está revisando tu solicitud.</p>
                                    </div>
                                @elseif ($solicitudActual->status === 'aceptada')
                                    <div class="alert-box alert-success">
                                        <p class="font-semibold">✓ Solicitud aceptada</p>
                                        <p style="font-size: 0.85rem; margin-top: 0.25rem;">Ya eres parte de este equipo.</p>
                                    </div>
                                @elseif ($solicitudActual->status === 'rechazada')
                                    <div class="alert-box alert-error">
                                        <p class="font-semibold">Tu solicitud fue rechazada</p>
                                        <p style="font-size: 0.85rem; margin-top: 0.25rem;">Puedes volver a intentarlo.</p>
                                    </div>
                                    <form action="{{ route('estudiante.solicitudes.store', $inscripcion->equipo) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-request">
                                            Volver a Solicitar
                                        </button>
                                    </form>
                                @endif
                            @else
                                <form action="{{ route('estudiante.solicitudes.store', $inscripcion->equipo) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-request">
                                        Solicitar Unirme a este Equipo
                                    </button>
                                </form>
                                <p class="help-text">
                                    El líder recibirá tu solicitud y decidirá si aceptarte.
                                </p>
                            @endif
                        @endif
                    @elseif ($inscripcion->miembros->count() >= 5)
                        <div class="alert-box alert-gray">
                            <p class="font-semibold">Equipo completo</p>
                            <p style="font-size: 0.85rem; margin-top: 0.25rem;">No hay espacios disponibles.</p>
                        </div>
                    @else
                        <div class="alert-box alert-gray">
                            <p class="font-semibold">Inscripciones no disponibles</p>
                            <p style="font-size: 0.85rem; margin-top: 0.25rem;">El evento no está activo o el equipo está completo.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection