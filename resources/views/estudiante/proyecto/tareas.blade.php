@extends('layouts.app')

@section('content')

<div class="tareas-page py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('estudiante.proyecto.show') }}" class="back-link">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver al Proyecto {{ $proyecto->nombre }}
            </a>
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-2xl">Tareas del Proyecto</h2>
                <p class="mt-1">{{ $proyecto->nombre }}</p>
            </div>
        </div>

        @if(session('success'))
            <div class="alert-success mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert-error mb-4">
                {{ session('error') }}
            </div>
        @endif

        {{-- Barra de Progreso --}}
        <div class="neuro-card rounded-lg p-6 mb-6">
            <div class="flex justify-between items-center mb-2">
                <h3 class="font-semibold">Progreso General</h3>
                <span class="progress-percentage">{{ $progreso }}%</span>
            </div>
            <div class="progress-container">
                <div class="progress-bar" style="width: {{ $progreso }}%"></div>
            </div>
            <p class="text-sm mt-2">
                {{ $tareas->where('completada', true)->count() }} de {{ $tareas->count() }} tareas completadas
            </p>
        </div>

        {{-- Formulario para Agregar Tarea (Solo Líder) --}}
        @if($esLider)
            <div class="neuro-card rounded-lg p-6 mb-6">
                <h3 class="font-semibold mb-4">➕ Agregar Nueva Tarea</h3>
                <form action="{{ route('estudiante.tareas.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Nombre de la Tarea *</label>
                            <input type="text" name="nombre" required maxlength="200"
                                   class="neuro-input w-full px-3 py-2 rounded-lg"
                                   placeholder="Ej: Implementar login">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Prioridad *</label>
                            <select name="prioridad" required
                                    class="neuro-select w-full px-3 py-2 rounded-lg">
                                <option value="Media">Media</option>
                                <option value="Alta">Alta</option>
                                <option value="Baja">Baja</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Asignar a</label>
                            <select name="asignado_a"
                                    class="neuro-select w-full px-3 py-2 rounded-lg">
                                <option value="">Todo el equipo</option>
                                @foreach($miembros as $miembro)
                                    <option value="{{ $miembro->id_miembro }}">
                                        {{ $miembro->user->nombre }} {{ $miembro->user->app_paterno }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Fecha Límite</label>
                            <input type="date" name="fecha_limite"
                                   class="neuro-input w-full px-3 py-2 rounded-lg">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Descripción</label>
                        <textarea name="descripcion" rows="2"
                                  class="neuro-textarea w-full px-3 py-2 rounded-lg"
                                  placeholder="Detalles adicionales..."></textarea>
                    </div>
                    <button type="submit" class="neuro-button px-6 py-2 rounded-lg">
                        Agregar Tarea
                    </button>
                </form>
            </div>
        @endif

        {{-- Lista de Tareas --}}
        <div class="neuro-card rounded-lg p-6">
            <h3 class="font-semibold mb-4">📋 Checklist de Tareas</h3>
            
            @forelse($tareas as $tarea)
                <div class="tarea-item border-b border-gray-200 last:border-0 py-4">
                    <div class="flex items-start space-x-3">
                        {{-- Checkbox --}}
                        <form action="{{ route('estudiante.tareas.toggle', $tarea) }}" method="POST" class="flex-shrink-0">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="checkbox-button mt-1">
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
                                        <p class="text-sm mt-1">{{ $tarea->descripcion }}</p>
                                    @endif
                                </div>

                                {{-- Botón Eliminar (Solo Líder) --}}
                                @if($esLider)
                                    <form action="{{ route('estudiante.tareas.destroy', $tarea) }}" method="POST" 
                                          onsubmit="return confirm('¿Eliminar esta tarea?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-button ml-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            </div>

                            {{-- Metadata --}}
                            <div class="flex flex-wrap items-center gap-3 mt-2 text-xs">
                                <span class="badge {{ $tarea->getColorPrioridad() }}">
                                    {{ $tarea->prioridad }}
                                </span>

                                @if($tarea->asignado_a)
                                    <span style="color: #6b6b6b;">
                                        👤 {{ $tarea->asignadoA->user->nombre }}
                                    </span>
                                @else
                                    <span style="color: #6b6b6b;">👥 Todo el equipo</span>
                                @endif

                                @if($tarea->fecha_limite)
                                    <span style="color: #6b6b6b;">
                                         {{ $tarea->fecha_limite->format('d/m/Y') }}
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
                <div class="empty-state">
                    <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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