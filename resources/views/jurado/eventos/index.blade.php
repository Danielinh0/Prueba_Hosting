@extends('jurado.layouts.app')

@section('content')

<div class="eventos-page">
    <div class="max-w-7xl mx-auto space-y-8">
        <!-- Botón volver al dashboard -->
        <a href="{{ route('dashboard') }}" class="back-link">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
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
                <div class="eventos-grid">
                    @foreach ($misEventosInscritos as $evento)
                        <div class="evento-card">
                            <div class="asignado-badge">
                                ✓ Asignado
                            </div>
                            <a href="{{ route('jurado.eventos.show', $evento) }}">
                                @if($evento->ruta_imagen)
                                    <img src="{{ asset('storage/' . $evento->ruta_imagen) }}" alt="Imagen del evento">
                                @else
                                    <div style="height: 200px; background: linear-gradient(135deg, #2c2c2c, #1a1a1a); display: flex; align-items: center; justify-content: center;">
                                        <svg style="width: 4rem; height: 4rem; color: rgba(232, 154, 60, 0.3);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                            </a>
                            <div class="p-6">
                                <div class="card-header-info">
                                    <h4>{{ $evento->nombre }}</h4>
                                    <span class="status-badge 
                                        @if ($evento->estado == 'Activo') status-activo @else status-default @endif">
                                        {{ $evento->estado }}
                                    </span>
                                </div>
                                <p style="margin-top: 0.5rem;">
                                    <svg style="width: 1rem; height: 1rem; display: inline; vertical-align: middle; color: #e89a3c;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
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
                <div class="eventos-grid">
                    @foreach ($eventosActivos as $evento)
                        <div class="evento-card">
                            <a href="{{ route('jurado.eventos.show', $evento) }}">
                                @if($evento->ruta_imagen)
                                    <img src="{{ asset('storage/' . $evento->ruta_imagen) }}" alt="Imagen del evento">
                                @else
                                    <div style="height: 200px; background: linear-gradient(135deg, #2c2c2c, #1a1a1a); display: flex; align-items: center; justify-content: center;">
                                        <svg style="width: 4rem; height: 4rem; color: rgba(232, 154, 60, 0.3);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                            </a>
                            <div class="p-6">
                                <h4>{{ $evento->nombre }}</h4>
                                <p style="margin-top: 0.5rem;">
                                    <svg style="width: 1rem; height: 1rem; display: inline; vertical-align: middle; color: #e89a3c;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
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
                <div class="eventos-grid">
                    @foreach ($eventosProximos as $evento)
                        <div class="evento-card">
                            <a href="{{ route('jurado.eventos.show', $evento) }}">
                                @if($evento->ruta_imagen)
                                    <img src="{{ asset('storage/' . $evento->ruta_imagen) }}" alt="Imagen del evento">
                                @else
                                    <div style="height: 200px; background: linear-gradient(135deg, #2c2c2c, #1a1a1a); display: flex; align-items: center; justify-content: center;">
                                        <svg style="width: 4rem; height: 4rem; color: rgba(232, 154, 60, 0.3);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                            </a>
                            <div class="p-6">
                                <h4>{{ $evento->nombre }}</h4>
                                <p style="margin-top: 0.5rem;">
                                    <svg style="width: 1rem; height: 1rem; display: inline; vertical-align: middle; color: #e89a3c;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
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


<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

    /* Back Link Neuromórfico */
    .back-link {
        font-family: 'Poppins', sans-serif;
        display: inline-flex;
        align-items: center;
        color: #e89a3c;
        font-size: 0.875rem;
        font-weight: 500;
        margin-bottom: 1rem;
        padding: 0.5rem 1rem;
        background: rgba(255, 253, 244, 0.9);
        border-radius: 10px;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        transition: all 0.2s ease;
        text-decoration: none;
    }
    
    .back-link:hover {
        color: #d98a2c;
        box-shadow: 6px 6px 12px #e6d5c9, -6px -6px 12px #ffffff;
        transform: translateY(-2px);
    }
    
    .back-link svg {
        width: 1rem;
        height: 1rem;
        margin-right: 0.5rem;
    }

    /* Fondo degradado neuromórfico */
    .eventos-page {
        background: linear-gradient(to bottom, #FFFDF4, #FFEEE2);
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
        color: #6b6b6b;
    }
    
    /* Section headers neuromórficos */
    .section-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
        padding: 1rem 1.5rem;
        background: linear-gradient(135deg, #e89a3c, #f5a847);
        border-radius: 15px;
        box-shadow: 4px 4px 8px rgba(232, 154, 60, 0.3);
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
    
    /* Alert info neuromórfico */
    .info-alert {
        background: linear-gradient(135deg, rgba(254, 240, 138, 0.8), rgba(252, 211, 77, 0.8));
        border-left: 4px solid #f59e0b;
        padding: 1rem 1.5rem;
        border-radius: 12px;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        backdrop-filter: blur(10px);
    }
    
    .info-alert p {
        font-family: 'Poppins', sans-serif;
        color: #92400e;
        margin: 0;
        font-weight: 500;
    }
    
    /* Evento card neuromórfica */
    .evento-card {
        background: #FFEEE2;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.3s ease;
        position: relative;
        border: none;
    }
    
    .evento-card:hover {
        transform: translateY(-5px);
        box-shadow: 12px 12px 24px #e6d5c9, -12px -12px 24px #ffffff;
    }
    
    .evento-card img {
        height: 200px;
        width: 100%;
        object-fit: cover;
        border-radius: 20px 20px 0 0;
    }
    
    .evento-card h4 {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
        font-weight: 700;
        font-size: 1.1rem;
        margin: 0;
    }
    
    .evento-card p {
        font-family: 'Poppins', sans-serif;
        color: #6b6b6b;
        font-size: 0.875rem;
        margin: 0;
    }
    
    .evento-card .p-6 {
        padding: 1.5rem;
        background: #FFEEE2;
    }
    
    /* Badge asignado */
    .asignado-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: linear-gradient(135deg, #10b981, #059669);
        color: #ffffff;
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.4rem 0.85rem;
        border-radius: 20px;
        z-index: 10;
        font-family: 'Poppins', sans-serif;
        box-shadow: 4px 4px 8px rgba(16, 185, 129, 0.3);
    }
    
    /* Badge de estado neuromórfico */
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
        box-shadow: 2px 2px 4px rgba(232, 154, 60, 0.3);
    }
    
    .status-default {
        background: rgba(255, 255, 255, 0.5);
        color: #d4a056;
        box-shadow: inset 2px 2px 4px #e6d5c9, inset -2px -2px 4px #ffffff;
    }
    
    /* Empty state neuromórfico */
    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        background: #FFEEE2;
        border-radius: 20px;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
    }
    
    .empty-state svg {
        width: 4rem;
        height: 4rem;
        color: #e89a3c;
        margin: 0 auto 1rem;
        opacity: 0.4;
    }
    
    .empty-state p {
        font-family: 'Poppins', sans-serif;
        color: #6b6b6b;
        font-size: 0.95rem;
    }
    
    /* Page title */
    .eventos-page-title {
        font-family: 'Poppins', sans-serif;
        font-size: 2rem;
        font-weight: 700;
        color: #2c2c2c;
        margin-bottom: 2rem;
    }

    /* Grid de eventos */
    .eventos-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 1.5rem;
    }

    /* Card header con info */
    .card-header-info {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 0.5rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .eventos-grid {
            grid-template-columns: 1fr;
        }

        .eventos-page {
            padding: 1rem;
        }

        .eventos-page-title {
            font-size: 1.5rem;
        }
    }
</style>
@endsection