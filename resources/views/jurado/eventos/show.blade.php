@extends('jurado.layouts.app')
@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

    .evento-detail-page {
        background: linear-gradient(to bottom, #FFF8F0, #FFEEE2);
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
        padding: 30px 40px;
    }

    .evento-detail-container {
        max-width: 1100px;
        margin: 0 auto;
    }

    /* Header con imagen del evento */
    .evento-header {
        display: flex;
        gap: 40px;
        margin-bottom: 30px;
        align-items: flex-start;
    }

    .evento-imagen {
        position: relative;
        border-radius: 16px;
        overflow: hidden;
        flex-shrink: 0;
        width: 380px;
        background: white;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    }

    .evento-imagen img {
        width: 100%;
        height: 220px;
        object-fit: cover;
        display: block;
    }

    .status-badge-large {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: #DB8C57;
        color: white;
        padding: 10px 20px;
        text-align: center;
        font-weight: 600;
        font-size: 0.95rem;
    }

    /* Descripción del evento */
    .descripcion-section {
        flex: 1;
    }

    .descripcion-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: #2c2c2c;
        margin-bottom: 12px;
    }

    .descripcion-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    }

    .descripcion-header {
        background: #DB8C57;
        color: white;
        padding: 14px 20px;
        text-align: center;
        font-weight: 600;
        font-size: 1.1rem;
    }

    .descripcion-body {
        padding: 20px 25px;
        color: #8a8a8a;
        line-height: 1.6;
        font-size: 0.95rem;
        border: 2px solid #f0f0f0;
        border-top: none;
        border-radius: 0 0 16px 16px;
    }

    /* Sección de equipos */
    .equipos-section {
        margin-top: 20px;
    }

    .section-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: #2c2c2c;
        margin-bottom: 15px;
    }

    .equipos-card {
        background: rgba(255, 255, 255, 0.5);
        border-radius: 16px;
        padding: 25px 30px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    }

    .equipos-subtitle {
        font-weight: 600;
        font-size: 1.05rem;
        color: #2c2c2c;
        margin-bottom: 20px;
    }

    /* Lista de equipos */
    .equipo-item {
        display: flex;
        align-items: center;
        padding: 12px 0;
        gap: 15px;
    }

    .equipo-item:not(:last-child) {
        border-bottom: 1px solid #f5f5f5;
    }

    .equipo-field {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        color: #9a9a9a;
        font-size: 0.9rem;
        padding: 10px 20px;
        background: #FFEFDC;
        border-radius: 10px;
        
        flex: 1;
        text-align: center;
    }

    .equipo-field.nombre {
        flex: 1;
    }

    .equipo-field.lider {
        flex: 1;
    }

    .equipo-field.miembros {
        flex: 1;
    }

    .equipo-field svg {
        width: 20px;
        height: 20px;
        color: #9a9a9a;
        flex-shrink: 0;
    }

    .btn-explorar {
        background: #F0BC7B;
        color: white;
        padding: 10px 22px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
        transition: background 0.2s;
        flex-shrink: 0;
    }

    .btn-explorar:hover {
        background: #dca970;
        color: white;
    }

    .btn-explorar svg {
        width: 18px;
        height: 18px;
    }

    .empty-equipos {
        text-align: center;
        padding: 40px;
        color: #9a9a9a;
        font-size: 1rem;
    }

    .jurado-status {
        margin-top: 15px;
        padding: 12px 20px;
        border-radius: 10px;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .jurado-status.no-asignado {
        background: #FFF3E0;
        color: #E65100;
        border: 1px solid #FFCC80;
    }

    .jurado-status.asignado {
        background: #E8F5E9;
        color: #2E7D32;
        border: 1px solid #A5D6A7;
    }

    .status-badge-large.proximo {
        background: #6e9edc;
    }

    @media (max-width: 900px) {
        .evento-header {
            flex-direction: column;
        }
        
        .evento-imagen {
            width: 100%;
            max-width: 400px;
        }
        
        .equipo-item {
            flex-wrap: wrap;
            gap: 10px;
        }
        
        .btn-explorar {
            margin-left: 0;
            margin-top: 10px;
        }
    }
</style>

<div class="evento-detail-page">
    <div class="evento-detail-container">
        
        <!-- Header con imagen y descripción -->
        <div class="evento-header">
            <!-- Imagen del evento -->
            <div class="evento-imagen">
                <img src="{{ asset('storage/' . $evento->ruta_imagen) }}" alt="{{ $evento->nombre }}">
                @if($eventoActivo)
                    <div class="status-badge-large">Ya esta aqui!</div>
                @else
                    <div class="status-badge-large proximo">Proximamente</div>
                @endif
            </div>

            <!-- Descripción -->
            <div class="descripcion-section">
                <h3 class="descripcion-title">Descripción</h3>
                <div class="descripcion-card">
                    <div class="descripcion-header">
                        {{ $evento->nombre }} - {{ date('Y') }}
                    </div>
                    <div class="descripcion-body">
                        {{ $evento->descripcion ?? 'Aquí debe de existir una descripción del evento' }}
                    </div>
                </div>
                
                {{-- Estado del jurado --}}
                @if($esJuradoDelEvento)   
                @else
                    <div class="jurado-status no-asignado">
                        ⚠ No estás asignado como jurado en este evento
                    </div>
                @endif
            </div>
        </div>

        <!-- Sección de Equipos -->
        <div class="equipos-section">
            <h3 class="section-title">Equipos</h3>
            
            <div class="equipos-card">
                <div class="equipos-subtitle">Equipos-Inscritos</div>
                
                @if($evento->inscripciones->isNotEmpty())
                    @foreach($evento->inscripciones as $inscripcion)
                        @if($inscripcion->equipo)
                            <div class="equipo-item">
                                <div class="equipo-field nombre">
                                    {{ $inscripcion->equipo->nombre ?? 'Nombre del equipo' }}
                                </div>
                                
                                <div class="equipo-field lider">
                                    <!-- Icono de líder -->
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8.25 6.75a3.75 3.75 0 1 1 7.5 0 3.75 3.75 0 0 1-7.5 0ZM15.75 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM2.25 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM6.31 15.117A6.745 6.745 0 0 1 12 12a6.745 6.745 0 0 1 6.709 7.498.75.75 0 0 1-.372.568A12.696 12.696 0 0 1 12 21.75c-2.305 0-4.47-.612-6.337-1.684a.75.75 0 0 1-.372-.568 6.787 6.787 0 0 1 1.019-4.38Z" clip-rule="evenodd" />
                                        <path d="M5.082 14.254a8.287 8.287 0 0 0-1.308 5.135 9.687 9.687 0 0 1-1.764-.44l-.115-.04a.563.563 0 0 1-.373-.487l-.01-.121a3.75 3.75 0 0 1 3.57-4.047ZM20.226 19.389a8.287 8.287 0 0 0-1.308-5.135 3.75 3.75 0 0 1 3.57 4.047l-.01.121a.563.563 0 0 1-.373.486l-.115.04c-.567.2-1.156.349-1.764.441Z" />
                                    </svg>
                                    Lider: {{ $inscripcion->equipo->lider_nombre }}
                                </div>

                                <div class="equipo-field miembros">
                                    <!-- Icono de miembros (proporcionado por usuario) -->
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M4.5 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM14.25 8.625a3.375 3.375 0 1 1 6.75 0 3.375 3.375 0 0 1-6.75 0ZM1.5 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122ZM17.25 19.128l-.001.144a2.25 2.25 0 0 1-.233.96 10.088 10.088 0 0 0 5.06-1.01.75.75 0 0 0 .42-.643 4.875 4.875 0 0 0-6.957-4.611 8.586 8.586 0 0 1 1.71 5.157v.003Z" />
                                    </svg>
                                    Num de Miembros: {{ $inscripcion->equipo->num_miembros }}
                                </div>

                                <a href="{{ route('jurado.eventos.equipo_evento', ['evento' => $evento->id_evento, 'equipo' => $inscripcion->equipo->id_equipo]) }}" class="btn-explorar">
                                    Explorar
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path fill-rule="evenodd" d="M12.97 3.97a.75.75 0 0 1 1.06 0l7.5 7.5a.75.75 0 0 1 0 1.06l-7.5 7.5a.75.75 0 1 1-1.06-1.06l6.22-6.22H3a.75.75 0 0 1 0-1.5h16.19l-6.22-6.22a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </div>
                        @endif
                    @endforeach
                @else
                    <div class="empty-equipos">
                        Sin equipos registrados
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection