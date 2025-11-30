@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-2xl text-gray-800">Avances del Proyecto</h2>
                <p class="text-gray-600 mt-1">{{ $proyecto->nombre }}</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('estudiante.proyecto.show') }}" class="text-indigo-600 hover:text-indigo-800">
                    ← Volver
                </a>
                <a href="{{ route('estudiante.avances.create') }}" 
                   class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition">
                    + Registrar Avance
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- Timeline de Avances --}}
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="font-semibold text-gray-800 mb-6">📊 Timeline de Entregas</h3>
            
            @forelse($avances as $avance)
                <div class="relative pl-8 pb-8 last:pb-0 border-l-2 border-indigo-200 last:border-transparent">
                    {{-- Punto del Timeline --}}
                    <div class="absolute -left-2 top-0 w-4 h-4 bg-indigo-600 rounded-full"></div>
                    
                    <div class="bg-gray-50 rounded-lg p-5 hover:shadow-md transition">
                        {{-- Header --}}
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                @if($avance->titulo)
                                    <h4 class="font-semibold text-lg text-gray-900">{{ $avance->titulo }}</h4>
                                @endif
                                <p class="text-sm text-gray-500 mt-1">
                                    Registrado por <span class="font-medium">{{ $avance->registradoPor->nombre }}</span>
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="font-semibold text-lg">No hay avances registrados</p>
                    <p class="text-sm mt-2">Registra el primer avance de tu proyecto para que los jurados puedan evaluarlo</p>
                    <a href="{{ route('estudiante.avances.create') }}" 
                       class="inline-block mt-4 bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg transition">
                        Registrar Primer Avance
                    </a>
                </div>
            @endforelse
        </div>

        {{-- Información Adicional --}}
        @if($avances->count() > 0)
            <div class="mt-6 bg-blue-50 border-l-4 border-blue-400 p-4 rounded-r-lg">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-blue-600 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <div class="text-sm text-blue-700">
                        <p class="font-semibold">Estos avances son visibles para los jurados del evento</p>
                        <p class="mt-1">Son utilizados para evaluar el progreso de tu proyecto durante el evento.</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
