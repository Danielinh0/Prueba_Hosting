@extends('layouts.app')

@section('content')


<div class="equipos-index-page py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('dashboard') }}" class="back-link">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver al Dashboard
        </a>
        
        <!-- Hero Section -->
        <div class="hero-section">
            <h1 class="hero-title">Gestión de Equipos</h1>
            <p class="hero-subtitle">Administra y supervisa todos los equipos registrados en los eventos</p>
        </div>
        
        @if (session('success'))
            <div class="alert-success" role="alert">
                <p class="font-bold">Éxito</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <!-- Contadores -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="counter-card total">
                <h3>
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    Total de Equipos
                </h3>
                <p>{{ $totalEquipos }}</p>
            </div>
            <div class="counter-card completos">
                <h3>
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Equipos Completos
                </h3>
                <p>{{ $equiposCompletos }}</p>
            </div>
            <div class="counter-card incompletos">
                <h3>
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Equipos Incompletos
                </h3>
                <p>{{ $equiposIncompletos }}</p>
            </div>
        </div>

        <!-- Filtros y Búsqueda -->
        <div class="filter-card mb-8">
            <form action="{{ route('admin.equipos.index') }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <div class="md:col-span-2">
                        <input type="text" name="search" placeholder="Buscar por nombre del equipo..." value="{{ request('search') }}" class="neuro-input block w-full">
                    </div>
                    <div>
                        <select name="estado" class="neuro-select block w-full">
                            <option value="">Todos los estados</option>
                            <option value="completo" {{ request('estado') == 'completo' ? 'selected' : '' }}>Completos</option>
                            <option value="incompleto" {{ request('estado') == 'incompleto' ? 'selected' : '' }}>Incompletos</option>
                        </select>
                    </div>
                    <div>
                        <select name="evento" class="neuro-select block w-full">
                            <option value="">Todos los eventos</option>
                            @foreach($eventos as $evento)
                                <option value="{{ $evento->id_evento }}" {{ request('evento') == $evento->id_evento ? 'selected' : '' }}>
                                    {{ $evento->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button type="submit" class="neuro-button-primary flex-1">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            Filtrar
                        </button>
                        <a href="{{ route('admin.equipos.index') }}" class="neuro-button-secondary flex-1 text-center">Limpiar</a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Tabla de Equipos -->
        <div class="table-container">
            <div class="overflow-x-auto">
                <table class="neuro-table">
                    <thead>
                        <tr>
                            <th scope="col">Equipo</th>
                            <th scope="col">Evento</th>
                            <th scope="col">Estado</th>
                            <th scope="col" class="text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($equipos as $equipo)
                            <tr>
                                <td>
                                    <div class="team-cell">
                                        @if ($equipo->ruta_imagen)
                                            <img class="team-image" src="{{ asset('storage/' . $equipo->ruta_imagen) }}" alt="Imagen del equipo">
                                        @else
                                            <div class="team-placeholder">
                                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                            </div>
                                        @endif
                                        <div class="team-info">
                                            <a href="{{ route('admin.equipos.show', $equipo) }}" class="team-name">{{ $equipo->nombre }}</a>
                                            <div class="team-members">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                                {{ $equipo->miembros->count() }} miembros
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($equipo->inscripciones->first() && $equipo->inscripciones->first()->evento)
                                        <a href="{{ route('admin.eventos.show', $equipo->inscripciones->first()->evento) }}" class="event-link">
                                            {{ $equipo->inscripciones->first()->evento->nombre }}
                                        </a>
                                    @else
                                        <span class="no-event">Sin evento</span>
                                    @endif
                                </td>
                                <td>
                                    @if($equipo->inscripciones->first())
                                        @if($equipo->inscripciones->first()->status_registro === 'Completo')
                                            <span class="status-badge status-completo">Completo</span>
                                        @else
                                            <span class="status-badge status-incompleto">Incompleto</span>
                                        @endif
                                    @else
                                        <span class="status-badge status-incompleto">Sin inscripción</span>
                                    @endif
                                </td>
                                <td class="text-right">
                                    <div class="flex items-center justify-end space-x-2">
                                        <a href="{{ route('admin.equipos.show', $equipo) }}" class="action-btn">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            Ver
                                        </a>
                                        <a href="{{ route('admin.equipos.edit', $equipo) }}" class="action-btn">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            Editar
                                        </a>
                                        <form action="{{ route('admin.equipos.destroy', $equipo) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este equipo?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn delete">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    <div class="empty-state">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        <p>No se encontraron equipos con los criterios seleccionados.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($equipos->hasPages())
                <div class="pagination-container">
                    {{ $equipos->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection