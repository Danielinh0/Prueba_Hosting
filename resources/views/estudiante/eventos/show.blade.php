@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
    
    /* Fondo degradado */
    .evento-detail-page {
        background: linear-gradient(to bottom, #FFFDF4, #FFEEE2);
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
    }
    
    /* Textos */
    .evento-detail-page h1,
    .evento-detail-page h2,
    .evento-detail-page h3,
    .evento-detail-page h4,
    .evento-detail-page h5 {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
    }
    
    .evento-detail-page p,
    .evento-detail-page span,
    .evento-detail-page li {
        font-family: 'Poppins', sans-serif;
        color: #6b6b6b;
    }
    
    /* Back button */
    .back-link {
        font-family: 'Poppins', sans-serif;
        display: inline-flex;
        align-items: center;
        color: black;
        font-size: 0.875rem;
        font-weight: 500;
        margin-bottom: 1rem;
        padding: 0.5rem 1rem;
        background: #FFEEE2;
        border-radius: 10px;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        transition: all 0.2s ease;
        text-decoration: none;
    }
    
    .back-link:hover {
        color: #4f46e5;
        box-shadow: 6px 6px 12px #e6d5c9, -6px -6px 12px #ffffff;
        transform: translateY(-2px);
    }
    
    .back-link svg {
        width: 1rem;
        height: 1rem;
        margin-right: 0.5rem;
    }
    
    /* Card principal neuromórfica */
    .neuro-card-main {
        background: #FFEEE2;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
        border-radius: 20px;
        overflow: hidden;
    }
    
    /* Badges de estado */
    .status-badge {
        font-family: 'Poppins', sans-serif;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
        box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.1);
    }
    
    .status-activo {
        background: linear-gradient(135deg, #00ff7f, #00cc66);
        color: #000000ff !important;
    }
    
    .status-en-progreso {
        background: linear-gradient(135deg, #4800ffff, #1b00ccff); /* Indigo gradient */
        color: #ffffff !important;
    }

    .status-proximo {
        background: rgba(191, 206, 254, 0.8);
        color: #1e40af;
    }
    
    .status-finalizado {
        background: rgba(235, 229, 229, 0.8);
        color: #374151;
    }
    
    /* Proyecto general box */
    .proyecto-box {
        background: linear-gradient(135deg, rgba(224, 231, 255, 0.5), rgba(237, 233, 254, 0.5));
        border-radius: 15px;
        padding: 1.5rem;
        border: 1px solid rgba(99, 102, 241, 0.2);
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        backdrop-filter: blur(10px);
    }
    
    .proyecto-box h4 {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
        font-weight: 700;
        font-size: 1.25rem;
    }
    
    .proyecto-box h5 {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
        font-weight: 600;
    }
    
    .publicado-badge {
        background: rgba(209, 250, 229, 0.8);
        color: #065f46;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
        box-shadow: 2px 2px 4px rgba(16, 185, 129, 0.2);
    }
    
    /* Botones de descarga */
    .download-button {
        font-family: 'Poppins', sans-serif;
        display: inline-flex;
        align-items: center;
        padding: 0.5rem 1rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.15);
    }
    
    .download-button:hover {
        transform: translateY(-2px);
        box-shadow: 6px 6px 12px rgba(0, 0, 0, 0.2);
    }
    
    .btn-indigo {
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: #ffffff;
    }
    
    .btn-purple {
        background: linear-gradient(135deg, #a855f7, #9333ea);
        color: #ffffff;
    }
    
    .btn-blue {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: #ffffff;
    }
    
    /* Lista de equipos */
    .equipos-list {
        background: rgba(255, 255, 255, 0.5);
        border-radius: 15px;
        padding: 1rem;
        box-shadow: inset 4px 4px 8px #e6d5c9, inset -4px -4px 8px #ffffff;
    }
    
    .equipo-item {
        background: rgba(255, 255, 255, 0.7);
        border-radius: 10px;
        padding: 0.5rem;
        backdrop-filter: blur(10px);
    }
    
    .equipo-item span {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
    }
    
    /* Botones de acción */
    .action-button-primary {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #2c2c2c, #1a1a1a);
        color: #ffffff;
        font-weight: 600;
        box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
        border: none;
    }
    
    .action-button-primary:hover {
        box-shadow: 6px 6px 12px rgba(0, 0, 0, 0.3);
        transform: translateY(-2px);
    }
    
    .action-button-secondary {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: #ffffff;
        font-weight: 600;
        box-shadow: 4px 4px 8px rgba(99, 102, 241, 0.3);
        transition: all 0.3s ease;
        border: none;
    }
    
    .action-button-secondary:hover {
        box-shadow: 6px 6px 12px rgba(99, 102, 241, 0.4);
        transform: translateY(-2px);
    }
    
    .inscrito-badge {
        font-family: 'Poppins', sans-serif;
        background: rgba(209, 250, 229, 0.8);
        border: 2px solid #10b981;
        color: #065f46;
        font-weight: 600;
        box-shadow: 4px 4px 8px rgba(16, 185, 129, 0.2);
    }
    
    /* Secciones */
    .section-divider {
        border-top: 1px solid rgba(107, 107, 107, 0.2);
        padding-top: 1.5rem;
        margin-top: 2rem;
    }
</style>

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
                    <span class="status-badge 
                        @if ($evento->estado == 'Activo') status-activo
                        @elseif ($evento->estado == 'En Progreso') status-en-progreso
                        @elseif ($evento->estado == 'Próximo') status-proximo
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
                        
                        <div class="mt-4">
                            {{-- Barra de progreso de ponderación total --}}
                            @php $totalPonderacion = $evento->criteriosEvaluacion->sum('ponderacion'); @endphp
                            <div style="margin-bottom: 1.5rem; padding: 1rem; background: rgba(255, 255, 255, 0.6); border-radius: 12px;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                    <span style="font-size: 0.875rem; color: #6b6b6b;">Ponderación Total:</span>
                                    <span style="font-weight: 700; color: {{ $totalPonderacion == 100 ? '#10b981' : '#f59e0b' }};">
                                        {{ $totalPonderacion }}%
                                        @if($totalPonderacion == 100)
                                            ✓
                                        @endif
                                    </span>
                                </div>
                                <div style="width: 100%; height: 8px; background: #e5e7eb; border-radius: 4px; overflow: hidden;">
                                    <div style="width: {{ min($totalPonderacion, 100) }}%; height: 100%; background: {{ $totalPonderacion == 100 ? 'linear-gradient(90deg, #10b981, #34d399)' : 'linear-gradient(90deg, #f59e0b, #fbbf24)' }}; border-radius: 4px;"></div>
                                </div>
                            </div>

                            {{-- Lista de criterios --}}
                            <div style="display: grid; gap: 1rem;">
                                @foreach($evento->criteriosEvaluacion as $criterio)
                                    <div style="padding: 1.25rem; background: #FFEEE2; border-radius: 16px; box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;">
                                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.75rem;">
                                            <h4 style="font-weight: 600; color: #2c2c2c; font-size: 1rem; margin: 0;">
                                                {{ $criterio->nombre }}
                                            </h4>
                                            <span style="padding: 0.25rem 0.75rem; background: linear-gradient(135deg, #e89a3c, #f5b76c); color: white; border-radius: 20px; font-size: 0.75rem; font-weight: 700; box-shadow: 0 2px 6px rgba(232, 154, 60, 0.3);">
                                                {{ $criterio->ponderacion }}%
                                            </span>
                                        </div>
                                        @if($criterio->descripcion)
                                            <p style="color: #6b6b6b; font-size: 0.875rem; margin: 0; line-height: 1.5;">
                                                {{ $criterio->descripcion }}
                                            </p>
                                        @endif
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
                    <a href="{{ route('estudiante.proyecto-evento.show') }}"
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