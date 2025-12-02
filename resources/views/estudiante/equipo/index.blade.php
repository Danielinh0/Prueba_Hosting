@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
    
    /* Fondo degradado */
    .mis-equipos-page {
        background: linear-gradient(to bottom, #FFFDF4, #FFEEE2);
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
    }
    
    /* Textos */
    .mis-equipos-page h2,
    .mis-equipos-page h3 {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
    }
    
    .mis-equipos-page p {
        font-family: 'Poppins', sans-serif;
        color: #6b6b6b;
    }
    
    /* Team card */
    .team-card {
        background: #FFEEE2;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
        transition: all 0.3s ease;
    }
    
    .team-card:hover {
        box-shadow: 12px 12px 24px #e6d5c9, -12px -12px 24px #ffffff;
        transform: translateY(-5px);
    }
    
    .team-card img {
        height: 12rem;
        width: 100%;
        object-fit: cover;
    }
    
    /* Team header */
    .team-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
    }
    
    .team-name {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
        font-weight: 700;
        font-size: 1.25rem;
    }
    
    /* Badges */
    .badge-lider {
        font-family: 'Poppins', sans-serif;
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.5rem;
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        color: #92400e;
        font-size: 0.75rem;
        font-weight: 700;
        border-radius: 20px;
        margin-top: 0.25rem;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .badge-status {
        font-family: 'Poppins', sans-serif;
        padding: 0.25rem 0.75rem;
        font-size: 0.75rem;
        font-weight: 600;
        border-radius: 20px;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .badge-status-complete {
        background: rgba(209, 250, 229, 0.8);
        color: #065f46;
    }
    
    .badge-status-incomplete {
        background: rgba(254, 240, 138, 0.8);
        color: #854d0e;
    }
    
    /* Event box */
    .event-box {
        margin-bottom: 1rem;
        padding: 0.75rem;
        border-radius: 15px;
        box-shadow: inset 2px 2px 4px #e6d5c9, inset -2px -2px 4px #ffffff;
    }
    
    .event-box-active {
        background: linear-gradient(135deg, rgba(224, 231, 255, 0.5), rgba(199, 210, 254, 0.5));
    }
    
    .event-box-inactive {
        background: rgba(249, 250, 251, 0.5);
    }
    
    .event-box p {
        font-size: 0.875rem;
        margin-bottom: 0.25rem;
    }
    
    .event-box strong {
        color: #2c2c2c;
    }
    
    .event-box-active p {
        color: #1e3a8a;
    }
    
    .event-box-inactive p {
        color: #6b6b6b;
    }
    
    .event-link {
        font-size: 0.75rem;
        color: #e89a3c;
        font-weight: 600;
        margin-top: 0.5rem;
        display: inline-block;
        transition: all 0.2s ease;
    }
    
    .event-link:hover {
        color: #d98a2c;
    }
    
    /* Event status badge */
    .event-status-badge {
        font-family: 'Poppins', sans-serif;
        display: inline-block;
        margin-top: 0.5rem;
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
        border-radius: 20px;
        font-weight: 600;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .event-status-activo {
        background: rgba(209, 250, 229, 0.8);
        color: #065f46;
    }
    
    .event-status-cerrado {
        background: rgba(254, 240, 138, 0.8);
        color: #854d0e;
    }
    
    .event-status-proximo {
        background: rgba(191, 219, 254, 0.8);
        color: #1e40af;
    }
    
    /* Description */
    .team-description {
        font-size: 0.875rem;
        color: #6b6b6b;
        margin-bottom: 1rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    /* Members info */
    .members-info {
        margin-bottom: 1rem;
    }
    
    .members-info p {
        font-size: 0.875rem;
        color: #2c2c2c;
    }
    
    .members-info strong {
        font-weight: 600;
    }
    
    /* Pending requests */
    .pending-requests {
        margin-bottom: 1rem;
        padding: 0.5rem;
        background: linear-gradient(135deg, rgba(219, 234, 254, 0.5), rgba(191, 219, 254, 0.5));
        border-left: 4px solid #3b82f6;
        border-radius: 0 15px 15px 0;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .pending-requests p {
        font-size: 0.75rem;
        color: #1e40af;
        font-weight: 600;
    }
    
    /* View details button */
    .btn-view-details {
        font-family: 'Poppins', sans-serif;
        display: block;
        width: 100%;
        text-align: center;
        padding: 0.5rem 1rem;
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: #ffffff;
        border-radius: 0.75rem;
        font-weight: 600;
        box-shadow: 4px 4px 8px rgba(99, 102, 241, 0.3);
        transition: all 0.3s ease;
        text-decoration: none;
    }
    
    .btn-view-details:hover {
        box-shadow: 6px 6px 12px rgba(99, 102, 241, 0.4);
        transform: translateY(-2px);
    }
    
    /* Create team button */
    .btn-create-team {
        font-family: 'Poppins', sans-serif;
        display: inline-flex;
        align-items: center;
        padding: 0.75rem 1.5rem;
        background: linear-gradient(135deg, #10b981, #059669);
        color: #ffffff;
        border-radius: 0.75rem;
        font-weight: 600;
        box-shadow: 4px 4px 8px rgba(16, 185, 129, 0.3);
        transition: all 0.3s ease;
        text-decoration: none;
    }
    
    .btn-create-team:hover {
        box-shadow: 6px 6px 12px rgba(16, 185, 129, 0.4);
        transform: translateY(-2px);
    }
    
    .btn-create-team svg {
        margin-right: 0.5rem;
    }
</style>

<div class="mis-equipos-page py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="font-semibold text-2xl mb-6">
            Mis Equipos
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($equipos as $equipoData)
                @php
                    $inscripcion = $equipoData['inscripcion'];
                    $esLider = $equipoData['esLider'];
                    $solicitudes = $equipoData['solicitudes'];
                    $roles = $equipoData['roles'];
                @endphp

                <div class="team-card">
                    @if ($inscripcion->equipo->ruta_imagen)
                        <img src="{{ asset('storage/' . $inscripcion->equipo->ruta_imagen) }}" alt="Imagen del equipo">
                    @endif
                    
                    <div class="p-6">
                        {{-- Header del Equipo --}}
                        <div class="team-header">
                            <div>
                                <h3 class="team-name">{{ $inscripcion->equipo->nombre }}</h3>
                                @if($esLider)
                                    <span class="badge-lider">
                                        ⭐ Líder
                                    </span>
                                @endif
                            </div>
                            <span class="badge-status
                                @if($inscripcion->status_registro === 'Completo') badge-status-complete
                                @else badge-status-incomplete @endif">
                                {{ $inscripcion->status_registro }}
                            </span>
                        </div>

                        {{-- Evento --}}
                        <div class="event-box {{ $inscripcion->evento ? 'event-box-active' : 'event-box-inactive' }}">
                            @if($inscripcion->evento)
                                @if($inscripcion->evento->trashed())
                                    {{-- Evento Eliminado --}}
                                    <p>
                                        <strong>Evento:</strong> {{ $inscripcion->evento->nombre }} <span style="color: #dc2626; font-weight: 600;">(Eliminado)</span>
                                    </p>
                                    <p style="font-size: 0.75rem; margin-top: 0.25rem; color: #6b6b6b;">
                                        Este evento fue eliminado. Tu equipo y sus datos se conservan.
                                    </p>
                                @else
                                    {{-- Evento Normal --}}
                                    <p>
                                        <strong>Evento:</strong> {{ $inscripcion->evento->nombre }}
                                    </p>
                                    <p style="font-size: 0.75rem; margin-top: 0.25rem;">
                                        {{ $inscripcion->evento->fecha_inicio->format('d/m/Y') }} - {{ $inscripcion->evento->fecha_fin->format('d/m/Y') }}
                                    </p>
                                    <span class="event-status-badge
                                        @if($inscripcion->evento->estado === 'Activo') event-status-activo
                                        @elseif($inscripcion->evento->estado === 'En Progreso') event-status-activo
                                        @elseif($inscripcion->evento->estado === 'Cerrado') event-status-cerrado
                                        @else event-status-proximo @endif">
                                        {{ $inscripcion->evento->estado }}
                                    </span>
                                @endif
                            @else
                                <p>
                                    <strong>Estado:</strong> Equipo sin evento
                                </p>
                                <p style="font-size: 0.75rem; margin-top: 0.25rem;">
                                    Este equipo aún no está registrado en ningún evento
                                </p>
                                <a href="{{ route('estudiante.eventos.index') }}" class="event-link">
                                    Registrar a un evento →
                                </a>
                            @endif
                        </div>

                        {{-- Descripción --}}
                        @if($inscripcion->equipo->descripcion)
                            <p class="team-description">
                                {{ $inscripcion->equipo->descripcion }}
                            </p>
                        @endif

                        {{-- Miembros --}}
                        <div class="members-info">
                            <p>
                                <strong>Miembros:</strong> {{ $inscripcion->miembros->count() }}
                            </p>
                        </div>

                        {{-- Solicitudes Pendientes (solo para líderes) --}}
                        @if($esLider && $solicitudes->isNotEmpty())
                            <div class="pending-requests">
                                <p>
                                    {{ $solicitudes->count() }} solicitud(es) pendiente(s)
                                </p>
                            </div>
                        @endif

                        {{-- Botón Ver Detalles --}}
                        <a href="{{ route('estudiante.equipo.show-detalle', $inscripcion) }}" 
                           class="btn-view-details">
                            Ver Detalles →
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Botón para crear equipo --}}
        <div class="mt-8 text-center">
            <a href="{{ route('estudiante.equipos.create-sin-evento') }}" 
               class="btn-create-team">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Crear Nuevo Equipo
            </a>
        </div>
    </div>
</div>
@endsection