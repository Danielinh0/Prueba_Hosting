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
    
    /* Main card */
    .main-card {
        background: #FFEEE2;
        border-radius: 20px;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
        overflow: hidden;
    }
    
    .main-card img {
        height: 16rem;
        width: 100%;
        object-fit: cover;
    }
    
    /* Status badge */
    .status-badge {
        font-family: 'Poppins', sans-serif;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .status-activo {
        background: linear-gradient(135deg, #2c2c2c, #1a1a1a);
        color: #ffffff;
    }
    
    .status-proximo {
        background: rgba(191, 219, 254, 0.8);
        color: #1e40af;
    }
    
    .status-cerrado {
        background: rgba(254, 240, 138, 0.8);
        color: #854d0e;
    }
    
    .status-finalizado {
        background: rgba(254, 202, 202, 0.8);
        color: #991b1b;
    }
    
    /* Section divider */
    .section-divider {
        border-top: 1px solid rgba(232, 154, 60, 0.2);
        margin-top: 1.5rem;
        padding-top: 1.5rem;
    }
    
    /* List boxes */
    .list-box {
        background: rgba(255, 255, 255, 0.3);
        border-radius: 15px;
        padding: 1rem;
        margin-top: 1rem;
        box-shadow: inset 2px 2px 4px #e6d5c9, inset -2px -2px 4px #ffffff;
    }
    
    .list-box ul li {
        margin-bottom: 0.75rem;
    }
    
    .list-box ul li:last-child {
        margin-bottom: 0;
    }
    
    .list-box a {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
        transition: all 0.2s ease;
    }
    
    .list-box a:hover {
        color: #e89a3c;
    }
    
    /* Project box */
    .project-box {
        background: linear-gradient(135deg, rgba(224, 231, 255, 0.5), rgba(237, 233, 254, 0.5));
        border: 1px solid rgba(99, 102, 241, 0.2);
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        backdrop-filter: blur(10px);
    }
    
    .project-box h4 {
        color: #312e81;
        font-size: 1.25rem;
        font-weight: 700;
    }
    
    .project-box h5 {
        color: #4338ca;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    
    .project-box p {
        color: #4f46e5;
    }
    
    .project-published-badge {
        background: rgba(209, 250, 229, 0.8);
        color: #065f46;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
        box-shadow: 2px 2px 4px rgba(16, 185, 129, 0.1);
    }
    
    /* Download buttons */
    .download-button {
        font-family: 'Poppins', sans-serif;
        background: rgba(255, 255, 255, 0.9);
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        border: 1px solid;
    }
    
    .download-button:hover {
        box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.15);
        transform: translateY(-2px);
    }
    
    .download-indigo {
        border-color: rgba(99, 102, 241, 0.3);
        color: #4f46e5;
    }
    
    .download-purple {
        border-color: rgba(168, 85, 247, 0.3);
        color: #7c3aed;
    }
    
    .download-blue {
        border-color: rgba(59, 130, 246, 0.3);
        color: #2563eb;
    }
    
    /* Info box individual */
    .info-box-individual {
        background: linear-gradient(135deg, rgba(237, 233, 254, 0.5), rgba(250, 245, 255, 0.5));
        border: 1px solid rgba(168, 85, 247, 0.2);
        border-radius: 15px;
        padding: 1rem;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        backdrop-filter: blur(10px);
    }
    
    .info-box-individual p {
        font-family: 'Poppins', sans-serif;
        color: #6b21a8;
        font-size: 0.875rem;
    }
    
    .info-box-individual a {
        color: #7c3aed;
        font-weight: 600;
        transition: all 0.2s ease;
    }
    
    .info-box-individual a:hover {
        color: #6d28d9;
    }
    
    /* Action buttons */
    .action-button {
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        transition: all 0.3s ease;
        box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.15);
        border: none;
    }
    
    .action-button:hover {
        box-shadow: 6px 6px 12px rgba(0, 0, 0, 0.2);
        transform: translateY(-2px);
    }
    
    .btn-indigo {
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: #ffffff;
    }
    
    .btn-green {
        background: linear-gradient(135deg, #10b981, #059669);
        color: #ffffff;
    }
    
    .btn-yellow {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: #ffffff;
    }
    
    .btn-blue {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: #ffffff;
    }
    
    .btn-gray {
        background: linear-gradient(135deg, #6b7280, #4b5563);
        color: #ffffff;
    }
    
    .btn-purple {
        background: linear-gradient(135deg, #a855f7, #9333ea);
        color: #ffffff;
    }
    
    .btn-orange {
        background: linear-gradient(135deg, #f97316, #ea580c);
        color: #ffffff;
    }
    
    .btn-red {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: #ffffff;
    }
    
    /* Modal */
    .modal-overlay {
        background: rgba(107, 107, 107, 0.5);
        backdrop-filter: blur(5px);
    }
    
    .modal-content {
        background: #FFEEE2;
        border-radius: 20px;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
        padding: 1.25rem;
    }
    
    .modal-content h3 {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
        font-weight: 700;
    }
    
    .modal-content p {
        font-family: 'Poppins', sans-serif;
        color: #6b6b6b;
        font-size: 0.875rem;
    }
    
    /* Radio option */
    .radio-option {
        background: rgba(255, 255, 255, 0.5);
        border: 2px solid rgba(232, 154, 60, 0.2);
        border-radius: 15px;
        padding: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
    }
    
    .radio-option:hover {
        border-color: #e89a3c;
    }
    
    .radio-option-selected {
        border-color: #e89a3c;
        background: rgba(232, 154, 60, 0.1);
    }
    
    .radio-option input[type="radio"]:disabled + div {
        opacity: 0.5;
        cursor: not-allowed;
    }
    
    /* Alert boxes */
    .alert-warning {
        background: rgba(254, 240, 138, 0.5);
        border: 1px solid #f59e0b;
        border-radius: 15px;
        padding: 0.75rem;
        margin-bottom: 1rem;
    }
    
    .alert-warning p {
        color: #92400e;
        font-size: 0.875rem;
    }
    
    .alert-danger {
        background: rgba(254, 202, 202, 0.5);
        border: 1px solid #ef4444;
        border-radius: 15px;
        padding: 0.75rem;
        margin-bottom: 1rem;
    }
    
    .alert-danger p {
        color: #991b1b;
        font-size: 0.875rem;
    }
</style>

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

                {{-- Criterios de Evaluación --}}
                <div class="section-divider">
                    <h3 class="text-lg font-medium" style="display: flex; align-items: center; gap: 0.5rem;">
                        <svg class="w-5 h-5" style="color: #e89a3c;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                        Criterios de Evaluación ({{ $evento->criteriosEvaluacion->count() }})
                    </h3>
                    
                    @if($evento->criteriosEvaluacion->isNotEmpty())
                        <div class="mt-4">
                            {{-- Barra de progreso de ponderación total --}}
                            @php $totalPonderacion = $evento->criteriosEvaluacion->sum('ponderacion'); @endphp
                            <div style="margin-bottom: 1.5rem; padding: 1rem; background: rgba(255, 255, 255, 0.5); border-radius: 12px;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                    <span style="font-size: 0.875rem; color: #6b6b6b;">Ponderación Total:</span>
                                    <span style="font-weight: 700; color: {{ $totalPonderacion == 100 ? '#10b981' : '#ef4444' }};">
                                        {{ $totalPonderacion }}%
                                        @if($totalPonderacion == 100)
                                            <svg class="inline w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                        @else
                                            <svg class="inline w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                        @endif
                                    </span>
                                </div>
                                <div style="width: 100%; height: 8px; background: #e5e7eb; border-radius: 4px; overflow: hidden;">
                                    <div style="width: {{ min($totalPonderacion, 100) }}%; height: 100%; background: {{ $totalPonderacion == 100 ? 'linear-gradient(90deg, #10b981, #34d399)' : 'linear-gradient(90deg, #f59e0b, #fbbf24)' }}; border-radius: 4px; transition: width 0.3s ease;"></div>
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
                                            <span style="padding: 0.25rem 0.75rem; background: linear-gradient(135deg, #2c2c2c, #1a1a1a); color: white; border-radius: 20px; font-size: 0.75rem; font-weight: 700;">
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
                                           class="mt-1" 
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
                                           class="mt-1" 
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

            </div>
        </div>
    </div>
</div>
@endsection