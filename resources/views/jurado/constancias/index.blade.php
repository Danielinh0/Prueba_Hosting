@extends('jurado.layouts.app')

@section('title', 'Constancias')

@section('content')

<div class="constancias-container">
    <a href="{{ route('jurado.dashboard') }}" class="back-btn">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15 6L9 12L15 18" stroke="#e89a3c" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Volver al Dashboard
    </a>
    
    <h1 class="constancias-title">Constancias Disponibles</h1>
    <p class="constancias-subtitle">Eventos en los que has evaluado y puedes generar constancia</p>

    <div class="constancias-grid">
        @forelse($eventosTotalesInscritos as $evento)
            <div class="constancia-card">
                <div class="constancia-card-header">
                    <h3 class="constancia-card-title">{{ $evento->nombre }}</h3>
                </div>
                <div class="constancia-card-body">
                    <p class="constancia-card-description">
                        {{ Str::limit($evento->descripcion, 150) }}
                    </p>
                    
                    <div class="constancia-info">
                        <div class="constancia-date">
                            <i class="far fa-calendar-alt"></i>
                            {{ \Carbon\Carbon::parse($evento->fecha_inicio)->format('d M, Y') }}
                        </div>
                    </div>
                    
                    <div class="constancia-action">
                        @if($evento->estado == 'Finalizado')
                            <a href="{{ route('jurado.constancias.ver', $evento)}}" 
                               class="constancia-btn" target="_blank">
                                <i class="fas fa-file-pdf"></i> Ver Constancia
                            </a>
                        @else
                            <button class="constancia-btn" disabled>
                                <i class="fas fa-clock"></i> Constancia en Proceso
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="no-constancias">
                <i class="far fa-file-alt"></i>
                <h3>No hay constancias disponibles</h3>
                <p>No tienes eventos completados con constancias generadas aún.</p>
            </div>
        @endforelse
    </div>
</div>

<!-- Font Awesome para iconos -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

    /* Contenedor principal neuromórfico */
    .constancias-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem 1rem;
        background: linear-gradient(to bottom, #FFFDF4, #FFEEE2);
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
    }

    /* Back button neuromórfico */
    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(255, 253, 244, 0.9);
        color: #e89a3c;
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 0.9rem;
        padding: 0.75rem 1.25rem;
        border-radius: 12px;
        text-decoration: none;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        transition: all 0.3s ease;
        margin-bottom: 2rem;
    }

    .back-btn:hover {
        color: #d98a2c;
        transform: translateY(-2px);
        box-shadow: 6px 6px 12px #e6d5c9, -6px -6px 12px #ffffff;
    }

    .back-btn:hover svg path {
        stroke: #d98a2c;
    }

    .back-btn svg {
        width: 20px;
        height: 20px;
    }

    .back-btn svg path {
        transition: all 0.3s ease;
    }

    /* Título principal */
    .constancias-title {
        font-family: 'Poppins', sans-serif;
        font-size: 2rem;
        font-weight: 700;
        color: #2c2c2c;
        text-align: center;
        margin-bottom: 0.75rem;
        letter-spacing: -0.5px;
    }

    /* Subtítulo */
    .constancias-subtitle {
        font-family: 'Poppins', sans-serif;
        font-size: 1rem;
        color: #6b7280;
        text-align: center;
        margin-bottom: 3rem;
        font-weight: 400;
    }

    /* Grid de constancias */
    .constancias-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
    }

    /* Tarjeta individual neuromórfica */
    .constancia-card {
        background: #FFEEE2;
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.4s ease;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
        animation: fadeInUp 0.5s ease forwards;
        opacity: 0;
    }

    .constancia-card:hover {
        transform: translateY(-5px);
        box-shadow: 12px 12px 24px #e6d5c9, -12px -12px 24px #ffffff;
    }

    /* Animación de entrada */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .constancia-card:nth-child(1) { animation-delay: 0.1s; }
    .constancia-card:nth-child(2) { animation-delay: 0.2s; }
    .constancia-card:nth-child(3) { animation-delay: 0.3s; }
    .constancia-card:nth-child(4) { animation-delay: 0.4s; }
    .constancia-card:nth-child(5) { animation-delay: 0.5s; }
    .constancia-card:nth-child(6) { animation-delay: 0.6s; }

    /* Encabezado de tarjeta - MANTENER GRADIENTE */
    .constancia-card-header {
        background: linear-gradient(135deg, #e89a3c, #f5a847);
        padding: 1.5rem;
        position: relative;
        overflow: hidden;
    }

    .constancia-card-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.1) 50%, transparent 70%);
        animation: shimmer 3s infinite linear;
    }

    @keyframes shimmer {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }

    .constancia-card-title {
        font-family: 'Poppins', sans-serif;
        font-size: 1.25rem;
        font-weight: 600;
        color: white;
        margin: 0;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        position: relative;
        z-index: 1;
    }

    /* Badge de estado (si se necesita) */
    .constancia-badge {
        position: absolute;
        top: 1.25rem;
        right: 1.25rem;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        padding: 0.35rem 0.85rem;
        border-radius: 20px;
        font-family: 'Poppins', sans-serif;
        font-size: 0.7rem;
        font-weight: 500;
        color: white;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
    }

    /* Cuerpo de tarjeta */
    .constancia-card-body {
        padding: 1.5rem;
    }

    .constancia-card-description {
        font-family: 'Poppins', sans-serif;
        font-size: 0.9rem;
        color: #2c2c2c;
        line-height: 1.6;
        margin-bottom: 1.5rem;
    }

    /* Información adicional */
    .constancia-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid rgba(232, 154, 60, 0.15);
    }

    .constancia-date {
        font-family: 'Poppins', sans-serif;
        font-size: 0.875rem;
        color: #6b7280;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .constancia-date i {
        color: #e89a3c;
        font-size: 1rem;
    }

    .constancia-participants {
        font-family: 'Poppins', sans-serif;
        font-size: 0.875rem;
        color: #6b7280;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .constancia-participants i {
        color: #e89a3c;
        font-size: 1rem;
    }

    /* Botón de acción neuromórfico */
    .constancia-action {
        text-align: center;
    }

    .constancia-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.625rem;
        background: linear-gradient(135deg, #e89a3c, #f5a847);
        color: white;
        border: none;
        padding: 0.75rem 1.875rem;
        border-radius: 20px;
        font-family: 'Poppins', sans-serif;
        font-size: 0.95rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 4px 4px 8px rgba(232, 154, 60, 0.3);
        width: 100%;
        position: relative;
        overflow: hidden;
    }

    .constancia-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }

    .constancia-btn:hover {
        transform: translateY(-2px);
        box-shadow: 6px 6px 12px rgba(232, 154, 60, 0.4);
        color: white;
        text-decoration: none;
    }

    .constancia-btn:hover::before {
        left: 100%;
    }

    .constancia-btn i {
        font-size: 1rem;
        transition: transform 0.3s ease;
    }

    .constancia-btn:hover i {
        transform: translateX(3px);
    }

    /* Botón deshabilitado */
    .constancia-btn:disabled {
        background: linear-gradient(135deg, rgba(156, 163, 175, 0.8), rgba(209, 213, 219, 0.8));
        color: #4b5563;
        box-shadow: 4px 4px 8px rgba(156, 163, 175, 0.3);
        cursor: not-allowed;
    }

    .constancia-btn:disabled:hover {
        transform: none;
        box-shadow: 4px 4px 8px rgba(156, 163, 175, 0.3);
    }

    .constancia-btn:disabled i {
        transform: none !important;
    }

    /* Estado cuando no hay eventos */
    .no-constancias {
        grid-column: 1 / -1;
        text-align: center;
        padding: 4rem 2rem;
        background: #FFEEE2;
        border-radius: 20px;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
    }

    .no-constancias i {
        font-size: 4rem;
        color: #e89a3c;
        margin-bottom: 1.5rem;
        opacity: 0.4;
    }

    .no-constancias h3 {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 0.75rem;
    }

    .no-constancias p {
        font-family: 'Poppins', sans-serif;
        color: #6b7280;
        font-size: 1rem;
        margin: 0;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .constancias-container {
            padding: 1.5rem 0.75rem;
        }

        .constancias-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .constancias-title {
            font-size: 1.75rem;
        }

        .constancias-subtitle {
            font-size: 0.9rem;
            margin-bottom: 2rem;
        }

        .constancia-card-header {
            padding: 1.25rem;
        }

        .constancia-card-title {
            font-size: 1.125rem;
        }

        .constancia-info {
            flex-direction: column;
            gap: 0.75rem;
            align-items: flex-start;
        }

        .no-constancias {
            padding: 3rem 1.5rem;
        }

        .no-constancias i {
            font-size: 3rem;
        }

        .no-constancias h3 {
            font-size: 1.25rem;
        }

        .no-constancias p {
            font-size: 0.9rem;
        }
    }

    @media (max-width: 480px) {
        .constancias-grid {
            grid-template-columns: 1fr;
        }

        .constancia-card {
            margin: 0;
        }
    }
</style>
@endsection