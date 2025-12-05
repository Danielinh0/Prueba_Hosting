@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
    
    /* =============================================== */
    /* PALETA MODERNA - ESTILO USUARIOS */
    /* =============================================== */
    .equipos-index-page {
        background: linear-gradient(to bottom, #FFFDF4, #FFEEE2);
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
    }
    
    /* Hero Section */
    .hero-section {
        background: linear-gradient(135deg, #2c2c2c 0%, #1a1a1a 100%);
        border-radius: 25px;
        padding: 2.5rem;
        margin-bottom: 2rem;
        box-shadow: 12px 12px 24px rgba(0, 0, 0, 0.3), -6px -6px 12px rgba(60, 60, 60, 0.2);
        position: relative;
        overflow: hidden;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -30%;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(232, 154, 60, 0.15) 0%, transparent 70%);
        pointer-events: none;
    }

    .hero-title {
        color: #ffffff;
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
    }

    .hero-subtitle {
        color: rgba(255, 255, 255, 0.7);
        font-size: 1rem;
    }

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
    
    /* Alert success */
    .alert-success {
        background: rgba(209, 250, 229, 0.8);
        border-left: 4px solid #10b981;
        color: #065f46;
        padding: 1rem;
        margin-bottom: 1.5rem;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        backdrop-filter: blur(10px);
    }
    
    .alert-success p {
        font-family: 'Poppins', sans-serif;
        color: #065f46;
    }
    
    /* Counter cards */
    .counter-card {
        background: #FFEEE2;
        border-radius: 20px;
        padding: 1.5rem;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
        transition: all 0.3s ease;
    }
    
    .counter-card:hover {
        box-shadow: 10px 10px 20px #e6d5c9, -10px -10px 20px #ffffff;
        transform: translateY(-3px);
    }
    
    .counter-card h3 {
        font-family: 'Poppins', sans-serif;
        color: #6b6b6b;
        font-size: 0.875rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .counter-card h3 svg {
        width: 1.25rem;
        height: 1.25rem;
    }
    
    .counter-card.total h3 svg { color: #3b82f6; }
    .counter-card.completos h3 svg { color: #10b981; }
    .counter-card.incompletos h3 svg { color: #f59e0b; }
    
    .counter-card p {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
        font-size: 1.875rem;
        font-weight: 600;
        margin-top: 0.25rem;
    }
    
    /* Filter card */
    .filter-card {
        background: #FFEEE2;
        border-radius: 20px;
        padding: 1.5rem;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
    }
    
    /* Inputs y selects */
    .neuro-input,
    .neuro-select {
        font-family: 'Poppins', sans-serif;
        background: rgba(255, 255, 255, 0.5);
        border: none;
        box-shadow: inset 4px 4px 8px #e6d5c9, inset -4px -4px 8px #ffffff;
        border-radius: 10px;
        padding: 0.625rem 1rem;
        transition: all 0.2s ease;
        backdrop-filter: blur(10px);
        color: #2c2c2c;
        font-size: 0.875rem;
    }
    
    .neuro-input::placeholder {
        color: #9ca3af;
    }
    
    .neuro-input:focus,
    .neuro-select:focus {
        outline: none;
        box-shadow: inset 6px 6px 12px #e6d5c9, inset -6px -6px 12px #ffffff;
    }
    
    /* Buttons */
    .neuro-button-primary {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #2c2c2c, #1a1a1a);
        color: #ffffff;
        font-weight: 600;
        font-size: 0.875rem;
        padding: 0.625rem 1.25rem;
        border-radius: 10px;
        border: none;
        transition: all 0.3s ease;
        box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.2);
    }
    
    .neuro-button-primary:hover {
        transform: translateY(-2px);
        box-shadow: 6px 6px 12px rgba(0, 0, 0, 0.3);
    }
    
    .neuro-button-secondary {
        font-family: 'Poppins', sans-serif;
        background: rgba(255, 255, 255, 0.5);
        color: #2c2c2c;
        font-weight: 500;
        font-size: 0.875rem;
        padding: 0.625rem 1.25rem;
        border-radius: 10px;
        border: none;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }
    
    .neuro-button-secondary:hover {
        box-shadow: 6px 6px 12px #e6d5c9, -6px -6px 12px #ffffff;
        transform: translateY(-2px);
    }
    
    /* Table container */
    .table-container {
        background: #FFEEE2;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
    }
    
    /* Table */
    .neuro-table {
        width: 100%;
        font-family: 'Poppins', sans-serif;
        border-collapse: collapse;
    }
    
    .neuro-table thead {
        background: rgba(255, 255, 255, 0.3);
        backdrop-filter: blur(5px);
    }
    
    .neuro-table thead th {
        padding: 1rem 1.5rem;
        text-align: left;
        font-size: 0.75rem;
        font-weight: 600;
        color: #2c2c2c;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    
    .neuro-table tbody tr {
        border-bottom: 1px solid rgba(107, 107, 107, 0.1);
        transition: all 0.2s ease;
    }
    
    .neuro-table tbody tr:hover {
        background: rgba(232, 154, 60, 0.05);
    }
    
    .neuro-table tbody tr:last-child {
        border-bottom: none;
    }
    
    .neuro-table tbody td {
        padding: 1rem 1.5rem;
        color: #2c2c2c;
        font-size: 0.875rem;
        vertical-align: middle;
    }
    
    /* Team cell */
    .team-cell {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .team-image {
        height: 3rem;
        width: 3rem;
        object-fit: cover;
        border-radius: 10px;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
    }
    
    .team-placeholder {
        height: 3rem;
        width: 3rem;
        background: rgba(229, 231, 235, 0.5);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: inset 2px 2px 4px #e6d5c9, inset -2px -2px 4px #ffffff;
    }
    
    .team-placeholder svg {
        width: 1.5rem;
        height: 1.5rem;
        color: #9ca3af;
    }
    
    .team-info .team-name {
        font-weight: 600;
        color: #2c2c2c;
        text-decoration: none;
        transition: color 0.2s ease;
    }
    
    .team-info .team-name:hover {
        color: #e89a3c;
    }
    
    .team-info .team-members {
        font-size: 0.75rem;
        color: #6b6b6b;
        display: flex;
        align-items: center;
        gap: 0.25rem;
        margin-top: 0.25rem;
    }
    
    /* Event link */
    .event-link {
        color: #e89a3c;
        text-decoration: none;
        font-size: 0.875rem;
        transition: color 0.2s ease;
    }
    
    .event-link:hover {
        color: #d98a2c;
        text-decoration: underline;
    }
    
    .no-event {
        color: #9ca3af;
        font-size: 0.875rem;
        font-style: italic;
    }
    
    /* Status badges */
    .status-badge {
        font-family: 'Poppins', sans-serif;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .status-completo {
        background: rgba(209, 250, 229, 0.8);
        color: #065f46;
    }
    
    .status-incompleto {
        background: rgba(254, 240, 138, 0.8);
        color: #854d0e;
    }
    
    /* Action buttons */
    .action-btn {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #2c2c2c, #1a1a1a);
        color: #ffffff;
        font-weight: 600;
        padding: 0.25rem 0.75rem;
        border-radius: 0.375rem;
        font-size: 0.75rem;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
        border: none;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }
    
    .action-btn:hover {
        box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.3);
        transform: translateY(-2px);
        color: #ffffff;
    }
    
    .action-btn.delete {
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        box-shadow: 2px 2px 4px rgba(220, 38, 38, 0.3);
    }
    
    .action-btn.delete:hover {
        box-shadow: 4px 4px 8px rgba(220, 38, 38, 0.4);
    }
    
    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 3rem 1.5rem;
        color: #6b6b6b;
    }
    
    .empty-state svg {
        width: 48px;
        height: 48px;
        margin: 0 auto 1rem;
        opacity: 0.5;
    }
    
    .empty-state p {
        color: var(--eq-text-muted);
        font-size: 0.9rem;
    }
    
    /* Pagination container */
    .pagination-container {
        padding: 1rem 1.5rem;
        background: rgba(255, 255, 255, 0.3);
        backdrop-filter: blur(5px);
    }
</style>

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