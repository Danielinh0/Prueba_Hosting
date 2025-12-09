@extends('layouts.app')

@section('content')

<div class="proyecto-form-page py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('estudiante.proyecto-evento.especifico', $evento->id_evento) }}" class="back-link">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver al Proyecto del Evento
        </a>

        <div class="mb-6">
            <h2 class="font-semibold text-2xl">Crear Proyecto para el Evento</h2>
            <p class="mt-1">Estás creando un proyecto para tu equipo en este evento específico</p>
        </div>

        <!-- Información del Evento -->
        <div class="event-info-card">
            <div class="flex items-start justify-between">
                <div>
                    <h3 class="font-semibold text-lg" style="color: #6366f1;">{{ $evento->nombre }}</h3>
                    <p class="text-sm mt-1" style="color: #6b7280;">
                        <i class="far fa-calendar me-1"></i>
                        Del {{ $evento->fecha_inicio->format('d M Y') }} al {{ $evento->fecha_fin->format('d M Y') }}
                    </p>
                    <p class="text-sm mt-1" style="color: #6b7280;">
                        <i class="fas fa-users me-1"></i>
                        Equipo: {{ $inscripcion->equipo->nombre }}
                    </p>
                </div>
                <div class="text-right">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium"
                          style="background: linear-gradient(135deg, #6366f1, #8b5cf6); color: white;">
                        {{ $evento->estado }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Información del Proyecto del Evento (si existe) -->
        @if($evento->tipo_proyecto === 'general' && $evento->proyectoGeneral)
            <div class="event-info-card" style="background: linear-gradient(135deg, rgba(34, 197, 94, 0.1), rgba(16, 185, 129, 0.1)); border-color: rgba(34, 197, 94, 0.2);">
                <h4 class="font-semibold text-sm mb-2" style="color: #059669;">
                    <i class="fas fa-info-circle me-2"></i>Proyecto General del Evento
                </h4>
                <p class="text-sm" style="color: #047857;">
                    <strong>{{ $evento->proyectoGeneral->titulo }}</strong>
                </p>
                @if($evento->proyectoGeneral->objetivo)
                    <p class="text-sm mt-2" style="color: #065f46;">
                        <strong>Objetivo:</strong> {{ $evento->proyectoGeneral->objetivo }}
                    </p>
                @endif
                <p class="text-xs mt-2" style="color: #6b7280; font-style: italic;">
                    Tu proyecto será la solución que tu equipo desarrolla para este proyecto general.
                </p>
            </div>
        @elseif($evento->tipo_proyecto === 'individual' && $inscripcion->proyectoEvento)
            <div class="event-info-card" style="background: linear-gradient(135deg, rgba(34, 197, 94, 0.1), rgba(16, 185, 129, 0.1)); border-color: rgba(34, 197, 94, 0.2);">
                <h4 class="font-semibold text-sm mb-2" style="color: #059669;">
                    <i class="fas fa-info-circle me-2"></i>Proyecto Asignado a tu Equipo
                </h4>
                <p class="text-sm" style="color: #047857;">
                    <strong>{{ $inscripcion->proyectoEvento->titulo }}</strong>
                </p>
                @if($inscripcion->proyectoEvento->objetivo)
                    <p class="text-sm mt-2" style="color: #065f46;">
                        <strong>Objetivo:</strong> {{ $inscripcion->proyectoEvento->objetivo }}
                    </p>
                @endif
                <p class="text-xs mt-2" style="color: #6b7280; font-style: italic;">
                    A continuación, registra la solución específica que tu equipo desarrollará.
                </p>
            </div>
        @endif

        <div class="neuro-card rounded-lg p-6">
            <form action="{{ route('estudiante.proyecto.store-from-evento', $evento->id_evento) }}" method="POST">
                @csrf

                {{-- Nombre del Proyecto --}}
                <div class="mb-6">
                    <label for="nombre" class="block text-sm mb-2">
                        Nombre del Proyecto <span class="required-asterisk">*</span>
                    </label>
                    <input type="text" name="nombre" id="nombre"
                           value="{{ old('nombre') }}"
                           class="neuro-input w-full px-4 py-2 rounded-lg"
                           placeholder="Ej: Sistema de Gestión Escolar"
                           required maxlength="200">
                    @error('nombre')
                        <p class="error-message mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Descripción Técnica --}}
                <div class="mb-6">
                    <label for="descripcion_tecnica" class="block text-sm mb-2">
                        Descripción Técnica
                    </label>
                    <textarea name="descripcion_tecnica" id="descripcion_tecnica" rows="5"
                              class="neuro-textarea w-full px-4 py-2 rounded-lg"
                              placeholder="Describe las características técnicas, stack tecnológico, arquitectura, funcionalidades principales...">{{ old('descripcion_tecnica') }}</textarea>
                    @error('descripcion_tecnica')
                        <p class="error-message mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- URL del Repositorio --}}
                <div class="mb-6">
                    <label for="repositorio_url" class="block text-sm mb-2">
                        URL del Repositorio (GitHub, GitLab, etc.)
                    </label>
                    <input type="url" name="repositorio_url" id="repositorio_url"
                           value="{{ old('repositorio_url') }}"
                           class="neuro-input w-full px-4 py-2 rounded-lg"
                           placeholder="https://github.com/tu-usuario/nombre-del-proyecto">
                    @error('repositorio_url')
                        <p class="error-message mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs mt-1" style="color: #9ca3af;">
                        Opcional: Puedes agregarlo más tarde si aún no tienes el repositorio
                    </p>
                </div>

                {{-- Botones --}}
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('estudiante.proyecto-evento.especifico', $evento->id_evento) }}"
                       class="neuro-button-secondary px-6 py-2 rounded-lg">
                        Cancelar
                    </a>
                    <button type="submit"
                            class="neuro-button-primary px-6 py-2 rounded-lg">
                        Crear Proyecto para este Evento
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection