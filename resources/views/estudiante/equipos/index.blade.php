@extends('layouts.app')

@section('content')

<div class="equipos-evento-page-mieq py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('estudiante.eventos.show',$evento) }}" class="back-link-mieq">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver al Evento
        </a>
        
        <!-- Hero Section -->
        <div class="hero-section-mieq">
            <div class="hero-content-mieq">
                <div class="hero-text-mieq">
                    <h1>Equipos para: <span>{{ $evento->nombre }}</span></h1>
                    <p>Explora los equipos disponibles o crea uno nuevo para participar.</p>
                </div>
                @if(!$miInscripcionDeEquipoId)
                <a href="{{ route('estudiante.eventos.equipos.create', $evento) }}" class="btn-create-mieq">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Crear Equipo
                </a>
                @endif
            </div>
        </div>

        <!-- Filtros y Búsqueda -->
        <div class="filter-card-mieq">
            <form action="{{ route('estudiante.eventos.equipos.index', $evento) }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="md:col-span-2">
                        <input type="text" name="search" placeholder="Buscar por nombre de equipo..." value="{{ request('search') }}" class="neuro-input-mieq">
                    </div>
                    <div>
                        <select name="status" class="neuro-select-mieq">
                            <option value="">Todos los equipos</option>
                            <option value="Incompleto" {{ request('status') == 'Incompleto' ? 'selected' : '' }}>Con lugares disponibles</option>
                            <option value="Completo" {{ request('status') == 'Completo' ? 'selected' : '' }}>Equipos llenos</option>
                        </select>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button type="submit" class="btn-filter-mieq w-full justify-center">Filtrar</button>
                        <a href="{{ route('estudiante.eventos.equipos.index', $evento) }}" class="btn-clear-mieq w-full">Limpiar</a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Lista de Equipos -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse ($inscripciones as $inscripcion)
                <div class="team-card-mieq">
                    <a href="{{ route('estudiante.eventos.equipos.show', [$evento, $inscripcion->equipo]) }}" class="team-header-mieq">
                        <div>
                            @if ($inscripcion->equipo->ruta_imagen)
                                <img class="team-avatar-mieq" src="{{ asset('storage/' . $inscripcion->equipo->ruta_imagen) }}" alt="Imagen del equipo">
                            @else
                                <span class="team-placeholder-mieq">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                </span>
                            @endif
                        </div>
                        <div style="min-width: 0;">
                            <h4 class="team-name-mieq">{{ $inscripcion->equipo->nombre }}</h4>
                            <p class="team-members-count-mieq">{{ $inscripcion->equipo->miembros->count() }} Miembros</p>
                        </div>
                    </a>

                    <!-- Botón de Solicitud de Unión -->
                    <div class="action-section-mieq">
                        @php
                            $cantidadMiembros = $inscripcion->equipo->miembros->count();
                            $equipoLleno = $cantidadMiembros >= 5;
                        @endphp
                        
                        @if ($evento->estado === 'Activo' && !$equipoLleno)
                        
                            @if ($miInscripcionDeEquipoId)
                                {{-- El usuario YA es miembro de un equipo en este evento --}}
                                @if ($miInscripcionDeEquipoId === $inscripcion->equipo->id_equipo)
                                    <span class="badge-in-team-mieq">✔ Estás en este equipo</span>
                                @else
                                    <span class="status-other-team-mieq">Ya eres miembro de otro equipo.</span>
                                @endif

                            @else
                                {{-- El usuario NO es miembro de ningún equipo, revisamos sus solicitudes --}}
                                @if ($solicitudesDelEstudiante->has($inscripcion->equipo->id_equipo))
                                    @php
                                        $solicitudActual = $solicitudesDelEstudiante[$inscripcion->equipo->id_equipo];
                                    @endphp
                                    @if ($solicitudActual->status === 'pendiente')
                                        <span class="status-pending-mieq">Solicitud enviada (pendiente).</span>
                                    @elseif ($solicitudActual->status === 'rechazada')
                                        <div class="text-center">
                                            <form action="{{ route('estudiante.solicitudes.store', $inscripcion->equipo) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn-request-mieq">
                                                    Volver a solicitar
                                                </button>
                                            </form>
                                            <p class="reject-message-mieq">Tu solicitud anterior fue rechazada.</p>
                                        </div>
                                    @endif
                                @else
                                    {{-- No es miembro y no hay solicitud, puede unirse --}}
                                    <form action="{{ route('estudiante.solicitudes.store', $inscripcion->equipo) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-request-mieq">
                                            Solicitar Unirme
                                        </button>
                                    </form>
                                @endif
                            @endif

                        @elseif ($equipoLleno)
                            <span class="status-full-mieq">Equipo completo ({{ $cantidadMiembros }}/5 miembros).</span>
                        @else
                            <span class="status-not-available-mieq">Inscripciones no disponibles aún.</span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="empty-state-mieq">
                    <p>No hay equipos inscritos para este evento todavía. ¡Sé el primero!</p>
                </div>
            @endforelse
        </div>

         <div class="mt-8">
            {{ $inscripciones->appends(request()->query())->links() }}
        </div>
    </div>
</div>

@endsection