@extends('layouts.app')

@section('content')

<div class="equipo-detail-page py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <!-- Back Link -->
        <a href="{{ route('estudiante.equipo.index') }}" class="back-link">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Volver a Mis Equipos
        </a>

        <!-- Hero Card con imagen -->
        <div class="hero-card">
            <!-- Imagen del equipo -->
            <div class="hero-image-container">
                @if($inscripcion->equipo->ruta_imagen)
                    <img src="{{ asset('storage/' . $inscripcion->equipo->ruta_imagen) }}" alt="{{ $inscripcion->equipo->nombre }}" class="hero-image">
                @else
                    <div class="hero-image-placeholder">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                @endif
            </div>
            
            <!-- Contenido principal -->
            <div class="hero-main-content">
                <div class="hero-content">
                    <div class="hero-info">
                        <div class="hero-badge">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            {{ $inscripcion->miembros->count() }} Miembros
                    </div>
                    <h1 class="hero-title">{{ $inscripcion->equipo->nombre }}</h1>
@if($inscripcion->evento)
    <p class="hero-event">
        Participando en 
        <a href="{{ route('estudiante.eventos.show', $inscripcion->evento) }}">
            {{ $inscripcion->evento->nombre }}
        </a>
    </p>
@else
    <p class="hero-event">
        Equipo sin evento asignado
    </p>
@endif
                </div>
                <div class="hero-actions">
                    @if($esLider)
                        <a href="{{ route('estudiante.equipo.edit') }}" class="hero-btn hero-btn-edit">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Editar Equipo
                        </a>
                    @else
                        <form action="{{ route('estudiante.miembros.leave') }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres abandonar este equipo?');">
                            @csrf
                            <button type="submit" class="hero-btn hero-btn-leave">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                Salir del Equipo
                            </button>
                        </form>
                    @endif
                </div>
            </div>
            </div> {{-- Cierre hero-main-content --}}
        </div>

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon stat-icon-orange">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <div class="stat-value">{{ $inscripcion->miembros->count() }}</div>
                <div class="stat-label">Miembros</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon stat-icon-dark">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div class="stat-value">{{ $inscripcion->proyecto ? '1' : '0' }}</div>
                <div class="stat-label">Proyecto</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon stat-icon-gray">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                    </svg>
                </div>
                <div class="stat-value">{{ $inscripcion->equipo->recursos->count() ?? 0 }}</div>
                <div class="stat-label">Recursos</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon stat-icon-orange">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                </div>
                <div class="stat-value">0/0</div>
                <div class="stat-label">Tareas</div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="content-grid">
            <!-- Left Column -->
            <div class="left-column">
                
                <!-- Description -->
                @if($inscripcion->equipo->descripcion)
                <div class="content-card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Descripción del Equipo
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="description-box">
                            <p>{{ $inscripcion->equipo->descripcion }}</p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Team Members -->
                <div class="content-card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            Miembros del Equipo
                        </h3>
                        <span class="card-badge">{{ $inscripcion->miembros->count() }} total</span>
                    </div>
                    <div class="card-body">
                        <div class="members-list">
                            @foreach($inscripcion->miembros as $miembro)
                                <div class="member-item">
                                    <div class="member-info">
                                        <a href="{{ route('perfil.show', $miembro->user) }}" style="text-decoration: none;">
                                            <div class="member-avatar {{ $miembro->es_lider ? 'member-avatar-leader' : '' }}">
                                                {{ strtoupper(substr($miembro->user->nombre ?? 'U', 0, 1)) }}{{ strtoupper(substr($miembro->user->app_paterno ?? '', 0, 1)) }}
                                            </div>
                                        </a>
                                        <div class="member-details">
                                            <h4>
                                                <a href="{{ route('perfil.show', $miembro->user) }}" style="text-decoration: none; color: inherit; cursor: pointer;">
                                                    {{ $miembro->user->nombre ?? 'Usuario' }} {{ $miembro->user->app_paterno ?? '' }}
                                                </a>
                                                @if($miembro->es_lider)
                                                    <span class="badge-leader">Líder</span>
                                                @endif
                                            </h4>
                                            <p>{{ $miembro->user->estudiante->carrera->nombre ?? 'Carrera no disponible' }}</p>
                                            <span class="badge-role">
                                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                                </svg>
                                                {{ $miembro->rol->nombre ?? 'Sin rol' }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    @if($esLider && !$miembro->es_lider)
                                        <div class="member-controls">
                                            <form action="{{ route('estudiante.miembros.updateRole', $miembro) }}" method="POST" style="display: flex; align-items: center; gap: 0.5rem;">
                                                @csrf
                                                @method('PATCH')
                                                <select name="id_rol_equipo">
                                                    @foreach($roles as $rol)
                                                        <option value="{{ $rol->id_rol_equipo }}" @if($rol->id_rol_equipo == $miembro->id_rol_equipo) selected @endif>
                                                            {{ $rol->nombre }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <button type="submit" class="btn-sm btn-primary">Actualizar</button>
                                            </form>
                                            <form action="{{ route('estudiante.miembros.destroy', $miembro) }}" method="POST" onsubmit="return confirm('¿Eliminar a este miembro del equipo?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-sm btn-danger">
                                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Pending Requests (Leader only) -->
                @if($esLider)
                <div class="content-card" id="solicitudes">
                    <div class="card-header">
                        <h3 class="card-title">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                            Solicitudes Pendientes
                        </h3>
                        <span class="card-badge">{{ $solicitudes->count() }}</span>
                    </div>
                    <div class="card-body">
                        @forelse($solicitudes as $solicitud)
                            <div class="request-item">
                                <div class="request-info">
                                    <h4>{{ $solicitud->estudiante->user->nombre ?? 'Usuario' }} {{ $solicitud->estudiante->user->app_paterno ?? '' }}</h4>
                                    <p>Quiere unirse al equipo</p>
                                </div>
                                <div class="request-actions">
                                    <form action="{{ route('estudiante.solicitudes.accept', $solicitud) }}" method="POST" style="display: flex; align-items: center; gap: 0.5rem;">
                                        @csrf
                                        <select name="id_rol_equipo" required>
                                            <option value="">Rol...</option>
                                            @foreach($roles as $rol)
                                                <option value="{{ $rol->id_rol_equipo }}">{{ $rol->nombre }}</option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="btn-sm btn-success">Aceptar</button>
                                    </form>
                                    <form action="{{ route('estudiante.solicitudes.reject', $solicitud) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-sm btn-danger">Rechazar</button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                </svg>
                                <p>No hay solicitudes pendientes</p>
                            </div>
                        @endforelse
                    </div>
                </div>
                @endif
            </div>

            <!-- Right Column -->
            <div class="right-column">
                
                <!-- Associated Event -->
<div class="content-card">
    <div class="card-header">
        <h3 class="card-title">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            Evento Asociado
        </h3>
    </div>
    <div class="card-body">
        @if($inscripcion->evento)
            <a href="{{ route('estudiante.eventos.show', $inscripcion->evento) }}" class="event-link-card">
                <div class="event-link-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                    </svg>
                </div>
                <div class="event-link-info">
                    <h4>{{ $inscripcion->evento->nombre }}</h4>
                    <p>{{ $inscripcion->evento->fecha_inicio->format('d M, Y') }} - {{ $inscripcion->evento->fecha_fin->format('d M, Y') }}</p>
                </div>
            </a>
        @else
            <div class="empty-state">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <p>Este equipo aún no está registrado en ningún evento</p>
            </div>
        @endif
    </div>
</div>

                <!-- Quick Links -->
                <div class="content-card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            Accesos Rápidos
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="quick-links-grid">
    <a href="{{ route('estudiante.recursos.index', $inscripcion->equipo) }}" class="quick-link quick-link-blue">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z"/>
        </svg>
        <span>Recursos</span>
        <small>{{ $inscripcion->equipo->recursos->count() ?? 0 }} archivos</small>
    </a>
    @if($inscripcion->evento)
        <a href="{{ route('estudiante.eventos.show', $inscripcion->evento) }}" class="quick-link quick-link-green">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
            <span>Ver Evento</span>
            <small>Detalles completos</small>
        </a>
    @else
        <a href="{{ route('estudiante.eventos.index') }}" class="quick-link quick-link-green">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <span>Buscar Eventos</span>
            <small>Registra tu equipo</small>
        </a>
    @endif
</div>
                    </div>
                </div>

                <!-- Team Status -->
                <div class="content-card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Estado del Equipo
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="status-list">
                            <div class="status-item">
                                <span class="status-label">Estado Registro</span>
                                <span class="status-value {{ $inscripcion->status_registro === 'Completo' ? 'status-value-success' : 'status-value-warning' }}">
                                    {{ $inscripcion->status_registro }}
                                </span>
                            </div>
                            <div class="status-item">
                                <span class="status-label">Código de Acceso</span>
                                <span class="status-value-code">
                                    {{ $inscripcion->codigo_acceso_equipo ?? 'N/A' }}
                                </span>
                            </div>
                            @if($inscripcion->puesto_ganador)
                                <div class="status-item status-winner">
                                    <span class="status-label">🏆 Puesto Ganador</span>
                                    <span class="status-value">#{{ $inscripcion->puesto_ganador }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
    
    .equipo-detail-page {
        background: linear-gradient(to bottom, #FFFDF4, #FFEEE2);
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
    }
    
    .equipo-detail-page * {
        font-family: 'Poppins', sans-serif;
    }

    /* Back Link Neuromórfico */
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
        padding: 0.5rem 1rem;
        background: rgba(255, 253, 244, 0.9);
        border-radius: 10px;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
    }
    
    .back-link:hover {
        color: #4f46e5;
        box-shadow: 6px 6px 12px #e6d5c9, -6px -6px 12px #ffffff;
        transform: translateY(-2px);
        color: #d98a2c;
        transform: translateX(-3px);
        box-shadow: 6px 6px 12px #e6d5c9, -6px -6px 12px #ffffff;
    }
    
    .back-link svg {
        width: 1rem;
        height: 1rem;
        margin-right: 0.5rem;
    }

    /* Hero Section con imagen */
    .hero-card {
        background: linear-gradient(135deg, #1a1a1a 0%, #2c2c2c 50%, #3d3d3d 100%);
        border-radius: 24px;
        padding: 0;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        display: flex;
        min-height: 220px;
    }

    .hero-image-container {
        width: 280px;
        min-width: 280px;
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
        width: 80px;
        height: 80px;
        color: rgba(255, 255, 255, 0.5);
    }

    .hero-main-content {
        flex: 1;
        padding: 2.5rem;
        position: relative;
    }

    .hero-card::before {
        content: '';
        position: absolute;
        top: -100px;
        right: -100px;
        width: 350px;
        height: 350px;
        background: radial-gradient(circle, rgba(232, 154, 60, 0.15) 0%, transparent 70%);
        pointer-events: none;
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
    }

    .hero-content {
        position: relative;
        z-index: 1;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .hero-info {
        flex: 1;
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: linear-gradient(135deg, #e89a3c, #f5a847);
        color: white;
        padding: 0.4rem 1rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }

    .hero-badge svg {
        width: 16px;
        height: 16px;
    }

    .hero-title {
        color: #ffffff;
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
    }

    .hero-event {
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.95rem;
    }

    .hero-event a {
        color: #e89a3c;
        text-decoration: none;
        font-weight: 500;
    }

    .hero-event a:hover {
        text-decoration: underline;
    }

    .hero-actions {
        display: flex;
        gap: 0.75rem;
    }

    .hero-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.25rem;
        border-radius: 12px;
        font-size: 0.85rem;
        font-weight: 600;
        border: none;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .hero-btn svg {
        width: 18px;
        height: 18px;
    }

    .hero-btn-edit {
        background: #ffffff;
        color: #1a1a1a;
    }

    .hero-btn-edit:hover {
        background: #e89a3c;
        color: #ffffff;
        transform: translateY(-2px);
    }

    .hero-btn-leave {
        background: rgba(239, 68, 68, 0.9);
        color: #ffffff;
    }

    .hero-btn-leave:hover {
        background: #dc2626;
        transform: translateY(-2px);
    }

    /* Stats Grid Neuromórficas */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.25rem;
        margin-bottom: 2rem;
    }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    .stat-card {
        background: #FFEEE2;
        border-radius: 16px;
        padding: 1.5rem;
        text-align: center;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
        border: none;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 12px 12px 24px #e6d5c9, -12px -12px 24px #ffffff;
    }

    .stat-icon {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
    }

    .stat-icon svg {
        width: 26px;
        height: 26px;
    }

    .stat-icon-orange {
        background: linear-gradient(135deg, rgba(232, 154, 60, 0.2), rgba(232, 154, 60, 0.1));
        color: #e89a3c;
    }

    .stat-icon-dark {
        background: linear-gradient(135deg, rgba(44, 44, 44, 0.15), rgba(44, 44, 44, 0.08));
        color: #2c2c2c;
    }

    .stat-icon-gray {
        background: linear-gradient(135deg, rgba(107, 114, 128, 0.15), rgba(107, 114, 128, 0.08));
        color: #6b7280;
    }

    .stat-value {
        font-size: 1.75rem;
        font-weight: 800;
        color: #2c2c2c;
        margin-bottom: 0.25rem;
    }

    .stat-label {
        font-size: 0.75rem;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    /* Main Content Grid */
    .content-grid {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 1.5rem;
    }

    @media (max-width: 1024px) {
        .content-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Content Cards Neuromórficas */
    .content-card {
        background: #FFEEE2;
        border-radius: 20px;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
        border: none;
        overflow: hidden;
        margin-bottom: 1.5rem;
    }

    .card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid rgba(232, 154, 60, 0.1);
    }

    .card-title {
        font-size: 1rem;
        font-weight: 700;
        color: #2c2c2c;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin: 0;
    }

    .card-title svg {
        width: 20px;
        height: 20px;
        color: #e89a3c;
    }

    .card-badge {
        background: rgba(255, 255, 255, 0.5);
        color: #6b7280;
        padding: 0.35rem 0.85rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        box-shadow: inset 2px 2px 4px #e6d5c9, inset -2px -2px 4px #ffffff;
    }

    .card-body {
        padding: 1.5rem;
        background: #FFEEE2;
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
        justify-content: space-between;
        padding: 1rem 1.25rem;
        background: rgba(255, 255, 255, 0.4);
        border-radius: 14px;
        transition: all 0.3s ease;
        box-shadow: inset 3px 3px 6px #e6d5c9, inset -3px -3px 6px #ffffff;
    }

    .member-item:hover {
        background: rgba(255, 255, 255, 0.6);
    }

    .member-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .member-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: linear-gradient(135deg, #e89a3c, #f5a847);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1rem;
        border: 3px solid #FFEEE2;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
    }

    .member-avatar-leader {
        background: linear-gradient(135deg, #2c2c2c, #1a1a1a);
        border-color: #e89a3c;
    }

    .member-details h4 {
        font-size: 0.95rem;
        font-weight: 600;
        color: #2c2c2c;
        margin: 0 0 0.25rem 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .member-details p {
        font-size: 0.8rem;
        color: #6b7280;
        margin: 0 0 0.35rem 0;
    }

    .badge-leader {
        background: linear-gradient(135deg, rgba(254, 243, 199, 0.9), rgba(253, 230, 138, 0.9));
        color: #92400e;
        padding: 0.15rem 0.5rem;
        border-radius: 20px;
        font-size: 0.65rem;
        font-weight: 700;
        text-transform: uppercase;
        box-shadow: inset 2px 2px 4px rgba(245, 158, 11, 0.2);
    }

    .badge-role {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        background: rgba(255, 255, 255, 0.5);
        color: #b37a2e;
        padding: 0.25rem 0.6rem;
        border-radius: 6px;
        font-size: 0.7rem;
        font-weight: 500;
        box-shadow: inset 2px 2px 4px #e6d5c9, inset -2px -2px 4px #ffffff;
    }

    .badge-role svg {
        width: 12px;
        height: 12px;
        color: #e89a3c;
    }

    .member-controls {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .member-controls select {
        background: rgba(255, 255, 255, 0.5);
        border: none;
        padding: 0.4rem 0.6rem;
        border-radius: 8px;
        font-size: 0.75rem;
        color: #374151;
        cursor: pointer;
        box-shadow: inset 2px 2px 4px #e6d5c9, inset -2px -2px 4px #ffffff;
    }

    .btn-sm {
        padding: 0.4rem 0.8rem;
        border-radius: 8px;
        font-size: 0.7rem;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }

    .btn-sm svg {
        width: 14px;
        height: 14px;
    }

    .btn-primary {
        background: linear-gradient(135deg, #2c2c2c, #1a1a1a);
        color: #ffffff;
        box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.2);
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #e89a3c, #f5a847);
        box-shadow: 6px 6px 12px rgba(232, 154, 60, 0.3);
    }

    .btn-danger {
        background: linear-gradient(135deg, rgba(254, 226, 226, 0.9), rgba(252, 211, 211, 0.9));
        color: #dc2626;
        box-shadow: 4px 4px 8px rgba(239, 68, 68, 0.2);
    }

    .btn-danger:hover {
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        color: #ffffff;
        box-shadow: 6px 6px 12px rgba(220, 38, 38, 0.3);
    }

    .btn-success {
        background: linear-gradient(135deg, rgba(209, 250, 229, 0.9), rgba(167, 243, 208, 0.9));
        color: #059669;
        box-shadow: 4px 4px 8px rgba(16, 185, 129, 0.2);
    }

    .btn-success:hover {
        background: linear-gradient(135deg, #059669, #047857);
        color: #ffffff;
        box-shadow: 6px 6px 12px rgba(5, 150, 105, 0.3);
    }

    /* Requests Section */
    .request-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem 1.25rem;
        background: rgba(255, 255, 255, 0.4);
        border-radius: 14px;
        border-left: 4px solid #e89a3c;
        margin-bottom: 0.75rem;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
    }

    .request-info h4 {
        font-size: 0.9rem;
        font-weight: 600;
        color: #2c2c2c;
        margin: 0 0 0.25rem 0;
    }

    .request-info p {
        font-size: 0.8rem;
        color: #6b7280;
        margin: 0;
    }

    .request-actions {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .request-actions select {
        background: rgba(255, 255, 255, 0.5);
        border: none;
        padding: 0.4rem 0.6rem;
        border-radius: 8px;
        font-size: 0.75rem;
        box-shadow: inset 2px 2px 4px #e6d5c9, inset -2px -2px 4px #ffffff;
    }

    /* Event Link Card */
    .event-link-card {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.25rem;
        background: rgba(255, 255, 255, 0.4);
        border-radius: 14px;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: inset 3px 3px 6px #e6d5c9, inset -3px -3px 6px #ffffff;
    }

    .event-link-card:hover {
        background: rgba(255, 255, 255, 0.6);
        transform: translateX(4px);
    }

    .event-link-icon {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        background: linear-gradient(135deg, #e89a3c, #f5a847);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        box-shadow: 4px 4px 8px rgba(232, 154, 60, 0.3);
    }

    .event-link-icon svg {
        width: 26px;
        height: 26px;
    }

    .event-link-info h4 {
        font-size: 0.95rem;
        font-weight: 600;
        color: #2c2c2c;
        margin: 0 0 0.25rem 0;
    }

    .event-link-info p {
        font-size: 0.8rem;
        color: #6b7280;
        margin: 0;
    }

    /* Status Section */
    .status-list {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .status-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.85rem 1rem;
        background: rgba(255, 255, 255, 0.4);
        border-radius: 10px;
        box-shadow: inset 2px 2px 4px #e6d5c9, inset -2px -2px 4px #ffffff;
    }

    .status-label {
        font-size: 0.85rem;
        color: #6b7280;
    }

    .status-value {
        font-size: 0.85rem;
        font-weight: 600;
        color: #2c2c2c;
    }

    .status-value-success {
        color: #059669;
    }

    .status-value-warning {
        color: #d97706;
    }

    .status-value-code {
        font-family: 'Courier New', monospace;
        background: linear-gradient(135deg, #2c2c2c, #1a1a1a);
        color: #f2b987ff;
        padding: 0.25rem 0.6rem;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: bold;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
    }

    .status-winner {
        background: linear-gradient(135deg, rgba(254, 243, 199, 0.9), rgba(253, 230, 138, 0.9));
        border: 2px solid #f59e0b;
        box-shadow: 4px 4px 8px rgba(245, 158, 11, 0.3);
    }

    .status-winner .status-label {
        color: #92400e;
        font-weight: 600;
    }

    .status-winner .status-value {
        color: #92400e;
        font-weight: 800;
    }

    /* Quick Links */
    .quick-links-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.75rem;
    }

    .quick-link {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 1.25rem;
        border-radius: 14px;
        text-decoration: none;
        transition: all 0.3s ease;
        text-align: center;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
    }

    .quick-link:hover {
        transform: translateY(-4px);
        box-shadow: 12px 12px 24px #e6d5c9, -12px -12px 24px #ffffff;
    }

    .quick-link svg {
        width: 28px;
        height: 28px;
        margin-bottom: 0.5rem;
    }

    .quick-link span {
        font-size: 0.8rem;
        font-weight: 600;
    }

    .quick-link small {
        font-size: 0.7rem;
        opacity: 0.8;
        margin-top: 0.25rem;
    }

    .quick-link-blue {
        background: linear-gradient(135deg, rgba(191, 219, 254, 0.8), rgba(147, 197, 253, 0.8));
        color: #1e40af;
    }

    .quick-link-green {
        background: linear-gradient(135deg, rgba(209, 250, 229, 0.8), rgba(167, 243, 208, 0.8));
        color: #065f46;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 2rem;
    }

    .empty-state svg {
        width: 48px;
        height: 48px;
        color: #d1d5db;
        margin-bottom: 0.75rem;
        opacity: 0.5;
    }

    .empty-state p {
        color: #9ca3af;
        font-size: 0.875rem;
        margin: 0;
    }

    /* Description Box */
    .description-box {
        background: rgba(255, 255, 255, 0.4);
        border-radius: 12px;
        padding: 1.25rem;
        box-shadow: inset 3px 3px 6px #e6d5c9, inset -3px -3px 6px #ffffff;
    }

    .description-box p {
        font-size: 0.875rem;
        color: #4b5563;
        line-height: 1.7;
        margin: 0;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .hero-content {
            flex-direction: column;
            gap: 1.5rem;
        }

        .hero-actions {
            width: 100%;
            justify-content: center;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>
@endsection