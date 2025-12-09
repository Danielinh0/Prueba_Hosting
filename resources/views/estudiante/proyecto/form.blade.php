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

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
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
    /* Fondo degradado */
    .proyecto-form-page {
        background: linear-gradient(to bottom, #FFFDF4, #FFEEE2);
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
    }
    
    /* Textos */
    .proyecto-form-page h2 {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
    }
    
    .proyecto-form-page p {
        font-family: 'Poppins', sans-serif;
        color: #6b6b6b;
    }
    
    .proyecto-form-page label {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
        font-weight: 600;
    }
    
    /* Cards neuromórficas */
    .neuro-card {
        background: #FFEEE2;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
    }
    
    /* Inputs y textareas neuromórficos */
    .neuro-input,
    .neuro-textarea {
        font-family: 'Poppins', sans-serif;
        background: rgba(255, 255, 255, 0.5);
        border: none;
        box-shadow: inset 4px 4px 8px #e6d5c9, inset -4px -4px 8px #ffffff;
        transition: all 0.2s ease;
        backdrop-filter: blur(10px);
        color: #2c2c2c;
    }
    
    .neuro-input::placeholder,
    .neuro-textarea::placeholder {
        color: #9ca3af;
    }
    
    .neuro-input:focus,
    .neuro-textarea:focus {
        outline: none;
        box-shadow: inset 6px 6px 12px #e6d5c9, inset -6px -6px 12px #ffffff;
    }
    
    /* Botón principal */
    .neuro-button-primary {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #e89a3c, #f5a847);
        color: #ffffff;
        font-weight: 600;
        box-shadow: 4px 4px 8px rgba(232, 154, 60, 0.3);
        transition: all 0.3s ease;
        border: none;
    }
    
    .neuro-button-primary:hover {
        box-shadow: 6px 6px 12px rgba(232, 154, 60, 0.4);
        transform: translateY(-2px);
    }
    
    /* Botón secundario */
    .neuro-button-secondary {
        font-family: 'Poppins', sans-serif;
        background: rgba(255, 255, 255, 0.5);
        color: #2c2c2c;
        font-weight: 500;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        transition: all 0.3s ease;
        border: 1px solid transparent;
        backdrop-filter: blur(10px);
    }
    
    .neuro-button-secondary:hover {
        box-shadow: 6px 6px 12px #e6d5c9, -6px -6px 12px #ffffff;
        transform: translateY(-2px);
    }
    
    /* Mensajes de error */
    .error-message {
        font-family: 'Poppins', sans-serif;
        color: #dc2626;
        font-size: 0.875rem;
    }
    
    /* Asterisco requerido */
    .required-asterisk {
        color: #ef4444;
    }
</style>
@endsection