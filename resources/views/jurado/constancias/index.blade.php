@extends('jurado.layouts.app')

@section('title', 'Constancias')

@section('content')
<style>
    /* Contenedor principal */
    .constancias-container {
        max-width: 1200px;
        margin: 0 auto;
        margin-top: 50px;
        padding: 30px 20px;
        background: #FFF5ED;
        min-height: 80%;
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.4s ease;
        box-shadow: 8px 8px 16px rgba(230, 213, 201, 0.6);
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
    /* Título principal */
    .constancias-title {
        font-family: 'Poppins', sans-serif;
        font-size: 2.5rem;
        font-weight: 700;
        color: #2c2c2c;
        text-align: center;
        margin-bottom: 20px;
        letter-spacing: -0.5px;
        position: relative;
        padding-bottom: 15px;
    }

    .constancias-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 100px;
        height: 4px;
        background: linear-gradient(to right, #e89a3c, #f5a847);
        border-radius: 2px;
    }

    /* Subtítulo */
    .constancias-subtitle {
        font-family: 'Poppins', sans-serif;
        font-size: 1.1rem;
        color: #6b6b6b;
        text-align: center;
        margin-bottom: 50px;
        font-weight: 400;
        opacity: 0.9;
    }

    /* Grid de constancias */
    .constancias-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 30px;
        margin-top: 30px;
    }

    /* Tarjeta individual */
    .constancia-card {
        background: #FFEEE2;
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.4s ease;
        position: relative;
        border: 1px solid rgba(232, 154, 60, 0.1);
        box-shadow: 8px 8px 16px rgba(230, 213, 201, 0.6),
                   -8px -8px 16px rgba(255, 255, 255, 0.8);
        cursor: pointer;
    }

    .constancia-card:hover {
        transform: translateY(-5px);
        box-shadow: 12px 12px 24px rgba(230, 213, 201, 0.7),
                   -12px -12px 24px rgba(255, 255, 255, 0.9);
        border-color: rgba(232, 154, 60, 0.3);
    }

    /* Encabezado de tarjeta */
    .constancia-card-header {
        background: linear-gradient(135deg, #e89a3c, #f5a847);
        padding: 25px;
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
        font-size: 1.4rem;
        font-weight: 600;
        color: white;
        margin: 0;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        position: relative;
        z-index: 1;
    }

    /* Badge de estado */
    .constancia-badge {
        position: absolute;
        top: 20px;
        right: 20px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        padding: 5px 15px;
        border-radius: 20px;
        font-family: 'Poppins', sans-serif;
        font-size: 0.8rem;
        font-weight: 500;
        color: white;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Cuerpo de tarjeta */
    .constancia-card-body {
        padding: 30px;
        background: #FFEEE2;
    }

    .constancia-card-description {
        font-family: 'Poppins', sans-serif;
        font-size: 1rem;
        color: #2c2c2c;
        line-height: 1.6;
        margin-bottom: 25px;
        opacity: 0.9;
    }

    /* Información adicional */
    .constancia-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        padding-bottom: 20px;
        border-bottom: 1px solid rgba(232, 154, 60, 0.2);
    }

    .constancia-date {
        font-family: 'Poppins', sans-serif;
        font-size: 0.95rem;
        color: #6b6b6b;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .constancia-date i {
        color: #e89a3c;
        font-size: 1.1rem;
    }

    .constancia-participants {
        font-family: 'Poppins', sans-serif;
        font-size: 0.95rem;
        color: #6b6b6b;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .constancia-participants i {
        color: #e89a3c;
        font-size: 1.1rem;
    }

    /* Botón de acción */
    .constancia-action {
        text-align: center;
    }

    .constancia-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        background: linear-gradient(135deg, #e89a3c, #f5a847);
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 50px;
        font-family: 'Poppins', sans-serif;
        font-size: 1rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(232, 154, 60, 0.3);
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
        box-shadow: 0 6px 20px rgba(232, 154, 60, 0.4);
        color: white;
        text-decoration: none;
    }

    .constancia-btn:hover::before {
        left: 100%;
    }

    .constancia-btn i {
        font-size: 1.1rem;
        transition: transform 0.3s ease;
    }

    .constancia-btn:hover i {
        transform: translateX(5px);
    }

    /* Estado cuando no hay eventos */
    .no-constancias {
        grid-column: 1 / -1;
        text-align: center;
        padding: 60px 20px;
        background: #FFEEE2;
        border-radius: 20px;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
    }

    .no-constancias i {
        font-size: 4rem;
        color: #e89a3c;
        margin-bottom: 20px;
        opacity: 0.5;
    }

    .no-constancias h3 {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
        font-size: 1.5rem;
        margin-bottom: 10px;
    }

    .no-constancias p {
        font-family: 'Poppins', sans-serif;
        color: #6b6b6b;
        font-size: 1rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .constancias-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .constancias-title {
            font-size: 2rem;
        }

        .constancia-card {
            margin: 0 10px;
        }

        .constancia-info {
            flex-direction: column;
            gap: 15px;
            align-items: flex-start;
        }
    }

    /* Efecto de carga */
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

    .constancia-card {
        animation: fadeInUp 0.5s ease forwards;
        opacity: 0;
    }

    .constancia-card:nth-child(1) { animation-delay: 0.1s; }
    .constancia-card:nth-child(2) { animation-delay: 0.2s; }
    .constancia-card:nth-child(3) { animation-delay: 0.3s; }
    .constancia-card:nth-child(4) { animation-delay: 0.4s; }
    .constancia-card:nth-child(5) { animation-delay: 0.5s; }
</style>

<div class="constancias-container">
    <a href="{{ route('jurado.dashboard') }}" class="back-link">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
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
                    @if($evento->estado == 'Finalizado')
                        <span class="constancia-badge">Disponible</span>
                    @else
                        <span class="constancia-badge" style="background: rgba(255,255,255,0.1);">En proceso</span>
                    @endif
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
                            <button class="constancia-btn" style="opacity: 0.7; cursor: not-allowed;" disabled>
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
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
@endsection