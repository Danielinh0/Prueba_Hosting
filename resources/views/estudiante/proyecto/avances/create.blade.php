@extends('layouts.app')

@section('content')

<div class="avance-form-page py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('estudiante.avances.index') }}" class="back-link">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver a avances
        </a>
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-2xl">Registrar Nuevo Avance</h2>
                <p class="mt-1">Documenta el progreso de tu proyecto</p>
            </div>
        </div>

        <div class="neuro-card rounded-lg p-6">
            <form action="{{ route('estudiante.avances.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Título (Opcional) --}}
                <div class="mb-6">
                    <label for="titulo" class="block text-sm mb-2">
                        Título del Avance (Opcional)
                    </label>
                    <input type="text" name="titulo" id="titulo" 
                           value="{{ old('titulo') }}"
                           class="neuro-input w-full px-4 py-2 rounded-lg"
                           maxlength="100"
                           placeholder="Ej: Implementación del módulo de autenticación">
                    @error('titulo')
                        <p class="error-message mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Descripción (Requerida) --}}
                <div class="mb-6">
                    <label for="descripcion" class="block text-sm mb-2">
                        Descripción del Avance <span class="required-asterisk">*</span>
                    </label>
                    <textarea name="descripcion" id="descripcion" rows="8" required
                              class="neuro-textarea w-full px-4 py-2 rounded-lg"
                              placeholder="Describe detalladamente:
- ¿Qué se logró en este avance?
- ¿Qué problemas se resolvieron?
- ¿Qué tecnologías se utilizaron?
- ¿Qué aprendizajes se obtuvieron?">{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                        <p class="error-message mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Archivo de Evidencia (Opcional) --}}
                <div class="mb-6">
                    <label for="archivo" class="block text-sm mb-2">
                        Archivo de Evidencia (Opcional)
                    </label>
                    <p class="helper-text mb-2">Puedes subir capturas, documentos, etc. (Máximo 10MB)</p>
                    <input type="file" name="archivo" id="archivo"
                           class="neuro-file w-full px-4 py-2 rounded-lg"
                           accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.zip">
                    @error('archivo')
                        <p class="error-message mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Info Box --}}
                <div class="warning-alert mb-6">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-yellow-600 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <p class="title">Este avance será visible para los jurados</p>
                            <p class="mt-1">Asegúrate de que la información sea clara, profesional y refleje el trabajo realizado por el equipo.</p>
                        </div>
                    </div>
                </div>

                {{-- Botones --}}
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('estudiante.avances.index') }}" 
                       class="neuro-button-secondary px-6 py-2 rounded-lg">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="neuro-button-primary px-6 py-2 rounded-lg">
                        Registrar Avance
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
    .avance-form-page {
        background: linear-gradient(to bottom, #FFFDF4, #FFEEE2);
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
    }
    
    /* Textos */
    .avance-form-page h2 {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
    }
    
    .avance-form-page p {
        font-family: 'Poppins', sans-serif;
        color: #6b6b6b;
    }
    
    .avance-form-page label {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
        font-weight: 600;
    }
    
    /* Links */
    .link-accent {
        font-family: 'Poppins', sans-serif;
        color: #e89a3c;
        transition: all 0.2s ease;
    }
    
    .link-accent:hover {
        color: #d98a2c;
        opacity: 0.8;
    }
    
    /* Cards neuromórficas */
    .neuro-card {
        background: #FFEEE2;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
    }
    
    /* Inputs, textareas y file inputs neuromórficos */
    .neuro-input,
    .neuro-textarea,
    .neuro-file {
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
    .neuro-textarea:focus,
    .neuro-file:focus {
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
    
    /* Info helper text */
    .helper-text {
        font-family: 'Poppins', sans-serif;
        color: #6b6b6b;
        font-size: 0.875rem;
    }
    
    /* Warning alert */
    .warning-alert {
        background: rgba(254, 243, 199, 0.8);
        border-left: 4px solid #f59e0b;
        border-radius: 0 15px 15px 0;
        padding: 1rem;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        backdrop-filter: blur(10px);
    }
    
    .warning-alert p {
        font-family: 'Poppins', sans-serif;
        color: #b45309;
        font-size: 0.875rem;
    }
    
    .warning-alert .title {
        font-weight: 600;
    }
</style>
@endsection