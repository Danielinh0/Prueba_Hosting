@extends('layouts.app')

@section('title', 'Editar Proyecto')

@section('content')

<div class="proyecto-form-page py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('estudiante.proyecto.show-specific', $proyecto->id_proyecto) }}" class="back-link">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver al Proyecto
        </a>

        <div class="mb-6">
            <h2 class="font-semibold text-2xl">Editar Proyecto</h2>
            <p class="mt-1">Actualiza la información de tu proyecto</p>
        </div>

        <!-- Información del Evento -->
        @if($evento)
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
        @endif

        <div class="neuro-card rounded-lg p-6">
            <form action="{{ route('estudiante.proyecto.update-specific', $proyecto->id_proyecto) }}" method="POST">
                @csrf
                @method('PATCH')

                {{-- Nombre del Proyecto --}}
                <div class="mb-6">
                    <label for="nombre" class="block text-sm mb-2">
                        Nombre del Proyecto <span class="required-asterisk">*</span>
                    </label>
                    <input type="text" name="nombre" id="nombre"
                           value="{{ old('nombre', $proyecto->nombre) }}"
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
                    <textarea name="descripcion_tecnica" id="descripcion_tecnica" rows="6"
                              class="neuro-textarea w-full px-4 py-2 rounded-lg"
                              placeholder="Describe las características técnicas, stack tecnológico, arquitectura, funcionalidades principales...">{{ old('descripcion_tecnica', $proyecto->descripcion_tecnica) }}</textarea>
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
                           value="{{ old('repositorio_url', $proyecto->repositorio_url) }}"
                           class="neuro-input w-full px-4 py-2 rounded-lg"
                           placeholder="https://github.com/tu-usuario/nombre-del-proyecto">
                    @error('repositorio_url')
                        <p class="error-message mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs mt-1" style="color: #9ca3af;">
                        Enlace al repositorio de código donde está alojado el proyecto
                    </p>
                </div>

                <!-- Información Adicional -->
                <div class="mb-6 p-4 rounded-lg" style="background: rgba(99, 102, 241, 0.05); border: 1px solid rgba(99, 102, 241, 0.1);">
                    <p class="text-sm" style="color: #4b5563;">
                        <i class="fas fa-info-circle mr-2" style="color: #6366f1;"></i>
                        <strong>Información del proyecto:</strong>
                    </p>
                    <ul class="text-sm mt-2" style="color: #6b7280;">
                        <li>Creado el: {{ $proyecto->created_at->format('d/m/Y H:i') }}</li>
                        <li>Última actualización: {{ $proyecto->updated_at->format('d/m/Y H:i') }}</li>
                        @if($proyecto->avances->count() > 0)
                            <li>Avances registrados: {{ $proyecto->avances->count() }}</li>
                        @endif
                        @if($proyecto->tareas->count() > 0)
                            <li>Tareas creadas: {{ $proyecto->tareas->count() }}</li>
                        @endif
                    </ul>
                </div>

                {{-- Botones --}}
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('estudiante.proyecto.show-specific', $proyecto->id_proyecto) }}"
                       class="neuro-button-secondary px-6 py-2 rounded-lg">
                        Cancelar
                    </a>
                    <button type="submit"
                            class="neuro-button-primary px-6 py-2 rounded-lg">
                        <i class="fas fa-save mr-2"></i>
                        Actualizar Proyecto
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection