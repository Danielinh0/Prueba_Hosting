@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
    
    /* Fondo degradado */
    .equipo-detalle-page {
        background: linear-gradient(to bottom, #FFFDF4, #FFEEE2);
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
    }
    
    /* Textos */
    .equipo-detalle-page h1,
    .equipo-detalle-page h2,
    .equipo-detalle-page h3 {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
    }
    
    .equipo-detalle-page p {
        font-family: 'Poppins', sans-serif;
        color: #6b6b6b;
    }
    
    /* Main card */
    .main-card {
        background: #FFEEE2;
        border-radius: 20px;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
        overflow: hidden;
        margin-bottom: 1.5rem;
    }
    
    .main-card img {
        height: 16rem;
        width: 100%;
        object-fit: cover;
    }
    
    /* Team header */
    .team-header {
        border-bottom: 1px solid rgba(232, 154, 60, 0.2);
        padding-bottom: 1.5rem;
    }
    
    .team-title {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
        font-weight: 700;
        font-size: 1.875rem;
    }
    
    .event-link {
        color: #e89a3c;
        transition: all 0.2s ease;
    }
    
    .event-link:hover {
        color: #d98a2c;
        text-decoration: underline;
    }
    
    /* Buttons */
    .btn-edit {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #2c2c2c, #1a1a1a);
        color: #ffffff;
        font-weight: 600;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
        border: none;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }
    
    .btn-edit:hover {
        box-shadow: 6px 6px 12px rgba(0, 0, 0, 0.3);
        transform: translateY(-2px);
    }
    
    .btn-leave {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        color: #ffffff;
        font-weight: 600;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        box-shadow: 4px 4px 8px rgba(220, 38, 38, 0.3);
        transition: all 0.3s ease;
        border: none;
        display: inline-flex;
        align-items: center;
    }
    
    .btn-leave:hover {
        box-shadow: 6px 6px 12px rgba(220, 38, 38, 0.4);
        transform: translateY(-2px);
    }
    
    .btn-leave svg {
        margin-right: 0.5rem;
    }
    
    /* Description box */
    .description-box {
        margin-top: 1rem;
        padding: 1rem;
        background: rgba(255, 255, 255, 0.3);
        border-radius: 15px;
        box-shadow: inset 2px 2px 4px #e6d5c9, inset -2px -2px 4px #ffffff;
    }
    
    .description-box h3 {
        font-weight: 600;
        color: #2c2c2c;
        margin-bottom: 0.5rem;
    }
    
    /* Members section */
    .members-section {
        margin-top: 2rem;
    }
    
    .members-section h3 {
        font-size: 1.125rem;
        font-weight: 500;
    }
    
    /* Member item */
    .member-item {
        padding: 1rem 0;
        border-bottom: 1px solid rgba(232, 154, 60, 0.1);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .member-item:last-child {
        border-bottom: none;
    }
    
    .member-photo {
        width: 3rem;
        height: 3rem;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #e89a3c;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .member-name {
        font-weight: 600;
        color: #2c2c2c;
    }
    
    .member-career {
        font-size: 0.875rem;
        color: #9ca3af;
    }
    
    /* Badges */
    .badge-lider {
        font-family: 'Poppins', sans-serif;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        padding: 0.25rem 0.5rem;
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        color: #92400e;
        border-radius: 20px;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .badge-rol {
        font-family: 'Poppins', sans-serif;
        display: inline-flex;
        align-items: center;
        padding: 0.125rem 0.5rem;
        border-radius: 20px;
        background: rgba(224, 231, 255, 0.8);
        color: #3730a3;
        font-size: 0.75rem;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    /* Member controls */
    .member-controls {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .member-controls select {
        font-family: 'Poppins', sans-serif;
        background: rgba(255, 255, 255, 0.5);
        border: none;
        box-shadow: inset 2px 2px 4px #e6d5c9, inset -2px -2px 4px #ffffff;
        padding: 0.25rem 0.5rem;
        border-radius: 0.375rem;
        font-size: 0.75rem;
        color: #2c2c2c;
    }
    
    .member-controls select:focus {
        outline: none;
        box-shadow: inset 4px 4px 8px #e6d5c9, inset -4px -4px 8px #ffffff;
    }
    
    .btn-update {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: #ffffff;
        padding: 0.25rem 0.5rem;
        border-radius: 0.375rem;
        font-size: 0.75rem;
        font-weight: 600;
        box-shadow: 2px 2px 4px rgba(59, 130, 246, 0.3);
        transition: all 0.3s ease;
        border: none;
    }
    
    .btn-update:hover {
        box-shadow: 4px 4px 8px rgba(59, 130, 246, 0.4);
        transform: translateY(-2px);
    }
    
    .btn-remove {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        color: #ffffff;
        padding: 0.25rem 0.5rem;
        border-radius: 0.375rem;
        font-size: 0.75rem;
        font-weight: 600;
        box-shadow: 2px 2px 4px rgba(220, 38, 38, 0.3);
        transition: all 0.3s ease;
        border: none;
    }
    
    .btn-remove:hover {
        box-shadow: 4px 4px 8px rgba(220, 38, 38, 0.4);
        transform: translateY(-2px);
    }
    
    /* Requests section */
    .requests-section {
        margin-top: 2rem;
        border-top: 1px solid rgba(232, 154, 60, 0.2);
        padding-top: 1.5rem;
    }
    
    .requests-section h3 {
        font-size: 1.125rem;
        font-weight: 500;
    }
    
    .request-item {
        padding: 1rem;
        background: rgba(249, 250, 251, 0.5);
        border-radius: 15px;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 0.5rem;
    }
    
    .request-name {
        font-weight: 600;
        color: #2c2c2c;
    }
    
    .request-message {
        font-size: 0.875rem;
        color: #6b6b6b;
    }
    
    .btn-accept {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #10b981, #059669);
        color: #ffffff;
        padding: 0.25rem 0.75rem;
        border-radius: 0.375rem;
        font-size: 0.75rem;
        font-weight: 600;
        box-shadow: 2px 2px 4px rgba(16, 185, 129, 0.3);
        transition: all 0.3s ease;
        border: none;
    }
    
    .btn-accept:hover {
        box-shadow: 4px 4px 8px rgba(16, 185, 129, 0.4);
        transform: translateY(-2px);
    }
    
    .btn-reject {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        color: #ffffff;
        padding: 0.25rem 0.75rem;
        border-radius: 0.375rem;
        font-size: 0.75rem;
        font-weight: 600;
        box-shadow: 2px 2px 4px rgba(220, 38, 38, 0.3);
        transition: all 0.3s ease;
        border: none;
    }
    
    .btn-reject:hover {
        box-shadow: 4px 4px 8px rgba(220, 38, 38, 0.4);
        transform: translateY(-2px);
    }
    
    /* Quick access card */
    .quick-access-card {
        background: #FFEEE2;
        border-radius: 20px;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
        padding: 1.5rem;
    }
    
    .quick-access-card h3 {
        font-size: 1.125rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }
    
    /* Quick access items */
    .quick-access-item {
        padding: 1rem;
        border-radius: 15px;
        text-align: center;
        transition: all 0.3s ease;
        text-decoration: none;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
    }
    
    .quick-access-item:hover {
        box-shadow: 6px 6px 12px #e6d5c9, -6px -6px 12px #ffffff;
        transform: translateY(-3px);
    }
    
    .quick-access-blue {
        background: linear-gradient(135deg, rgba(219, 234, 254, 0.5), rgba(191, 219, 254, 0.5));
    }
    
    .quick-access-blue:hover {
        background: linear-gradient(135deg, rgba(219, 234, 254, 0.7), rgba(191, 219, 254, 0.7));
    }
    
    .quick-access-green {
        background: linear-gradient(135deg, rgba(209, 250, 229, 0.5), rgba(167, 243, 208, 0.5));
    }
    
    .quick-access-green:hover {
        background: linear-gradient(135deg, rgba(209, 250, 229, 0.7), rgba(167, 243, 208, 0.7));
    }
    
    .quick-access-purple {
        background: linear-gradient(135deg, rgba(237, 233, 254, 0.5), rgba(221, 214, 254, 0.5));
    }
    
    .quick-access-purple:hover {
        background: linear-gradient(135deg, rgba(237, 233, 254, 0.7), rgba(221, 214, 254, 0.7));
    }
    
    .quick-access-yellow {
        background: linear-gradient(135deg, rgba(254, 249, 195, 0.5), rgba(254, 240, 138, 0.5));
    }
    
    .quick-access-yellow:hover {
        background: linear-gradient(135deg, rgba(254, 249, 195, 0.7), rgba(254, 240, 138, 0.7));
    }
    
    .quick-access-item svg {
        width: 2.5rem;
        height: 2.5rem;
        margin: 0 auto 0.5rem;
    }
    
    .quick-access-item p:first-of-type {
        font-size: 0.875rem;
        font-weight: 600;
    }
    
    .quick-access-item p:last-of-type {
        font-size: 0.75rem;
        margin-top: 0.25rem;
    }
</style>

<div class="equipo-detalle-page py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="font-semibold text-xl mb-6">Mi Equipo</h2>
        
        <div class="main-card">
            @if ($inscripcion->equipo->ruta_imagen)
                <img src="{{ asset('storage/' . $inscripcion->equipo->ruta_imagen) }}" alt="Imagen del equipo">
            @endif
            
            <div class="p-6 sm:p-8">
                <!-- Información del Equipo y Evento -->
                <div class="team-header">
                    <div class="flex items-center justify-between">
                        <h1 class="team-title">{{ $inscripcion->equipo->nombre }}</h1>
                        <div class="flex items-center space-x-3">
                            @if($esLider)
                                <a href="{{ route('estudiante.equipo.edit') }}" class="btn-edit">
                                    Editar Equipo
                                </a>
                            @else
                                {{-- Botón para que miembros NO líderes salgan del equipo --}}
                                <form action="{{ route('estudiante.miembros.leave') }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres abandonar este equipo?');">
                                    @csrf
                                    <button type="submit" class="btn-leave">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                        Salir del Equipo
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                    <p class="text-sm mt-2" style="color: #6b6b6b;">
                        Participando en el evento: 
                        <a href="{{ route('estudiante.eventos.show', $inscripcion->evento) }}" class="event-link">
                            {{ $inscripcion->evento->nombre }}
                        </a>
                    </p>

                    @if($inscripcion->equipo->descripcion)
                        <div class="description-box">
                            <h3>Descripción del Equipo</h3>
                            <p class="text-sm" style="line-height: 1.6;">{{ $inscripcion->equipo->descripcion }}</p>
                        </div>
                    @endif
                </div>

                <!-- Lista de Miembros -->
                <div class="members-section">
                    <h3>
                        Miembros del Equipo ({{ $inscripcion->equipo->miembros->count() }})
                    </h3>
                    <div class="mt-4">
                        <ul>
                            @foreach($inscripcion->equipo->miembros as $miembro)
                                <li class="member-item">
                                    <div class="flex items-center space-x-4">
                                        <!-- Foto de Perfil -->
                                        <img src="{{ $miembro->user->foto_perfil_url }}" alt="{{ $miembro->user->nombre }}" class="member-photo">
                                        
                                        <div>
                                            <div class="flex items-center space-x-2">
                                                <p class="member-name">{{ $miembro->user->nombre }} {{ $miembro->user->app_paterno }}</p>
                                                @if($miembro->es_lider)
                                                    <span class="badge-lider">Líder</span>
                                                @endif
                                            </div>
                                            <p class="member-career">{{ $miembro->user->estudiante->carrera->nombre ?? 'Carrera no disponible' }}</p>
                                            <p style="font-size: 0.75rem; margin-top: 0.125rem;">
                                                <span class="badge-rol">
                                                    {{ $miembro->rol->nombre ?? 'Rol no asignado' }}
                                                </span>
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Controles del Líder para otros miembros -->
                                    @if($esLider && !$miembro->es_lider)
                                        <div class="member-controls">
                                            <!-- Formulario para Cambiar Rol -->
                                            <form action="{{ route('estudiante.miembros.updateRole', $miembro) }}" method="POST" class="flex items-center space-x-2">
                                                @csrf
                                                @method('PATCH')
                                                <select name="id_rol_equipo">
                                                    @foreach($roles as $rol)
                                                        <option value="{{ $rol->id_rol_equipo }}" @if($rol->id_rol_equipo == $miembro->id_rol_equipo) selected @endif>
                                                            {{ $rol->nombre }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <button type="submit" class="btn-update">Actualizar</button>
                                            </form>
                                            <!-- Formulario para Eliminar -->
                                            <form action="{{ route('estudiante.miembros.destroy', $miembro) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar a este miembro del equipo?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-remove">Quitar</button>
                                            </form>
                                        </div>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Acciones de Líder (Solo visible para el líder) -->
                @if($esLider)
                    <div class="requests-section">
                        <h3>Gestionar Solicitudes</h3>
                        <div class="mt-4">
                            @forelse($solicitudes as $solicitud)
                                <div class="request-item">
                                    <div>
                                        <p class="request-name">{{ $solicitud->estudiante->user->nombre }} {{ $solicitud->estudiante->user->app_paterno }}</p>
                                        <p class="request-message">Quiere unirse al equipo</p>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <!-- Formulario para Aceptar -->
                                        <form action="{{ route('estudiante.solicitudes.accept', $solicitud) }}" method="POST" class="flex items-center space-x-2">
                                            @csrf
                                            <select name="id_rol_equipo" required style="font-family: 'Poppins', sans-serif; background: rgba(255, 255, 255, 0.5); border: none; box-shadow: inset 2px 2px 4px #e6d5c9, inset -2px -2px 4px #ffffff; padding: 0.25rem 0.5rem; border-radius: 0.375rem; font-size: 0.75rem; color: #2c2c2c;">
                                                <option value="">Asignar Rol...</option>
                                                @foreach($roles as $rol)
                                                    <option value="{{ $rol->id_rol_equipo }}">{{ $rol->nombre }}</option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="btn-accept">Aceptar</button>
                                        </form>
                                        <!-- Formulario para Rechazar -->
                                        <form action="{{ route('estudiante.solicitudes.reject', $solicitud) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn-reject">Rechazar</button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <p style="color: #6b6b6b;">No hay solicitudes pendientes.</p>
                            @endforelse
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Accesos Rápidos -->
        <div class="quick-access-card">
            <h3>⚡ Accesos Rápidos</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <!-- Recursos -->
                <a href="{{ route('estudiante.recursos.index', $inscripcion->equipo) }}" class="quick-access-item quick-access-blue">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #3b82f6;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p style="color: #1e3a8a;">Recursos</p>
                    <p style="color: #3b82f6;">{{ $inscripcion->equipo->recursos->count() }} archivos</p>
                </a>
                
                <!-- Proyecto/Hitos -->
                <a href="#" class="quick-access-item quick-access-green">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #10b981;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p style="color: #065f46;">Hitos</p>
                    <p style="color: #10b981;">{{ $inscripcion->proyecto ? $inscripcion->proyecto->hitos->where('completado', true)->count() . '/' . $inscripcion->proyecto->hitos->count() : '0/0' }}</p>
                </a>
                
                <!-- Tecnologías -->
                <a href="#" class="quick-access-item quick-access-purple">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #a855f7;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                    </svg>
                    <p style="color: #6b21a8;">Tecnologías</p>
                    <p style="color: #a855f7;">0 tags</p>
                </a>
                
                <!-- Actividad -->
                <a href="{{ route('estudiante.actividades.equipo', $inscripcion->equipo) }}" class="quick-access-item quick-access-yellow">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #f59e0b;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    <p style="color: #92400e;">Actividad</p>
                    <p style="color: #f59e0b;">Feed del equipo</p>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection