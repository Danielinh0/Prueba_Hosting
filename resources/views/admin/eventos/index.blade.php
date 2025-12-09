@extends('layouts.app')

@section('content')

<div class="eventos-index-page py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('dashboard') }}" class="back-link">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver al Dashboard
        </a>
        <div class="flex justify-between items-center mb-6">
            <!-- Hero Section -->
            <div class="hero-section" style="flex: 1;">
                <h1 class="hero-title">Gestión de Eventos</h1>
                <p class="hero-subtitle">Crea, administra y supervisa todos los eventos académicos del sistema</p>
            </div>
        </div>
       
        
        @if (session('success'))
            <div class="alert-success" role="alert">
                <p class="font-bold">Éxito</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <!-- Filtros y Búsqueda -->
        <div class="filter-card">
            <form action="{{ route('admin.eventos.index') }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="md:col-span-2">
                        <label for="search" class="sr-only">Buscar</label>
                        <input type="text" name="search" id="search" placeholder="Buscar por nombre de evento..." value="{{ request('search') }}" class="neuro-input">
                    </div>
                    <div>
                        <label for="status" class="sr-only">Estado</label>
                        <select name="status" id="status" class="neuro-select">
                            <option value="">Todos los estados</option>
                            <option value="En Progreso" {{ request('status') == 'En Progreso' ? 'selected' : '' }}>En Progreso</option>
                            <option value="Próximo" {{ request('status') == 'Próximo' ? 'selected' : '' }}>Próximo</option>
                            <option value="Activo" {{ request('status') == 'Activo' ? 'selected' : '' }}>Activo</option>
                            <option value="Cerrado" {{ request('status') == 'Cerrado' ? 'selected' : '' }}>Cerrado</option>
                            <option value="Finalizado" {{ request('status') == 'Finalizado' ? 'selected' : '' }}>Finalizado</option>
                        </select>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button type="submit" class="btn-filter w-full justify-center">Filtrar</button>
                        <a href="{{ route('admin.eventos.index') }}" class="btn-clear w-full text-center">Limpiar</a>
                    </div>
                </div>
            </form>
        </div>
         <div class="flex justify-end mb-4">
            <a href="{{ route('admin.eventos.create') }}" class="create-button inline-flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Crear Nuevo Evento
            </a>
        </div>

        @php
            $statusOrder = ['En Progreso', 'Activo', 'Próximo', 'Cerrado', 'Finalizado'];
        @endphp

        @foreach ($statusOrder as $status)
            @if (isset($eventosAgrupados[$status]) && $eventosAgrupados[$status]->isNotEmpty())
                <h3 class="font-bold text-2xl mb-4 mt-8">{{ $status }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-8">
                    @foreach ($eventosAgrupados[$status] as $evento)
                        <div class="event-card">
                            <a href="{{ route('admin.eventos.show', $evento) }}">
                                @if ($evento->ruta_imagen)
                                    <img src="{{ asset('storage/' . $evento->ruta_imagen) }}" alt="Imagen del evento: {{ $evento->nombre }}">
                                @else
                                    <div class="placeholder">
                                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                @endif
                            </a>
                            <div class="p-6">
                                <div class="flex items-center justify-between">
                                    <h3>{{ $evento->nombre }}</h3>
                                    <span class="status-badge 
                                        @if ($evento->estado == 'Activo') status-activo
                                        @elseif ($evento->estado == 'En Progreso') status-en-progreso
                                        @elseif ($evento->estado == 'Cerrado') status-cerrado
                                        @elseif ($evento->estado == 'Próximo') status-proximo
                                        @else status-finalizado @endif">
                                        @if ($evento->estado == 'Activo')
                                            <span class="dot"></span>
                                        @endif
                                        {{ $evento->estado }}
                                    </span>
                                </div>
                                <p>
                                    {{ $evento->fecha_inicio->format('d M, Y') }} - {{ $evento->fecha_fin->format('d M, Y') }}
                                </p>
                                
                                <div class="action-divider flex items-center justify-end space-x-3">
                                    <a href="{{ route('admin.eventos.edit', $evento) }}" class="btn-edit inline-flex items-center" title="Editar Evento">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.5L16.732 3.732z"></path></svg>
                                    </a>
                                    <form action="{{ route('admin.eventos.destroy', $evento->id_evento) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este evento? Esta acción es irreversible.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete" title="Eliminar Evento">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <h3 class="font-bold text-2xl mb-4 mt-8">{{ $status }}</h3>
                <div class="empty-state">
                    <p>No hay eventos con estado "{{ $status }}".</p>
                </div>
            @endif
        @endforeach
    </div>
</div>
@endsection