@extends('layouts.app')

@section('title', 'Tareas del Proyecto')

@section('content')

<div class="tareas-page py-12">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('estudiante.proyecto.show-specific', $proyecto->id_proyecto) }}" class="back-link">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver al Proyecto
        </a>

        <div class="neuro-card-main">
            <div class="p-6 sm:p-8">
                <h1 class="font-bold text-3xl mb-4">Tareas del Proyecto</h1>

                <div class="project-info">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <strong>Proyecto:</strong>
                            <p class="text-lg mt-1">{{ $proyecto->nombre }}</p>
                        </div>
                        <div>
                            <strong>Equipo:</strong>
                            <p class="text-lg mt-1">{{ $inscripcion->equipo->nombre }}</p>
                        </div>
                        @if($inscripcion->evento)
                            <div>
                                <strong>Evento:</strong>
                                <p class="text-lg mt-1">{{ $inscripcion->evento->nombre }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Estadísticas --}}
        <div class="progress-stats">
            <div class="stat-card">
                <div class="stat-number">{{ $tareas->where('completada', true)->count() }}</div>
                <div class="stat-label">Tareas Completadas</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $tareas->where('completada', false)->count() }}</div>
                <div class="stat-label">Tareas Pendientes</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $tareas->count() }}</div>
                <div class="stat-label">Total de Tareas</div>
            </div>
        </div>

        <div class="content-section">
            <div class="section-header">
                <h3 class="section-title">
                    <i class="fas fa-tasks"></i>
                    Lista de Tareas
                </h3>
            </div>

            @if($tareas->isNotEmpty())
                <div class="progress-bar mb-6">
                    <div class="progress-fill" style="width: {{ round(($tareas->where('completada', true)->count() / $tareas->count()) * 100) }}%;"></div>
                </div>
                <p class="text-sm text-muted mb-6">
                    Progreso: {{ round(($tareas->where('completada', true)->count() / $tareas->count()) * 100) }}% completado
                </p>
            @endif

            <div class="task-list">
                @forelse($tareas as $tarea)
                    <div class="task-item {{ $tarea->completada ? 'completed' : 'pending' }}">
                        <form action="{{ route('estudiante.proyectos.tareas.toggle', $tarea) }}" method="POST" class="task-header">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="task-checkbox {{ $tarea->completada ? 'checked' : '' }}">
                                @if($tarea->completada)
                                    <i class="fas fa-check text-white"></i>
                                @endif
                            </button>
                        </form>

                        <div class="task-content">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <div class="task-title {{ $tarea->completada ? 'completed' : '' }}">
                                        {{ $tarea->nombre }}
                                    </div>
                                    @if($tarea->descripcion)
                                        <div class="task-description">{{ $tarea->descripcion }}</div>
                                    @endif
                                </div>

                                @if($esLider)
                                    <form action="{{ route('estudiante.proyectos.tareas.destroy', $tarea) }}" method="POST"
                                          onsubmit="return confirm('¿Estás seguro de eliminar esta tarea?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-button">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>

                            <div class="task-meta">
                                <span class="task-badge badge-priority">
                                    <i class="fas fa-flag"></i>
                                    {{ $tarea->prioridad ?? 'Media' }}
                                </span>

                                @if($tarea->asignado_a)
                                    <span class="task-badge badge-assignee">
                                        <i class="fas fa-user"></i>
                                        {{ $tarea->asignadoA->user->nombre }}
                                    </span>
                                @else
                                    <span class="task-badge badge-assignee">
                                        <i class="fas fa-users"></i>
                                        Todo el equipo
                                    </span>
                                @endif

                                @if($tarea->fecha_vencimiento)
                                    <span class="task-badge badge-due">
                                        <i class="fas fa-calendar"></i>
                                        {{ $tarea->fecha_vencimiento->format('d/m/Y') }}
                                    </span>
                                @endif

                                @if($tarea->completada && $tarea->completadaPor)
                                    <span class="task-badge badge-completed">
                                        <i class="fas fa-check-circle"></i>
                                        Completada por {{ $tarea->completadaPor->nombre }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <i class="fas fa-clipboard-list"></i>
                        <h5>No hay tareas registradas</h5>
                        <p>Crea la primera tarea para comenzar a organizar el proyecto.</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Formulario para agregar tarea (solo líderes) --}}
        @if($esLider)
            <div class="content-section">
                <div class="section-header">
                    <h3 class="section-title">
                        <i class="fas fa-plus"></i>
                        Agregar Nueva Tarea
                    </h3>
                </div>

                <form action="{{ route('estudiante.tareas.store-specific', $proyecto->id_proyecto) }}" method="POST">
                    @csrf
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">
                                Nombre de la Tarea <span class="required-asterisk">*</span>
                            </label>
                            <input type="text" name="nombre" required maxlength="200"
                                   class="neuro-input"
                                   placeholder="Ej: Implementar sistema de login">
                        </div>
                        <div class="form-group">
                            <label class="form-label">
                                Prioridad
                            </label>
                            <select name="prioridad" class="neuro-select">
                                <option value="Baja">Baja</option>
                                <option value="Media" selected>Media</option>
                                <option value="Alta">Alta</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">
                                Asignar a
                            </label>
                            <select name="asignado_a" class="neuro-select">
                                <option value="">Todo el equipo</option>
                                @foreach($miembros as $miembro)
                                    <option value="{{ $miembro->user->id_usuario }}">
                                        {{ $miembro->user->nombre }} {{ $miembro->user->app_paterno }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">
                                Fecha de Vencimiento
                            </label>
                            <input type="date" name="fecha_vencimiento" class="neuro-input">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Descripción
                        </label>
                        <textarea name="descripcion" rows="3" class="neuro-textarea"
                                  placeholder="Detalles adicionales sobre la tarea..."></textarea>
                    </div>

                    <div class="text-right">
                        <button type="submit" class="action-button btn-primary">
                            <i class="fas fa-plus"></i>
                            Agregar Tarea
                        </button>
                    </div>
                </form>
            </div>
        @endif
    </div>
</div>
@endsection