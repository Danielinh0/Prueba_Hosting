@extends('layouts.app')

@section('title', 'Constancias')

@section('content')

<div class="constancias-container-ctsi">
    <a href="{{ route('estudiante.dashboard') }}" class="back-link-ctsi">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Volver al Dashboard
    </a>
    
    <!-- Hero Section -->
    <div class="hero-section-ctsi">
        <div class="hero-content-ctsi">
            <div class="hero-text-ctsi">
                <h1><span>Constancias</span></h1>
                <p>Descarga las constancias de participación de los eventos en los que has participado.</p>
            </div>
        </div>
    </div>

    <div class="constancias-grid-ctsi">
        @forelse($eventosTotalesInscritos as $evento)
            <div class="constancia-card-ctsi">
                <div class="constancia-card-header-ctsi">
                    <h3 class="constancia-card-title-ctsi">{{ $evento->nombre }}</h3>
                    @if($evento->estado == 'Finalizado')
                        <span class="constancia-badge-ctsi">Disponible</span>
                    @else
                        <span class="constancia-badge-ctsi" style="background: rgba(255,255,255,0.1);">En proceso</span>
                    @endif
                </div>
                <div class="constancia-card-body-ctsi">
                    <p class="constancia-card-description-ctsi">
                        {{ Str::limit($evento->descripcion, 150) }}
                    </p>
                    
                    <div class="constancia-info-ctsi">
                        <div class="constancia-date-ctsi">
                            <i class="far fa-calendar-alt"></i>
                            {{ \Carbon\Carbon::parse($evento->fecha_inicio)->format('d M, Y') }}
                        </div>
                    </div>
                    
                    <div class="constancia-action-ctsi">
                        @if($evento->estado == 'Finalizado')
                            <a href="{{ route('estudiante.constancias.ver', $evento)}}" 
                               class="constancia-btn-ctsi" target="_blank">
                                <i class="fas fa-file-pdf"></i> Ver Constancia
                            </a>
                        @else
                            <button class="constancia-btn-ctsi" style="opacity: 0.7; cursor: not-allowed;" disabled>
                                <i class="fas fa-clock"></i> Constancia en Proceso
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="no-constancias-ctsi">
                <i class="far fa-file-alt"></i>
                <h3>No hay constancias disponibles</h3>
                <p>No tienes eventos completados con constancias generadas aún.</p>
            </div>
        @endforelse
    </div>
</div>

<!-- Font Awesome para iconos -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

@endsection