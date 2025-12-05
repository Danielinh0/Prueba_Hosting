@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
    
    /* Fondo degradado */
    .eventos-index-page {
        background: linear-gradient(to bottom, #FFFDF4, #FFEEE2);
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
    }
    
    /* Textos */
    .eventos-index-page h2,
    .eventos-index-page h3 {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
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
    
    .eventos-index-page p {
        font-family: 'Poppins', sans-serif;
        color: #6b6b6b;
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

    /* Create button */
    .create-button {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #2c2c2c, #1a1a1a);
        color: #ffffff;
        font-weight: 600;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
        border: none;
    }
    
    .create-button:hover {
        box-shadow: 6px 6px 12px rgba(0, 0, 0, 0.3);
        transform: translateY(-2px);
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
    
    .alert-success .font-bold {
        font-weight: 700;
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
    }
    
    .btn-clear:hover {
        box-shadow: 6px 6px 12px #e6d5c9, -6px -6px 12px #ffffff;
        transform: translateY(-2px);
    }
    
    /* Event card */
    .event-card {
        background: #FFEEE2;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
        transition: all 0.3s ease;
    }
    
    .event-card:hover {
        box-shadow: 12px 12px 24px #e6d5c9, -12px -12px 24px #ffffff;
        transform: translateY(-5px);
    }
    
    .event-card img {
        height: 12rem;
        width: 100%;
        object-fit: cover;
    }
    
    .event-card .placeholder {
        height: 12rem;
        width: 100%;
        background: rgba(229, 231, 235, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .event-card h3 {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
        font-weight: 700;
        font-size: 1.25rem;
        margin-bottom: 0.5rem;
    }
    
    .event-card p {
        font-family: 'Poppins', sans-serif;
        color: #6b6b6b;
        font-size: 0.875rem;
        margin-bottom: 1rem;
    }
    
    /* Status badge */
    .status-badge {
        font-family: 'Poppins', sans-serif;
        padding: 0.25rem 0.5rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        display: inline-flex;
        align-items: center;
    }
    
    .status-activo {
        background: linear-gradient(135deg, #2c2c2c, #1a1a1a);
        color: #ffffff;
    }
    
    .status-activo .dot {
        width: 0.5rem;
        height: 0.5rem;
        border-radius: 50%;
        background: #ffffff;
        margin-right: 0.25rem;
    }
    
    .status-cerrado {
        background: rgba(254, 240, 138, 0.8);
        color: #854d0e;
    }

    .status-en-progreso {
        background: linear-gradient(135deg, #6366f1, #4f46e5); /* Indigo gradient */
        color: #ffffff;
    }
    
    .status-proximo {
        background: rgba(191, 219, 254, 0.8);
        color: #1e40af;
    }
    
    .status-finalizado {
        background: rgba(229, 231, 235, 0.8);
        color: #374151;
    }
    
    /* Action buttons */
    .action-divider {
        border-top: 1px solid rgba(232, 154, 60, 0.2);
        padding-top: 1rem;
        margin-top: 1rem;
    }
    
    .btn-edit {
        background: linear-gradient(135deg, #2c2c2c, #1a1a1a);
        color: #ffffff;
        padding: 0.25rem 0.5rem;
        border-radius: 0.375rem;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
        border: none;
    }
    
    .btn-edit:hover {
        box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.3);
        transform: translateY(-2px);
    }
    
    .btn-delete {
        color: #9ca3af;
        transition: all 0.2s ease;
        background: none;
        border: none;
        cursor: pointer;
    }
    
    .btn-delete:hover {
        color: #ef4444;
    }
    
    /* Empty state */
    .empty-state {
        background: #FFEEE2;
        border-radius: 20px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
    }
    
    .empty-state p {
        font-family: 'Poppins', sans-serif;
        color: #6b6b6b;
    }
</style>

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