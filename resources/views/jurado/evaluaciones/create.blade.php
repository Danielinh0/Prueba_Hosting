@extends('layouts.prueba')

@section('content')
<div class="py-12">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="mb-6">
            <a href="{{ route('jurado.equipos.show', $equipo) }}" class="text-indigo-600 hover:text-indigo-800 text-sm mb-2 inline-block">
                ← Volver al Equipo
            </a>
            <h2 class="font-semibold text-2xl text-gray-900">Evaluar Proyecto</h2>
            <p class="text-gray-600 mt-1">{{ $equipo->nombre }} - {{ $proyecto->nombre }}</p>
        </div>

        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if($evaluacion->estado == 'Finalizada')
            <div class="mb-4 bg-blue-100 border-l-4 border-blue-500 p-4 rounded-r-lg">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-blue-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="font-semibold text-blue-800">Esta evaluación ya ha sido finalizada.</p>
                </div>
            </div>
        @endif

        <form action="{{ route('jurado.evaluaciones.store', $inscripcion) }}" method="POST">
            @csrf

            {{-- Criterios de Evaluación --}}
            <div class="bg-white shadow-sm rounded-lg p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-900 mb-6">📊 Criterios de Evaluación (0-100pts)</h3>

                {{-- Innovación --}}
                <div class="mb-6">
                    <label for="calificacion_innovacion" class="block text-sm font-semibold text-gray-700 mb-2">
                        💡 Innovación y Creatividad
                    </label>
                    <p class="text-sm text-gray-600 mb-2">Originalidad de la solución, uso creativo de tecnologías</p>
                    <input type="number" name="calificacion_innovacion" id="calificacion_innovacion"
                           value="{{ old('calificacion_innovacion', $evaluacion->calificacion_innovacion) }}"
                           min="0" max="100" step="0.5"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                           placeholder="0-100"
                           {{ $evaluacion->estado == 'Finalizada' ? 'disabled' : '' }}>
                    @error('calificacion_innovacion')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Funcionalidad --}}
                <div class="mb-6">
                    <label for="calificacion_funcionalidad" class="block text-sm font-semibold text-gray-700 mb-2">
                        ⚙️ Funcionalidad y Calidad Técnica
                    </label>
                    <p class="text-sm text-gray-600 mb-2">Completitud, estabilidad, calidad del código</p>
                    <input type="number" name="calificacion_funcionalidad" id="calificacion_funcionalidad"
                           value="{{ old('calificacion_funcionalidad', $evaluacion->calificacion_funcionalidad) }}"
                           min="0" max="100" step="0.5"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                           placeholder="0-100"
                           {{ $evaluacion->estado == 'Finalizada' ? 'disabled' : '' }}>
                    @error('calificacion_funcionalidad')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Presentación --}}
                <div class="mb-6">
                    <label for="calificacion_presentacion" class="block text-sm font-semibold text-gray-700 mb-2">
                        🎨 Presentación y UX
                    </label>
                    <p class="text-sm text-gray-600 mb-2">Interfaz, usabilidad, experiencia de usuario</p>
                    <input type="number" name="calificacion_presentacion" id="calificacion_presentacion"
                           value="{{ old('calificacion_presentacion', $evaluacion->calificacion_presentacion) }}"
                           min="0" max="100" step="0.5"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                           placeholder="0-100"
                           {{ $evaluacion->estado == 'Finalizada' ? 'disabled' : '' }}>
                    @error('calificacion_presentacion')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Impacto --}}
                <div class="mb-6">
                    <label for="calificacion_impacto" class="block text-sm font-semibold text-gray-700 mb-2">
                        🎯 Impacto y Aplicabilidad
                    </label>
                    <p class="text-sm text-gray-600 mb-2">Relevancia, utilidad práctica, escalabilidad</p>
                    <input type="number" name="calificacion_impacto" id="calificacion_impacto"
                           value="{{ old('calificacion_impacto', $evaluacion->calificacion_impacto) }}"
                           min="0" max="100" step="0.5"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                           placeholder="0-100"
                           {{ $evaluacion->estado == 'Finalizada' ? 'disabled' : '' }}>
                    @error('calificacion_impacto')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Calificación Final Preview --}}
                @if($evaluacion->calificacion_final)
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="flex justify-between items-center">
                            <span class="font-semibold text-gray-700">Calificación Final:</span>
                            <span class="text-3xl font-bold text-indigo-600">{{ number_format($evaluacion->calificacion_final, 2) }}/100</span>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Comentarios --}}
            <div class="bg-white shadow-sm rounded-lg p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-900 mb-6">💬 Retroalimentación</h3>

                {{-- Fortalezas --}}
                <div class="mb-6">
                    <label for="comentarios_fortalezas" class="block text-sm font-semibold text-gray-700 mb-2">
                        ✅ Fortalezas del Proyecto
                    </label>
                    <textarea name="comentarios_fortalezas" id="comentarios_fortalezas" rows="4"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                              placeholder="¿Qué aspectos destacan positivamente?"
                              {{ $evaluacion->estado == 'Finalizada' ? 'disabled' : '' }}>{{ old('comentarios_fortalezas', $evaluacion->comentarios_fortalezas) }}</textarea>
                    @error('comentarios_fortalezas')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Áreas de Mejora --}}
                <div class="mb-6">
                    <label for="comentarios_areas_mejora" class="block text-sm font-semibold text-gray-700 mb-2">
                        📈 Áreas de Mejora
                    </label>
                    <textarea name="comentarios_areas_mejora" id="comentarios_areas_mejora" rows="4"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                              placeholder="¿Qué podría mejorar el equipo?"
                              {{ $evaluacion->estado == 'Finalizada' ? 'disabled' : '' }}>{{ old('comentarios_areas_mejora', $evaluacion->comentarios_areas_mejora) }}</textarea>
                    @error('comentarios_areas_mejora')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Comentarios Generales --}}
                <div class="mb-6">
                    <label for="comentarios_generales" class="block text-sm font-semibold text-gray-700 mb-2">
                        📝 Comentarios Generales
                    </label>
                    <textarea name="comentarios_generales" id="comentarios_generales" rows="4"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                              placeholder="Cualquier otro comentario u observación..."
                              {{ $evaluacion->estado == 'Finalizada' ? 'disabled' : '' }}>{{ old('comentarios_generales', $evaluacion->comentarios_generales) }}</textarea>
                    @error('comentarios_generales')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Botones de Acción --}}
            @if($evaluacion->estado != 'Finalizada')
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('jurado.equipos.show', $equipo) }}"
                       class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                        Cancelar
                    </a>
                    <button type="submit" name="finalizar" value="0"
                            class="px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                        Guardar Borrador
                    </button>
                    <button type="submit" name="finalizar" value="1"
                            class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition"
                            onclick="return confirm('¿Finalizar evaluación? No podrás editarla después.')">
                        Finalizar Evaluación
                    </button>
                </div>
            @else
                <div class="flex justify-end">
                    <a href="{{ route('jurado.equipos.show', $equipo) }}"
                       class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                        Volver al Equipo
                    </a>
                </div>
            @endif
        </form>
    </div>
</div>
@endsection
