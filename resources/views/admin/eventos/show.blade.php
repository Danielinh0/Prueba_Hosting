@extends('layouts.app')

@section('content')


<div class="evento-detail-page py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('admin.eventos.index') }}" class="back-link">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver al Eventos
        </a>
        <div class="flex items-center mb-6">
            <h2 class="font-semibold text-xl ml-2">
                Detalle del Evento
            </h2>
        </div>
        
        <div class="main-card">
            @if ($evento->ruta_imagen)
                <img src="{{ asset('storage/' . $evento->ruta_imagen) }}" alt="Imagen del evento: {{ $evento->nombre }}">
            @endif
            
            <div class="p-6 sm:p-8">
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="font-bold text-3xl">{{ $evento->nombre }}</h1>
                        <p class="text-sm mt-1">
                            Del {{ $evento->fecha_inicio->format('d/m/Y') }} al {{ $evento->fecha_fin->format('d/m/Y') }}
                        </p>
                    </div>
                    <span class="status-badge 
                        @if ($evento->estado == 'Activo') status-activo
                        @elseif ($evento->estado == 'En Progreso') status-activo
                        @elseif ($evento->estado == 'Próximo') status-proximo
                        @elseif ($evento->estado == 'Cerrado') status-cerrado
                        @else status-finalizado @endif">
                        {{ $evento->estado }}
                    </span>
                </div>

                <div class="section-divider">
                    <h3 class="text-lg font-medium">Descripción del Evento</h3>
                    <p class="mt-2">
                        {{ $evento->descripcion ?: 'No hay descripción disponible.' }}
                    </p>
                </div>

                <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Columna de Jurados -->
                    <div>
                        <h3 class="text-lg font-medium">
                            Jurados Asignados ({{ $evento->jurados->count() }})
                        </h3>
                        <div class="list-box">
                            <ul class="space-y-3">
                                @forelse($evento->jurados as $jurado)
                                    <li class="flex items-center space-x-3">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        <a href="{{ route('admin.users.edit', $jurado->user) }}">
                                            {{ $jurado->user->nombre }} {{ $jurado->user->app_paterno }}
                                        </a>
                                    </li>
                                @empty
                                    <li style="color: #6b6b6b; font-size: 0.875rem;">No hay jurados asignados a este evento.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>

                    <!-- Columna de Equipos -->
                    <div>
                        <h3 class="text-lg font-medium">
                            Equipos Inscritos ({{ $evento->inscripciones->count() }} / {{ $evento->cupo_max_equipos }})
                        </h3>
                        <div class="list-box">
                            <ul class="space-y-3">
                                @forelse($evento->inscripciones as $inscripcion)
                                    <li class="flex items-center space-x-3">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        <a href="{{ route('admin.equipos.show', $inscripcion->equipo) }}">
                                            <span class="{{ $inscripcion->puesto_ganador ? 'font-bold' : '' }}">
                                                @if($inscripcion->puesto_ganador == 1) 🥇 @endif
                                                @if($inscripcion->puesto_ganador == 2) 🥈 @endif
                                                @if($inscripcion->puesto_ganador == 3) 🥉 @endif
                                                {{ $inscripcion->equipo->nombre }}
                                            </span>
                                        </a>
                                    </li>
                                @empty
                                    <li style="color: #6b6b6b; font-size: 0.875rem;">No hay equipos inscritos en este evento.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>

  {{-- Proyecto del Evento (si está publicado) --}}
                @if($evento->tipo_proyecto && ($evento->tipo_proyecto === 'general' && $evento->proyectoGeneral && $evento->proyectoGeneral->publicado))
                    <div class="section-divider">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-lg font-medium">📋 Proyecto del Evento</h3>
                            <span class="project-published-badge">
                                ✓ Publicado
                            </span>
                        </div>
                        <div class="project-box">
                            <h4 class="mb-3">{{ $evento->proyectoGeneral->titulo }}</h4>
                            
                            @if($evento->proyectoGeneral->descripcion_completa)
                                <div class="mb-4">
                                    <h5>Descripción:</h5>
                                    <p style="white-space: pre-line;">{{ Str::limit($evento->proyectoGeneral->descripcion_completa, 300) }}</p>
                                </div>
                            @endif

                            @if($evento->proyectoGeneral->objetivo)
                                <div class="mb-4">
                                    <h5>🎯 Objetivo:</h5>
                                    <p>{{ $evento->proyectoGeneral->objetivo }}</p>
                                </div>
                            @endif

                            <div class="mt-4 flex flex-wrap gap-3">
                                @if($evento->proyectoGeneral->archivo_bases)
                                    <a href="{{ Storage::url($evento->proyectoGeneral->archivo_bases) }}" 
                                       target="_blank"
                                       class="download-button download-indigo inline-flex items-center">
                                        📄 Descargar Bases
                                    </a>
                                @endif
                                @if($evento->proyectoGeneral->archivo_recursos)
                                    <a href="{{ Storage::url($evento->proyectoGeneral->archivo_recursos) }}" 
                                       target="_blank"
                                       class="download-button download-purple inline-flex items-center">
                                        📦 Descargar Recursos
                                    </a>
                                @endif
                                @if($evento->proyectoGeneral->url_externa)
                                    <a href="{{ $evento->proyectoGeneral->url_externa }}" 
                                       target="_blank"
                                       class="download-button download-blue inline-flex items-center">
                                        🔗 Recursos Externos
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @elseif($evento->tipo_proyecto === 'individual')
                    <div class="section-divider">
                        <h3 class="text-lg font-medium">📝 Proyectos Individuales</h3>
                        <div class="info-box-individual mt-4">
                            <p>
                                Este evento usa <strong>proyectos individuales</strong>. Cada equipo puede tener un proyecto diferente.
                            </p>
                            <a href="{{ route('admin.proyectos-evento.asignar', $evento) }}" 
                               class="inline-block mt-3">
                                Ver estado de asignaciones →
                            </a>
                        </div>
                    </div>
                @endif

                <!-- Acciones de Administrador -->
                <div class="section-divider">
                    <h3 class="text-lg font-medium">Acciones de Administrador</h3>
                    <div class="mt-4 flex flex-wrap gap-3">
                        <a href="{{ route('admin.eventos.asignar', $evento) }}" class="action-button btn-indigo">
                            Gestionar Jurados
                        </a>

                        @if($evento->estado === 'Próximo')
                            <form action="{{ route('admin.eventos.activar', $evento) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres activar este evento? Los usuarios podrán inscribirse.');">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="action-button btn-green">
                                    Activar Evento
                                </button>
                            </form>
                        @elseif($evento->estado === 'Activo')
                            <form action="{{ route('admin.eventos.cerrar', $evento) }}" method="POST" onsubmit="return confirm('¿Cerrar inscripciones? Los equipos no podrán unirse.');">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="action-button btn-yellow">
                                    🔒 Cerrar Inscripciones
                                </button>
                            </form>
                            <form action="{{ route('admin.eventos.finalizar', $evento) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres finalizar este evento?');">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="action-button btn-blue">
                                    Finalizar Evento
                                </button>
                            </form>
                            <form action="{{ route('admin.eventos.desactivar', $evento) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres mover este evento a Próximos? Se cerrarán las inscripciones.');">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="action-button btn-gray">
                                    Mover a Próximos
                                </button>
                            </form>
                        @elseif($evento->estado === 'En Progreso')
                            {{-- Estado En Progreso: Evento activo con proyectos publicados --}}
                            <form action="{{ route('admin.eventos.finalizar', $evento) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres finalizar este evento? Asegúrate de que los jurados hayan completado las evaluaciones.');">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="action-button btn-blue">
                                    🏁 Finalizar Evento
                                </button>
                            </form>
                            <form action="{{ route('admin.eventos.cerrar', $evento) }}" method="POST" onsubmit="return confirm('¿Cerrar el evento? Los equipos ya no podrán subir avances.');">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="action-button btn-yellow">
                                    🔒 Cerrar Evento
                                </button>
                            </form>
                            @if($evento->tipo_proyecto === 'general' && $evento->proyectoGeneral)
                                <a href="{{ route('admin.proyectos-evento.edit', $evento->proyectoGeneral) }}" 
                                   class="action-button btn-purple">
                                    ✏️ Editar Proyecto
                                </a>
                            @elseif($evento->tipo_proyecto === 'individual')
                                <a href="{{ route('admin.proyectos-evento.asignar', $evento) }}" 
                                   class="action-button btn-purple">
                                    📝 Ver Proyectos
                                </a>
                            @endif
                        @elseif($evento->estado === 'Cerrado')
                            <!-- Configuración de Proyectos del Evento -->
                            @if(!$evento->tipo_proyecto)
                                <button onclick="document.getElementById('modalTipoProyecto').classList.remove('hidden')" 
                                        class="action-button btn-purple">
                                    📋 Configurar Tipo de Proyecto
                                </button>
                            @else
                                @if($evento->tipo_proyecto === 'general')
                                    @if($evento->proyectoGeneral)
                                        <a href="{{ route('admin.proyectos-evento.edit', $evento->proyectoGeneral) }}" 
                                           class="action-button btn-blue">
                                            ✏️ Editar Proyecto General
                                        </a>
                                        @if($evento->proyectoGeneral->publicado)
                                            <form action="{{ route('admin.proyectos-evento.despublicar', $evento->proyectoGeneral) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="action-button btn-gray">
                                                    👁️‍🗨️ Despublicar
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.proyectos-evento.publicar', $evento->proyectoGeneral) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="action-button btn-green">
                                                    🚀 Publicar Proyecto
                                                </button>
                                            </form>
                                        @endif
                                    @else
                                        <a href="{{ route('admin.proyectos-evento.create', $evento) }}" 
                                           class="action-button btn-green">
                                            ➕ Crear Proyecto General
                                        </a>
                                    @endif
                                @else
                                    <a href="{{ route('admin.proyectos-evento.asignar', $evento) }}" 
                                       class="action-button btn-green">
                                        📝 Asignar Proyectos Individuales
                                    </a>
                                @endif

                                {{-- Botón para cambiar tipo de proyecto --}}
                                @if($evento->tipo_proyecto === 'general')
                                    <button onclick="document.getElementById('modalTipoProyecto').classList.remove('hidden')" 
                                            class="action-button btn-gray">
                                        🔄 Cambiar a Individual
                                    </button>
                                @endif
                            @endif

                            <form action="{{ route('admin.eventos.reactivar', $evento) }}" method="POST" onsubmit="return confirm('¿Reabrir inscripciones?');">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="action-button btn-orange">
                                    🔓 Reabrir Inscripciones
                                </button>
                            </form>

                            <form action="{{ route('admin.eventos.finalizar', $evento) }}" method="POST" onsubmit="return confirm('¿Finalizar evento?');">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="action-button btn-blue">
                                    Finalizar Evento
                                </button>
                            </form>
                        @elseif($evento->estado === 'Finalizado')
                            <a href="{{ route('admin.eventos.resultados', $evento) }}" 
                               class="action-button btn-indigo">
                                🏆 Ver Resultados
                            </a>
                            <form action="{{ route('admin.eventos.reactivar', $evento) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres reactivar este evento?');">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="action-button btn-red">
                                    Reactivar Evento
                                </button>
                            </form>
                        @endif

                        <a href="{{ route('admin.eventos.edit', $evento) }}" class="action-button btn-gray">
                            Editar Evento
                        </a>
                    </div>
                </div>

                <!-- Modal Tipo de Proyecto -->
                <div id="modalTipoProyecto" class="hidden fixed inset-0 modal-overlay overflow-y-auto h-full w-full z-50">
                    <div class="relative top-20 mx-auto p-5 w-96 modal-content">
                        <h3 class="text-lg mb-4">
                            {{ $evento->tipo_proyecto ? 'Cambiar Tipo de Proyecto' : 'Configurar Tipo de Proyecto' }}
                        </h3>
                        
                        @if($evento->tipo_proyecto === 'general')
                            <div class="alert-warning">
                                <p>
                                    ⚠️ <strong>Nota:</strong> Cambiar a proyectos individuales mantendrá el proyecto general creado, pero ya no será visible para los equipos.
                                </p>
                            </div>
                        @elseif($evento->tipo_proyecto === 'individual')
                            <div class="alert-danger">
                                <p>
                                    🚫 <strong>No se puede cambiar:</strong> Ya tienes proyectos individuales asignados. Cambiar a proyecto general eliminaría los archivos de cada equipo.
                                </p>
                            </div>
                        @else
                            <p class="mb-4">Elige cómo se asignarán los proyectos a los equipos:</p>
                        @endif
                        
                        <form action="{{ route('admin.eventos.configurar-proyectos', $evento) }}" method="POST">
                            @csrf
                            <div class="space-y-3">
                                <label class="radio-option {{ $evento->tipo_proyecto === 'general' ? 'radio-option-selected' : '' }}">
                                    <input type="radio" name="tipo_proyecto" value="general" 
                                           {{ $evento->tipo_proyecto === 'general' ? 'checked' : '' }}
                                           {{ $evento->tipo_proyecto === 'individual' ? 'disabled' : 'required' }}>
                                    <div class="ml-3">
                                        <div class="font-semibold" style="color: #2c2c2c;">📋 Proyecto General</div>
                                        <div class="text-sm" style="color: #6b6b6b;">Un solo proyecto para todos los equipos</div>
                                        @if($evento->tipo_proyecto === 'general')
                                            <div class="text-xs mt-1" style="color: #6366f1;">✓ Tipo actual</div>
                                        @elseif($evento->tipo_proyecto === 'individual')
                                            <div class="text-xs mt-1" style="color: #ef4444;">⚠️ No disponible</div>
                                        @endif
                                    </div>
                                </label>
                                <label class="radio-option {{ $evento->tipo_proyecto === 'individual' ? 'radio-option-selected' : '' }}">
                                    <input type="radio" name="tipo_proyecto" value="individual" 
                                           {{ $evento->tipo_proyecto === 'individual' ? 'checked' : '' }}
                                           {{ !$evento->tipo_proyecto || $evento->tipo_proyecto === 'general' ? 'required' : '' }}>
                                    <div class="ml-3">
                                        <div class="font-semibold" style="color: #2c2c2c;">📝 Proyectos Individuales</div>
                                        <div class="text-sm" style="color: #6b6b6b;">Proyectos diferentes por equipo</div>
                                        @if($evento->tipo_proyecto === 'individual')
                                            <div class="text-xs mt-1" style="color: #a855f7;">✓ Tipo actual</div>
                                        @endif
                                    </div>
                                </label>
                            </div>
                            <div class="mt-6 flex justify-end space-x-3">
                                <button type="button" onclick="document.getElementById('modalTipoProyecto').classList.add('hidden')" 
                                        class="action-button" style="background: rgba(255, 255, 255, 0.5); color: #2c2c2c; box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;">
                                    Cancelar
                                </button>
                                @if($evento->tipo_proyecto !== 'individual')
                                    <button type="submit" class="action-button btn-indigo">
                                        {{ $evento->tipo_proyecto ? 'Cambiar Tipo' : 'Confirmar' }}
                                    </button>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>


                {{-- Criterios de Evaluación --}}
                <div class="section-divider">
                    <h3 class="text-lg font-medium" style="display: flex; align-items: center; gap: 0.5rem;">
                        <svg class="w-5 h-5" style="color: #e89a3c;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                        Criterios de Evaluación ({{ $evento->criteriosEvaluacion->count() }})
                    </h3>
                    
                    @if($evento->criteriosEvaluacion->isNotEmpty())
                        <div class="mt-3">
                            {{-- Barra de progreso compacta --}}
                            @php $totalPonderacion = $evento->criteriosEvaluacion->sum('ponderacion'); @endphp
                            <div class="ponderacion-bar">
                                <span class="ponderacion-label">Ponderación Total:</span>
                                <div class="ponderacion-track">
                                    <div class="ponderacion-fill {{ $totalPonderacion == 100 ? 'complete' : 'incomplete' }}" style="width: {{ min($totalPonderacion, 100) }}%;"></div>
                                </div>
                                <span class="ponderacion-value {{ $totalPonderacion == 100 ? 'complete' : 'incomplete' }}">
                                    {{ $totalPonderacion }}%
                                    @if($totalPonderacion == 100)✓@else⚠@endif
                                </span>
                            </div>

                            {{-- Grid de criterios compacto --}}
                            <div class="criterios-grid">
                                @foreach($evento->criteriosEvaluacion as $criterio)
                                    <div class="criterio-card">
                                        <div class="criterio-info">
                                            <p class="criterio-nombre" title="{{ $criterio->nombre }}">{{ $criterio->nombre }}</p>
                                            @if($criterio->descripcion)
                                                <p class="criterio-desc" title="{{ $criterio->descripcion }}">{{ $criterio->descripcion }}</p>
                                            @endif
                                        </div>
                                        <span class="criterio-peso">{{ $criterio->ponderacion }}%</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div style="margin-top: 1rem; padding: 1.5rem; background: rgba(255, 255, 255, 0.5); border-radius: 12px; text-align: center;">
                            <svg class="mx-auto w-12 h-12" style="color: #d1d5db;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <p style="color: #9ca3af; margin-top: 0.75rem; font-size: 0.875rem;">
                                No se han definido criterios de evaluación para este evento.
                            </p>
                            <a href="{{ route('admin.eventos.edit', $evento) }}" style="display: inline-block; margin-top: 1rem; padding: 0.5rem 1rem; background: linear-gradient(135deg, #2c2c2c, #1a1a1a); color: white; border-radius: 8px; font-size: 0.875rem; font-weight: 500; text-decoration: none;">
                                + Agregar Criterios
                            </a>
                        </div>
                    @endif
                </div>

              
            </div>
        </div>
    </div>
</div>
@endsection