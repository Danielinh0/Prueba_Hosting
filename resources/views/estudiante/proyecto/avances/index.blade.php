@extends('layouts.app')

@section('content')

<div class="avances-page py-12">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('estudiante.proyecto.show') }}" class="back-link">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver al Proyecto {{ $proyecto->nombre }}
        </a>
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-2xl">Avances del Proyecto</h2>
                <p class="mt-1">{{ $proyecto->nombre }}</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('estudiante.proyecto.show') }}" class="link-accent">
                    ← Volver
                </a>
                <a href="{{ route('estudiante.avances.create') }}" 
                   class="neuro-button px-4 py-2 rounded-lg">
                    + Registrar Avance
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert-success mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- Timeline de Avances --}}
        <div class="neuro-card rounded-lg p-6">
            <h3 class="font-semibold mb-6">📊 Timeline de Entregas</h3>
            
            @forelse($avances as $avance)
                <div class="relative pl-8 pb-8 last:pb-0 {{ $loop->last ? 'timeline-border last-item' : 'timeline-border' }}">
                    {{-- Punto del Timeline --}}
                    <div class="timeline-dot"></div>
                    
                    <div class="avance-item">
                        {{-- Header --}}
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex-1">
                                @if($avance->titulo)
                                    <h4>{{ $avance->titulo }}</h4>
                                @endif
                                <p class="meta-info mt-1">
                                    Registrado por <span class="author">{{ $avance->usuarioRegistro->nombre }}</span>
                                    · {{ $avance->created_at->format('d/m/Y H:i') }}
                                   <span style="color: #9ca3af; font-size: 0.75rem;">({{ $avance->created_at->diffForHumans() }})</span>
                                </p>
                            </div>
                            {{-- Badge de estado de calificación --}}
                            <div class="ml-3">
                                @if($avance->evaluaciones->count() > 0)
                                    <button type="button" 
                                            class="status-badge calificado"
                                            onclick="mostrarEvaluaciones({{ $avance->id_avance }})">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Calificado ({{ $avance->evaluaciones->count() }})
                                    </button>
                                @else
                                    <span class="status-badge pendiente">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                        </svg>
                                        En espera
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Descripción --}}
                        <div class="description mb-3 whitespace-pre-line">
                            {{ $avance->descripcion }}
                        </div>

                        {{-- Archivo Adjunto --}}
                        @if($avance->archivo_evidencia)
                            <div class="mt-3 pt-3" style="border-top: 1px solid rgba(107, 107, 107, 0.2);">
                                <a href="{{ Storage::url($avance->archivo_evidencia) }}" target="_blank"
                                   class="attachment-link inline-flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                    </svg>
                                    Ver archivo adjunto
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="title">No hay avances registrados</p>
                    <p class="text-sm mt-2">Registra el primer avance de tu proyecto para que los jurados puedan evaluarlo</p>
                    <a href="{{ route('estudiante.avances.create') }}" 
                       class="neuro-button inline-block mt-4 px-6 py-2 rounded-lg">
                        Registrar Primer Avance
                    </a>
                </div>
            @endforelse
        </div>

        {{-- Información Adicional --}}
        @if($avances->count() > 0)
            <div class="info-alert mt-6">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-blue-600 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <p class="title">Estos avances son visibles para los jurados del evento</p>
                        <p class="mt-1">Son utilizados para evaluar el progreso de tu proyecto durante el evento.</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

{{-- Modal de Evaluaciones --}}
<div id="eval-modal-overlay" class="eval-modal-overlay" onclick="cerrarModal(event)">
    <div class="eval-modal" onclick="event.stopPropagation()">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-semibold text-lg" style="color: #2c2c2c;">Evaluaciones del Avance</h3>
            <button onclick="cerrarModalDirecto()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        {{-- Contenido dinámico --}}
        <div id="modal-content">
            <!-- Se llenará con JavaScript -->
        </div>
    </div>
</div>

<script>
    // Datos de evaluaciones por avance
    const evaluacionesPorAvance = {
        @foreach($avances as $avance)
            @if($avance->evaluaciones->count() > 0)
            {{ $avance->id_avance }}: {
                titulo: "{{ $avance->titulo ?? 'Avance #' . $loop->iteration }}",
                promedio: {{ round($avance->evaluaciones->avg('calificacion'), 1) }},
                evaluaciones: [
                    @foreach($avance->evaluaciones as $eval)
                    {
                        jurado: "{{ $eval->jurado->user->nombre ?? 'Jurado' }} {{ $eval->jurado->user->app_paterno ?? '' }}",
                        calificacion: {{ $eval->calificacion }},
                        fecha: "{{ $eval->fecha_evaluacion->format('d/m/Y H:i') }}",
                        comentarios: `{{ $eval->comentarios ?? '' }}`
                    },
                    @endforeach
                ]
            },
            @endif
        @endforeach
    };

    function mostrarEvaluaciones(avanceId) {
        const data = evaluacionesPorAvance[avanceId];
        if (!data) return;

        let html = `
            <div class="promedio-badge">
                <div style="font-size: 0.75rem; opacity: 0.9;">Promedio General</div>
                <div style="font-size: 1.25rem;">${data.promedio}/100</div>
            </div>
            <p style="font-size: 0.75rem; color: #6b6b6b; margin-bottom: 0.75rem;">
                ${data.evaluaciones.length} evaluación(es) de jurados
            </p>
        `;

        data.evaluaciones.forEach(eval => {
            html += `
                <div class="eval-card">
                    <div class="flex justify-between items-start">
                        <div>
                            <div class="eval-jurado">${eval.jurado}</div>
                            <div class="eval-fecha">${eval.fecha}</div>
                        </div>
                        <div class="eval-score">${eval.calificacion}</div>
                    </div>
                    ${eval.comentarios ? `<div class="eval-comentarios">"${eval.comentarios}"</div>` : ''}
                </div>
            `;
        });

        document.getElementById('modal-content').innerHTML = html;
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

    // Cerrar con tecla Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            cerrarModalDirecto();
        }
    });
</script>


@endsection