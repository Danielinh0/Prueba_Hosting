@extends('layouts.app')

@section('content')

<div class="evento-detail-page py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('estudiante.eventos.index') }}" class="back-link">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver Eventos
        </a>
        <div class="flex items-center mb-6">
            <h2 class="font-semibold text-xl ml-2">
                Detalle del Evento
            </h2>
        </div>
        
        <div class="neuro-card-main">
            @if ($evento->ruta_imagen)
                <img class="h-64 w-full object-cover" src="{{ asset('storage/' . $evento->ruta_imagen) }}" alt="Imagen del evento: {{ $evento->nombre }}">
            @endif
            
            <div class="p-6 sm:p-8">
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="font-bold text-3xl">{{ $evento->nombre }}</h1>
                        <p class="text-sm mt-1">
                            Del {{ $evento->fecha_inicio->format('d/m/Y') }} al {{ $evento->fecha_fin->format('d/m/Y') }}
                        </p>
                    </div>
                    <div class="flex items-center gap-3">
                        @if($evento->estado == 'Finalizado' && $evento->inscripciones()->whereNotNull('puesto_ganador')->exists())
                            <a href="{{ route('estudiante.eventos.posiciones', $evento) }}" class="btn-positions">
                                <i class="fas fa-trophy"></i>
                                Ver Posiciones
                            </a>
                        @endif
                        <span class="status-badge
                            @if ($evento->estado == 'Activo') status-activo
                            @elseif ($evento->estado == 'En Progreso') status-en-progreso
                            @elseif ($evento->estado == 'Próximo') status-proximo
                            @else status-finalizado @endif">
                            {{ $evento->estado }}
                        </span>
                    </div>
                </div>

                <div class="section-divider">
                    <h3 class="text-lg font-medium">Descripción del Evento</h3>
                    <p class="mt-2">
                        {{ $evento->descripcion ?: 'No hay descripción disponible.' }}
                    </p>
                </div>

                {{-- Sección de Jurados --}}
                @if($evento->jurados->isNotEmpty())
                    <div class="section-divider">
                        <h3 class="text-lg font-medium">
                            <i class="fas fa-gavel" style="color: #e89a3c; margin-right: 0.5rem;"></i>
                            Jurados del Evento ({{ $evento->jurados->count() }})
                        </h3>
                        <div style="display: flex; flex-wrap: wrap; gap: 1rem; margin-top: 1rem;">
                            @foreach($evento->jurados as $jurado)
                                <div style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem; background: rgba(255, 255, 255, 0.7); border-radius: 12px; box-shadow: 2px 2px 6px rgba(0,0,0,0.05);">
                                    <div style="width: 45px; height: 45px; border-radius: 50%; background: linear-gradient(135deg, #e89a3c, #f5b76c); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 1rem; box-shadow: 0 2px 8px rgba(232, 154, 60, 0.3);">
                                        {{ strtoupper(substr($jurado->user->nombre ?? 'J', 0, 1)) }}{{ strtoupper(substr($jurado->user->app_paterno ?? '', 0, 1)) }}
                                    </div>
                                    <div>
                                        <p style="font-weight: 600; color: #2c2c2c; margin: 0; font-size: 0.9rem;">
                                            {{ $jurado->user->nombre ?? 'Jurado' }} {{ $jurado->user->app_paterno ?? '' }}
                                        </p>
                                        @if($jurado->especialidad)
                                            <p style="font-size: 0.75rem; color: #9ca3af; margin: 0;">
                                                {{ $jurado->especialidad }}
                                            </p>
                                        @endif
                                        @if($jurado->empresa_institucion)
                                            <p style="font-size: 0.7rem; color: #6b6b6b; margin: 0;">
                                                <i class="fas fa-building" style="margin-right: 0.25rem;"></i>{{ $jurado->empresa_institucion }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Criterios de Evaluación --}}
                @if($evento->criteriosEvaluacion->isNotEmpty())
                    <div class="section-divider">
                        <h3 class="text-lg font-medium" style="display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fas fa-clipboard-check" style="color: #e89a3c;"></i>
                            Criterios de Evaluación ({{ $evento->criteriosEvaluacion->count() }})
                        </h3>
                        
                        <div class="mt-3">
                            {{-- Barra de progreso compacta --}}
                            @php $totalPonderacion = $evento->criteriosEvaluacion->sum('ponderacion'); @endphp
                            <div class="ponderacion-bar">
                                <span class="ponderacion-label">Ponderación Total:</span>
                                <div class="ponderacion-track">
                                    <div class="ponderacion-fill {{ $totalPonderacion == 100 ? 'complete' : 'incomplete' }}" style="width: {{ min($totalPonderacion, 100) }}%;"></div>
                                </div>
                                <span class="ponderacion-value {{ $totalPonderacion == 100 ? 'complete' : 'incomplete' }}">
                                    {{ $totalPonderacion }}% @if($totalPonderacion == 100)✓@endif
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
                    </div>
                @endif

                {{-- Proyecto del Evento (si está publicado y es general) --}}
                @if($evento->tipo_proyecto === 'general' && $evento->proyectoGeneral && $evento->proyectoGeneral->publicado)
                    <div class="section-divider">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-lg font-medium">📋 Proyecto del Evento</h3>
                            <span class="publicado-badge">
                                ✓ Publicado
                            </span>
                        </div>
                        <div class="proyecto-box">
                            <h4 class="mb-3">{{ $evento->proyectoGeneral->titulo }}</h4>
                            
                            @if($evento->proyectoGeneral->descripcion_completa)
                                <div class="mb-4">
                                    <h5 class="mb-2">Descripción:</h5>
                                    <div class="whitespace-pre-line" style="color: #6b6b6b;">{{ $evento->proyectoGeneral->descripcion_completa }}</div>
                                </div>
                            @endif

                            @if($evento->proyectoGeneral->objetivo)
                                <div class="mb-4">
                                    <h5 class="mb-2">🎯 Objetivo:</h5>
                                    <p>{{ $evento->proyectoGeneral->objetivo }}</p>
                                </div>
                            @endif

                            @if($evento->proyectoGeneral->requisitos)
                                <div class="mb-4">
                                    <h5 class="mb-2">📝 Requisitos Técnicos:</h5>
                                    <div class="whitespace-pre-line" style="color: #6b6b6b;">{{ $evento->proyectoGeneral->requisitos }}</div>
                                </div>
                            @endif

                            @if($evento->proyectoGeneral->premios)
                                <div class="mb-4">
                                    <h5 class="mb-2">🏆 Premios:</h5>
                                    <p>{{ $evento->proyectoGeneral->premios }}</p>
                                </div>
                            @endif

                            <div class="mt-6 flex flex-wrap gap-3">
                                @if($evento->proyectoGeneral->archivo_bases)
                                    <a href="{{ Storage::url($evento->proyectoGeneral->archivo_bases) }}" 
                                       target="_blank" download
                                       class="download-button btn-indigo">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        Descargar Bases
                                    </a>
                                @endif
                                @if($evento->proyectoGeneral->archivo_recursos)
                                    <a href="{{ Storage::url($evento->proyectoGeneral->archivo_recursos) }}" 
                                       target="_blank" download
                                       class="download-button btn-purple">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
                                        </svg>
                                        Descargar Recursos
                                    </a>
                                @endif
                                @if($evento->proyectoGeneral->url_externa)
                                    <a href="{{ $evento->proyectoGeneral->url_externa }}" 
                                       target="_blank"
                                       class="download-button btn-blue">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                        </svg>
                                        Ver Recursos Externos
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                <div class="section-divider">
                    <h3 class="text-lg font-medium">
                        Equipos Inscritos ({{ $evento->inscripciones->count() }} / {{ $evento->cupo_max_equipos }})
                    </h3>
                    <div class="equipos-list mt-4">
                        <ul class="space-y-3">
                            @forelse($evento->inscripciones as $inscripcion)
                                <li class="equipo-item flex items-center justify-between p-2">
                                    <div class="flex items-center space-x-3">
                                        <svg class="w-6 h-6" style="color: #6b6b6b;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        <span>{{ $inscripcion->equipo->nombre }}</span>
                                    </div>
                                </li>
                            @empty
                                <li style="color: #6b6b6b; font-size: 0.875rem;">Aún no hay equipos inscritos.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <!-- Acciones de Estudiante -->
                <div class="section-divider">
                    <h3 class="text-lg font-medium">Acciones</h3>
                    <div class="mt-4 flex flex-wrap items-center gap-4">

        @if ($yaTieneEquipo)
            <div class="flex flex-wrap items-center gap-4">
                {{-- If student is in a team, show the "Ver Mi Proyecto" button only if the event is "En Progreso" --}}
                @if($evento->estado === 'En Progreso')
                    <a href="{{ route('estudiante.proyecto-evento.especifico', $evento->id_evento) }}"
                       class="action-button-primary inline-flex items-center justify-center px-6 py-3 rounded-md">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Ver Mi Proyecto
                    </a>
                @endif

                {{-- Also show a badge confirming their enrollment --}}
                <div class="inscrito-badge inline-flex items-center px-6 py-3 rounded-md">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Ya estás inscrito en este evento
                </div>
            </div>

                        @elseif ($evento->estado === 'Activo')
                            {{-- If student is NOT in a team AND event is active, show inscription buttons --}}
                            <a href="{{ route('estudiante.eventos.equipos.index', $evento) }}"
                               class="action-button-primary inline-flex items-center justify-center px-6 py-3 rounded-md">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                Ver Equipos / Crear Equipo
                            </a>
                            <a href="{{ route('estudiante.eventos.select-equipo-existente', $evento) }}"
                               class="action-button-secondary inline-flex items-center justify-center px-6 py-3 rounded-md">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                Registrar Equipo Existente
                            </a>
                        @else
                            {{-- For all other cases (not in team, event not active), show a message --}}
                            <p>Las inscripciones no están abiertas para este evento.</p>
                        @endif

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection