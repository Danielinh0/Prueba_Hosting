@extends('layouts.app')

@section('content')
<div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex items-center">
            <a href="{{ route('estudiante.dashboard') }}" class="text-gray-800 hover:text-gray-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 mb-6">
                Detalle del Evento
            </h2>
        </div>
            <div class="bg-white overflow-hidden shadow-xl rounded-lg">
                @if ($evento->ruta_imagen)
                    <img class="h-64 w-full object-cover" src="{{ asset('storage/' . $evento->ruta_imagen) }}" alt="Imagen del evento: {{ $evento->nombre }}">
                @endif
                
                <div class="p-6 sm:p-8">
                    <div class="flex justify-between items-start">
                        <div>
                            <h1 class="font-bold text-3xl text-gray-800">{{ $evento->nombre }}</h1>
                            <p class="text-gray-500 text-sm mt-1">
                                Del {{ $evento->fecha_inicio->format('d/m/Y') }} al {{ $evento->fecha_fin->format('d/m/Y') }}
                            </p>
                        </div>
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                            @if ($evento->estado == 'Activo') bg-black text-white
                            @elseif ($evento->estado == 'Próximo') bg-blue-200 text-blue-800
                            @else bg-gray-200 text-gray-800 @endif">
                            {{ $evento->estado }}
                        </span>
                    </div>

                    <div class="mt-6 border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-medium text-gray-900">Descripción del Evento</h3>
                        <p class="mt-2 text-gray-600">
                            {{ $evento->descripcion ?: 'No hay descripción disponible.' }}
                        </p>
                    </div>

                    {{-- Proyecto del Evento (si está publicado y es general) --}}
                    @if($evento->tipo_proyecto === 'general' && $evento->proyectoGeneral && $evento->proyectoGeneral->publicado)
                        <div class="mt-8 border-t border-gray-200 pt-6">
                            <div class="flex justify-between items-start mb-4">
                                <h3 class="text-lg font-medium text-gray-900">📋 Proyecto del Evento</h3>
                                <span class="px-3 py-1 bg-green-100 text-green-700 text-sm font-semibold rounded-full">
                                    ✓ Publicado
                                </span>
                            </div>
                            <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-lg p-6 border border-indigo-200">
                                <h4 class="text-xl font-bold text-gray-900 mb-3">{{ $evento->proyectoGeneral->titulo }}</h4>
                                
                                @if($evento->proyectoGeneral->descripcion_completa)
                                    <div class="mb-4">
                                        <h5 class="font-semibold text-gray-700 mb-2">Descripción:</h5>
                                        <div class="text-gray-600 whitespace-pre-line">{{ $evento->proyectoGeneral->descripcion_completa }}</div>
                                    </div>
                                @endif

                                @if($evento->proyectoGeneral->objetivo)
                                    <div class="mb-4">
                                        <h5 class="font-semibold text-gray-700 mb-2">🎯 Objetivo:</h5>
                                        <p class="text-gray-600">{{ $evento->proyectoGeneral->objetivo }}</p>
                                    </div>
                                @endif

                                @if($evento->proyectoGeneral->requisitos)
                                    <div class="mb-4">
                                        <h5 class="font-semibold text-gray-700 mb-2">📝 Requisitos Técnicos:</h5>
                                        <div class="text-gray-600 whitespace-pre-line">{{ $evento->proyectoGeneral->requisitos }}</div>
                                    </div>
                                @endif

                                @if($evento->proyectoGeneral->premios)
                                    <div class="mb-4">
                                        <h5 class="font-semibold text-gray-700 mb-2">🏆 Premios:</h5>
                                        <p class="text-gray-600">{{ $evento->proyectoGeneral->premios }}</p>
                                    </div>
                                @endif

                                <div class="mt-6 flex flex-wrap gap-3">
                                    @if($evento->proyectoGeneral->archivo_bases)
                                        <a href="{{ Storage::url($evento->proyectoGeneral->archivo_bases) }}" 
                                           target="_blank" download
                                           class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            Descargar Bases
                                        </a>
                                    @endif
                                    @if($evento->proyectoGeneral->archivo_recursos)
                                        <a href="{{ Storage::url($evento->proyectoGeneral->archivo_recursos) }}" 
                                           target="_blank" download
                                           class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
                                            </svg>
                                            Descargar Recursos
                                        </a>
                                    @endif
                                    @if($evento->proyectoGeneral->url_externa)
                                        <a href="{{ $evento->proyectoGeneral->url_externa }}" 
                                           target="_blank"
                                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                            </svg>
                                            Ver Recursos Externos
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-gray-900">
                            Equipos Inscritos ({{ $evento->inscripciones->count() }} / {{ $evento->cupo_max_equipos }})
                        </h3>
                        <div class="mt-4 bg-gray-50 rounded-lg p-4">
                            <ul class="space-y-3">
                                @forelse($evento->inscripciones as $inscripcion)
                                    <li class="flex items-center justify-between p-2 rounded-md">
                                        <div class="flex items-center space-x-3">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                            <span class="text-gray-700">{{ $inscripcion->equipo->nombre }}</span>
                                        </div>
                                    </li>
                                @empty
                                    <li class="text-gray-500 text-sm">Aún no hay equipos inscritos.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>

                    <!-- Acciones de Estudiante -->
                    <div class="mt-8 border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-medium text-gray-900">Inscripción</h3>
                        <div class="mt-4">
                            @if($evento->estado === 'Activo')
                                <a href="{{ route('estudiante.eventos.equipos.index', $evento) }}" class="px-4 py-2 bg-black text-white rounded-md hover:bg-gray-800 font-semibold">
                                    Ver Equipos / Inscribirse
                                </a>
                            @else
                                <p class="text-gray-600">Las inscripciones no están abiertas para este evento. Vuelve a consultar cuando el evento esté 'Activo'.</p>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
