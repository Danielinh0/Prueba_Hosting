@extends('layouts.app')

@section('title', 'Tareas del Proyecto')

@section('content')

<div class="tareas-create-page">
    <div class="container-form">
        
        <a href="{{ route('estudiante.proyecto.show-specific', $proyecto->id_proyecto) }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Volver al Proyecto
        </a>

        {{-- Header --}}
        <div class="page-header">
            <div class="header-icon">
                <i class="fas fa-tasks"></i>
            </div>
            <div class="header-text">
                <h1>Gestión de Tareas</h1>
                <p>Organiza las actividades del proyecto</p>
            </div>
        </div>

        {{-- Información del Proyecto --}}
        <div class="info-card">
            <div class="info-grid">
                <div class="info-item">
                    <i class="fas fa-project-diagram"></i>
                    <div>
                        <span class="info-label">Proyecto</span>
                        <span class="info-value">{{ $proyecto->nombre }}</span>
                    </div>
                </div>
                <div class="info-item">
                    <i class="fas fa-users"></i>
                    <div>
                        <span class="info-label">Equipo</span>
                        <span class="info-value">{{ $inscripcion->equipo->nombre }}</span>
                    </div>
                </div>
                @if($evento)
                <div class="info-item">
                    <i class="fas fa-calendar-alt"></i>
                    <div>
                        <span class="info-label">Evento</span>
                        <span class="info-value">{{ $evento->nombre }}</span>
                    </div>
                </div>
                <div class="info-item">
                    <i class="fas fa-clock"></i>
                    <div>
                        <span class="info-label">Período</span>
                        <span class="info-value">{{ $evento->fecha_inicio->format('d/m') }} - {{ $evento->fecha_fin->format('d/m/Y') }}</span>
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- Estadísticas --}}
        @php
            $completadas = $tareas->where('completada', true)->count();
            $pendientes = $tareas->where('completada', false)->count();
            $total = $tareas->count();
            $progreso = $total > 0 ? round(($completadas / $total) * 100) : 0;
        @endphp
        <div class="stats-card">
            <div class="stat-item green">
                <span class="stat-num">{{ $completadas }}</span>
                <span class="stat-txt">Completadas</span>
            </div>
            <div class="stat-item orange">
                <span class="stat-num">{{ $pendientes }}</span>
                <span class="stat-txt">Pendientes</span>
            </div>
            <div class="stat-item purple">
                <span class="stat-num">{{ $progreso }}%</span>
                <span class="stat-txt">Progreso</span>
            </div>
        </div>

        {{-- Barra de Progreso --}}
        @if($total > 0)
        <div class="progress-container">
            <div class="progress-bar">
                <div class="progress-fill" style="width: {{ $progreso }}%"></div>
            </div>
        </div>
        @endif

        {{-- Formulario Nueva Tarea (Solo Líder) --}}
        @if($esLider)
        <div class="form-card">
            <div class="form-card-header">
                <i class="fas fa-plus-circle"></i>
                <span>Agregar Nueva Tarea</span>
            </div>
            
            <form action="{{ route('estudiante.tareas.store-specific', $proyecto->id_proyecto) }}" method="POST" id="tareaForm">
                @csrf

                {{-- Nombre de la Tarea --}}
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-heading"></i>
                        Nombre de la Tarea <span class="required">*</span>
                    </label>
                    <input type="text" 
                           name="nombre" 
                           id="nombreTarea"
                           required 
                           maxlength="100"
                           class="form-input"
                           placeholder="Nombre de la tarea (máx. 100 caracteres)"
                           value="{{ old('nombre') }}">
                    <div class="input-footer">
                        <span class="char-count" id="nombreCount">0/100</span>
                    </div>
                    @error('nombre')
                        <div class="error-msg"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                {{-- Descripción --}}
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-align-left"></i>
                        Descripción <span class="optional">(opcional - máx. 1000 caracteres)</span>
                    </label>
                    <textarea name="descripcion" 
                              id="descripcionTarea"
                              rows="3"
                              maxlength="1000"
                              class="form-textarea"
                              placeholder="Detalles adicionales sobre la tarea...">{{ old('descripcion') }}</textarea>
                    <div class="input-footer">
                        <span class="char-count" id="descCount">0/1000</span>
                    </div>
                    @error('descripcion')
                        <div class="error-msg"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                {{-- Fila de opciones --}}
                <div class="form-row">
                    <div class="form-group flex-1">
                        <label class="form-label">
                            <i class="fas fa-flag"></i>
                            Prioridad
                        </label>
                        <select name="prioridad" class="form-select">
                            <option value="Baja">Baja</option>
                            <option value="Media" selected>Media</option>
                            <option value="Alta">Alta</option>
                        </select>
                    </div>

                    <div class="form-group flex-1">
                        <label class="form-label">
                            <i class="fas fa-user"></i>
                            Asignar a
                        </label>
                        <select name="asignado_a" class="form-select">
                            <option value="">Todo el equipo</option>
                            @foreach($miembros as $miembro)
                                <option value="{{ $miembro->user->id_usuario }}">
                                    {{ $miembro->user->nombre }} {{ $miembro->user->app_paterno }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group flex-1">
                        <label class="form-label">
                            <i class="fas fa-calendar-alt"></i>
                            Fecha Límite
                        </label>
                        <input type="date" 
                               name="fecha_limite" 
                               class="form-input"
                               @if($evento)
                                   min="{{ $evento->fecha_inicio->format('Y-m-d') }}"
                                   max="{{ $evento->fecha_fin->format('Y-m-d') }}"
                               @endif>
                        @if($evento)
                            <div class="help-text">
                                <i class="fas fa-info-circle"></i>
                                Solo fechas del evento: {{ $evento->fecha_inicio->format('d/m') }} - {{ $evento->fecha_fin->format('d/m/Y') }}
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Botones --}}
                <div class="button-group">
                    <a href="{{ route('estudiante.proyecto.show-specific', $proyecto->id_proyecto) }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <i class="fas fa-plus"></i>
                        <span>Agregar Tarea</span>
                    </button>
                </div>
            </form>
        </div>
        @endif

        {{-- Lista de Tareas --}}
        <div class="form-card">
            <div class="form-card-header">
                <i class="fas fa-clipboard-list"></i>
                <span>Lista de Tareas ({{ $tareas->count() }})</span>
            </div>

            @forelse($tareas as $tarea)
                <div class="task-item {{ $tarea->completada ? 'completed' : 'pending' }}">
                    <form action="{{ route('estudiante.proyectos.tareas.toggle', $tarea) }}" method="POST" class="task-check">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="check-btn {{ $tarea->completada ? 'checked' : '' }}">
                            @if($tarea->completada)
                                <i class="fas fa-check"></i>
                            @endif
                        </button>
                    </form>

                    <div class="task-content">
                        <h4 class="{{ $tarea->completada ? 'done' : '' }}">{{ $tarea->nombre }}</h4>
                        @if($tarea->descripcion)
                            <p class="task-desc">{{ $tarea->descripcion }}</p>
                        @endif
                        <div class="task-meta">
                            <span class="meta-badge priority-{{ strtolower($tarea->prioridad ?? 'media') }}">
                                {{ $tarea->prioridad ?? 'Media' }}
                            </span>
                            @if($tarea->asignado_a && $tarea->asignadoA)
                                <span class="meta-badge user">
                                    <i class="fas fa-user"></i> {{ $tarea->asignadoA->user->nombre }}
                                </span>
                            @else
                                <span class="meta-badge team">
                                    <i class="fas fa-users"></i> Equipo
                                </span>
                            @endif
                            @if($tarea->fecha_limite)
                                <span class="meta-badge date {{ $tarea->estaVencida() ? 'overdue' : '' }}">
                                    <i class="fas fa-calendar"></i> {{ $tarea->fecha_limite->format('d/m/Y') }}
                                </span>
                            @endif
                            @if($tarea->completada && $tarea->completadaPor)
                                <span class="meta-badge completed-by">
                                    <i class="fas fa-check"></i> {{ $tarea->completadaPor->nombre }}
                                </span>
                            @endif
                        </div>
                    </div>

                    @if($esLider)
                        <form action="{{ route('estudiante.proyectos.tareas.destroy', $tarea) }}" method="POST"
                              onsubmit="return confirm('¿Eliminar esta tarea?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-btn">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    @endif
                </div>
            @empty
                <div class="empty-state">
                    <i class="fas fa-clipboard-list"></i>
                    <p>No hay tareas registradas</p>
                    @if($esLider)
                        <span>Usa el formulario de arriba para crear la primera tarea</span>
                    @endif
                </div>
            @endforelse
        </div>
    </div>
</div>

<script>
    // Character counters
    const nombreInput = document.getElementById('nombreTarea');
    const nombreCount = document.getElementById('nombreCount');
    const nombreHint = document.getElementById('nombreHint');
    
    const descInput = document.getElementById('descripcionTarea');
    const descCount = document.getElementById('descCount');

    if (nombreInput) {
        nombreInput.addEventListener('input', () => {
            const len = nombreInput.value.length;
            nombreCount.textContent = `${len}/100`;
        });
    }

    if (descInput) {
        descInput.addEventListener('input', () => {
            const len = descInput.value.length;
            descCount.textContent = `${len}/1000`;
        });
    }

    // Form submission
    const form = document.getElementById('tareaForm');
    const submitBtn = document.getElementById('submitBtn');

    if (form) {
        form.addEventListener('submit', (e) => {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Agregando...';
        });
    }
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

.tareas-create-page {
    background: linear-gradient(135deg, #FFFDF4 0%, #FFEEE2 50%, #FFF5E8 100%);
    min-height: 100vh;
    padding: 1.5rem 1rem;
    font-family: 'Inter', -apple-system, sans-serif;
}

.container-form {
    max-width: 700px;
    margin: 0 auto;
}

/* Back Link - Neumórfico */
.back-link {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    color: #6b7280;
    font-size: 0.85rem;
    font-weight: 500;
    text-decoration: none;
    margin-bottom: 1.5rem;
    transition: all 0.3s;
    padding: 0.5rem 1rem;
    background: #ffeee2;
    border-radius: 12px;
    box-shadow: 3px 3px 6px #e6d5c9, -3px -3px 6px rgba(255, 255, 255, 0.7);
}
.back-link:hover { 
    color: #6366f1;
    box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px rgba(255, 255, 255, 0.8);
}

/* Page Header */
.page-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.header-icon {
    width: 56px;
    height: 56px;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    box-shadow: 4px 4px 8px rgba(99, 102, 241, 0.35), -2px -2px 6px rgba(255, 255, 255, 0.5);
}

.header-text h1 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #111827;
    margin: 0;
}
.header-text p {
    font-size: 0.875rem;
    color: #6b7280;
    margin: 0.25rem 0 0 0;
}

/* Info Card - Mantener colores morados */
.info-card {
    background: linear-gradient(135deg, #ede9fe, #e0e7ff);
    border-radius: 14px;
    padding: 1rem 1.25rem;
    margin-bottom: 1rem;
    border: 1px solid #c7d2fe;
    box-shadow: 4px 4px 8px rgba(99, 102, 241, 0.15), -3px -3px 6px rgba(255, 255, 255, 0.6);
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
    gap: 1rem;
}

.info-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}
.info-item i {
    color: #6366f1;
    font-size: 1rem;
}
.info-item div { display: flex; flex-direction: column; }
.info-label { font-size: 0.65rem; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; }
.info-value { font-size: 0.85rem; font-weight: 600; color: #111827; }

/* Stats Card - Neumórfico */
.stats-card {
    display: flex;
    gap: 0.75rem;
    margin-bottom: 0.75rem;
}

.stat-item {
    flex: 1;
    background: #ffeee2;
    border-radius: 12px;
    padding: 0.875rem;
    text-align: center;
    border: 1px solid rgba(232, 154, 60, 0.1);
    box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px rgba(255, 255, 255, 0.6);
    transition: all 0.3s ease;
}
.stat-item:hover {
    box-shadow: 5px 5px 10px #e6d5c9, -5px -5px 10px rgba(255, 255, 255, 0.7);
}
.stat-num { font-size: 1.5rem; font-weight: 700; display: block; }
.stat-txt { font-size: 0.7rem; color: #6b7280; }
.stat-item.green .stat-num { color: #059669; }
.stat-item.orange .stat-num { color: #ea580c; }
.stat-item.purple .stat-num { color: #7c3aed; }

/* Progress - Mantener colores morados */
.progress-container { margin-bottom: 1.5rem; }
.progress-bar {
    height: 8px;
    background: #ffffff;
    border-radius: 4px;
    overflow: hidden;
    box-shadow: inset 2px 2px 4px #e6d5c9, inset -2px -2px 4px rgba(255, 255, 255, 0.5);
}
.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #6366f1, #8b5cf6);
    border-radius: 4px;
    transition: width 0.3s;
}

/* Form Card - Neumórfico */
.form-card {
    background: #ffeee2;
    border-radius: 16px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px rgba(255, 255, 255, 0.6);
    border: 1px solid rgba(232, 154, 60, 0.1);
}

.form-card-header {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 600;
    font-size: 1rem;
    color: #111827;
    margin-bottom: 1.25rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid rgba(230, 213, 201, 0.5);
}
.form-card-header i { color: #6366f1; }

/* Form Groups */
.form-group {
    margin-bottom: 1.25rem;
}

.form-row {
    display: flex;
    gap: 1rem;
    margin-bottom: 1.25rem;
}
.flex-1 { flex: 1; }

.form-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
}
.form-label i { color: #6366f1; font-size: 0.8rem; }
.required { color: #ef4444; }
.optional { color: #9ca3af; font-weight: 400; font-size: 0.75rem; }

.form-input, .form-textarea, .form-select {
    width: 100%;
    padding: 0.875rem 1rem;
    border: none;
    border-radius: 12px;
    font-size: 0.9rem;
    font-family: inherit;
    transition: all 0.2s;
    background: #ffffff;
    box-shadow: inset 2px 2px 4px #e6d5c9, inset -2px -2px 4px rgba(255, 255, 255, 0.5);
}
.form-input:focus, .form-textarea:focus, .form-select:focus {
    outline: none;
    box-shadow: inset 3px 3px 6px #e6d5c9, 
                inset -3px -3px 6px rgba(255, 255, 255, 0.5),
                0 0 0 3px rgba(99, 102, 241, 0.1);
}
.form-input::placeholder, .form-textarea::placeholder {
    color: #9ca3af;
}
.form-textarea {
    resize: vertical;
    min-height: 90px;
}

.input-footer {
    display: flex;
    justify-content: space-between;
    margin-top: 0.4rem;
    font-size: 0.7rem;
}
.char-count { color: #9ca3af; }
.min-hint { color: #f59e0b; font-weight: 500; }
.min-hint.valid { color: #10b981; }

.error-msg {
    color: #ef4444;
    font-size: 0.8rem;
    margin-top: 0.4rem;
    display: flex;
    align-items: center;
    gap: 0.3rem;
}

.help-text {
    font-size: 0.7rem;
    color: #6b7280;
    margin-top: 0.4rem;
    display: flex;
    align-items: center;
    gap: 0.3rem;
}
.help-text i { color: #6366f1; }

/* Buttons - Neumórfico y manteniendo morado */
.button-group {
    display: flex;
    gap: 1rem;
    margin-top: 1.5rem;
    padding-top: 1.25rem;
    border-top: 1px solid rgba(230, 213, 201, 0.5);
}

.btn {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.875rem 1.5rem;
    border-radius: 12px;
    font-size: 0.9rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s;
    border: none;
    cursor: pointer;
}

.btn-secondary {
    background: #ffffff;
    color: #374151;
    box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px rgba(255, 255, 255, 0.7);
}
.btn-secondary:hover {
    color: #111827;
    box-shadow: 5px 5px 10px #e6d5c9, -5px -5px 10px rgba(255, 255, 255, 0.8);
}
.btn-secondary:active {
    box-shadow: inset 3px 3px 6px #e6d5c9, inset -3px -3px 6px rgba(255, 255, 255, 0.5);
}

.btn-primary {
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    color: white;
    box-shadow: 4px 4px 8px rgba(99, 102, 241, 0.35), -2px -2px 6px rgba(255, 255, 255, 0.5);
}
.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 6px 6px 12px rgba(99, 102, 241, 0.45), -3px -3px 8px rgba(255, 255, 255, 0.6);
}
.btn-primary:active {
    transform: translateY(0);
    box-shadow: inset 3px 3px 6px rgba(0, 0, 0, 0.2), inset -2px -2px 4px rgba(255, 255, 255, 0.1);
}
.btn-primary:disabled {
    opacity: 0.7;
    cursor: not-allowed;
    transform: none;
}

/* Task Items - Diseño PLANO (mantener como estaba) */
.task-item {
    display: flex;
    align-items: flex-start;
    gap: 0.875rem;
    padding: 1rem;
    background: #fafafa;
    border-radius: 12px;
    margin-bottom: 0.75rem;
    border-left: 4px solid #e5e7eb;
    border: 1px solid #f3f4f6;
    transition: all 0.2s;
}
.task-item:hover { background: #f5f5f5; }
.task-item.completed { border-left: 4px solid #10b981; background: #f0fdf4; border-color: #d1fae5; }
.task-item.pending { border-left: 4px solid #f59e0b; border-color: #fef3c7; }

.check-btn {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    border: 2px solid #d1d5db;
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
    flex-shrink: 0;
}
.check-btn i { color: white; font-size: 0.7rem; }
.check-btn.checked {
    background: #10b981;
    border-color: #10b981;
}
.check-btn:hover { border-color: #10b981; }

.task-content { flex: 1; min-width: 0; }
.task-content h4 {
    font-size: 0.95rem;
    font-weight: 600;
    color: #111827;
    margin: 0 0 0.35rem 0;
}
.task-content h4.done {
    text-decoration: line-through;
    color: #9ca3af;
}
.task-desc {
    font-size: 0.8rem;
    color: #6b7280;
    margin: 0 0 0.5rem 0;
    line-height: 1.4;
}

.task-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 0.4rem;
}

/* Badges - Mantener todos los colores originales */
.meta-badge {
    font-size: 0.65rem;
    font-weight: 600;
    padding: 0.25rem 0.6rem;
    border-radius: 5px;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}
.meta-badge.priority-alta { background: #fee2e2; color: #dc2626; }
.meta-badge.priority-media { background: #fef3c7; color: #d97706; }
.meta-badge.priority-baja { background: #d1fae5; color: #059669; }
.meta-badge.user { background: #e0e7ff; color: #4338ca; }
.meta-badge.team { background: #f3f4f6; color: #6b7280; }
.meta-badge.date { background: #fef3c7; color: #92400e; }
.meta-badge.date.overdue { background: #fee2e2; color: #dc2626; }
.meta-badge.completed-by { background: #d1fae5; color: #059669; }

.delete-btn {
    background: none;
    border: none;
    color: #d1d5db;
    cursor: pointer;
    padding: 0.5rem;
    border-radius: 8px;
    transition: all 0.2s;
}
.delete-btn:hover { color: #ef4444; background: #fef2f2; }

/* Empty State */
.empty-state {
    text-align: center;
    padding: 2.5rem 1rem;
    color: #9ca3af;
}
.empty-state i { font-size: 2.5rem; margin-bottom: 0.75rem; opacity: 0.5; }
.empty-state p { font-size: 0.95rem; margin: 0; color: #6b7280; }
.empty-state span { font-size: 0.8rem; }

/* Responsive */
@media (max-width: 640px) {
    .form-row { flex-direction: column; gap: 0; }
    .flex-1 { flex: none; margin-bottom: 1rem; }
    .info-grid { grid-template-columns: 1fr 1fr; }
    .button-group { flex-direction: column-reverse; }
    .stats-card { gap: 0.5rem; }
}
</style>

@endsection