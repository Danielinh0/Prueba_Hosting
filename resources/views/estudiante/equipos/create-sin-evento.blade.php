@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('estudiante.dashboard') }}" class="text-indigo-600 hover:text-indigo-800 text-sm mb-2 inline-block">
                ← Volver al Dashboard
            </a>
            <h2 class="font-semibold text-2xl text-gray-900">
                Crear Equipo
            </h2>
            <p class="text-gray-600 mt-1">Crea tu equipo con anticipación y regístralo a un evento cuando esté disponible</p>
        </div>

        <div class="bg-white shadow-sm rounded-lg p-6">
            <form action="{{ route('estudiante.equipos.store-sin-evento') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Nombre del Equipo --}}
                <div class="mb-6">
                    <label for="nombre" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nombre del Equipo <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nombre" id="nombre" 
                           value="{{ old('nombre') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('nombre') border-red-500 @enderror"
                           required maxlength="100"
                           placeholder="Ej: Caballeros del Código">
                    @error('nombre')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Descripción --}}
                <div class="mb-6">
                    <label for="descripcion" class="block text-sm font-semibold text-gray-700 mb-2">
                        Descripción del Equipo
                    </label>
                    <textarea name="descripcion" id="descripcion" rows="4"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('descripcion') border-red-500 @enderror"
                              maxlength="1000"
                              placeholder="Describe a tu equipo, habilidades, intereses...">{{ old('descripcion') }}</textarea>
                    <p class="text-xs text-gray-500 mt-1">Máximo 1000 caracteres</p>
                    @error('descripcion')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Imagen del Equipo --}}
                <div class="mb-6">
                    <label for="ruta_imagen" class="block text-sm font-semibold text-gray-700 mb-2">
                        Logo/Imagen del Equipo
                    </label>
                    <input type="file" name="ruta_imagen" id="ruta_imagen" 
                           accept="image/jpeg,image/png,image/jpg,image/gif"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 @error('ruta_imagen') border-red-500 @enderror">
                    <p class="text-xs text-gray-500 mt-1">JPG, PNG, GIF - Máximo 2MB</p>
                    @error('ruta_imagen')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Información Importante --}}
                <div class="mb-6 p-4 bg-indigo-50 border border-indigo-200 rounded-lg">
                    <h3 class="font-semibold text-indigo-900 mb-2">📌 Importante:</h3>
                    <ul class="text-sm text-indigo-700 space-y-1">
                        <li>• Serás automáticamente el <strong>líder</strong> del equipo</li>
                        <li>• Podrás registrar este equipo a eventos cuando estén disponibles</li>
                        <li>• El equipo quedará en tu "pool" de equipos disponibles</li>
                        <li>• Puedes tener múltiples equipos diferentes</li>
                    </ul>
                </div>

                {{-- Botones --}}
                <div class="flex justify-end space-x-3 pt-6 border-t">
                    <a href="{{ route('estudiante.dashboard') }}" 
                       class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                        Crear Equipo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
