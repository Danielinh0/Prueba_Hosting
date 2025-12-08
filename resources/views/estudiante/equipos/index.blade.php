@extends('layouts.app')

@section('content')

<div class="equipos-evento-page py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('estudiante.eventos.show',$evento) }}" class="back-link">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver al Evento
        </a>
        
        <!-- Hero Section -->
        <div class="hero-section">
            <div class="hero-content">
                <div class="hero-text">
                    <h1>Equipos para: <span>{{ $evento->nombre }}</span></h1>
                    <p>Explora los equipos disponibles o crea uno nuevo para participar.</p>
                </div>
                @if(!$miInscripcionDeEquipoId)
                <a href="{{ route('estudiante.eventos.equipos.create', $evento) }}" class="btn-create">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Crear Equipo
                </a>
                @endif
            </div>
        </div>

        <!-- Filtros y Búsqueda -->
        <div class="filter-card">
            <form action="{{ route('estudiante.eventos.equipos.index', $evento) }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="md:col-span-2">
                        <input type="text" name="search" placeholder="Buscar por nombre de equipo..." value="{{ request('search') }}" class="neuro-input">
                    </div>
                    <div>
                        <select name="status" class="neuro-select">
                            <option value="">Todos los equipos</option>
                            <option value="Incompleto" {{ request('status') == 'Incompleto' ? 'selected' : '' }}>Con lugares disponibles</option>
                            <option value="Completo" {{ request('status') == 'Completo' ? 'selected' : '' }}>Equipos llenos</option>
                        </select>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button type="submit" class="btn-filter w-full justify-center">Filtrar</button>
                        <a href="{{ route('estudiante.eventos.equipos.index', $evento) }}" class="btn-clear w-full">Limpiar</a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Lista de Equipos -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse ($inscripciones as $inscripcion)
                <div class="team-card">
                    <a href="{{ route('estudiante.eventos.equipos.show', [$evento, $inscripcion->equipo]) }}" class="team-header">
                        <div>
                            @if ($inscripcion->equipo->ruta_imagen)
                                <img class="team-avatar" src="{{ asset('storage/' . $inscripcion->equipo->ruta_imagen) }}" alt="Imagen del equipo">
                            @else
                                <span class="team-placeholder">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                </span>
                            @endif
                        </div>
                        <div style="min-width: 0;">
                            <h4 class="team-name">{{ $inscripcion->equipo->nombre }}</h4>
                            <p class="team-members-count">{{ $inscripcion->equipo->miembros->count() }} Miembros</p>
                        </div>
                    </a>

                    <!-- Botón de Solicitud de Unión -->
                    <div class="action-section">
                        @php
                            $cantidadMiembros = $inscripcion->equipo->miembros->count();
                            $equipoLleno = $cantidadMiembros >= 5;
                        @endphp
                        
                        @if ($evento->estado === 'Activo' && !$equipoLleno)
                        
                            @if ($miInscripcionDeEquipoId)
                                {{-- El usuario YA es miembro de un equipo en este evento --}}
                                @if ($miInscripcionDeEquipoId === $inscripcion->equipo->id_equipo)
                                    <span class="badge-in-team">✔ Estás en este equipo</span>
                                @else
                                    <span class="status-other-team">Ya eres miembro de otro equipo.</span>
                                @endif

                            @else
                                {{-- El usuario NO es miembro de ningún equipo, revisamos sus solicitudes --}}
                                @if ($solicitudesDelEstudiante->has($inscripcion->equipo->id_equipo))
                                    @php
                                        $solicitudActual = $solicitudesDelEstudiante[$inscripcion->equipo->id_equipo];
                                    @endphp
                                    @if ($solicitudActual->status === 'pendiente')
                                        <span class="status-pending">Solicitud enviada (pendiente).</span>
                                    @elseif ($solicitudActual->status === 'rechazada')
                                        <div class="text-center">
                                            <form action="{{ route('estudiante.solicitudes.store', $inscripcion->equipo) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn-request">
                                                    Volver a solicitar
                                                </button>
                                            </form>
                                            <p class="reject-message">Tu solicitud anterior fue rechazada.</p>
                                        </div>
                                    @endif
                                @else
                                    {{-- No es miembro y no hay solicitud, puede unirse --}}
                                    <form action="{{ route('estudiante.solicitudes.store', $inscripcion->equipo) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-request">
                                            Solicitar Unirme
                                        </button>
                                    </form>
                                @endif
                            @endif

                        @elseif ($equipoLleno)
                            <span class="status-full">Equipo completo ({{ $cantidadMiembros }}/5 miembros).</span>
                        @else
                            <span class="status-not-available">Inscripciones no disponibles aún.</span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <p>No hay equipos inscritos para este evento todavía. ¡Sé el primero!</p>
                </div>
            @endforelse
        </div>

         <div class="mt-8">
            {{ $inscripciones->appends(request()->query())->links() }}
        </div>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
    
    /* Fondo degradado */
    .equipos-evento-page {
        background: linear-gradient(to bottom, #FFFDF4, #FFEEE2);
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
    }
    
    /* Textos */
    .equipos-evento-page h2,
    .equipos-evento-page h4 {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
    }
    
    .equipos-evento-page p {
        font-family: 'Poppins', sans-serif;
        color: #6b6b6b;
    }
    
    /* Back button */
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
    }
    
    .back-link:hover {
        color: #4f46e5;
        box-shadow: 6px 6px 12px #e6d5c9, -6px -6px 12px #ffffff;
        transform: translateY(-2px);
    }
    
    .back-link svg {
        width: 1rem;
        height: 1rem;
        margin-right: 0.5rem;
    }
    
    /* Create button */
    .btn-create {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #f57636ff, #e57f4cff);
        color: #ffffff;
        font-weight: 600;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        font-size: 0.75rem;
        text-transform: uppercase;
        box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
        border: none;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }
    
    .btn-create:hover {
        box-shadow: 6px 6px 12px rgba(0, 0, 0, 0.3);
        transform: translateY(-2px);
    }
    
    .btn-create svg {
        margin-right: 0.5rem;
    }
    
    /* Filter card */
    .filter-card {
        background: #FFEEE2;
        border-radius: 20px;
        padding: 1rem;
        margin-bottom: 2rem;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
    }
    
    /* Inputs y selects */
    .neuro-input,
    .neuro-select {
        font-family: 'Poppins', sans-serif;
        background: rgba(255, 255, 255, 0.5);
        border: none;
        box-shadow: inset 4px 4px 8px #e6d5c9, inset -4px -4px 8px #ffffff;
        transition: all 0.2s ease;
        backdrop-filter: blur(10px);
        color: #2c2c2c;
        width: 100%;
        padding: 0.5rem;
        border-radius: 0.375rem;
    }
    
    .neuro-input::placeholder {
        color: #9ca3af;
    }
    
    .neuro-input:focus,
    .neuro-select:focus {
        outline: none;
        box-shadow: inset 6px 6px 12px #e6d5c9, inset -6px -6px 12px #ffffff;
    }
    
    /* Filter buttons */
    .btn-filter {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #2c2c2c, #1a1a1a);
        color: #ffffff;
        font-weight: 600;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
        border: none;
    }
    
    .btn-filter:hover {
        box-shadow: 6px 6px 12px rgba(0, 0, 0, 0.3);
        transform: translateY(-2px);
    }
    
    .btn-clear {
        font-family: 'Poppins', sans-serif;
        background: rgba(255, 255, 255, 0.5);
        color: #2c2c2c;
        font-weight: 500;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        transition: all 0.3s ease;
        border: none;
        backdrop-filter: blur(10px);
        text-decoration: none;
        display: inline-block;
        text-align: center;
    }
    
    .btn-clear:hover {
        box-shadow: 6px 6px 12px #e6d5c9, -6px -6px 12px #ffffff;
        transform: translateY(-2px);
    }
    
    /* Team card */
    .team-card {
        background: #FFEEE2;
        border-radius: 20px;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    
    /* Team header */
    .team-header {
        padding: 1rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: all 0.3s ease;
    }
    
    .team-header:hover {
        opacity: 0.8;
    }
    
    .team-avatar {
        width: 4rem;
        height: 4rem;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #e89a3c;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        flex-shrink: 0;
    }
    
    .team-placeholder {
        width: 4rem;
        height: 4rem;
        border-radius: 50%;
        background: rgba(229, 231, 235, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: inset 2px 2px 4px #e6d5c9, inset -2px -2px 4px #ffffff;
        flex-shrink: 0;
    }
    
    .team-name {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
        font-weight: 600;
        font-size: 1.125rem;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    
    .team-members-count {
        font-size: 0.875rem;
        color: #9ca3af;
    }
    
    /* Action section */
    .action-section {
        margin-top: auto;
        padding: 1rem;
        border-top: 1px solid rgba(232, 154, 60, 0.2);
    }
    
    /* Status badges */
    .badge-in-team {
        font-family: 'Poppins', sans-serif;
        width: 100%;
        text-align: center;
        padding: 0.5rem 1rem;
        background: linear-gradient(135deg, rgba(209, 250, 229, 0.5), rgba(167, 243, 208, 0.5));
        color: #065f46;
        border-radius: 0.375rem;
        font-weight: 600;
        font-size: 0.875rem;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        display: block;
    }
    
    .status-pending {
        font-size: 0.75rem;
        color: #d97706;
        font-weight: 600;
    }
    
    .status-other-team {
        font-size: 0.75rem;
        color: #9ca3af;
        font-weight: 600;
    }
    
    .status-full {
        font-size: 0.75rem;
        color: #dc2626;
        font-weight: 600;
    }
    
    .status-not-available {
        font-size: 0.75rem;
        color: #9ca3af;
    }
    
    /* Request buttons */
    .btn-request {
        font-family: 'Poppins', sans-serif;
        width: 100%;
        padding: 0.5rem 1rem;
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: #ffffff;
        border-radius: 0.375rem;
        font-weight: 600;
        font-size: 0.875rem;
        box-shadow: 4px 4px 8px rgba(99, 102, 241, 0.3);
        transition: all 0.3s ease;
        border: none;
    }
    
    .btn-request:hover {
        box-shadow: 6px 6px 12px rgba(99, 102, 241, 0.4);
        transform: translateY(-2px);
    }
    
    .reject-message {
        font-size: 0.75rem;
        color: #ef4444;
        margin-top: 0.25rem;
        text-align: center;
    }
    
    /* Empty state */
    .empty-state {
        grid-column: 1 / -1;
        text-align: center;
        padding: 4rem 0;
    }
    
    .empty-state p {
        color: #9ca3af;
    }

    /* Hero Section Negro */
    .hero-section {
        background: linear-gradient(135deg, #0e0e0eff 0%, #434343ff 50%, #1d1d1dff 100%);
        border-radius: 24px;
        padding: 2.5rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: 8px 8px 16px rgba(200, 200, 200, 0.4), -8px -8px 16px rgba(255, 255, 255, 0.9);
    }

    .hero-content {
        position: relative;
        z-index: 1;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .hero-text h1 {
        color: #c1c1c1ff;
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
    }

    .hero-text h1 span {
        color: #e89a3c;
    }

    .hero-text p {
        color: #cfcfcfff;
        font-size: 1rem;
    }
</style>
@endsection