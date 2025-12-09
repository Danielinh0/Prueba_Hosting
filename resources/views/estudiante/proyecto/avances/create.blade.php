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


@endsection