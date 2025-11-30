@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6 flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800">Proyecto del Equipo</h2>
            @if($esLider && $proyecto)
                <a href="{{ route('estudiante.proyecto.edit') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition">
                    Editar Proyecto
                </a>
            @endif
        </div>

        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if($proyecto)
            {{-- Información del Proyecto --}}
            <div class="bg-white shadow-sm rounded-lg p-6 mb-6">
                <h3 class="text-xl font-bold text-gray-900 mb-4">{{ $proyecto->nombre }}</h3>
                
                @if($proyecto->descripcion_tecnica)
                    <div class="mb-4">
                        <h4 class="font-semibold text-gray-700 mb-2">Descripción Técnica</h4>
                        <p class="text-gray-600">{{ $proyecto->descripcion_tecnica }}</p>
                    </div>
                @endif

                @if($proyecto->repositorio_url)
                    <div class="mb-4">
                        <h4 class="font-semibold text-gray-700 mb-2">Repositorio</h4>
                        <a href="{{ $proyecto->repositorio_url }}" target="_blank" class="text-indigo-600 hover:text-indigo-800 underline">
                            {{ $proyecto->repositorio_url }}
                        </a>
                    </div>
                @endif

                <div class="text-sm text-gray-500 mt-4">
                    Creado: {{ $proyecto->created_at->format('d/m/Y H:i') }}
                    @if($proyecto->updated_at != $proyecto->created_at)
                        | Actualizado: {{ $proyecto->updated_at->format('d/m/Y H:i') }}
                    @endif
                </div>
            </div>

            {{-- Accesos Rápidos --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('estudiante.tareas.index') }}" class="bg-white p-6 rounded-lg shadow-sm border-2 border-gray-200 hover:border-indigo-500 transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="font-semibold text-gray-700">Tareas del Proyecto</h4>
                            <p class="text-gray-500 text-sm mt-1">Gestiona el checklist</p>
                        </div>
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                    </div>
                </a>

                <a href="{{ route('estudiante.avances.index') }}" class="bg-white p-6 rounded-lg shadow-sm border-2 border-gray-200 hover:border-green-500 transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="font-semibold text-gray-700">Avances Registrados</h4>
                            <p class="text-gray-500 text-sm mt-1">Timeline de entregas</p>
                        </div>
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </a>

                <a href="{{ route('estudiante.equipo.index') }}" class="bg-white p-6 rounded-lg shadow-sm border-2 border-gray-200 hover:border-purple-500 transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="font-semibold text-gray-700">Mi Equipo</h4>
                            <p class="text-gray-500 text-sm mt-1">Ver miembros</p>
                        </div>
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </a>
            </div>

        @else
            {{-- No hay proyecto --}}
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6 rounded-r-lg">
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-yellow-600 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <div>
                        <h3 class="font-semibold text-yellow-800 mb-2">No hay proyecto creado</h3>
                        <p class="text-yellow-700 mb-4">Tu equipo aún no ha creado un proyecto. El líder debe crear el proyecto para comenzar.</p>
                        
                        @if($esLider)
                            <a href="{{ route('estudiante.proyecto.create') }}" class="inline-block bg-yellow-600 hover:bg-yellow-700 text-white px-6 py-2 rounded-lg transition">
                                Crear Proyecto Ahora
                            </a>
                        @else
                            <p class="text-sm text-yellow-600">Contacta al líder de tu equipo para que cree el proyecto.</p>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
