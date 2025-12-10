@extends('layouts.app')

@section('title', 'Detalle del Evento')

@section('content')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/eventos/show.css') }}">
@endpush

<div class="evento-modern-page">
    <div class="container-evento">
        
        {{-- Back Link --}}
        <a href="{{ route('admin.eventos.index') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Volver a Eventos
        </a>

        {{-- Mensajes de Sesión --}}
        @if(session('success'))
            <div style="background: linear-gradient(135deg, #d1fae5, #a7f3d0); border: 2px solid #10b981; border-radius: 12px; padding: 1rem 1.5rem; margin-bottom: 1.5rem; color: #065f46;">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <i class="fas fa-check-circle" style="color: #10b981;"></i>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('warning'))
            <div style="background: linear-gradient(135deg, #fef3c7, #fde68a); border: 2px solid #f59e0b; border-radius: 12px; padding: 1.25rem 1.5rem; margin-bottom: 1.5rem;">
                <div style="display: flex; align-items: flex-start; gap: 1rem;">
                    <div style="background: #f59e0b; border-radius: 50%; padding: 0.5rem; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-exclamation-triangle" style="color: white; font-size: 1.1rem;"></i>
                    </div>
                    <div style="flex: 1;">
                        <p style="font-weight: 600; color: #92400e; margin: 0 0 0.5rem 0;">{{ session('warning') }}</p>
                        
                        @if(session('confirm_close'))
                            <div style="display: flex; gap: 1rem; margin-top: 1rem;">
                                <form action="{{ route('admin.eventos.cerrar-forzado', $evento) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" style="background: #dc2626; color: white; border: none; padding: 0.6rem 1.25rem; border-radius: 8px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.2s;" onmouseover="this.style.background='#b91c1c'" onmouseout="this.style.background='#dc2626'">
                                        <i class="fas fa-lock"></i>
                                        Cerrar de todas formas
                                    </button>
                                </form>
                                <a href="{{ route('admin.eventos.asignar', $evento) }}" style="background: #3b82f6; color: white; text-decoration: none; padding: 0.6rem 1.25rem; border-radius: 8px; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.2s;" onmouseover="this.style.background='#2563eb'" onmouseout="this.style.background='#3b82f6'">
                                    <i class="fas fa-user-tie"></i>
                                    Asignar Jurados Primero
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div style="background: linear-gradient(135deg, #fee2e2, #fecaca); border: 2px solid #ef4444; border-radius: 12px; padding: 1rem 1.5rem; margin-bottom: 1.5rem; color: #991b1b;">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <i class="fas fa-times-circle" style="color: #ef4444;"></i>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif

        {{-- Hero Section con Imagen --}}
        <div class="event-hero" style="min-height: 220px;">
            @if ($evento->ruta_imagen)
                <div class="hero-image">
                    <img src="{{ asset('storage/' . $evento->ruta_imagen) }}" alt="{{ $evento->nombre }}">
                    <div class="hero-gradient"></div>
                </div>
            @endif
            <div class="hero-content {{ !$evento->ruta_imagen ? 'no-image' : '' }}" style="min-height: 220px;">
                <div class="hero-main">
                    <span class="estado-badge estado-{{ strtolower($evento->estado) }}">
                        <i class="fas fa-circle"></i>
                        {{ $evento->estado }}
                    </span>
                    <h1>{{ $evento->nombre }}</h1>
                </div>
            </div>
        </div>

        {{-- Fechas Destacadas --}}
        <div class="dates-showcase">
            <div class="date-card start">
                <div class="date-info">
                    <span class="date-label">FECHA DE INICIO</span>
                    <span class="date-main">{{ $evento->fecha_inicio->format('d') }}</span>
                    <span class="date-secondary">{{ $evento->fecha_inicio->translatedFormat('F Y') }}</span>
                    <span class="date-full">{{ $evento->fecha_inicio->translatedFormat('l, j \d\e F') }}</span>
                </div>
            </div>
            <div class="date-connector">
                <div class="connector-line"></div>
                <span class="connector-days">
                    {{ $evento->fecha_inicio->diffInDays($evento->fecha_fin) }} días
                </span>
                <div class="connector-line"></div>
            </div>
            <div class="date-card end">
                <div class="date-info">
                    <span class="date-label">FECHA DE CIERRE</span>
                    <span class="date-main">{{ $evento->fecha_fin->format('d') }}</span>
                    <span class="date-secondary">{{ $evento->fecha_fin->translatedFormat('F Y') }}</span>
                    <span class="date-full">{{ $evento->fecha_fin->translatedFormat('l, j \d\e F') }}</span>
                </div>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="stats-grid">
            <div class="stat-card teams">
                <div class="stat-icon"><i class="fas fa-users"></i></div>
                <div class="stat-data">
                    <span class="stat-number">{{ $evento->inscripciones->count() }}</span>
                    <span class="stat-label">Equipos Inscritos</span>
                    <span class="stat-sublabel">de {{ $evento->cupo_max_equipos }} máx.</span>
                </div>
            </div>
            <div class="stat-card judges">
                <div class="stat-icon"><i class="fas fa-user-tie"></i></div>
                <div class="stat-data">
                    <span class="stat-number">{{ $evento->jurados->count() }}</span>
                    <span class="stat-label">Jurados</span>
                    <span class="stat-sublabel">asignados</span>
                </div>
            </div>
            <div class="stat-card criteria">
                <div class="stat-icon"><i class="fas fa-clipboard-check"></i></div>
                <div class="stat-data">
                    <span class="stat-number">{{ $evento->criteriosEvaluacion->count() }}</span>
                    <span class="stat-label">Criterios</span>
                    <span class="stat-sublabel">de evaluación</span>
                </div>
            </div>
        </div>

        {{-- ACCIONES DE ADMINISTRADOR (MOVIDO ARRIBA) --}}
        <div class="content-card actions-card">
            <div class="card-header neuro-card">
                <i class="fas fa-cogs"></i>
                <h3>Acciones de Administrador</h3>
            </div>
            <div class="card-body">
                <div class="actions-grid">
                    <a href="{{ route('admin.eventos.asignar', $evento) }}" class="action-btn primary">
                        <i class="fas fa-user-tie"></i>
                        <span>Gestionar Jurados</span>
                    </a>

                    @if($evento->estado === 'Próximo')
                        <form action="{{ route('admin.eventos.activar', $evento) }}" method="POST" onsubmit="return confirm('¿Activar este evento?');">
                            @csrf @method('PATCH')
                            <button type="submit" class="action-btn success">
                                <i class="fas fa-play"></i>
                                <span>Activar Evento</span>
                            </button>
                        </form>
                    @elseif($evento->estado === 'Activo')
                        <form action="{{ route('admin.eventos.cerrar', $evento) }}" method="POST" onsubmit="return confirm('¿Cerrar inscripciones?');">
                            @csrf @method('PATCH')
                            <button type="submit" class="action-btn warning">
                                <i class="fas fa-lock"></i>
                                <span>Cerrar Inscripciones</span>
                            </button>
                        </form>
                        <form action="{{ route('admin.eventos.finalizar', $evento) }}" method="POST" onsubmit="return confirm('¿Finalizar evento?');">
                            @csrf @method('PATCH')
                            <button type="submit" class="action-btn info">
                                <i class="fas fa-flag-checkered"></i>
                                <span>Finalizar</span>
                            </button>
                        </form>
                    @elseif($evento->estado === 'En Progreso')
                        @if($evento->todasEvaluacionesCompletas())
                            <form action="{{ route('admin.eventos.finalizar', $evento) }}" method="POST" onsubmit="return confirm('¿Finalizar evento? Todas las evaluaciones están completas.');">
                                @csrf @method('PATCH')
                                <button type="submit" class="action-btn success">
                                    <i class="fas fa-flag-checkered"></i>
                                    <span>Finalizar Evento</span>
                                </button>
                            </form>
                        @else
                            <button onclick="document.getElementById('modalForzarFinalizar').classList.remove('hidden')" class="action-btn warning">
                                <i class="fas fa-exclamation-triangle"></i>
                                <span>Forzar Finalización</span>
                            </button>
                            <div class="text-sm text-gray-600 mt-2">
                                <i class="fas fa-info-circle"></i>
                                No se puede finalizar: faltan evaluaciones por completar
                            </div>
                        @endif
                    @elseif($evento->estado === 'Cerrado')
                        @if(!$evento->tipo_proyecto)
                            <button onclick="document.getElementById('modalTipoProyecto').classList.remove('hidden')" class="action-btn secondary">
                                <i class="fas fa-project-diagram"></i>
                                <span>Configurar Proyecto</span>
                            </button>
                        @else
                            @if($evento->tipo_proyecto === 'general')
                                @if($evento->proyectoGeneral)
                                    <a href="{{ route('admin.proyectos-evento.edit', $evento->proyectoGeneral) }}" class="action-btn info">
                                        <i class="fas fa-edit"></i>
                                        <span>Editar Proyecto</span>
                                    </a>
                                    @if(!$evento->proyectoGeneral->publicado)
                                        <form action="{{ route('admin.proyectos-evento.publicar', $evento->proyectoGeneral) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="action-btn success">
                                                <i class="fas fa-rocket"></i>
                                                <span>Publicar</span>
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    <a href="{{ route('admin.proyectos-evento.create', $evento) }}" class="action-btn success">
                                        <i class="fas fa-plus"></i>
                                        <span>Crear Proyecto</span>
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('admin.proyectos-evento.asignar', $evento) }}" class="action-btn success">
                                    <i class="fas fa-tasks"></i>
                                    <span>Asignar Proyectos</span>
                                </a>
                            @endif
                        @endif
                        <form action="{{ route('admin.eventos.reactivar', $evento) }}" method="POST" onsubmit="return confirm('¿Reabrir inscripciones?');">
                            @csrf @method('PATCH')
                            <button type="submit" class="action-btn warning">
                                <i class="fas fa-unlock"></i>
                                <span>Reabrir</span>
                            </button>
                        </form>
                    @elseif($evento->estado === 'Finalizado')
                        <a href="{{ route('admin.eventos.resultados', $evento) }}" class="action-btn primary">
                            <i class="fas fa-trophy"></i>
                            <span>Ver Resultados</span>
                        </a>
                        <form action="{{ route('admin.eventos.reactivar', $evento) }}" method="POST" onsubmit="return confirm('¿Reactivar evento?');">
                            @csrf @method('PATCH')
                            <button type="submit" class="action-btn danger">
                                <i class="fas fa-redo"></i>
                                <span>Reactivar</span>
                            </button>
                        </form>
                    @endif

                    <a href="{{ route('admin.eventos.edit', $evento) }}" class="action-btn neutral">
                        <i class="fas fa-edit"></i>
                        <span>Editar Evento</span>
                    </a>
                </div>
            </div>
        </div>

        {{-- Descripción --}}
        @if($evento->descripcion)
        <div class="content-card">
            <div class="card-header neuro-card">
                <i class="fas fa-info-circle"></i>
                <h3>Descripción del Evento</h3>
            </div>
            <div class="card-body">
                <p class="description-text">{{ $evento->descripcion }}</p>
            </div>
        </div>
        @endif

        {{-- Dos columnas: Jurados y Equipos --}}
        <div class="two-columns">
            {{-- Jurados --}}
            <div class="content-card">
                <div class="card-header neuro-card">
                    <i class="fas fa-user-tie"></i>
                    <h3>Jurados Asignados</h3>
                    <span class="count-badge">{{ $evento->jurados->count() }}</span>
                </div>
                <div class="card-body">
                    @forelse($evento->jurados as $jurado)
                        <a href="{{ route('admin.users.edit', $jurado->user) }}" class="person-row neuro-card">
                            <div class="person-avatar">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="person-info">
                                <span class="person-name">{{ $jurado->user->nombre }} {{ $jurado->user->app_paterno }}</span>
                                <span class="person-detail">{{ $jurado->especialidad ?? 'Jurado' }}</span>
                            </div>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    @empty
                        <div class="empty-list">
                            <i class="fas fa-user-slash"></i>
                            <p>Sin jurados asignados</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Equipos --}}
            <div class="content-card">
                <div class="card-header neuro-card">
                    <i class="fas fa-users"></i>
                    <h3>Equipos Inscritos</h3>
                    <span class="count-badge">{{ $evento->inscripciones->count() }}/{{ $evento->cupo_max_equipos }}</span>
                </div>
                <div class="card-body">
                    @forelse($evento->inscripciones as $inscripcion)
                        <a href="{{ route('admin.equipos.show', $inscripcion->equipo) }}" class="person-row team-row neuro-card">
                            <div class="team-rank">
                                @if($inscripcion->puesto_ganador == 1)
                                    <span class="medal gold">🥇</span>
                                @elseif($inscripcion->puesto_ganador == 2)
                                    <span class="medal silver">🥈</span>
                                @elseif($inscripcion->puesto_ganador == 3)
                                    <span class="medal bronze">🥉</span>
                                @else
                                    <div class="team-avatar"><i class="fas fa-users"></i></div>
                                @endif
                            </div>
                            <div class="person-info">
                                <span class="person-name {{ $inscripcion->puesto_ganador ? 'winner' : '' }}">
                                    {{ $inscripcion->equipo->nombre }}
                                </span>
                                <span class="person-detail">{{ $inscripcion->miembros->count() }} miembros</span>
                            </div>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    @empty
                        <div class="empty-list">
                            <i class="fas fa-users-slash"></i>
                            <p>Sin equipos inscritos</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Proyecto del Evento --}}
        @if($evento->tipo_proyecto && $evento->tipo_proyecto === 'general' && $evento->proyectoGeneral && $evento->proyectoGeneral->publicado)
        <div class="content-card project-card">
            <div class="card-header neuro-card">
                <i class="fas fa-project-diagram"></i>
                <h3>Proyecto del Evento</h3>
                <span class="published-badge"><i class="fas fa-check-circle"></i> Publicado</span>
            </div>
            <div class="card-body">
                <h4 class="project-title">{{ $evento->proyectoGeneral->titulo }}</h4>
                @if($evento->proyectoGeneral->descripcion_completa)
                    <p class="project-desc">{{ Str::limit($evento->proyectoGeneral->descripcion_completa, 300) }}</p>
                @endif
                @if($evento->proyectoGeneral->objetivo)
                    <div class="project-objective">
                        <strong><i class="fas fa-bullseye"></i> Objetivo:</strong>
                        <p>{{ $evento->proyectoGeneral->objetivo }}</p>
                    </div>
                @endif
                <div class="project-files">
                    @if($evento->proyectoGeneral->archivo_bases)
                        <a href="{{ Storage::url($evento->proyectoGeneral->archivo_bases) }}" target="_blank" class="file-btn bases">
                            <i class="fas fa-file-pdf"></i> Descargar Bases
                        </a>
                    @endif
                    @if($evento->proyectoGeneral->archivo_recursos)
                        <a href="{{ Storage::url($evento->proyectoGeneral->archivo_recursos) }}" target="_blank" class="file-btn recursos">
                            <i class="fas fa-folder-open"></i> Recursos
                        </a>
                    @endif
                    @if($evento->proyectoGeneral->url_externa)
                        <a href="{{ $evento->proyectoGeneral->url_externa }}" target="_blank" class="file-btn external">
                            <i class="fas fa-external-link-alt"></i> Link Externo
                        </a>
                    @endif
                </div>
            </div>
        </div>
        @elseif($evento->tipo_proyecto === 'individual')
        <div class="content-card">
            <div class="card-header neuro-card">
                <i class="fas fa-project-diagram"></i>
                <h3>Proyectos Individuales</h3>
            </div>
            <div class="card-body">
                <p class="info-text">Este evento usa <strong>proyectos individuales</strong>. Cada equipo puede tener un proyecto diferente.</p>
                <a href="{{ route('admin.proyectos-evento.asignar', $evento) }}" class="inline-link">
                    Ver estado de asignaciones <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
        @endif

        {{-- Criterios de Evaluación --}}
        @if($evento->criteriosEvaluacion->isNotEmpty())
        <div class="content-card">
            <div class="card-header neuro-card">
                <i class="fas fa-clipboard-list"></i>
                <h3>Criterios de Evaluación</h3>
                @php $totalPonderacion = $evento->criteriosEvaluacion->sum('ponderacion'); @endphp
                <span class="count-badge {{ $totalPonderacion == 100 ? 'success' : 'warning' }}">
                    {{ $totalPonderacion }}%
                </span>
            </div>
            <div class="card-body">
                <div class="criteria-grid">
                    @foreach($evento->criteriosEvaluacion as $criterio)
                        <div class="criteria-item neuro-card">
                            <div class="criteria-weight">{{ $criterio->ponderacion }}%</div>
                            <div class="criteria-info">
                                <span class="criteria-name">{{ $criterio->nombre }}</span>
                                @if($criterio->descripcion)
                                    <span class="criteria-desc">{{ Str::limit($criterio->descripcion, 60) }}</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        {{-- Modal Tipo de Proyecto --}}
        <div id="modalTipoProyecto" class="hidden fixed inset-0 modal-overlay z-50">
            <div class="modal-container">
                <div class="modal-content">
                    <h3><i class="fas fa-project-diagram"></i> Configurar Tipo de Proyecto</h3>
                    <form action="{{ route('admin.eventos.configurar-proyectos', $evento) }}" method="POST">
                        @csrf
                        <div class="modal-options">
                            <label class="option-card">
                                <input type="radio" name="tipo_proyecto" value="general" required>
                                <div class="option-content">
                                    <i class="fas fa-globe"></i>
                                    <strong>Proyecto General</strong>
                                    <p>Un solo proyecto para todos los equipos</p>
                                </div>
                            </label>
                            <label class="option-card">
                                <input type="radio" name="tipo_proyecto" value="individual">
                                <div class="option-content">
                                    <i class="fas fa-user-edit"></i>
                                    <strong>Proyectos Individuales</strong>
                                    <p>Proyectos diferentes por equipo</p>
                                </div>
                            </label>
                        </div>
                        <div class="modal-actions">
                            <button type="button" onclick="document.getElementById('modalTipoProyecto').classList.add('hidden')" class="modal-btn cancel">
                                Cancelar
                            </button>
                            <button type="submit" class="modal-btn confirm">
                                Confirmar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para forzar finalización del evento -->
<div id="modalForzarFinalizar" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="p-6">
                <div class="text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 mb-4">
                        <i class="fas fa-exclamation-triangle text-yellow-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">
                        ¿Está seguro de forzar la finalización?
                    </h3>
                    <p class="text-sm text-gray-600 mb-4">
                        El evento aún tiene evaluaciones pendientes. Al forzar la finalización, se cerrará el evento sin esperar a que todos los jurados completen sus evaluaciones.
                    </p>
                    <div class="bg-yellow-50 border border-yellow-200 rounded-md p-3 mb-4">
                        <p class="text-sm text-yellow-800">
                            <strong>Advertencia:</strong> Esta acción no se puede deshacer. Los equipos sin evaluaciones completas no tendrán calificaciones finales.
                        </p>
                    </div>
                </div>
                <form action="{{ route('admin.eventos.finalizar-forzado', $evento) }}" method="POST">
                    @csrf @method('PATCH')
                    <div class="modal-actions">
                        <button type="button" onclick="document.getElementById('modalForzarFinalizar').classList.add('hidden')" class="modal-btn cancel">
                            Cancelar
                        </button>
                        <button type="submit" class="modal-btn confirm" style="background-color: #f59e0b;">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            Forzar Finalización
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



@endsection