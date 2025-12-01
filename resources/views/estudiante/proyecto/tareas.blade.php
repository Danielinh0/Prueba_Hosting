@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
    
    /* Fondo degradado */
    .tareas-page {
        background: linear-gradient(to bottom, #FFFDF4, #FFEEE2);
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
    }
    
    /* Textos */
    .tareas-page h2,
    .tareas-page h3,
    .tareas-page h4 {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
    }
    
    .tareas-page p,
    .tareas-page label {
        font-family: 'Poppins', sans-serif;
        color: #6b6b6b;
    }
    
    .tareas-page a {
        font-family: 'Poppins', sans-serif;
        color: #e89a3c;
        transition: all 0.2s ease;
    }
    
    .tareas-page a:hover {
        color: #d98a2c;
        opacity: 0.8;
    }
    
    /* Cards neuromórficas */
    .neuro-card {
        background: #FFEEE2;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
        transition: all 0.3s ease;
    }
    
    /* Alerts */
    .alert-success {
        background: rgba(209, 250, 229, 0.8);
        border: 1px solid #10b981;
        color: #065f46;
        border-radius: 15px;
        padding: 1rem 1.5rem;
        font-family: 'Poppins', sans-serif;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
    }
    
    .alert-error {
        background: rgba(254, 226, 226, 0.8);
        border: 1px solid #ef4444;
        color: #991b1b;
        border-radius: 15px;
        padding: 1rem 1.5rem;
        font-family: 'Poppins', sans-serif;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
    }
    
    /* Barra de progreso */
    .progress-container {
        background: rgba(255, 255, 255, 0.3);
        border-radius: 15px;
        height: 1rem;
        box-shadow: inset 4px 4px 8px #e6d5c9, inset -4px -4px 8px #ffffff;
    }
    
    .progress-bar {
        background: linear-gradient(135deg, #e89a3c, #f5a847);
        height: 1rem;
        border-radius: 15px;
        box-shadow: 2px 2px 4px rgba(232, 154, 60, 0.3);
        transition: all 0.5s ease;
    }
    
    .progress-percentage {
        font-family: 'Poppins', sans-serif;
        color: #e89a3c;
        font-size: 1.5rem;
        font-weight: 700;
    }
    
    /* Inputs y selects neuromórficos */
    .neuro-input,
    .neuro-select,
    .neuro-textarea {
        font-family: 'Poppins', sans-serif;
        background: rgba(255, 255, 255, 0.5);
        border: none;
        box-shadow: inset 4px 4px 8px #e6d5c9, inset -4px -4px 8px #ffffff;
        transition: all 0.2s ease;
        backdrop-filter: blur(10px);
    }
    
    .neuro-input:focus,
    .neuro-select:focus,
    .neuro-textarea:focus {
        outline: none;
        box-shadow: inset 6px 6px 12px #e6d5c9, inset -6px -6px 12px #ffffff;
    }
    
    /* Botón principal */
    .neuro-button {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #e89a3c, #f5a847);
        color: #ffffff;
        font-weight: 600;
        box-shadow: 4px 4px 8px rgba(232, 154, 60, 0.3);
        transition: all 0.3s ease;
        border: none;
    }
    
    .neuro-button:hover {
        box-shadow: 6px 6px 12px rgba(232, 154, 60, 0.4);
        transform: translateY(-2px);
    }
    
    /* Tarea item */
    .tarea-item {
        transition: all 0.2s ease;
    }
    
    .tarea-item:hover {
        background: rgba(255, 255, 255, 0.3);
        border-radius: 10px;
    }
    
    /* Checkbox buttons */
    .checkbox-button {
        background: none;
        border: none;
        padding: 0;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .checkbox-button:hover {
        transform: scale(1.1);
    }
    
    /* Badges de prioridad */
    .badge {
        font-family: 'Poppins', sans-serif;
        padding: 0.25rem 0.5rem;
        border-radius: 10px;
        font-size: 0.75rem;
        font-weight: 500;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    /* Delete button */
    .delete-button {
        color: #ef4444;
        background: none;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .delete-button:hover {
        color: #dc2626;
        transform: scale(1.1);
    }
    
    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 3rem 0;
    }
    
    .empty-state svg {
        margin: 0 auto;
        color: #6b6b6b;
    }
    
    .empty-state p {
        font-family: 'Poppins', sans-serif;
        color: #6b6b6b;
    }
</style>

<div class="tareas-page py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-2xl">Tareas del Proyecto</h2>
                <p class="mt-1">{{ $proyecto->nombre }}</p>
            </div>
            <a href="{{ route('estudiante.proyecto.show') }}">
                ← Volver al Proyecto
            </a>
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