@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="font-semibold text-2xl text-gray-900 mb-6">
            Mis Equipos
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($equipos as $equipoData)
                @php
                    $inscripcion = $equipoData['inscripcion'];
                    $esLider = $equipoData['esLider'];
                    $solicitudes = $equipoData['solicitudes'];
                    $roles = $equipoData['roles'];
                @endphp

                <div class="bg-white overflow-hidden shadow-xl rounded-lg hover:shadow-2xl transition">
                    @if ($inscripcion->equipo->ruta_imagen)
                        <img class="h-48 w-full object-cover" src="{{ asset('storage/' . $inscripcion->equipo->ruta_imagen) }}" alt="Imagen del equipo">
                    @endif
                    
                    <div class="p-6">
                        {{-- Header del Equipo --}}
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="font-bold text-xl text-gray-900">{{ $inscripcion->equipo->nombre }}</h3>
                                @if($esLider)
                                    <span class="inline-flex items-center px-2 py-1 bg-yellow-100 text-yellow-800 text-xs font-bold rounded-full mt-1">
                                        ⭐ Líder
                                    </span>
                                @endif
                            </div>
                            <span class="px-3 py-1 text-xs font-semibold rounded-full
                                @if($inscripcion->status_registro === 'Completo') bg-green-100 text-green-700
                                @else bg-yellow-100 text-yellow-700 @endif">
                                {{ $inscripcion->status_registro }}
                            </span>
                        </div>

                        {{-- Evento --}}
                        <div class="mb-4 p-3 {{ $inscripcion->evento ? 'bg-indigo-50' : 'bg-gray-50' }} rounded-lg">
                            @if($inscripcion->evento)
                                <p class="text-sm text-indigo-900">
                                    <strong>Evento:</strong> {{ $inscripcion->evento->nombre }}
                                </p>
                                <p class="text-xs text-indigo-700 mt-1">
                                    {{ $inscripcion->evento->fecha_inicio->format('d/m/Y') }} - {{ $inscripcion->evento->fecha_fin->format('d/m/Y') }}
                                </p>
                                <span class="inline-block mt-2 px-2 py-1 text-xs rounded-full
                                    @if($inscripcion->evento->estado === 'Activo') bg-green-200 text-green-800
                                    @elseif($inscripcion->evento->estado === 'Cerrado') bg-yellow-200 text-yellow-800
                                    @else bg-blue-200 text-blue-800 @endif">
                                    {{ $inscripcion->evento->estado }}
                                </span>
                            @else
                                <p class="text-sm text-gray-600">
                                    <strong>Estado:</strong> Equipo sin evento
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    Este equipo aún no está registrado en ningún evento
                                </p>
                                <a href="{{ route('estudiante.eventos.index') }}" class="inline-block mt-2 text-xs text-indigo-600 hover:text-indigo-800 font-semibold">
                                    Registrar a un evento →
                                </a>
                            @endif
                        </div>

                        {{-- Descripción --}}
                        @if($inscripcion->equipo->descripcion)
                            <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                                {{ $inscripcion->equipo->descripcion }}
                            </p>
                        @endif

                        {{-- Miembros --}}
                        <div class="mb-4">
                            <p class="text-sm text-gray-700">
                                <strong>Miembros:</strong> {{ $inscripcion->miembros->count() }}
                            </p>
                        </div>

                        {{-- Solicitudes Pendientes (solo para líderes) --}}
                        @if($esLider && $solicitudes->isNotEmpty())
                            <div class="mb-4 p-2 bg-blue-50 border-l-4 border-blue-500 rounded">
                                <p class="text-xs text-blue-700 font-semibold">
                                    {{ $solicitudes->count() }} solicitud(es) pendiente(s)
                                </p>
                            </div>
                        @endif

                        {{-- Botón Ver Detalles --}}
                        <a href="{{ route('estudiante.equipo.show-detalle', $inscripcion) }}" 
                           class="block w-full text-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-semibold">
                            Ver Detalles →
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Botón para crear equipo --}}
        <div class="mt-8 text-center">
            <a href="{{ route('estudiante.equipos.create-sin-evento') }}" 
               class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-semibold">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Crear Nuevo Equipo
            </a>
        </div>
    </div>
</div>
@endsection
