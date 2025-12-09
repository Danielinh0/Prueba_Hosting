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


<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
    
    .equipo-publico-page {
        background: linear-gradient(to bottom, #FFFDF4, #FFEEE2);
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
    }
    
    .equipo-publico-page * {
        font-family: 'Poppins', sans-serif;
    }

    /* Back Link */
    .back-link {
        display: inline-flex;
        align-items: center;
        color: #2c2c2c;
        font-size: 0.875rem;
        font-weight: 500;
        margin-bottom: 1.5rem;
        padding: 0.5rem 1rem;
        background: rgba(255, 253, 244, 0.9);
        border-radius: 12px;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        transition: all 0.3s ease;
        text-decoration: none;
    }
    
    .back-link:hover {
        color: #e89a3c;
        transform: translateX(-3px);
        box-shadow: 6px 6px 12px #e6d5c9, -6px -6px 12px #ffffff;
    }
    
    .back-link svg {
        width: 1rem;
        height: 1rem;
        margin-right: 0.5rem;
    }

    /* Hero Section */
    .hero-card {
        background: linear-gradient(135deg, #1a1a1a 0%, #2c2c2c 50%, #3d3d3d 100%);
        border-radius: 24px;
        padding: 0;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        display: flex;
        min-height: 200px;
    }

    .hero-image-container {
        width: 220px;
        min-width: 220px;
        position: relative;
        overflow: hidden;
    }

    .hero-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .hero-card:hover .hero-image {
        transform: scale(1.05);
    }

    .hero-image-placeholder {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #e89a3c 0%, #f5a847 100%);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .hero-image-placeholder svg {
        width: 60px;
        height: 60px;
        color: rgba(255, 255, 255, 0.5);
    }

    .hero-content {
        flex: 1;
        padding: 2rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.35rem 0.75rem;
        background: rgba(232, 154, 60, 0.2);
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        color: #e89a3c;
        width: fit-content;
        margin-bottom: 0.75rem;
    }

    .hero-badge svg {
        width: 0.875rem;
        height: 0.875rem;
    }

    .hero-title {
        color: #ffffff;
        font-size: 1.75rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
    }

    .hero-event-link {
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.875rem;
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .hero-event-link:hover {
        color: #e89a3c;
    }

    .hero-event-link span {
        color: #e89a3c;
        font-weight: 600;
    }

    /* Status Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: #FFEEE2;
        border-radius: 16px;
        padding: 1.25rem;
        box-shadow: 6px 6px 12px #e6d5c9, -6px -6px 12px #ffffff;
        text-align: center;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
    }

    .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2c2c2c;
    }

    .stat-label {
        font-size: 0.75rem;
        color: #6b6b6b;
        margin-top: 0.25rem;
    }

    .stat-card.status-complete {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
    }

    .stat-card.status-complete .stat-value {
        color: #065f46;
    }

    .stat-card.status-looking {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
    }

    .stat-card.status-looking .stat-value {
        color: #92400e;
    }

    /* Content Cards */
    .content-card {
        background: #FFEEE2;
        border-radius: 20px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
    }

    .card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid rgba(232, 154, 60, 0.2);
    }

    .card-title {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 1rem;
        font-weight: 600;
        color: #2c2c2c;
    }

    .card-title svg {
        width: 1.25rem;
        height: 1.25rem;
        color: #e89a3c;
    }

    /* Members List */
    .members-list {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .member-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: rgba(255, 255, 255, 0.5);
        border-radius: 14px;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        transition: all 0.3s ease;
    }

    .member-item:hover {
        transform: translateY(-2px);
        box-shadow: 6px 6px 12px #e6d5c9, -6px -6px 12px #ffffff;
    }

    .member-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, #e89a3c, #f5a847);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        font-weight: 700;
        color: white;
        box-shadow: 3px 3px 6px rgba(0, 0, 0, 0.15);
        flex-shrink: 0;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .member-avatar:hover {
        transform: scale(1.05);
    }

    .member-avatar-leader {
        background: linear-gradient(135deg, #2c2c2c, #1a1a1a);
        box-shadow: 0 0 0 3px #e89a3c;
    }

    .member-photo {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #e89a3c;
        box-shadow: 3px 3px 6px rgba(0, 0, 0, 0.15);
        flex-shrink: 0;
        transition: all 0.3s ease;
    }

    .member-photo:hover {
        transform: scale(1.05);
    }

    .member-details {
        flex: 1;
    }

    .member-name {
        font-weight: 600;
        color: #2c2c2c;
        font-size: 0.95rem;
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .member-name:hover {
        color: #e89a3c;
    }

    .member-career {
        font-size: 0.8rem;
        color: #6b6b6b;
        margin-top: 0.125rem;
    }

    .badge-leader {
        display: inline-block;
        padding: 0.125rem 0.5rem;
        border-radius: 10px;
        font-size: 0.65rem;
        font-weight: 700;
        text-transform: uppercase;
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        color: #92400e;
        margin-left: 0.5rem;
    }

    .badge-role {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        padding: 0.2rem 0.5rem;
        border-radius: 8px;
        font-size: 0.7rem;
        font-weight: 500;
        background: rgba(224, 231, 255, 0.8);
        color: #3730a3;
        margin-top: 0.25rem;
    }

    .badge-role svg {
        width: 0.7rem;
        height: 0.7rem;
    }

    /* Description Box */
    .description-box {
        padding: 1rem;
        background: rgba(255, 255, 255, 0.4);
        border-radius: 12px;
        box-shadow: inset 2px 2px 4px #e6d5c9, inset -2px -2px 4px #ffffff;
    }

    .description-box p {
        font-size: 0.875rem;
        color: #6b6b6b;
        line-height: 1.6;
    }

    /* Alert Boxes */
    .alert-box {
        padding: 1rem 1.25rem;
        border-radius: 14px;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        margin-bottom: 1rem;
    }

    .alert-success {
        background: linear-gradient(135deg, rgba(209, 250, 229, 0.7), rgba(167, 243, 208, 0.7));
        border-left: 4px solid #10b981;
    }

    .alert-success p { color: #065f46; }
    .alert-success .font-semibold { font-weight: 700; }
    .alert-success a {
        color: #047857;
        font-size: 0.875rem;
        margin-top: 0.25rem;
        display: inline-block;
        transition: all 0.2s ease;
    }
    .alert-success a:hover {
        color: #065f46;
        text-decoration: underline;
    }

    .alert-warning {
        background: linear-gradient(135deg, rgba(254, 243, 199, 0.7), rgba(254, 240, 138, 0.7));
        border-left: 4px solid #f59e0b;
    }
    .alert-warning p { color: #92400e; }

    .alert-info {
        background: linear-gradient(135deg, rgba(219, 234, 254, 0.7), rgba(191, 219, 254, 0.7));
        border-left: 4px solid #3b82f6;
    }
    .alert-info p { color: #1e40af; }

    .alert-error {
        background: linear-gradient(135deg, rgba(254, 226, 226, 0.7), rgba(252, 165, 165, 0.7));
        border-left: 4px solid #ef4444;
    }
    .alert-error p { color: #991b1b; }

    .alert-gray {
        background: linear-gradient(135deg, rgba(243, 244, 246, 0.7), rgba(229, 231, 235, 0.7));
        border-left: 4px solid #6b7280;
    }
    .alert-gray p { color: #374151; }

    /* Request Button */
    .btn-request {
        width: 100%;
        padding: 0.875rem 1.5rem;
        background: linear-gradient(135deg, #2c2c2c, #1a1a1a);
        color: #ffffff;
        border-radius: 14px;
        font-weight: 600;
        box-shadow: 6px 6px 12px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        font-size: 0.95rem;
    }

    .btn-request:hover {
        box-shadow: 8px 8px 16px rgba(0, 0, 0, 0.3);
        transform: translateY(-3px);
    }

    .help-text {
        font-size: 0.75rem;
        color: #9ca3af;
        text-align: center;
        margin-top: 0.75rem;
    }

    /* Grid Layout */
    .content-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }

    @media (max-width: 768px) {
        .hero-card {
            flex-direction: column;
        }
        .hero-image-container {
            width: 100%;
            min-width: 100%;
            height: 180px;
        }
        .stats-grid {
            grid-template-columns: 1fr;
        }
        .content-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection