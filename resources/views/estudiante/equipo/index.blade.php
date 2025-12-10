@extends('layouts.app')

@section('content')

<div class="equipos-page-eqi py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('estudiante.dashboard') }}" class="back-link-eqi">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver al Inicio
        </a>
        <!-- Hero Section -->
        <div class="hero-section-eqi">
            <div class="hero-content-eqi">
                <div class="hero-text-eqi">
                    <h1><span>Equipos</span></h1>
                    <p>Gestiona tus equipos, revisa solicitudes pendientes y colabora con tus compañeros en los proyectos.</p>
                </div>
                <div style="display: flex; align-items: center; gap: 1.5rem;">
                    <a href="{{ route('estudiante.equipos.create-sin-evento') }}" class="btn-crear-equipo-eqi">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Crear Equipo
                    </a>
                    <div class="hero-stats-eqi">
                        <div class="hero-stat-eqi">
                            <div class="hero-stat-number-eqi">{{ $equipos->count() }}</div>
                            <div class="hero-stat-label-eqi">Equipos</div>
                        </div>
                        <div class="hero-stat-eqi">
                            <div class="hero-stat-number-eqi">{{ $equipos->where('esLider', true)->count() }}</div>
                            <div class="hero-stat-label-eqi">Como Líder</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Filtro de Búsqueda -->
        <div class="filter-card" style="background: #FFEEE2; border-radius: 20px; padding: 1rem; margin-bottom: 2rem; box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;">
            <form action="{{ route('estudiante.equipo.index') }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="md:col-span-3">
                        <input type="text" name="search" placeholder="Buscar por nombre de equipo o evento..." value="{{ $search ?? '' }}" 
                            style="font-family: 'Poppins', sans-serif; background: rgba(255, 255, 255, 0.5); border: none; box-shadow: inset 4px 4px 8px #e6d5c9, inset -4px -4px 8px #ffffff; color: #2c2c2c; width: 100%; padding: 0.5rem 1rem; border-radius: 0.375rem;"
                            class="w-full">
                    </div>
                    <div class="flex items-center space-x-2">
                        <button type="submit" style="font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #2c2c2c, #1a1a1a); color: #ffffff; font-weight: 600; padding: 0.5rem 1rem; border-radius: 0.375rem; box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.2); border: none; width: 100%;">Buscar</button>
                        <a href="{{ route('estudiante.equipo.index') }}" style="font-family: 'Poppins', sans-serif; background: rgba(255, 255, 255, 0.5); color: #2c2c2c; font-weight: 500; padding: 0.5rem 1rem; border-radius: 0.375rem; box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff; border: none; text-decoration: none; text-align: center; width: 100%;">Limpiar</a>
                    </div>
                </div>
            </form>
        </div>

        @if($equipos->count() > 0)
            <!-- Teams Grid -->
            <div class="teams-grid-eqi">
                @foreach($equipos as $equipoData)
                    @php
                        $inscripcion = $equipoData['inscripcion'];
                        $esLider = $equipoData['esLider'];
                        $solicitudes = $equipoData['solicitudes'];
                        $equipo = $inscripcion->equipo;
                        $miembros = $inscripcion->miembros;
                        $evento = $inscripcion->evento;
                        $miRol = $miembros->firstWhere('id_estudiante', Auth::user()->id_usuario)?->rol?->nombre ?? 'Miembro';
                    @endphp
                    
                    <div class="team-card-eqi {{ $esLider ? 'team-card-leader-eqi' : '' }}">
                        @if($esLider && $solicitudes->count() > 0)
                            <div class="pending-requests-eqi">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                                {{ $solicitudes->count() }} solicitud{{ $solicitudes->count() > 1 ? 'es' : '' }}
                            </div>
                        @endif

                        <!-- Imagen del equipo -->
                        <div class="team-image-container-eqi">
                            @if($equipo->ruta_imagen)
                                <img src="{{ asset('storage/' . $equipo->ruta_imagen) }}" alt="{{ $equipo->nombre }}" class="team-image-eqi">
                            @else
                                <div class="team-image-placeholder-eqi">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                            @endif
                            <div class="team-image-overlay-eqi"></div>
                        </div>

                        <div class="team-card-header-eqi">
                            <h3 class="team-name-eqi">{{ $equipo->nombre }}</h3>
                            <div class="team-event-eqi">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                @if($evento && !$evento->trashed())
                                    {{ $evento->nombre }}
                                    <span class="event-status-badge-eqi status-{{ strtolower(str_replace(' ', '-', $evento->estado)) }}-eqi">
                                        {{ $evento->estado }}
                                    </span>
                                @elseif($evento && $evento->trashed())
                                    Sin evento
                                @else
                                    Sin evento
                                @endif
                            </div>
                        </div>

                        <div class="team-card-body-eqi">
                            <!-- Team Stats -->
                            <div class="team-stats-row-eqi">
                                <div class="team-stat-item-eqi">
                                    <div class="team-stat-value-eqi">{{ $miembros->count() }}</div>
                                    <div class="team-stat-label-eqi">Miembros</div>
                                </div>
                                <div class="team-stat-item-eqi">
                                    <div class="team-stat-value-eqi">{{ $esLider ? $solicitudes->count() : '-' }}</div>
                                    <div class="team-stat-label-eqi">Solicitudes</div>
                                </div>
                                <div class="team-stat-item-eqi">
                                    <div class="team-stat-value-eqi">0%</div>
                                    <div class="team-stat-label-eqi">Avance</div>
                                </div>
                            </div>

                            <!-- Members Preview -->
                            <div class="members-preview-eqi">
                                <div class="members-preview-title-eqi">Miembros del equipo</div>
                                <div class="members-avatars-eqi">
                                    @foreach($miembros->take(5) as $miembro)
                                        <div class="member-avatar-eqi {{ $miembro->es_lider ? 'member-avatar-leader-eqi' : '' }}" 
                                             title="{{ $miembro->user->name }} {{ $miembro->es_lider ? '(Líder)' : '' }}">
                                            {{ strtoupper(substr($miembro->user->name, 0, 2)) }}
                                        </div>
                                    @endforeach
                                    @if($miembros->count() > 5)
                                        <div class="member-avatar-eqi member-avatar-more-eqi">
                                            +{{ $miembros->count() - 5 }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- My Role -->
                            <div class="my-role-badge-eqi">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Mi rol: {{ $miRol }}
                            </div>

                            <!-- Actions -->
                            <div class="team-actions-eqi">
                                <!-- Ver Equipo -->
                                <a href="{{ route('estudiante.equipo.show-detalle', $inscripcion) }}" class="team-action-btn-eqi team-action-primary-eqi">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Ver Equipo
                                </a>
                                @if($esLider && $solicitudes->count() > 0)
                                    <a href="{{ route('estudiante.equipo.show-detalle', $inscripcion) }}#solicitudes" class="team-action-btn-eqi team-action-secondary-eqi">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                        </svg>
                                        Solicitudes
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="empty-state-eqi">
                <div class="empty-state-icon-eqi">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <h3>Aún no tienes equipos</h3>
                <p>Únete a un equipo existente o crea uno nuevo para participar en los eventos y colaborar con otros estudiantes.</p>
                <div class="empty-state-actions-eqi">
                    <a href="{{ route('estudiante.equipos.create-sin-evento') }}" class="empty-state-btn-eqi empty-state-btn-primary-eqi">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Crear Nuevo Equipo
                    </a>
                    <a href="{{ route('estudiante.eventos.index') }}" class="empty-state-btn-eqi empty-state-btn-secondary-eqi">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Explorar Eventos
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>


@endsection