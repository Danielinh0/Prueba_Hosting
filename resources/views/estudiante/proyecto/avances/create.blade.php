@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-2xl text-gray-800">Registrar Nuevo Avance</h2>
                <p class="text-gray-600 mt-1">Documenta el progreso de tu proyecto</p>
            </div>
            <a href="{{ route('estudiante.avances.index') }}" class="text-indigo-600 hover:text-indigo-800">
                ← Volver a Avances
            </a>
        </div>

        <div class="bg-white shadow-sm rounded-lg p-6">
            <form action="{{ route('estudiante.avances.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Título (Opcional) --}}
                <div class="mb-6">
                    <label for="titulo" class="block text-sm font-semibold text-gray-700 mb-2">
                        Título del Avance (Opcional)
                    </label>
                    <input type="text" name="titulo" id="titulo" 
                           value="{{ old('titulo') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                           maxlength="100"
                           placeholder="Ej: Implementación del módulo de autenticación">
                    @error('titulo')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Descripción (Requerida) --}}
                <div class="mb-6">
                    <label for="descripcion" class="block text-sm font-semibold text-gray-700 mb-2">
                        Descripción del Avance <span class="text-red-500">*</span>
                    </label>
                    <textarea name="descripcion" id="descripcion" rows="8" required
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                              placeholder="Describe detalladamente:
- ¿Qué se logró en este avance?
- ¿Qué problemas se resolvieron?
- ¿Qué tecnologías se utilizaron?
- ¿Qué aprendizajes se obtuvieron?">{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Archivo de Evidencia (Opcional) --}}
                <div class="mb-6">
                    <label for="archivo" class="block text-sm font-semibold text-gray-700 mb-2">
                        Archivo de Evidencia (Opcional)
                    </label>
                    <p class="text-sm text-gray-500 mb-2">Puedes subir capturas, documentos, etc. (Máximo 10MB)</p>
                    <input type="file" name="archivo" id="archivo"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                           accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.zip">
                    @error('archivo')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Info Box --}}
                <div class="mb-6 bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r-lg">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-yellow-600 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <div class="text-sm text-yellow-700">
                            <p class="font-semibold">Este avance será visible para los jurados</p>
                            <p class="mt-1">Asegúrate de que la información sea clara, profesional y refleje el trabajo realizado por el equipo.</p>
                        </div>
                    </div>
                </div>

                {{-- Botones --}}
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('estudiante.avances.index') }}" 
                       class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                        Registrar Avance
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
