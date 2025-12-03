@extends('jurado.layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
    
    /* Fondo degradado */
    .eventos-page {
        background: linear-gradient(to bottom, #FFFDF4, #FFEEE2);
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
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
    
    /* Alert info */
    .info-alert {
        background: rgba(254, 243, 199, 0.8);
        border-left: 4px solid #f59e0b;
        padding: 1rem;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        backdrop-filter: blur(10px);
    }
    
    .info-alert p {
        font-family: 'Poppins', sans-serif;
        color: #b45309;
    }
    
    /* Evento card */
    .evento-card {
        background: #FFEEE2;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.3s ease;
        position: relative;
    }
    
    .evento-card:hover {
        box-shadow: 12px 12px 24px #e6d5c9, -12px -12px 24px #ffffff;
        transform: translateY(-5px);
    }
    
    .evento-card h4 {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
        font-weight: 700;
        font-size: 1.25rem;
    }
    
    .evento-card p {
        font-family: 'Poppins', sans-serif;
        color: #6b6b6b;
        font-size: 0.875rem;
    }
    
    /* Badge asignado */
    .asignado-badge {
        position: absolute;
        top: 0;
        right: 0;
        background: linear-gradient(135deg, #10b981, #059669);
        color: #ffffff;
        font-size: 0.75rem;
        font-weight: 700;
        padding: 0.5rem 0.75rem;
        border-bottom-left-radius: 15px;
        z-index: 10;
        box-shadow: 2px 2px 4px rgba(16, 185, 129, 0.3);
    }
    
    /* Badge de estado */
    .status-badge {
        font-family: 'Poppins', sans-serif;
        padding: 0.25rem 0.5rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .status-activo {
        background: linear-gradient(135deg, #2c2c2c, #1a1a1a);
        color: #ffffff;
    }
    
    .status-default {
        background: rgba(229, 231, 235, 0.8);
        color: #374151;
    }
    
    /* Empty state */
    .empty-state {
        background: #FFEEE2;
        border-radius: 15px;
        padding: 1.5rem;
        text-align: center;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        backdrop-filter: blur(10px);
    }
    
    .empty-state p {
        font-family: 'Poppins', sans-serif;
        color: #6b6b6b;
    }
</style>

<div class="eventos-page py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-12">
        <h2 class="font-semibold text-xl mb-6">Eventos Disponibles</h2>

        @if (session('info'))
            <div class="info-alert mb-6" role="alert">
                <p>{{ session('info') }}</p>
            </div>
        @endif

        <!-- Sección Mis Eventos Asignados -->
        <div>
            <h3 class="text-2xl font-bold mb-6">Mis Eventos Asignados</h3>
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
                    <p>Aún no tienes eventos asignados.</p>
                </div>
            @endif
        </div>

        <!-- Sección Eventos Activos Disponibles -->
        <div>
            <h3 class="text-2xl font-bold mb-6">Eventos Activos Disponibles</h3>
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
                    <p>No hay eventos próximos anunciados.</p>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection