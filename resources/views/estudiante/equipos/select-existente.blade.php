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


@endsection