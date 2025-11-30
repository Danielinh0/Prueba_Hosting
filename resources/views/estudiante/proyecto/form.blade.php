@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6">
            <h2 class="font-semibold text-2xl text-gray-800">{{ isset($proyecto) ? 'Editar Proyecto' : 'Crear Proyecto' }}</h2>
            <p class="text-gray-600 mt-1">Define la información básica de tu proyecto</p>
        </div>

        <div class="bg-white shadow-sm rounded-lg p-6">
            <form action="{{ isset($proyecto) ? route('estudiante.proyecto.update') : route('estudiante.proyecto.store') }}" method="POST">
                @csrf
                @if(isset($proyecto))
                    @method('PATCH')
                @endif

                {{-- Nombre del Proyecto --}}
                <div class="mb-6">
                    <label for="nombre" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nombre del Proyecto <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nombre" id="nombre" 
                           value="{{ old('nombre', $proyecto->nombre ?? '') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                           required maxlength="200">
                    @error('nombre')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Descripción Técnica --}}
                <div class="mb-6">
                    <label for="descripcion_tecnica" class="block text-sm font-semibold text-gray-700 mb-2">
                        Descripción Técnica
                    </label>
                    <textarea name="descripcion_tecnica" id="descripcion_tecnica" rows="5"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                              placeholder="Describe las características técnicas, stack tecnológico, objetivos...">{{ old('descripcion_tecnica', $proyecto->descripcion_tecnica ?? '') }}</textarea>
                    @error('descripcion_tecnica')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- URL del Repositorio --}}
                <div class="mb-6">
                    <label for="repositorio_url" class="block text-sm font-semibold text-gray-700 mb-2">
                        URL del Repositorio (GitHub, GitLab, etc.)
                    </label>
                    <input type="url" name="repositorio_url" id="repositorio_url"
                           value="{{ old('repositorio_url', $proyecto->repositorio_url ?? '') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                           placeholder="https://github.com/usuario/proyecto">
                    @error('repositorio_url')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Botones --}}
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('estudiante.proyecto.show') }}" 
                       class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                        {{ isset($proyecto) ? 'Actualizar Proyecto' : 'Crear Proyecto' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
