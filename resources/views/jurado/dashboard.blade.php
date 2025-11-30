@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6">
            <h2 class="font-semibold text-2xl text-gray-800">Panel de Jurado</h2>
            <p class="text-gray-600 mt-1">Bienvenido, {{ $jurado->user->nombre }} {{ $jurado->user->app_paterno }}</p>
        </div>

        {{-- KPIs del Jurado --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 font-medium">Eventos Asignados</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $eventosAsignados->count() }}</p>
                    </div>
                    <svg class="w-12 h-12 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 font-medium">Equipos a Evaluar</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalEquipos }}</p>
                    </div>
                    <svg class="w-12 h-12 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 font-medium">Avances Recientes</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $avancesRecientes }}</p>
                        <p class="text-xs text-gray-500 mt-1">Últimos 7 días</p>
                    </div>
                    <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Eventos Asignados --}}
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-xl font-bold text-gray-900 mb-6">Mis Eventos Asignados</h3>

            @forelse($eventosAsignados as $evento)
                <div class="mb-6 pb-6 border-b border-gray-200 last:border-0 last:pb-0">
                    {{-- Header del Evento --}}
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900">{{ $evento->nombre }}</h4>
                            <p class="text-sm text-gray-600 mt-1">
                                📅 {{ $evento->fecha_inicio->format('d/m/Y') }} - {{ $evento->fecha_fin->format('d/m/Y') }}
                            </p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-sm font-semibold
                            @if($evento->estado == 'Activo') bg-green-100 text-green-800
                            @else bg-blue-100 text-blue-800 @endif">
                            {{ $evento->estado }}
                        </span>
                    </div>

                    @if($evento->descripcion)
                        <p class="text-gray-700 mb-4">{{ $evento->descripcion }}</p>
                    @endif

                    {{-- Lista de Equipos --}}
                    @if($evento->inscripciones->count() > 0)
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h5 class="font-semibold text-gray-700 mb-3">
                                Equipos Registrados ({{ $evento->inscripciones->count() }})
                            </h5>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                @foreach($evento->inscripciones as $inscripcion)
                                    <div class="bg-white rounded-lg p-4 border border-gray-200 hover:border-indigo-500 transition">
                                        <div class="flex justify-between items-start">
                                            <div class="flex-1">
                                                <h6 class="font-semibold text-gray-900">{{ $inscripcion->equipo->nombre }}</h6>
                                                @if($inscripcion->proyecto)
                                                    <p class="text-sm text-gray-600 mt-1">{{ $inscripcion->proyecto->nombre }}</p>
                                                    <p class="text-xs text-gray-500 mt-1">
                                                        {{ $inscripcion->proyecto->avances->count() }} avances registrados
                                                    </p>
                                                @else
                                                    <p class="text-sm text-gray-500 italic mt-1">Sin proyecto registrado</p>
                                                @endif
                                            </div>
                                            @if($inscripcion->proyecto && $inscripcion->proyecto->avances->count() > 0)
                                                <a href="{{ route('jurado.equipos.show', $inscripcion->equipo) }}" 
                                                   class="text-indigo-600 hover:text-indigo-800 text-sm font-medium ml-2">
                                                    Ver →
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="bg-gray-50 rounded-lg p-4 text-center text-gray-500">
                            No hay equipos registrados en este evento aún
                        </div>
                    @endif
                </div>
            @empty
                <div class="text-center py-12 text-gray-500">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                    <p class="font-semibold text-lg">No tienes eventos asignados</p>
                    <p class="text-sm mt-2">Contacta al administrador para que te asigne a eventos</p>
                </div>
            @endforelse
        </div>

        {{-- Información Adicional --}}
        @if($eventosAsignados->count() > 0)
            <div class="mt-6 bg-blue-50 border-l-4 border-blue-400 p-4 rounded-r-lg">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-blue-600 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <div class="text-sm text-blue-700">
                        <p class="font-semibold">Rol de Jurado</p>
                        <p class="mt-1">Puedes ver los proyectos y avances de los equipos asignados. Los equipos están trabajando activamente en sus proyectos.</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
