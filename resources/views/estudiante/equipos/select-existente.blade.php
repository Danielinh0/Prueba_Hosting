@extends('layouts.app')

@section('content')

<div class="registrar-equipo-page py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('estudiante.eventos.show', $evento) }}" class="back-link">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver al Evento
            </a>
            <h2 class="font-semibold text-2xl">
                Registrar Equipo Existente
            </h2>
            <p class="mt-1">Selecciona uno de tus equipos para registrarlo a "{{ $evento->nombre }}"</p>
        </div>

        @if($equiposFiltrados->isEmpty())
            <div class="warning-box">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p>
                            <strong>No tienes equipos disponibles</strong>
                        </p>
                        <p class="mt-1">
                            Todos tus equipos ya están registrados en eventos o tienen conflictos de fechas con este evento.
                        </p>
                        <p class="mt-2">
                            <a href="{{ route('estudiante.equipos.create-sin-evento') }}">
                                Crea un nuevo equipo
                            </a> para participar en este evento.
                        </p>
                    </div>
                </div>
            </div>
        @else
            <form action="{{ route('estudiante.eventos.registrar-equipo-existente', $evento) }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    @foreach($equiposFiltrados as $inscripcion)
                        <label class="team-radio-container">
                            <input type="radio" 
                                   name="inscripcion_id" 
                                   value="{{ $inscripcion->id_inscripcion }}" 
                                   class="team-radio-input" 
                                   required>
                            
                            <div class="team-radio-card">
                                @if($inscripcion->equipo->ruta_imagen)
                                    <img src="{{ asset('storage/' . $inscripcion->equipo->ruta_imagen) }}" 
                                         alt="{{ $inscripcion->equipo->nombre }}">
                                @endif

                                <h3>
                                    {{ $inscripcion->equipo->nombre }}
                                </h3>

                                @if($inscripcion->equipo->descripcion)
                                    <p class="team-description">
                                        {{ $inscripcion->equipo->descripcion }}
                                    </p>
                                @endif

                                <div class="team-members">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                    <span>{{ $inscripcion->miembros->count() }} miembro(s)</span>
                                </div>

                                <div class="selection-badge">
                                    <span class="badge-select">
                                        <span class="unselected">Seleccionar</span>
                                        <span class="selected">✓ Seleccionado</span>
                                    </span>
                                </div>
                            </div>
                        </label>
                    @endforeach
                </div>

                <div class="info-box">
                    <p>
                        <strong>📌 Importante:</strong> Al registrar este equipo, todos sus miembros participarán en el evento.
                    </p>
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('estudiante.eventos.show', $evento) }}" 
                       class="btn-cancel">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="btn-submit">
                        Registrar Equipo al Evento
                    </button>
                </div>
            </form>
        @endif
    </div>
</div>


<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
    
    /* Fondo degradado */
    .registrar-equipo-page {
        background: linear-gradient(to bottom, #FFFDF4, #FFEEE2);
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
    }
    
    /* Textos */
    .registrar-equipo-page h2,
    .registrar-equipo-page h3 {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
    }
    
    .registrar-equipo-page p {
        font-family: 'Poppins', sans-serif;
        color: #6b6b6b;
    }
    
    /* Back link */
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
    
    /* Warning box */
    .warning-box {
        background: linear-gradient(135deg, rgba(254, 243, 199, 0.5), rgba(254, 240, 138, 0.5));
        border-left: 4px solid #f59e0b;
        padding: 1rem;
        border-radius: 0 15px 15px 0;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
    }
    
    .warning-box p {
        font-size: 0.875rem;
        color: #92400e;
    }
    
    .warning-box strong {
        font-weight: 700;
    }
    
    .warning-box a {
        color: #d97706;
        font-weight: 600;
        text-decoration: underline;
    }
    
    .warning-box a:hover {
        color: #b45309;
    }
    
    .warning-box svg {
        color: #f59e0b;
    }
    
    /* Team card radio */
    .team-radio-container {
        position: relative;
    }
    
    .team-radio-input {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }
    
    .team-radio-card {
        background: #FFEEE2;
        border: 2px solid rgba(232, 154, 60, 0.3);
        border-radius: 15px;
        padding: 1.25rem;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .team-radio-card:hover {
        border-color: #e89a3c;
        box-shadow: 6px 6px 12px #e6d5c9, -6px -6px 12px #ffffff;
    }
    
    .team-radio-input:checked + .team-radio-card {
        border-color: #e89a3c;
        background: linear-gradient(135deg, rgba(232, 154, 60, 0.1), rgba(245, 168, 71, 0.1));
        box-shadow: 6px 6px 12px #e6d5c9, -6px -6px 12px #ffffff, inset 0 0 0 1px rgba(232, 154, 60, 0.2);
    }
    
    .team-radio-card img {
        height: 8rem;
        width: 100%;
        object-fit: cover;
        border-radius: 10px;
        margin-bottom: 0.75rem;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .team-radio-card h3 {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
        font-weight: 700;
        font-size: 1.125rem;
        margin-bottom: 0.5rem;
    }
    
    .team-description {
        font-size: 0.875rem;
        color: #6b6b6b;
        margin-bottom: 0.75rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .team-members {
        display: flex;
        align-items: center;
        font-size: 0.875rem;
        color: #6b6b6b;
    }
    
    .team-members svg {
        width: 1rem;
        height: 1rem;
        margin-right: 0.25rem;
    }
    
    /* Selection badge */
    .selection-badge {
        margin-top: 0.75rem;
        padding-top: 0.75rem;
        border-top: 1px solid rgba(232, 154, 60, 0.2);
    }
    
    .badge-select {
        font-family: 'Poppins', sans-serif;
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.5rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        background: rgba(243, 244, 246, 0.8);
        color: #374151;
        transition: all 0.3s ease;
    }
    
    .team-radio-input:checked + .team-radio-card .badge-select {
        background: linear-gradient(135deg, #e89a3c, #d98a2c);
        color: #ffffff;
    }
    
    .badge-select .unselected {
        display: inline;
    }
    
    .badge-select .selected {
        display: none;
    }
    
    .team-radio-input:checked + .team-radio-card .badge-select .unselected {
        display: none;
    }
    
    .team-radio-input:checked + .team-radio-card .badge-select .selected {
        display: inline;
    }
    
    /* Info box */
    .info-box {
        background: linear-gradient(135deg, rgba(219, 234, 254, 0.5), rgba(191, 219, 254, 0.5));
        border-left: 4px solid #3b82f6;
        padding: 1rem;
        margin-bottom: 1.5rem;
        border-radius: 0 15px 15px 0;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
    }
    
    .info-box p {
        font-size: 0.875rem;
        color: #1e40af;
    }
    
    .info-box strong {
        font-weight: 700;
    }
    
    /* Action buttons */
    .btn-cancel {
        font-family: 'Poppins', sans-serif;
        background: rgba(255, 255, 255, 0.5);
        color: #2c2c2c;
        font-weight: 500;
        padding: 0.5rem 1.5rem;
        border-radius: 0.75rem;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        transition: all 0.3s ease;
        border: 1px solid rgba(232, 154, 60, 0.3);
        text-decoration: none;
        display: inline-block;
    }
    
    .btn-cancel:hover {
        box-shadow: 6px 6px 12px #e6d5c9, -6px -6px 12px #ffffff;
        transform: translateY(-2px);
    }
    
    .btn-submit {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: #ffffff;
        font-weight: 600;
        padding: 0.5rem 1.5rem;
        border-radius: 0.75rem;
        box-shadow: 4px 4px 8px rgba(99, 102, 241, 0.3);
        transition: all 0.3s ease;
        border: none;
    }
    
    .btn-submit:hover {
        box-shadow: 6px 6px 12px rgba(99, 102, 241, 0.4);
        transform: translateY(-2px);
    }
</style>
@endsection