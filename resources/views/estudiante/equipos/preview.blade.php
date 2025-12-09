@extends('layouts.app')

@section('content')

<div class="preview-container">
    <div class="preview-header">
        <a href="{{ route('estudiante.dashboard') }}" class="back-btn">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Volver al Dashboard
        </a>
        <h1 style="font-size: 2rem; font-weight: 700; color: #2c2c2c;">Previsualización del Equipo</h1>
    </div>

    <div class="main-content">
        <!-- Información del Equipo -->
        <div class="team-info-card">
            <h2 class="card-title">
                <div class="card-icon">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                {{ $equipo->nombre }}
            </h2>

            <div class="info-row">
                <svg class="info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
                <span class="info-label">Código:</span>
                <span class="info-value">{{ $equipo->codigo }}</span>
            </div>

            @if($inscripcionActiva)
            <div class="info-row">
                <svg class="info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span class="info-label">Evento:</span>
                <span class="info-value">{{ $inscripcionActiva->evento->nombre }}</span>
            </div>
            @endif

            <div class="info-row">
                <svg class="info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span class="info-label">Miembros:</span>
                <span class="info-value">{{ $cantidadMiembros }} / 5</span>
            </div>

            <!-- Lista de Miembros -->
            <h3 style="font-size: 1.125rem; font-weight: 600; color: #2c2c2c; margin-top: 1.5rem; margin-bottom: 0.5rem;">
                Miembros del Equipo
            </h3>
            <div class="members-list">
                @foreach($equipo->miembros as $miembro)
                <div class="member-item">
                    <div class="member-avatar">
                        {{ strtoupper(substr($miembro->user->nombre, 0, 1)) }}
                    </div>
                    <div class="member-info">
                        <div class="member-name">{{ $miembro->user->nombre }} {{ $miembro->user->app_paterno }}</div>
                        <div class="member-role">{{ $miembro->rol->nombre ?? 'Sin rol' }}</div>
                    </div>
                    @if($miembro->es_lider)
                    <span class="member-badge">Líder</span>
                    @endif
                </div>
                @endforeach
            </div>
        </div>

        <!-- Información del Proyecto -->
        <div class="project-card">
            <h2 class="card-title">
                <div class="card-icon">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                Proyecto
            </h2>

            @if($equipo->proyecto)
            <div class="info-row">
                <span class="info-label">Nombre:</span>
                <span class="info-value">{{ $equipo->proyecto->nombre }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Descripción:</span>
                <span class="info-value">{{ $equipo->proyecto->descripcion ?? 'Sin descripción' }}</span>
            </div>
            @else
            <div style="text-align: center; padding: 2rem;">
                <svg width="64" height="64" fill="none" stroke="#e89a3c" viewBox="0 0 24 24" style="margin: 0 auto 1rem;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p style="color: #6b7280;">Este equipo aún no tiene un proyecto asignado</p>
            </div>
            @endif
        </div>

        <!-- Sección de Acciones -->
        <div class="action-section">
            @if($esMiembro)
                <div class="alert-box alert-info">
                    <strong>¡Ya eres miembro de este equipo!</strong>
                </div>
            @elseif($tieneSolicitudPendiente)
                <div class="alert-box alert-warning">
                    <strong>Tienes una solicitud pendiente para unirte a este equipo.</strong>
                    <p>El líder del equipo revisará tu solicitud pronto.</p>
                </div>
            @else
                @if($cantidadMiembros < 5)
                    <form action="{{ route('equipos.solicitud.store', $equipo) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn-primary">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                            Solicitar unirme al equipo
                        </button>
                    </form>
                    <p style="margin-top: 1rem; color: #6b7280;">
                        Al enviar esta solicitud, el líder del equipo recibirá una notificación y podrá aceptarla o rechazarla.
                    </p>
                @else
                    <div class="alert-box alert-warning">
                        <strong>Este equipo está completo</strong>
                        <p>El equipo ya tiene el máximo de 5 miembros.</p>
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>

@endsection