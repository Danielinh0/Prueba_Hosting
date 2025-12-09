@extends('jurado.layouts.app')
@section('content')

<div class="evento-detail-page">
    <div class="evento-detail-container">
        
        <!-- Botón volver a eventos -->
        <a href="{{ route('jurado.eventos.index') }}" class="back-btn">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" width="20" height="20">
                <path d="M15 6L9 12L15 18" stroke="#e89a3c" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Volver a Eventos
        </a>

        <!-- Header con imagen y descripción -->
        <div class="evento-header">
            <!-- Imagen del evento -->
            <div class="evento-imagen">
                @if($evento->ruta_imagen)
                    <img src="{{ asset('storage/' . $evento->ruta_imagen) }}" alt="{{ $evento->nombre }}">
                @else
                    <div style="height: 220px; background: linear-gradient(135deg, #2c2c2c, #1a1a1a); display: flex; align-items: center; justify-content: center;">
                        <svg style="width: 4rem; height: 4rem; color: rgba(232, 154, 60, 0.3);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                @endif
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
                    <div class="jurado-status asignado">
                        ✓ Estás asignado como jurado en este evento
                    </div>
                @else
                    <div class="jurado-status no-asignado">
                        ⚠ No estás asignado como jurado en este evento
                    </div>
                @endif
            </div>
        </div>

        <!-- Sección de Equipos -->
        <div class="equipos-section">
            <div class="section-header">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <h2>Equipos Inscritos</h2>
                <span class="section-badge">
                    {{ $evento->inscripciones->count() }} equipo(s)
                </span>
            </div>
            
            <div class="equipos-grid">
                @if($evento->inscripciones->isNotEmpty())
                    @foreach($evento->inscripciones as $inscripcion)
                        @if($inscripcion->equipo)
                            <div class="equipo-item">
                                <div class="equipo-field">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <span class="equipo-nombre">{{ $inscripcion->equipo->nombre ?? 'Nombre del equipo' }}</span>
                                </div>
                                
                                <div class="equipo-field">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <span>Líder: {{ $inscripcion->equipo->lider_nombre }}</span>
                                </div>

                                <div class="equipo-field">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <span>{{ $inscripcion->equipo->nombre_proyecto }}</span>
                                </div>

                                <a href="{{ route('jurado.eventos.equipo_evento', ['evento' => $evento->id_evento, 'equipo' => $inscripcion->equipo->id_equipo]) }}" class="btn-explorar">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Explorar
                                </a>
                            </div>
                        @endif
                    @endforeach
                @else
                    <div class="empty-state">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <h3>Sin equipos inscritos</h3>
                        <p>Aún no hay equipos registrados en este evento.</p>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

    .evento-detail-page {
        min-height: 100vh;
        background: linear-gradient(to bottom, #FFFDF4, #FFEEE2);
        padding: 2rem;
        font-family: 'Poppins', sans-serif;
    }

    .evento-detail-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Botón volver neuromórfico */
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
        border-radius: 10px;
        text-decoration: none;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        transition: all 0.3s ease;
        margin-bottom: 1.5rem;
    }

    .back-btn:hover {
        color: #d98a2c;
        transform: translateY(-2px);
        box-shadow: 6px 6px 12px #e6d5c9, -6px -6px 12px #ffffff;
    }

    .back-btn svg path {
        stroke: #e89a3c;
        transition: all 0.3s ease;
    }

    .back-btn:hover svg path {
        stroke: #d98a2c;
    }

    /* Header con imagen del evento */
    .evento-header {
        display: flex;
        gap: 2rem;
        margin-bottom: 2rem;
        align-items: stretch;
    }

    .evento-imagen {
        position: relative;
        border-radius: 20px;
        overflow: hidden;
        flex-shrink: 0;
        width: 380px;
        background: #FFEEE2;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
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
        background: linear-gradient(135deg, #e89a3c, #f5a847);
        color: white;
        padding: 12px 20px;
        text-align: center;
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 0.95rem;
        box-shadow: 0 -4px 8px rgba(232, 154, 60, 0.2);
    }

    .status-badge-large.proximo {
        background: linear-gradient(135deg, #6366f1, #818cf8);
    }

    /* Descripción del evento */
    .descripcion-section {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .descripcion-title {
        font-family: 'Poppins', sans-serif;
        font-size: 1.25rem;
        font-weight: 700;
        color: #2c2c2c;
        margin-bottom: 1rem;
    }

    .descripcion-card {
        background: #FFEEE2;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
        flex: 1;
    }

    .descripcion-header {
        background: linear-gradient(135deg, #e89a3c, #f5a847);
        color: white;
        padding: 1rem 1.5rem;
        text-align: center;
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 1.1rem;
    }

    .descripcion-body {
        padding: 1.5rem;
        color: #6b6b6b;
        line-height: 1.7;
        font-family: 'Poppins', sans-serif;
        font-size: 0.95rem;
    }

    /* Estado del jurado */
    .jurado-status {
        margin-top: 1rem;
        padding: 0.75rem 1rem;
        border-radius: 12px;
        font-family: 'Poppins', sans-serif;
        font-size: 0.85rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
    }

    .jurado-status.no-asignado {
        background: linear-gradient(135deg, rgba(254, 240, 138, 0.8), rgba(252, 211, 77, 0.8));
        color: #92400e;
    }

    .jurado-status.asignado {
        background: linear-gradient(135deg, rgba(209, 250, 229, 0.8), rgba(167, 243, 208, 0.8));
        color: #065f46;
    }

    /* Sección de equipos */
    .equipos-section {
        margin-top: 1.5rem;
    }

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
        width: 2rem;
        height: 2rem;
        color: white;
    }

    .section-header h2 {
        font-family: 'Poppins', sans-serif;
        font-size: 1.25rem;
        font-weight: 600;
        color: white;
        margin: 0;
    }

    .section-badge {
        margin-left: auto;
        padding: 0.35rem 0.85rem;
        background: rgba(255, 255, 255, 0.95);
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        color: #e89a3c;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
    }

    .equipos-grid {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    /* Lista de equipos neuromórfica */
    .equipo-item {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr auto;
        align-items: center;
        gap: 1rem;
        padding: 1rem 1.5rem;
        background: #FFEEE2;
        border-radius: 20px;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
        transition: all 0.3s ease;
    }

    .equipo-item:hover {
        transform: translateY(-3px);
        box-shadow: 12px 12px 24px #e6d5c9, -12px -12px 24px #ffffff;
    }

    .equipo-field {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        background: rgba(255, 255, 255, 0.4);
        border-radius: 10px;
        box-shadow: inset 2px 2px 4px #e6d5c9, inset -2px -2px 4px #ffffff;
    }

    .equipo-field svg {
        width: 1.25rem;
        height: 1.25rem;
        color: #e89a3c;
        flex-shrink: 0;
    }

    .equipo-field span {
        font-family: 'Poppins', sans-serif;
        font-size: 0.9rem;
        color: #6b6b6b;
        font-weight: 500;
    }

    .equipo-nombre {
        font-weight: 600;
        color: #2c2c2c;
    }

    .btn-explorar {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.25rem;
        background: linear-gradient(135deg, #e89a3c, #f5a847);
        color: white;
        border-radius: 10px;
        font-family: 'Poppins', sans-serif;
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 4px 4px 8px rgba(232, 154, 60, 0.3);
        white-space: nowrap;
    }

    .btn-explorar:hover {
        transform: translateY(-2px);
        box-shadow: 6px 6px 12px rgba(232, 154, 60, 0.4);
        color: white;
    }

    .btn-explorar svg {
        width: 1rem;
        height: 1rem;
    }

    /* Empty state neuromórfico */
    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        background: #FFEEE2;
        border-radius: 20px;
        margin-top: 1rem;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
    }

    .empty-state svg {
        width: 4rem;
        height: 4rem;
        color: #e89a3c;
        margin-bottom: 1rem;
        opacity: 0.4;
    }

    .empty-state h3 {
        font-family: 'Poppins', sans-serif;
        font-size: 1.25rem;
        font-weight: 600;
        color: #2c2c2c;
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: #9ca3af;
        font-size: 0.9rem;
        font-family: 'Poppins', sans-serif;
    }

    /* Responsive */
    @media (max-width: 900px) {
        .evento-header {
            flex-direction: column;
        }
        
        .evento-imagen {
            width: 100%;
            max-width: 400px;
        }
        
        .equipo-item {
            grid-template-columns: 1fr;
            text-align: center;
        }

        .equipo-field {
            justify-content: center;
        }
        
        .btn-explorar {
            width: 100%;
            justify-content: center;
        }

        .evento-detail-page {
            padding: 1rem;
        }
    }
</style>
@endsection