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
            <div class="stat-card-eqv">
                <div class="stat-icon stat-icon-orange">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <div class="stat-value">{{ $inscripcion->miembros->count() }}</div>
                <div class="stat-label">Miembros</div>
            </div>
            <div class="stat-card-eqv">
                <div class="stat-icon stat-icon-dark">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div class="stat-value">{{ $inscripcion->proyecto ? '1' : '0' }}</div>
                <div class="stat-label">Proyecto</div>
            </div>
            <div class="stat-card-eqv">
                <div class="stat-icon stat-icon-gray">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                    </svg>
                </div>
                <div class="stat-value">{{ $inscripcion->equipo->recursos->count() ?? 0 }}</div>
                <div class="stat-label">Recursos</div>
            </div>
            <div class="stat-card-eqv">
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


@endsection