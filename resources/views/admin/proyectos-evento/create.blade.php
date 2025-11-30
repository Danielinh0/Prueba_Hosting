@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('admin.eventos.show', $evento) }}" class="text-indigo-600 hover:text-indigo-800 text-sm mb-2 inline-block">
                ← Volver al Evento
            </a>
            <h2 class="font-semibold text-2xl text-gray-900">
                {{ $proyectoExistente ? 'Editar' : 'Crear' }} Proyecto del Evento
            </h2>
            <p class="text-gray-600 mt-1">{{ $evento->nombre }}</p>
        </div>

        <div class="bg-white shadow-sm rounded-lg p-6">
            <form action="{{ route('admin.proyectos-evento.store', $evento) }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Título --}}
                <div class="mb-6">
                    <label for="titulo" class="block text-sm font-semibold text-gray-700 mb-2">
                        Título del Proyecto <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="titulo" id="titulo" 
                           value="{{ old('titulo', $proyectoExistente->titulo ?? '') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                           required maxlength="200"
                           placeholder="Ej: Desarrollar solución educativa innovadora">
                    @error('titulo')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Descripción Completa --}}
                <div class="mb-6">
                    <label for="descripcion_completa" class="block text-sm font-semibold text-gray-700 mb-2">
                        Descripción Completa
                    </label>
                    <textarea name="descripcion_completa" id="descripcion_completa" rows="6"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                              placeholder="Describe detalladamente el proyecto, contexto, tecnologías recomendadas...">{{ old('descripcion_completa', $proyectoExistente->descripcion_completa ?? '') }}</textarea>
                    <p class="text-xs text-gray-500 mt-1">Puedes usar Markdown para formatear el texto</p>
                    @error('descripcion_completa')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Objetivo --}}
                <div class="mb-6">
                    <label for="objetivo" class="block text-sm font-semibold text-gray-700 mb-2">
                        Objetivo del Proyecto
                    </label>
                    <textarea name="objetivo" id="objetivo" rows="3"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                              placeholder="¿Qué se espera lograr con este proyecto?">{{ old('objetivo', $proyectoExistente->objetivo ?? '') }}</textarea>
                    @error('objetivo')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Requisitos --}}
                <div class="mb-6">
                    <label for="requisitos" class="block text-sm font-semibold text-gray-700 mb-2">
                        Requisitos Técnicos
                    </label>
                    <textarea name="requisitos" id="requisitos" rows="4"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                              placeholder="Tecnologías, herramientas, conocimientos previos necesarios...">{{ old('requisitos', $proyectoExistente->requisitos ?? '') }}</textarea>
                    @error('requisitos')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Premios --}}
                <div class="mb-6">
                    <label for="premios" class="block text-sm font-semibold text-gray-700 mb-2">
                        Premios y Reconocimientos
                    </label>
                    <textarea name="premios" id="premios" rows="3"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                              placeholder="Premios para los ganadores...">{{ old('premios', $proyectoExistente->premios ?? '') }}</textarea>
                    @error('premios')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <hr class="my-8">

                {{-- Archivo de Bases --}}
                <div class="mb-6">
                    <label for="archivo_bases" class="block text-sm font-semibold text-gray-700 mb-2">
                        📄 Archivo de Bases (PDF)
                    </label>
                    <input type="file" name="archivo_bases" id="archivo_bases" 
                           accept=".pdf,.doc,.docx"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                    <p class="text-xs text-gray-500 mt-1">PDF, DOC o DOCX - Máximo 20MB</p>
                    @if($proyectoExistente && $proyectoExistente->archivo_bases)
                        <p class="text-sm text-green-600 mt-2">
                            ✓ Archivo actual: {{ basename($proyectoExistente->archivo_bases) }}
                        </p>
                    @endif
                    @error('archivo_bases')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Archivo de Recursos --}}
                <div class="mb-6">
                    <label for="archivo_recursos" class="block text-sm font-semibold text-gray-700 mb-2">
                        📦 Recursos Adicionales (ZIP)
                    </label>
                    <input type="file" name="archivo_recursos" id="archivo_recursos" 
                           accept=".zip,.rar,.pdf"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                    <p class="text-xs text-gray-500 mt-1">ZIP, RAR o PDF - Máximo 50MB</p>
                    @if($proyectoExistente && $proyectoExistente->archivo_recursos)
                        <p class="text-sm text-green-600 mt-2">
                            ✓ Archivo actual: {{ basename($proyectoExistente->archivo_recursos) }}
                        </p>
                    @endif
                    @error('archivo_recursos')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- URL Externa --}}
                <div class="mb-6">
                    <label for="url_externa" class="block text-sm font-semibold text-gray-700 mb-2">
                        🔗 URL a Recursos Externos
                    </label>
                    <input type="url" name="url_externa" id="url_externa" 
                           value="{{ old('url_externa', $proyectoExistente->url_externa ?? '') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                           placeholder="https://drive.google.com/...">
                    <p class="text-xs text-gray-500 mt-1">Google Drive, Dropbox, etc.</p>
                    @error('url_externa')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Botones --}}
                <div class="flex justify-end space-x-3 pt-6 border-t">
                    <a href="{{ route('admin.eventos.show', $evento) }}" 
                       class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                        {{ $proyectoExistente ? 'Actualizar Proyecto' : 'Crear Proyecto' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
