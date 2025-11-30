@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('estudiante.eventos.show', $evento) }}" class="text-indigo-600 hover:text-indigo-800 text-sm mb-2 inline-block">
                ← Volver al Evento
            </a>
            <h2 class="font-semibold text-2xl text-gray-900">
                Registrar Equipo Existente
            </h2>
            <p class="text-gray-600 mt-1">Selecciona uno de tus equipos para registrarlo a "{{ $evento->nombre }}"</p>
        </div>

        @if($equiposFiltrados->isEmpty())
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">
                            <strong>No tienes equipos disponibles</strong>
                        </p>
                        <p class="text-sm text-yellow-600 mt-1">
                            Todos tus equipos ya están registrados en eventos o tienen conflictos de fechas con este evento.
                        </p>
                        <p class="text-sm text-yellow-600 mt-2">
                            <a href="{{ route('estudiante.equipos.create-sin-evento') }}" class="font-semibold underline">
                                Crea un nuevo equipo
                            </a> para participar en este evento.
                        </p>
                    </div>
                </div>
            </div>
        @else
            <form action="{{ route('estudiante.eventos.registrar-equipo-existente', $evento) }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    @foreach($equiposFiltrados as $inscripcion)
                        <label class="cursor-pointer group">
                            <input type="radio" name="inscripcion_id" value="{{ $inscripcion->id_inscripcion }}" 
                                   class="peer sr-only" required>
                            
                            <div class="border-2 border-gray-200 rounded-lg p-5 transition-all
                                        peer-checked:border-indigo-600 peer-checked:bg-indigo-50
                                        hover:border-indigo-300 hover:shadow-md">
                                
                                @if($inscripcion->equipo->ruta_imagen)
                                    <img src="{{ asset('storage/' . $inscripcion->equipo->ruta_imagen) }}" 
                                         alt="{{ $inscripcion->equipo->nombre }}"
                                         class="h-32 w-full object-cover rounded-lg mb-3">
                                @endif

                                <h3 class="font-bold text-lg text-gray-900 mb-2">
                                    {{ $inscripcion->equipo->nombre }}
                                </h3>

                                @if($inscripcion->equipo->descripcion)
                                    <p class="text-sm text-gray-600 mb-3 line-clamp-2">
                                        {{ $inscripcion->equipo->descripcion }}
                                    </p>
                                @endif

                                <div class="flex items-center text-sm text-gray-500">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                    <span>{{ $inscripcion->miembros->count() }} miembro(s)</span>
                                </div>

                                <div class="mt-3 pt-3 border-t border-gray-200 peer-checked:border-indigo-300">
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold
                                                 peer-checked:bg-indigo-600 peer-checked:text-white
                                                 bg-gray-100 text-gray-700">
                                        <span class="peer-checked:hidden">Seleccionar</span>
                                        <span class="hidden peer-checked:inline">✓ Seleccionado</span>
                                    </span>
                                </div>
                            </div>
                        </label>
                    @endforeach
                </div>

                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded-lg">
                    <p class="text-sm text-blue-700">
                        <strong>📌 Importante:</strong> Al registrar este equipo, todos sus miembros participarán en el evento.
                    </p>
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('estudiante.eventos.show', $evento) }}" 
                       class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-semibold">
                        Registrar Equipo al Evento
                    </button>
                </div>
            </form>
        @endif
    </div>
</div>
@endsection
