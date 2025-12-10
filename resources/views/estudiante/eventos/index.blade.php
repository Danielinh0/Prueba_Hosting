@extends('layouts.app')

@section('content')

<div class="eventos-page py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-12">
        <a href="{{ route('estudiante.dashboard') }}" class="back-link">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver al Inicio
        </a>
        
        <!-- Hero Section -->
        <div class="hero-section">
            <div class="hero-content">
                <div class="hero-text">
                    <h1><span>Eventos</span></h1>
                    <p>Descubre los eventos disponibles y gestiona tus inscripciones.</p>
                </div>
            </div>
        </div>
        
        <!-- Filtro de Búsqueda Unificado -->
        <div class="filter-card" style="background: #FFEEE2; border-radius: 20px; padding: 1.25rem; margin-bottom: 2rem; box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;">
            <form action="{{ route('estudiante.eventos.index') }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    <!-- Búsqueda por nombre -->
                    <div class="md:col-span-2">
                        <label style="font-size: 0.75rem; font-weight: 600; color: #6b6b6b; margin-bottom: 0.25rem; display: block;">Buscar por nombre</label>
                        <input type="text" name="search" placeholder="Nombre del evento..." value="{{ $search ?? '' }}" 
                            style="font-family: 'Poppins', sans-serif; background: rgba(255, 255, 255, 0.5); border: none; box-shadow: inset 4px 4px 8px #e6d5c9, inset -4px -4px 8px #ffffff; color: #2c2c2c; width: 100%; padding: 0.6rem 1rem; border-radius: 12px;"
                            class="w-full">
                    </div>
                    
                    <!-- Filtro Unificado -->
                    <div>
                        <label style="font-size: 0.75rem; font-weight: 600; color: #6b6b6b; margin-bottom: 0.25rem; display: block;">Filtrar por</label>
                        <select name="filtro" 
                            style="font-family: 'Poppins', sans-serif; background: rgba(255, 255, 255, 0.5); border: none; box-shadow: inset 4px 4px 8px #e6d5c9, inset -4px -4px 8px #ffffff; color: #2c2c2c; width: 100%; padding: 0.6rem 1rem; border-radius: 12px;"
                            class="w-full">
                            <option value="">Todos los eventos</option>
                            <optgroup label="── Por Estado ──">
                                <option value="En Progreso" {{ ($filtro ?? '') == 'En Progreso' ? 'selected' : '' }}>En Progreso</option>
                                <option value="Activo" {{ ($filtro ?? '') == 'Activo' ? 'selected' : '' }}>Activo (Inscripciones abiertas)</option>
                                <option value="Próximo" {{ ($filtro ?? '') == 'Próximo' ? 'selected' : '' }}>Próximo</option>
                                <option value="Cerrado" {{ ($filtro ?? '') == 'Cerrado' ? 'selected' : '' }}>Cerrado</option>
                                <option value="Finalizado" {{ ($filtro ?? '') == 'Finalizado' ? 'selected' : '' }}>Finalizado</option>
                            </optgroup>
                            <optgroup label="── Por Inscripción ──">
                                <option value="inscrito" {{ ($filtro ?? '') == 'inscrito' ? 'selected' : '' }}>Mis eventos (Inscrito)</option>
                                <option value="no_inscrito" {{ ($filtro ?? '') == 'no_inscrito' ? 'selected' : '' }}>Disponibles (Sin inscribir)</option>
                            </optgroup>
                        </select>
                    </div>
                    
                    <!-- Botones -->
                    <div class="flex items-center gap-2">
                        <button type="submit" style="font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #e89a3c, #d98a2c); color: #ffffff; font-weight: 600; padding: 0.6rem 1.25rem; border-radius: 12px; box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.15); border: none; flex: 1; transition: all 0.2s;">
                            <i class="fas fa-search" style="margin-right: 0.5rem;"></i>Filtrar
                        </button>
                        <a href="{{ route('estudiante.eventos.index') }}" style="font-family: 'Poppins', sans-serif; background: rgba(255, 255, 255, 0.5); color: #6b6b6b; font-weight: 500; padding: 0.6rem 1rem; border-radius: 12px; box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff; border: none; text-decoration: none; text-align: center; transition: all 0.2s;">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>

        @if (session('info'))
            <div class="info-alert mb-6" role="alert">
                <p>{{ session('info') }}</p>
            </div>
        @endif

        <!-- Sección Mis Eventos en Curso (En Progreso) -->
        @if($misEventosEnProgreso->isNotEmpty())
        <div>
            <h3 class="text-2xl font-bold mb-6" style="display: flex; align-items: center; gap: 0.5rem;">
                <span style="background: linear-gradient(135deg, #ef4444, #dc2626); color: white; padding: 0.25rem 0.75rem; border-radius: 8px; font-size: 0.85rem;">En Progreso</span>
                Mis Eventos en Curso
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($misEventosEnProgreso as $evento)
                    @if($evento)
                    <div class="evento-card">
                        <div class="inscrito-badge">
                            Inscrito
                        </div>
                        <a href="{{ route('estudiante.eventos.show', $evento) }}">
                            <img class="h-48 w-full object-cover" src="{{ asset('storage/' . $evento->ruta_imagen) }}" alt="Imagen del evento">
                        </a>
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <h4>{{ $evento->nombre }}</h4>
                                <span class="status-badge status-en-progreso">
                                    {{ $evento->estado }}
                                </span>
                            </div>
                            <p class="mt-1">
                                Finaliza: {{ $evento->fecha_fin->format('d M, Y') }}
                            </p>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
        @endif

        <!-- Sección Otros Eventos Inscritos -->
        @if($misOtrosEventosInscritos->isNotEmpty())
        <div>
            <h3 class="text-2xl font-bold mb-6" style="display: flex; align-items: center; gap: 0.5rem;">
                <span style="background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white; padding: 0.25rem 0.75rem; border-radius: 8px; font-size: 0.85rem;">Inscrito</span>
                Otros Eventos Inscritos
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($misOtrosEventosInscritos as $evento)
                    @if($evento)
                    <div class="evento-card">
                        <div class="inscrito-badge">
                            Inscrito
                        </div>
                        <a href="{{ route('estudiante.eventos.show', $evento) }}">
                            <img class="h-48 w-full object-cover" src="{{ asset('storage/' . $evento->ruta_imagen) }}" alt="Imagen del evento">
                        </a>
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <h4>{{ $evento->nombre }}</h4>
                                <span class="status-badge 
                                    @if ($evento->estado == 'Activo') status-activo 
                                    @elseif ($evento->estado == 'Próximo') status-proximo
                                    @elseif ($evento->estado == 'Cerrado') status-cerrado
                                    @elseif ($evento->estado == 'Finalizado') status-finalizado
                                    @else status-default @endif">
                                    {{ $evento->estado }}
                                </span>
                            </div>
                            <p class="mt-1">
                                {{ $evento->estado == 'Próximo' ? 'Inicia' : 'Finaliza' }}: {{ $evento->fecha_fin->format('d M, Y') }}
                            </p>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
        @endif

        <!-- Sección Eventos Activos Disponibles -->
        @if($eventosActivos->isNotEmpty())
        <div>
            <h3 class="text-2xl font-bold mb-6" style="display: flex; align-items: center; gap: 0.5rem;">
                <span style="background: linear-gradient(135deg, #10b981, #059669); color: white; padding: 0.25rem 0.75rem; border-radius: 8px; font-size: 0.85rem;">Activo</span>
                Eventos para Inscribirse
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($eventosActivos as $evento)
                    @if($evento)
                    <div class="evento-card">
                        <a href="{{ route('estudiante.eventos.show', $evento) }}">
                            <img class="h-48 w-full object-cover" src="{{ asset('storage/' . $evento->ruta_imagen) }}" alt="Imagen del evento">
                        </a>
                        <div class="p-6">
                            <h4>{{ $evento->nombre }}</h4>
                            <p class="mt-1">
                                Finaliza: {{ $evento->fecha_fin->format('d M, Y') }}
                            </p>
                            
                            {{-- Sección de Jurados --}}
                            @if($evento->jurados->isNotEmpty())
                                <div class="mt-4 pt-4" style="border-top: 1px solid rgba(232, 154, 60, 0.2);">
                                    <p style="font-size: 0.75rem; color: #6b6b6b; margin-bottom: 0.5rem;">
                                        <i class="fas fa-gavel" style="color: #e89a3c;"></i> Jurados:
                                    </p>
                                    <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                                        @foreach($evento->jurados->take(3) as $jurado)
                                            <span style="display: inline-flex; align-items: center; padding: 0.2rem 0.5rem; background: rgba(232, 154, 60, 0.1); border-radius: 20px; font-size: 0.7rem; color: #2c2c2c;">
                                                {{ $jurado->user->nombre ?? 'Jurado' }}
                                            </span>
                                        @endforeach
                                        @if($evento->jurados->count() > 3)
                                            <span style="font-size: 0.7rem; color: #6b6b6b;">
                                                +{{ $evento->jurados->count() - 3 }} más
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
        @endif

        <!-- Sección Próximos Eventos -->
        @if($eventosProximos->isNotEmpty())
        <div>
            <h3 class="text-2xl font-bold mb-6" style="display: flex; align-items: center; gap: 0.5rem;">
                <span style="background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; padding: 0.25rem 0.75rem; border-radius: 8px; font-size: 0.85rem;">Próximo</span>
                Próximos Eventos
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($eventosProximos as $evento)
                    @if($evento)
                    <div class="evento-card">
                        <a href="{{ route('estudiante.eventos.show', $evento) }}">
                            <img class="h-48 w-full object-cover" src="{{ asset('storage/' . $evento->ruta_imagen) }}" alt="Imagen del evento">
                        </a>
                        <div class="p-6">
                            <h4>{{ $evento->nombre }}</h4>
                            <p class="mt-1">
                                Inicia: {{ $evento->fecha_inicio->format('d M, Y') }}
                            </p>
                            
                            {{-- Sección de Jurados --}}
                            @if($evento->jurados->isNotEmpty())
                                <div class="mt-4 pt-4" style="border-top: 1px solid rgba(232, 154, 60, 0.2);">
                                    <p style="font-size: 0.75rem; color: #6b6b6b; margin-bottom: 0.5rem;">
                                        <i class="fas fa-gavel" style="color: #e89a3c;"></i> Jurados:
                                    </p>
                                    <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                                        @foreach($evento->jurados->take(3) as $jurado)
                                            <span style="display: inline-flex; align-items: center; padding: 0.2rem 0.5rem; background: rgba(232, 154, 60, 0.1); border-radius: 20px; font-size: 0.7rem; color: #2c2c2c;">
                                                {{ $jurado->user->nombre ?? 'Jurado' }}
                                            </span>
                                        @endforeach
                                        @if($evento->jurados->count() > 3)
                                            <span style="font-size: 0.7rem; color: #6b6b6b;">
                                                +{{ $evento->jurados->count() - 3 }} más
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
        @endif

        <!-- Sección Eventos Cerrados -->
        @if($eventosCerrados->isNotEmpty())
        <div>
            <h3 class="text-2xl font-bold mb-6" style="display: flex; align-items: center; gap: 0.5rem;">
                <span style="background: linear-gradient(135deg, #f59e0b, #d97706); color: white; padding: 0.25rem 0.75rem; border-radius: 8px; font-size: 0.85rem;">Cerrado</span>
                Eventos Cerrados
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($eventosCerrados as $evento)
                    @if($evento)
                    <div class="evento-card" style="opacity: 0.85;">
                        @if($eventosInscritosIds->contains($evento->id_evento))
                        <div class="inscrito-badge">
                            Inscrito
                        </div>
                        @endif
                        <a href="{{ route('estudiante.eventos.show', $evento) }}">
                            <img class="h-48 w-full object-cover" src="{{ asset('storage/' . $evento->ruta_imagen) }}" alt="Imagen del evento" style="filter: grayscale(20%);">
                        </a>
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <h4>{{ $evento->nombre }}</h4>
                                <span class="status-badge status-cerrado">
                                    {{ $evento->estado }}
                                </span>
                            </div>
                            <p class="mt-1">
                                Cerró: {{ $evento->fecha_fin->format('d M, Y') }}
                            </p>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
        @endif

        <!-- Sección Eventos Finalizados -->
        @if($eventosFinalizados->isNotEmpty())
        <div>
            <h3 class="text-2xl font-bold mb-6" style="display: flex; align-items: center; gap: 0.5rem;">
                <span style="background: linear-gradient(135deg, #6b7280, #4b5563); color: white; padding: 0.25rem 0.75rem; border-radius: 8px; font-size: 0.85rem;">Finalizado</span>
                Eventos Finalizados
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($eventosFinalizados as $evento)
                    @if($evento)
                    <div class="evento-card" style="opacity: 0.75;">
                        @if($eventosInscritosIds->contains($evento->id_evento))
                        <div class="inscrito-badge" style="background: linear-gradient(135deg, #6b7280, #4b5563);">
                            Participé
                        </div>
                        @endif
                        <a href="{{ route('estudiante.eventos.show', $evento) }}">
                            <img class="h-48 w-full object-cover" src="{{ asset('storage/' . $evento->ruta_imagen) }}" alt="Imagen del evento" style="filter: grayscale(40%);">
                        </a>
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <h4>{{ $evento->nombre }}</h4>
                                <span class="status-badge status-finalizado">
                                    {{ $evento->estado }}
                                </span>
                            </div>
                            <p class="mt-1">
                                Finalizó: {{ $evento->fecha_fin->format('d M, Y') }}
                            </p>
                            @if($eventosInscritosIds->contains($evento->id_evento))
                            <a href="{{ route('estudiante.eventos.posiciones', $evento) }}" 
                               style="display: inline-flex; align-items: center; gap: 0.5rem; margin-top: 0.75rem; padding: 0.4rem 0.75rem; background: linear-gradient(135deg, #e89a3c, #d98a2c); color: white; border-radius: 8px; font-size: 0.8rem; font-weight: 500; text-decoration: none; transition: all 0.2s;">
                                <i class="fas fa-trophy"></i> Ver Resultados
                            </a>
                            @endif
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
        @endif

        <!-- Estado vacío cuando no hay eventos -->
        @if($misEventosEnProgreso->isEmpty() && $misOtrosEventosInscritos->isEmpty() && $eventosActivos->isEmpty() && $eventosProximos->isEmpty() && $eventosCerrados->isEmpty() && $eventosFinalizados->isEmpty())
        <div class="empty-state" style="text-align: center; padding: 3rem;">
            <i class="fas fa-inbox" style="font-size: 4rem; margin-bottom: 1rem; color: #6b6b6b;"></i>
            <h3 style="font-size: 1.5rem; font-weight: 600; color: #2c2c2c; margin-bottom: 0.5rem;">No se encontraron eventos</h3>
            <p style="color: #6b6b6b;">
                @if($filtro || $search)
                    No hay eventos que coincidan con tu búsqueda. Intenta con otros filtros.
                @else
                    No hay eventos disponibles en este momento.
                @endif
            </p>
            @if($filtro || $search)
            <a href="{{ route('estudiante.eventos.index') }}" 
               style="display: inline-block; margin-top: 1rem; padding: 0.6rem 1.5rem; background: linear-gradient(135deg, #e89a3c, #d98a2c); color: white; border-radius: 12px; text-decoration: none; font-weight: 500;">
                Limpiar filtros
            </a>
            @endif
        </div>
        @endif

    </div>
</div>

@endsection

@push('styles')
<style>
    .status-cerrado {
        background: linear-gradient(135deg, #f59e0b, #d97706) !important;
        color: white !important;
    }
    
    .status-finalizado {
        background: linear-gradient(135deg, #6b7280, #4b5563) !important;
        color: white !important;
    }
    
    .status-proximo {
        background: linear-gradient(135deg, #3b82f6, #2563eb) !important;
        color: white !important;
    }
</style>
@endpush
