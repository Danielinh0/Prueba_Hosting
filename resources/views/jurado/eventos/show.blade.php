@extends('jurado.layouts.app')
@section('content')
<style>
    .evento-detail-page {
        min-height: 100vh;
        background: linear-gradient(135deg, #fef3e2 0%, #fde8d0 100%);
        padding: 2rem;
    }

    .evento-detail-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Page Header */
    .page-header {
        margin-bottom: 2rem;
    }

    .page-header h1 {
        font-family: 'Poppins', sans-serif;
        font-size: 2rem;
        font-weight: 700;
        color: #2c2c2c;
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
        border-radius: 15px;
        overflow: hidden;
        flex-shrink: 0;
        width: 380px;
        background: rgba(255, 255, 255, 0.9);
        box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.08), -2px -2px 8px rgba(255, 255, 255, 0.9);
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
    }

    .status-badge-large.proximo {
        background: linear-gradient(135deg, #3b82f6, #60a5fa);
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
        background: rgba(255, 255, 255, 0.9);
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.08), -2px -2px 8px rgba(255, 255, 255, 0.9);
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
        color: #5c5c5c;
        line-height: 1.7;
        font-family: 'Poppins', sans-serif;
        font-size: 0.95rem;
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
        box-shadow: 0 4px 15px rgba(232, 154, 60, 0.3);
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
        padding: 0.25rem 0.75rem;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        color: #e89a3c;
    }

    .equipos-grid {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    /* Lista de equipos - estilo de tarjeta */
    .equipo-item {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr auto;
        align-items: center;
        gap: 1rem;
        padding: 1rem 1.5rem;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 15px;
        box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.08), -2px -2px 8px rgba(255, 255, 255, 0.9);
        transition: all 0.3s ease;
    }

    .equipo-item:hover {
        transform: translateY(-2px);
        box-shadow: 6px 6px 15px rgba(0, 0, 0, 0.12), -3px -3px 10px rgba(255, 255, 255, 1);
    }

    .equipo-field {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        background: rgba(254, 243, 226, 0.8);
        border-radius: 10px;
    }

    .equipo-field svg {
        width: 1.25rem;
        height: 1.25rem;
        color: #d4a056;
        flex-shrink: 0;
    }

    .equipo-field span {
        font-family: 'Poppins', sans-serif;
        font-size: 0.9rem;
        color: #5c5c5c;
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
        box-shadow: 0 4px 10px rgba(232, 154, 60, 0.3);
        white-space: nowrap;
    }

    .btn-explorar:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(232, 154, 60, 0.4);
        color: white;
    }

    .btn-explorar svg {
        width: 1rem;
        height: 1rem;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        background: rgba(255, 255, 255, 0.7);
        border-radius: 15px;
        margin-top: 1rem;
    }

    .empty-state svg {
        width: 4rem;
        height: 4rem;
        color: #d1d5db;
        margin-bottom: 1rem;
    }

    .empty-state h3 {
        font-family: 'Poppins', sans-serif;
        font-size: 1.25rem;
        font-weight: 600;
        color: #6b7280;
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: #9ca3af;
        font-size: 0.9rem;
    }

    .jurado-status {
        margin-top: 1rem;
        padding: 0.75rem 1rem;
        border-radius: 10px;
        font-family: 'Poppins', sans-serif;
        font-size: 0.85rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .jurado-status.no-asignado {
        background: rgba(251, 191, 36, 0.15);
        color: #d97706;
        border: 1px solid rgba(251, 191, 36, 0.3);
    }

    .jurado-status.asignado {
        background: rgba(16, 185, 129, 0.15);
        color: #059669;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }

    /* Botón volver */
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
        margin-bottom: 1.5rem;
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
    }
</style>

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
@endsection