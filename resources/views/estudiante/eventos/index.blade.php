@extends('layouts.app')

@section('content')

<div class="eventos-page py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-12">
        <a href="{{ route('estudiante.dashboard') }}" class="back-link">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver al Dashboard
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
        
        <!-- Filtro de Búsqueda -->
        <div class="filter-card" style="background: #FFEEE2; border-radius: 20px; padding: 1rem; margin-bottom: 2rem; box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;">
            <form action="{{ route('estudiante.eventos.index') }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <div class="md:col-span-2">
                        <input type="text" name="search" placeholder="Buscar por nombre de evento..." value="{{ $search ?? '' }}" 
                            style="font-family: 'Poppins', sans-serif; background: rgba(255, 255, 255, 0.5); border: none; box-shadow: inset 4px 4px 8px #e6d5c9, inset -4px -4px 8px #ffffff; color: #2c2c2c; width: 100%; padding: 0.5rem 1rem; border-radius: 0.375rem;"
                            class="w-full">
                    </div>
                    <div>
                        <select name="status" 
                            style="font-family: 'Poppins', sans-serif; background: rgba(255, 255, 255, 0.5); border: none; box-shadow: inset 4px 4px 8px #e6d5c9, inset -4px -4px 8px #ffffff; color: #2c2c2c; width: 100%; padding: 0.5rem 1rem; border-radius: 0.375rem;"
                            class="w-full">
                            <option value="">Todos los estados</option>
                            <option value="En Progreso" {{ ($statusFilter ?? '') == 'En Progreso' ? 'selected' : '' }}>En Progreso</option>
                            <option value="Activo" {{ ($statusFilter ?? '') == 'Activo' ? 'selected' : '' }}>Activo</option>
                            <option value="Próximo" {{ ($statusFilter ?? '') == 'Próximo' ? 'selected' : '' }}>Próximo</option>
                        </select>
                    </div>
                    <div>
                        <select name="inscripcion" 
                            style="font-family: 'Poppins', sans-serif; background: rgba(255, 255, 255, 0.5); border: none; box-shadow: inset 4px 4px 8px #e6d5c9, inset -4px -4px 8px #ffffff; color: #2c2c2c; width: 100%; padding: 0.5rem 1rem; border-radius: 0.375rem;"
                            class="w-full">
                            <option value="">Todos</option>
                            <option value="inscrito" {{ ($inscripcionFilter ?? '') == 'inscrito' ? 'selected' : '' }}>Inscrito</option>
                            <option value="no_inscrito" {{ ($inscripcionFilter ?? '') == 'no_inscrito' ? 'selected' : '' }}>Por inscribir</option>
                        </select>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button type="submit" style="font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #2c2c2c, #1a1a1a); color: #ffffff; font-weight: 600; padding: 0.5rem 1rem; border-radius: 0.375rem; box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.2); border: none; width: 100%;">Filtrar</button>
                        <a href="{{ route('estudiante.eventos.index') }}" style="font-family: 'Poppins', sans-serif; background: rgba(255, 255, 255, 0.5); color: #2c2c2c; font-weight: 500; padding: 0.5rem 1rem; border-radius: 0.375rem; box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff; border: none; text-decoration: none; text-align: center; width: 100%;">Limpiar</a>
                    </div>
                </div>
            </form>
        </div>

        @if (session('info'))
            <div class="info-alert mb-6" role="alert">
                <p>{{ session('info') }}</p>
            </div>
        @endif

        <!-- Sección Mis Eventos en Curso -->
        <div>
            <h3 class="text-2xl font-bold mb-6">Mis Eventos en Curso</h3>
            @if($misEventosEnProgreso->isNotEmpty())
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
            @else
                <div class="empty-state">
                    <p>No estás participando en ningún evento que esté en curso.</p>
                </div>
            @endif
        </div>

        <!-- Sección Otros Eventos Inscritos -->
        <div>
            <h3 class="text-2xl font-bold mb-6">Otros Eventos Inscritos</h3>
            @if($misOtrosEventosInscritos->isNotEmpty())
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
                                        @if ($evento->estado == 'Activo') status-activo @else status-default @endif">
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
            @else
                <div class="empty-state">
                    <p>No estás inscrito en otros eventos.</p>
                </div>
            @endif
        </div>

        <!-- Sección Eventos Activos Disponibles -->
        <div>
            <h3 class="text-2xl font-bold mb-6">Eventos Activos para Inscribirse</h3>
            @if($eventosActivos->isNotEmpty())
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
                                            <i class="fas fa-gavel" style="color: #e89a3c;"></i> Jurados del evento:
                                        </p>
                                        <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                                            @foreach($evento->jurados->take(4) as $jurado)
                                                <a href="{{ route('profile.edit') }}" 
                                                   title="{{ $jurado->user->nombre ?? 'Jurado' }} {{ $jurado->user->app_paterno ?? '' }}"
                                                   style="display: inline-flex; align-items: center; padding: 0.25rem 0.5rem; background: rgba(232, 154, 60, 0.1); border-radius: 20px; text-decoration: none; transition: all 0.2s;">
                                                    <span style="width: 24px; height: 24px; border-radius: 50%; background: linear-gradient(135deg, #e89a3c, #d98a2c); color: white; display: flex; align-items: center; justify-content: center; font-size: 0.65rem; font-weight: 600; margin-right: 0.35rem;">
                                                        {{ strtoupper(substr($jurado->user->nombre ?? 'J', 0, 1)) }}
                                                    </span>
                                                    <span style="font-size: 0.75rem; color: #2c2c2c; font-weight: 500;">
                                                        {{ $jurado->user->nombre ?? 'Jurado' }}
                                                    </span>
                                                </a>
                                            @endforeach
                                            @if($evento->jurados->count() > 4)
                                                <span style="display: inline-flex; align-items: center; padding: 0.25rem 0.5rem; background: rgba(107, 107, 107, 0.1); border-radius: 20px; font-size: 0.75rem; color: #6b6b6b;">
                                                    +{{ $evento->jurados->count() - 4 }} más
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
            @else
                <div class="empty-state">
                    <p>No hay otros eventos activos en este momento.</p>
                </div>
            @endif
        </div>

        <!-- Sección Próximos Eventos -->
        <div>
            <h3 class="text-2xl font-bold mb-6">Próximos Eventos</h3>
            @if($eventosProximos->isNotEmpty())
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
                                            <i class="fas fa-gavel" style="color: #e89a3c;"></i> Jurados del evento:
                                        </p>
                                        <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                                            @foreach($evento->jurados->take(4) as $jurado)
                                                <a href="{{ route('profile.edit') }}" 
                                                   title="{{ $jurado->user->nombre ?? 'Jurado' }} {{ $jurado->user->app_paterno ?? '' }}"
                                                   style="display: inline-flex; align-items: center; padding: 0.25rem 0.5rem; background: rgba(232, 154, 60, 0.1); border-radius: 20px; text-decoration: none; transition: all 0.2s;">
                                                    <span style="width: 24px; height: 24px; border-radius: 50%; background: linear-gradient(135deg, #e89a3c, #d98a2c); color: white; display: flex; align-items: center; justify-content: center; font-size: 0.65rem; font-weight: 600; margin-right: 0.35rem;">
                                                        {{ strtoupper(substr($jurado->user->nombre ?? 'J', 0, 1)) }}
                                                    </span>
                                                    <span style="font-size: 0.75rem; color: #2c2c2c; font-weight: 500;">
                                                        {{ $jurado->user->nombre ?? 'Jurado' }}
                                                    </span>
                                                </a>
                                            @endforeach
                                            @if($evento->jurados->count() > 4)
                                                <span style="display: inline-flex; align-items: center; padding: 0.25rem 0.5rem; background: rgba(107, 107, 107, 0.1); border-radius: 20px; font-size: 0.75rem; color: #6b6b6b;">
                                                    +{{ $evento->jurados->count() - 4 }} más
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
            @else
                <div class="empty-state">
                    <p>No hay eventos próximos anunciados.</p>
                </div>
            @endif
        </div>

    </div>
</div>

@endsection
