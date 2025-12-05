@extends('jurado.layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
    
    /* Fondo degradado - igual que show */
    .eventos-page {
        background: linear-gradient(135deg, #fef3e2 0%, #fde8d0 100%);
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
        padding: 2rem;
    }
    
    /* Textos */
    .eventos-page h2,
    .eventos-page h3,
    .eventos-page h4 {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
    }
    
    .eventos-page p {
        font-family: 'Poppins', sans-serif;
        color: #5c5c5c;
    }
    
    /* Section headers - estilo show */
    .section-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
        padding: 1rem 1.5rem;
        background: linear-gradient(135deg, #e89a3c, #f5a847);
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(232, 154, 60, 0.3);
    }
    
    .section-header svg {
        width: 1.75rem;
        height: 1.75rem;
        color: white;
    }
    
    .section-header h3 {
        font-family: 'Poppins', sans-serif;
        font-size: 1.25rem;
        font-weight: 600;
        color: white;
        margin: 0;
    }
    
    /* Alert info */
    .info-alert {
        background: rgba(255, 255, 255, 0.9);
        border-left: 4px solid #e89a3c;
        padding: 1rem 1.5rem;
        border-radius: 0 15px 15px 0;
        box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.08), -2px -2px 8px rgba(255, 255, 255, 0.9);
    }
    
    .info-alert p {
        font-family: 'Poppins', sans-serif;
        color: #d97706;
        margin: 0;
    }
    
    /* Evento card - estilo show */
    .evento-card {
        background: rgba(255, 255, 255, 0.9);
        box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.08), -2px -2px 8px rgba(255, 255, 255, 0.9);
        border-radius: 15px;
        overflow: hidden;
        transition: all 0.3s ease;
        position: relative;
    }
    
    .evento-card:hover {
        transform: translateY(-4px);
        box-shadow: 6px 6px 15px rgba(0, 0, 0, 0.12), -3px -3px 10px rgba(255, 255, 255, 1);
    }
    
    .evento-card img {
        height: 200px;
        width: 100%;
        object-fit: cover;
    }
    
    .evento-card h4 {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
        font-weight: 700;
        font-size: 1.1rem;
    }
    
    .evento-card p {
        font-family: 'Poppins', sans-serif;
        color: #5c5c5c;
        font-size: 0.875rem;
    }
    
    .evento-card .p-6 {
        background: rgba(254, 243, 226, 0.5);
    }
    
    /* Badge asignado - estilo show */
    .asignado-badge {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        background: linear-gradient(135deg, #10b981, #059669);
        color: #ffffff;
        font-size: 0.8rem;
        font-weight: 600;
        padding: 0.5rem 1rem;
        text-align: center;
        z-index: 10;
        font-family: 'Poppins', sans-serif;
    }
    
    /* Badge de estado - estilo show */
    .status-badge {
        font-family: 'Poppins', sans-serif;
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .status-activo {
        background: linear-gradient(135deg, #e89a3c, #f5a847);
        color: #ffffff;
    }
    
    .status-default {
        background: rgba(254, 243, 226, 0.8);
        color: #d4a056;
        border: 1px solid rgba(232, 154, 60, 0.3);
    }
    
    /* Empty state - estilo show */
    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        background: rgba(255, 255, 255, 0.7);
        border-radius: 15px;
        box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.08), -2px -2px 8px rgba(255, 255, 255, 0.9);
    }
    
    .empty-state svg {
        width: 4rem;
        height: 4rem;
        color: #d4a056;
        margin: 0 auto 1rem;
        opacity: 0.6;
    }
    
    .empty-state p {
        font-family: 'Poppins', sans-serif;
        color: #5c5c5c;
        font-size: 0.95rem;
    }
    
    /* Botón volver - estilo show */
    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(255, 255, 255, 0.9);
        color: #e89a3c;
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 0.9rem;
        padding: 0.75rem 1.25rem;
        border-radius: 10px;
        text-decoration: none;
        box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.08), -2px -2px 8px rgba(255, 255, 255, 0.9);
        transition: all 0.3s ease;
    }
    
    .back-btn:hover {
        background: linear-gradient(135deg, #e89a3c, #f5a847);
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(232, 154, 60, 0.3);
    }
    
    .back-btn:hover svg path {
        stroke: #ffffff;
    }
    
    /* Page title - Index */
    .eventos-page-title {
        font-family: 'Poppins', sans-serif;
        font-size: 2rem;
        font-weight: 700;
        color: #2c2c2c;
        margin-bottom: 2rem;
    }
</style>

<div class="eventos-page">
    <div class="max-w-7xl mx-auto space-y-8">
        <!-- Botón volver al dashboard -->
        <a href="{{ route('jurado.dashboard') }}" class="back-btn">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" width="20" height="20">
                <path d="M15 6L9 12L15 18" stroke="#e89a3c" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Volver al Dashboard
        </a>
        
        <h1 class="eventos-page-title">Eventos Disponibles</h1>

        @if (session('info'))
            <div class="info-alert" role="alert">
                <p>{{ session('info') }}</p>
            </div>
        @endif

        <!-- Sección Mis Eventos Asignados -->
        <div>
            <div class="section-header">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                </svg>
                <h3>Mis Eventos Asignados</h3>
            </div>
            @if($misEventosInscritos->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($misEventosInscritos as $evento)
                        <div class="evento-card">
                            <div class="asignado-badge">
                                Asignado
                            </div>
                            <a href="{{ route('jurado.eventos.show', $evento) }}">
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
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                    <p>Aún no tienes eventos asignados.</p>
                </div>
            @endif
        </div>

        <!-- Sección Eventos Activos Disponibles -->
        <div>
            <div class="section-header">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                <h3>Eventos Activos Disponibles</h3>
            </div>
            @if($eventosActivos->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($eventosActivos as $evento)
                        <div class="evento-card">
                            <a href="{{ route('jurado.eventos.show', $evento) }}">
                                <img class="h-48 w-full object-cover" src="{{ asset('storage/' . $evento->ruta_imagen) }}" alt="Imagen del evento">
                            </a>
                            <div class="p-6">
                                <h4>{{ $evento->nombre }}</h4>
                                <p class="mt-1">
                                    Finaliza: {{ $evento->fecha_fin->format('d M, Y') }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    <p>No hay otros eventos activos en este momento.</p>
                </div>
            @endif
        </div>

        <!-- Sección Próximos Eventos -->
        <div>
            <div class="section-header">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <h3>Próximos Eventos</h3>
            </div>
            @if($eventosProximos->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($eventosProximos as $evento)
                        <div class="evento-card">
                            <a href="{{ route('jurado.eventos.show', $evento) }}">
                                <img class="h-48 w-full object-cover" src="{{ asset('storage/' . $evento->ruta_imagen) }}" alt="Imagen del evento">
                            </a>
                            <div class="p-6">
                                <h4>{{ $evento->nombre }}</h4>
                                <p class="mt-1">
                                    Inicia: {{ $evento->fecha_inicio->format('d M, Y') }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <p>No hay eventos próximos anunciados.</p>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection