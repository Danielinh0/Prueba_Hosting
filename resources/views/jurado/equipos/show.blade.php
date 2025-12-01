@extends('layouts.prueba')

@section('content')
<div class="py-12">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="mb-6 flex justify-between items-center">
            <div>
                <a href="{{ route('jurado.dashboard') }}" class="text-indigo-600 hover:text-indigo-800 text-sm mb-2 inline-block">
                    ← Volver al Dashboard
                </a>
                <h2 class="font-semibold text-2xl text-gray-900">{{ $equipo->nombre }}</h2>
                <p class="text-gray-600 mt-1">Evento: {{ $evento->nombre }}</p>
            </div>
            @if($inscripcion->proyecto)
                <a href="{{ route('jurado.evaluaciones.create', $inscripcion) }}"
                   class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg transition inline-flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Evaluar Proyecto
                </a>
            @endif
        </div>


        {{-- Información del Proyecto --}}
        @if($proyecto)
            <div class="bg-white shadow-sm rounded-lg p-6 mb-6">
                <h3 class="text-xl font-bold text-gray-900 mb-4">📁 {{ $proyecto->nombre }}</h3>
                
                @if($proyecto->descripcion_tecnica)
                    <div class="mb-4">
                        <h4 class="font-semibold text-gray-700 mb-2">Descripción Técnica</h4>
                        <p class="text-gray-700">{{ $proyecto->descripcion_tecnica }}</p>
                    </div>
                @endif

                @if($proyecto->repositorio_url)
                    <div class="mb-4">
                        <h4 class="font-semibold text-gray-700 mb-2">Repositorio</h4>
                        <a href="{{ $proyecto->repositorio_url }}" target="_blank" 
                           class="text-indigo-600 hover:text-indigo-800 underline flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z"></path>
                                <path d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z"></path>
                            </svg>
                            {{ $proyecto->repositorio_url }}
                        </a>
                    </div>
                @endif

                <div class="text-sm text-gray-500 pt-4 border-t">
                    Proyecto registrado: {{ $proyecto->created_at->format('d/m/Y H:i') }}
                </div>
            </div>

            {{-- Miembros del Equipo --}}
            <div class="bg-white shadow-sm rounded-lg p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">👥 Miembros del Equipo</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($inscripcion->miembros as $miembro)
                        <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                            <div class="flex-shrink-0 w-12 h-12 bg-indigo-600 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                {{ substr($miembro->user->nombre, 0, 1) }}{{ substr($miembro->user->app_paterno, 0, 1) }}
                            </div>
                            <div class="ml-4 flex-1">
                                <h4 class="font-semibold text-gray-900">
                                    {{ $miembro->user->nombre }} {{ $miembro->user->app_paterno }}
                                    @if($miembro->es_lider)
                                        <span class="ml-2 px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">Líder</span>
                                    @endif
                                </h4>
                                <p class="text-sm text-gray-600">{{ $miembro->rolEquipo->nombre }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Avances del Proyecto --}}
            <div class="bg-white shadow-sm rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-gray-900">📊 Avances Registrados</h3>
                    <span class="text-2xl font-bold text-indigo-600">
                        {{ $proyecto->avances->count() }}
                    </span>
                </div>

                @forelse($proyecto->avances->sortByDesc('created_at') as $avance)
                    <div class="relative pl-8 pb-8 last:pb-0 border-l-2 border-indigo-200 last:border-transparent">
                        {{-- Punto del Timeline --}}
                        <div class="absolute -left-2 top-0 w-4 h-4 bg-indigo-600 rounded-full"></div>
                        
                        <div class="bg-gray-50 rounded-lg p-5">
                            {{-- Header --}}
                            <div class="flex justify-between items-start mb-3">
                                <div class="flex-1">
                                    @if($avance->titulo)
                                        <h4 class="font-semibold text-lg text-gray-900">{{ $avance->titulo }}</h4>
                                    @endif
                                    <p class="text-sm text-gray-500 mt-1">
                                        Por <span class="font-medium">{{ $avance->registradoPor->nombre }} {{ $avance->registradoPor->app_paterno }}</span>
                                        · {{ $avance->created_at->format('d/m/Y H:i') }}
                                        <span class="text-xs text-gray-400">({{ $avance->created_at->diffForHumans() }})</span>
                                    </p>
                                </div>
                            </div>

                            {{-- Descripción --}}
                            <div class="text-gray-700 mb-3 whitespace-pre-line">
                                {{ $avance->descripcion }}
                            </div>

                            {{-- Archivo Adjunto --}}
                            @if($avance->archivo_evidencia)
                                <div class="mt-3 pt-3 border-t border-gray-200">
                                    <a href="{{ Storage::url($avance->archivo_evidencia) }}" target="_blank"
                                       class="inline-flex items-center text-indigo-600 hover:text-indigo-800">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                        </svg>
                                        Ver archivo adjunto
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12 text-gray-500">
                        <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p class="font-semibold">No hay avances registrados aún</p>
                        <p class="text-sm mt-2">El equipo aún no ha reportado avances en su proyecto</p>
                    </div>
                @endforelse
            </div>

        @else
            {{-- Sin Proyecto --}}
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6 rounded-r-lg">
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-yellow-600 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <div>
                        <h3 class="font-semibold text-yellow-800">Este equipo aún no ha creado su proyecto</h3>
                        <p class="text-yellow-700 mt-1">El líder del equipo debe crear el proyecto para comenzar a registrar avances.</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
