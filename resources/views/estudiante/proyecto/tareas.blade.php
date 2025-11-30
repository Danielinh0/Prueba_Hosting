@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-2xl text-gray-800">Tareas del Proyecto</h2>
                <p class="text-gray-600 mt-1">{{ $proyecto->nombre }}</p>
            </div>
            <a href="{{ route('estudiante.proyecto.show') }}" class="text-indigo-600 hover:text-indigo-800">
                ← Volver al Proyecto
            </a>
        </div>

        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
        @endif

        {{-- Barra de Progreso --}}
        <div class="bg-white shadow-sm rounded-lg p-6 mb-6">
            <div class="flex justify-between items-center mb-2">
                <h3 class="font-semibold text-gray-700">Progreso General</h3>
                <span class="text-2xl font-bold text-indigo-600">{{ $progreso }}%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-4">
                <div class="bg-indigo-600 h-4 rounded-full transition-all duration-500" style="width: {{ $progreso }}%"></div>
            </div>
            <p class="text-sm text-gray-500 mt-2">
                {{ $tareas->where('completada', true)->count() }} de {{ $tareas->count() }} tareas completadas
            </p>
        </div>

        {{-- Formulario para Agregar Tarea (Solo Líder) --}}
        @if($esLider)
            <div class="bg-white shadow-sm rounded-lg p-6 mb-6">
                <h3 class="font-semibold text-gray-800 mb-4">➕ Agregar Nueva Tarea</h3>
                <form action="{{ route('estudiante.tareas.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nombre de la Tarea *</label>
                            <input type="text" name="nombre" required maxlength="200"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                                   placeholder="Ej: Implementar login">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Prioridad *</label>
                            <select name="prioridad" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                <option value="Media">Media</option>
                                <option value="Alta">Alta</option>
                                <option value="Baja">Baja</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Asignar a</label>
                            <select name="asignado_a"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                <option value="">Todo el equipo</option>
                                @foreach($miembros as $miembro)
                                    <option value="{{ $miembro->id_miembro }}">
                                        {{ $miembro->user->nombre }} {{ $miembro->user->app_paterno }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Fecha Límite</label>
                            <input type="date" name="fecha_limite"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                        <textarea name="descripcion" rows="2"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                                  placeholder="Detalles adicionales..."></textarea>
                    </div>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg transition">
                        Agregar Tarea
                    </button>
                </form>
            </div>
        @endif

        {{-- Lista de Tareas --}}
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="font-semibold text-gray-800 mb-4">📋 Checklist de Tareas</h3>
            
            @forelse($tareas as $tarea)
                <div class="border-b border-gray-200 last:border-0 py-4 hover:bg-gray-50 transition">
                    <div class="flex items-start space-x-3">
                        {{-- Checkbox --}}
                        <form action="{{ route('estudiante.tareas.toggle', $tarea) }}" method="POST" class="flex-shrink-0">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="mt-1">
                                @if($tarea->completada)
                                    <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                @else
                                    <svg class="w-6 h-6 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <circle cx="12" cy="12" r="10" stroke-width="2"></circle>
                                    </svg>
                                @endif
                            </button>
                        </form>

                        {{-- Información de la Tarea --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h4 class="font-medium {{ $tarea->completada ? 'line-through text-gray-500' : 'text-gray-900' }}">
                                        {{ $tarea->nombre }}
                                    </h4>
                                    @if($tarea->descripcion)
                                        <p class="text-sm text-gray-600 mt-1">{{ $tarea->descripcion }}</p>
                                    @endif
                                </div>

                                {{-- Botón Eliminar (Solo Líder) --}}
                                @if($esLider)
                                    <form action="{{ route('estudiante.tareas.destroy', $tarea) }}" method="POST" 
                                          onsubmit="return confirm('¿Eliminar esta tarea?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 ml-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            </div>

                            {{-- Metadata --}}
                            <div class="flex flex-wrap items-center gap-3 mt-2 text-xs">
                                <span class="px-2 py-1 rounded {{ $tarea->getColorPrioridad() }}">
                                    {{ $tarea->prioridad }}
                                </span>

                                @if($tarea->asignado_a)
                                    <span class="text-gray-600">
                                        👤 {{ $tarea->asignadoA->user->nombre }}
                                    </span>
                                @else
                                    <span class="text-gray-500">👥 Todo el equipo</span>
                                @endif

                                @if($tarea->fecha_limite)
                                    <span class="text-gray-600">
                                        📅 {{ $tarea->fecha_limite->format('d/m/Y') }}
                                        @if($tarea->estaVencida())
                                            <span class="text-red-600 font-semibold">(Vencida)</span>
                                        @endif
                                    </span>
                                @endif

                                @if($tarea->completada && $tarea->completadaPor)
                                    <span class="text-green-600">
                                        ✓ Por {{ $tarea->completadaPor->nombre }} el {{ $tarea->fecha_completada->format('d/m/Y') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-12 text-gray-500">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <p class="font-semibold">No hay tareas registradas</p>
                    @if($esLider)
                        <p class="text-sm mt-1">Comienza agregando la primera tarea arriba</p>
                    @endif
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
