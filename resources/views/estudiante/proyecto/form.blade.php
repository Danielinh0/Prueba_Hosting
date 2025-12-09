@extends('layouts.app')

@section('content')

<div class="proyecto-form-page py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('estudiante.proyecto-evento.show') }}" class="back-link">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver a Proyectos
            </a>
            @if(isset($proyecto))
            <a href="{{ route('estudiante.proyecto.show') }}" class="back-link">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver al Proyecto {{ $proyecto->nombre }}
            </a>
            @endif
        <div class="mb-6">
            <h2 class="font-semibold text-2xl">{{ isset($proyecto) ? 'Editar Proyecto' : 'Crear Proyecto' }}</h2>
            <p class="mt-1">Define la información básica de tu proyecto</p>
        </div>

        <div class="neuro-card rounded-lg p-6">
            <form action="{{ isset($proyecto) ? route('estudiante.proyecto.update') : route('estudiante.proyecto.store') }}" method="POST">
                @csrf
                @if(isset($proyecto))
                    @method('PATCH')
                @endif

                {{-- Nombre del Proyecto --}}
                <div class="mb-6">
                    <label for="nombre" class="block text-sm mb-2">
                        Nombre del Proyecto <span class="required-asterisk">*</span>
                    </label>
                    <input type="text" name="nombre" id="nombre" 
                           value="{{ old('nombre', $proyecto->nombre ?? '') }}"
                           class="neuro-input w-full px-4 py-2 rounded-lg"
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
                              placeholder="Describe las características técnicas, stack tecnológico, objetivos...">{{ old('descripcion_tecnica', $proyecto->descripcion_tecnica ?? '') }}</textarea>
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
                           value="{{ old('repositorio_url', $proyecto->repositorio_url ?? '') }}"
                           class="neuro-input w-full px-4 py-2 rounded-lg"
                           placeholder="https://github.com/usuario/proyecto">
                    @error('repositorio_url')
                        <p class="error-message mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Botones --}}
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('estudiante.proyecto.show') }}" 
                       class="neuro-button-secondary px-6 py-2 rounded-lg">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="neuro-button-primary px-6 py-2 rounded-lg">
                        {{ isset($proyecto) ? 'Actualizar Proyecto' : 'Crear Proyecto' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection