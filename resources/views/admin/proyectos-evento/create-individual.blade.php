@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('admin.proyectos-evento.asignar', $evento) }}" class="text-indigo-600 hover:text-indigo-800 text-sm mb-2 inline-block">
                ← Volver a Asignaciones
            </a>
            <h2 class="font-semibold text-2xl text-gray-900">
                Asignar Proyecto Individual
            </h2>
            <p class="text-gray-600 mt-1">{{ $evento->nombre }}</p>
            
            {{-- Info del equipo --}}
            <div class="mt-4 p-4 bg-indigo-50 border border-indigo-200 rounded-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="font-semibold text-indigo-900">{{ $inscripcion->equipo->nombre }}</h3>
                        <p class="text-sm text-indigo-700 mt-1">
                            {{ $inscripcion->equipo->miembros->count() }} integrantes
                        </p>
                    </div>
                    <div class="text-right">
                        <span class="text-sm text-indigo-600">Código de equipo:</span>
                        <div class="font-mono text-lg font-bold text-indigo-900">{{ $inscripcion->codigo_acceso_equipo }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-sm rounded-lg p-6">
            <form action="{{ route('admin.proyectos-evento.store-individual', [$evento, $inscripcion]) }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Título --}}
                <div class="mb-6">
                    <label for="titulo" class="block text-sm font-semibold text-gray-700 mb-2">
                        Título del Proyecto <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="titulo" id="titulo" 
                           value="{{ old('titulo') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                           required maxlength="200"
                           placeholder="Ej: Desarrollar sistema de gestión de inventario">
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
                              placeholder="Describe detalladamente el proyecto específico para este equipo...">{{ old('descripcion_completa') }}</textarea>
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
                              placeholder="¿Qué debe lograr este equipo con este proyecto?">{{ old('objetivo') }}</textarea>
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
                              placeholder="Tecnologías, herramientas, conocimientos específicos para este proyecto...">{{ old('requisitos') }}</textarea>
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
                              placeholder="Premios si este equipo gana...">{{ old('premios') }}</textarea>
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
                    @error('archivo_bases')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Archivo de Recursos --}}
                <div class="mb-6">
                    <label for="archivo_recursos" class="block text-sm font-semibold text-gray-700 mb-2">
                        📦 Recursos Específicos (ZIP)
                    </label>
                    <input type="file" name="archivo_recursos" id="archivo_recursos" 
                           accept=".zip,.rar,.pdf"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                    <p class="text-xs text-gray-500 mt-1">ZIP, RAR o PDF - Máximo 50MB</p>
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
                           value="{{ old('url_externa') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                           placeholder="https://drive.google.com/...">
                    <p class="text-xs text-gray-500 mt-1">Google Drive, Dropbox, etc.</p>
                    @error('url_externa')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Botones --}}
                <div class="flex justify-end space-x-3 pt-6 border-t">
                    <a href="{{ route('admin.proyectos-evento.asignar', $evento) }}" 
                       class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                        Asignar Proyecto
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
