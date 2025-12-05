@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
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
    /* Fondo degradado */
    .proyecto-page {
        background: linear-gradient(to bottom, #FFFDF4, #FFEEE2);
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
    }
    
    /* Textos */
    .proyecto-page h2,
    .proyecto-page h3,
    .proyecto-page h4 {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
    }
    
    .proyecto-page p {
        font-family: 'Poppins', sans-serif;
        color: #6b6b6b;
    }
    
    .proyecto-page a {
        font-family: 'Poppins', sans-serif;
        transition: all 0.2s ease;
    }
    
    /* Cards neuromórficas */
    .neuro-card {
        background: #FFEEE2;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
        transition: all 0.3s ease;
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
    
    /* Alert success */
    .alert-success {
        background: rgba(209, 250, 229, 0.8);
        border: 1px solid #10b981;
        color: #065f46;
        border-radius: 15px;
        padding: 1rem 1.5rem;
        font-family: 'Poppins', sans-serif;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
    }
    
    /* Links normales */
    .link-accent {
        color: #e89a3c;
    }
    
    .link-accent:hover {
        color: #d98a2c;
        opacity: 0.8;
    }
    
    /* Quick access cards */
    .quick-access-card {
        background: rgba(255, 255, 255, 0.5);
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        border: 2px solid transparent;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }
    
    .quick-access-card:hover {
        box-shadow: 6px 6px 12px #e6d5c9, -6px -6px 12px #ffffff;
        transform: translateY(-5px);
    }
    
    .quick-access-card.border-indigo:hover {
        border-color: #6366f1;
    }
    
    .quick-access-card.border-green:hover {
        border-color: #10b981;
    }
    
    .quick-access-card.border-purple:hover {
        border-color: #8b5cf6;
    }
    
    .quick-access-card h4 {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
        font-weight: 600;
    }
    
    .quick-access-card p {
        font-family: 'Poppins', sans-serif;
        color: #6b6b6b;
        font-size: 0.875rem;
    }
    
    /* Warning alert */
    .warning-alert {
        background: rgba(254, 243, 199, 0.8);
        border-left: 4px solid #f59e0b;
        border-radius: 0 15px 15px 0;
        padding: 1.5rem;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        backdrop-filter: blur(10px);
    }
    
    .warning-alert h3 {
        color: #92400e;
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
    }
    
    .warning-alert p {
        color: #b45309;
        font-family: 'Poppins', sans-serif;
    }
    
    .warning-button {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #f59e0b, #f97316);
        color: #ffffff;
        font-weight: 600;
        box-shadow: 4px 4px 8px rgba(245, 158, 11, 0.3);
        transition: all 0.3s ease;
        border: none;
    }
    
    .warning-button:hover {
        box-shadow: 6px 6px 12px rgba(245, 158, 11, 0.4);
        transform: translateY(-2px);
    }

    /* Badge de evaluación */
    .eval-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 9999px;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .eval-badge.finalizada {
        background: rgba(16, 185, 129, 0.15);
        color: #059669;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }
    
    .eval-badge.finalizada:hover {
        background: rgba(16, 185, 129, 0.25);
    }
    
    .eval-badge.en-proceso {
        background: rgba(245, 158, 11, 0.15);
        color: #d97706;
        border: 1px solid rgba(245, 158, 11, 0.3);
    }
    
    .eval-badge.en-proceso:hover {
        background: rgba(245, 158, 11, 0.25);
    }
    
    .eval-badge.sin-evaluar {
        background: rgba(107, 114, 128, 0.15);
        color: #6b7280;
        border: 1px solid rgba(107, 114, 128, 0.3);
    }

    /* Modal de evaluaciones */
    .eval-modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 50;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }
    
    .eval-modal-overlay.active {
        opacity: 1;
        visibility: visible;
    }
    
    .eval-modal {
        background: #FFFDF4;
        border-radius: 1rem;
        padding: 1.5rem;
        max-width: 32rem;
        width: 90%;
        max-height: 80vh;
        overflow-y: auto;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        transform: scale(0.95);
        transition: transform 0.3s ease;
    }
    
    .eval-modal-overlay.active .eval-modal {
        transform: scale(1);
    }
    
    .eval-detail-card {
        background: rgba(255, 238, 226, 0.8);
        border-radius: 0.75rem;
        padding: 1rem;
        margin-bottom: 0.75rem;
        border: 1px solid rgba(232, 154, 60, 0.2);
    }
    
    .eval-detail-card:last-child {
        margin-bottom: 0;
    }
    
    .eval-score-big {
        font-size: 2rem;
        font-weight: 700;
        color: #e89a3c;
    }
    
    .eval-criteria {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.5rem;
        margin-top: 0.75rem;
        padding-top: 0.75rem;
        border-top: 1px dashed rgba(107, 107, 107, 0.2);
    }
    
    .eval-criteria-item {
        font-size: 0.75rem;
    }
    
    .eval-criteria-item span {
        color: #6b6b6b;
    }
    
    .eval-criteria-item strong {
        color: #2c2c2c;
    }
</style>

<div class="proyecto-page py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('estudiante.proyectos.index') }}" class="back-link">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver a Proyectos
            </a>
        <div class="mb-6 flex justify-between items-center">
            <h2 class="font-semibold text-2xl">Proyecto del Equipo</h2>
            @if($esLider && $proyecto)
                <a href="{{ route('estudiante.proyecto.edit') }}" class="neuro-button px-4 py-2 rounded-lg">
                    Editar Proyecto
                </a>
            @endif
        </div>

        @if(session('success'))
            <div class="alert-success mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if($proyecto)
            {{-- Información del Proyecto --}}
            <div class="neuro-card rounded-lg p-6 mb-6">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-xl font-bold">{{ $proyecto->nombre }}</h3>
                    
                    {{-- Badge de Estado de Evaluación --}}
                    @if($totalEvaluaciones > 0)
                        @if($evaluacionesFinalizadas > 0 && $evaluacionesFinalizadas == $totalEvaluaciones)
                            <button type="button" class="eval-badge finalizada" onclick="mostrarEvaluaciones()">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Evaluado ({{ $promedioGeneral }}/100)
                            </button>
                        @elseif($evaluacionesFinalizadas > 0)
                            <button type="button" class="eval-badge en-proceso" onclick="mostrarEvaluaciones()">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                </svg>
                                En Evaluación ({{ $evaluacionesFinalizadas }}/{{ $totalEvaluaciones }})
                            </button>
                        @else
                            <button type="button" class="eval-badge en-proceso" onclick="mostrarEvaluaciones()">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                </svg>
                                Evaluación en Borrador
                            </button>
                        @endif
                    @else
                        <span class="eval-badge sin-evaluar">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                            Sin Evaluar
                        </span>
                    @endif
                </div>
                
                @if($proyecto->descripcion_tecnica)
                    <div class="mb-4">
                        <h4 class="font-semibold mb-2">Descripción Técnica</h4>
                        <p>{{ $proyecto->descripcion_tecnica }}</p>
                    </div>
                @endif

                @if($proyecto->repositorio_url)
                    <div class="mb-4">
                        <h4 class="font-semibold mb-2">Repositorio</h4>
                        <a href="{{ $proyecto->repositorio_url }}" target="_blank" class="link-accent underline">
                            {{ $proyecto->repositorio_url }}
                        </a>
                    </div>
                @endif

                <div class="text-sm mt-4" style="color: #9ca3af;">
                    Creado: {{ $proyecto->created_at->format('d/m/Y H:i') }}
                    @if($proyecto->updated_at != $proyecto->created_at)
                        | Actualizado: {{ $proyecto->updated_at->format('d/m/Y H:i') }}
                    @endif
                </div>
            </div>

            {{-- Accesos Rápidos --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('estudiante.tareas.index') }}" class="quick-access-card border-indigo p-6 rounded-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4>Tareas del Proyecto</h4>
                            <p class="mt-1">Gestiona el checklist</p>
                        </div>
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                    </div>
                </a>

                <a href="{{ route('estudiante.avances.index') }}" class="quick-access-card border-green p-6 rounded-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4>Avances Registrados</h4>
                            <p class="mt-1">Timeline de entregas</p>
                        </div>
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </a>

                <a href="{{ route('estudiante.equipo.show-detalle', $inscripcion) }}" class="quick-access-card border-purple p-6 rounded-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4>Mi Equipo</h4>
                            <p class="mt-1">Ver miembros</p>
                        </div>
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </a>
            </div>

        @else
            {{-- No hay proyecto --}}
            <div class="warning-alert">
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-yellow-600 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <div>
                        <h3 class="mb-2">No hay proyecto creado</h3>
                        <p class="mb-4">Tu equipo aún no ha creado un proyecto. El líder debe crear el proyecto para comenzar.</p>
                        
                        @if($esLider)
                            <a href="{{ route('estudiante.proyecto.create') }}" class="warning-button inline-block px-6 py-2 rounded-lg">
                                Crear Proyecto Ahora
                            </a>
                        @else
                            <p class="text-sm" style="color: #d97706;">Contacta al líder de tu equipo para que cree el proyecto.</p>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

{{-- Modal de Evaluaciones Finales --}}
@if(isset($proyecto) && $proyecto && $totalEvaluaciones > 0)
<div id="eval-modal-overlay" class="eval-modal-overlay" onclick="cerrarModal(event)">
    <div class="eval-modal" onclick="event.stopPropagation()">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-semibold text-lg" style="color: #2c2c2c;">Evaluaciones del Proyecto</h3>
            <button onclick="cerrarModalDirecto()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        {{-- Promedio General --}}
        @if($promedioGeneral)
        <div class="text-center p-4 rounded-xl mb-4" style="background: linear-gradient(135deg, #e89a3c, #f5a847);">
            <div style="font-size: 0.875rem; color: rgba(255,255,255,0.9);">Calificación Final Promedio</div>
            <div style="font-size: 2.5rem; font-weight: 700; color: white;">{{ $promedioGeneral }}/100</div>
            <div style="font-size: 0.75rem; color: rgba(255,255,255,0.8);">{{ $evaluacionesFinalizadas }} de {{ $totalEvaluaciones }} jurados</div>
        </div>
        @endif

        {{-- Lista de Evaluaciones --}}
        <div class="space-y-3">
            @foreach($evaluacionesFinales as $eval)
            <div class="eval-detail-card">
                <div class="flex justify-between items-start">
                    <div>
                        <div class="font-semibold" style="color: #2c2c2c;">
                            {{ $eval->jurado->user->nombre ?? 'Jurado' }} {{ $eval->jurado->user->app_paterno ?? '' }}
                        </div>
                        <div class="text-xs" style="color: #9ca3af;">
                            {{ $eval->estado }}
                            @if($eval->updated_at)
                                · {{ $eval->updated_at->format('d/m/Y H:i') }}
                            @endif
                        </div>
                    </div>
                    @if($eval->estado == 'Finalizada' && $eval->calificacion_final)
                        <div class="eval-score-big">{{ number_format($eval->calificacion_final, 1) }}</div>
                    @else
                        <span class="text-sm px-2 py-1 rounded-full" style="background: rgba(245, 158, 11, 0.2); color: #d97706;">
                            Pendiente
                        </span>
                    @endif
                </div>

                @if($eval->estado == 'Finalizada')
                <div class="eval-criteria">
                    <div class="eval-criteria-item">
                        <span>Innovación:</span> <strong>{{ $eval->calificacion_innovacion ?? '-' }}</strong>
                    </div>
                    <div class="eval-criteria-item">
                        <span>Funcionalidad:</span> <strong>{{ $eval->calificacion_funcionalidad ?? '-' }}</strong>
                    </div>
                    <div class="eval-criteria-item">
                        <span>Presentación:</span> <strong>{{ $eval->calificacion_presentacion ?? '-' }}</strong>
                    </div>
                    <div class="eval-criteria-item">
                        <span>Impacto:</span> <strong>{{ $eval->calificacion_impacto ?? '-' }}</strong>
                    </div>
                </div>

                @if($eval->comentarios_fortalezas || $eval->comentarios_areas_mejora)
                <div class="mt-3 pt-3" style="border-top: 1px dashed rgba(107, 107, 107, 0.2);">
                    @if($eval->comentarios_fortalezas)
                    <div class="text-xs mb-2">
                        <span style="color: #059669; font-weight: 600;">Fortalezas:</span>
                        <span style="color: #2c2c2c;">{{ Str::limit($eval->comentarios_fortalezas, 100) }}</span>
                    </div>
                    @endif
                    @if($eval->comentarios_areas_mejora)
                    <div class="text-xs">
                        <span style="color: #d97706; font-weight: 600;">Áreas de mejora:</span>
                        <span style="color: #2c2c2c;">{{ Str::limit($eval->comentarios_areas_mejora, 100) }}</span>
                    </div>
                    @endif
                </div>
                @endif
                @endif
            </div>
            @endforeach
        </div>
    </div>
</div>

<script>
    function mostrarEvaluaciones() {
        document.getElementById('eval-modal-overlay').classList.add('active');
    }

    function cerrarModal(event) {
        if (event.target.id === 'eval-modal-overlay') {
            document.getElementById('eval-modal-overlay').classList.remove('active');
        }
    }

    function cerrarModalDirecto() {
        document.getElementById('eval-modal-overlay').classList.remove('active');
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            cerrarModalDirecto();
        }
    });
</script>
@endif
@endsection