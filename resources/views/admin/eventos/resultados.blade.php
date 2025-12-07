@extends('layouts.app')

@section('content')


<div class="resultados-page py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('admin.eventos.show', $evento) }}" class="back-link">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Volver al evento "{{ $evento->nombre }}"
    </a>
        {{-- Header --}}
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-2xl">Resultados y Evaluaciones</h2>
                <p class="mt-1">{{ $evento->nombre }}</p>
            </div>
        </div>

        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert-error">
                {{ session('error') }}
            </div>
        @endif

        {{-- Resumen de Evaluaciones --}}
        <div class="summary-card">
            <h3 class="text-lg mb-4">📊 Resumen de Evaluaciones</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="summary-box summary-box-blue">
                    <p>Equipos Registrados</p>
                    <p>{{ $equiposConCalificaciones->count() }}</p>
                </div>
                <div class="summary-box summary-box-green">
                    <p>Equipos Evaluados</p>
                    <p>{{ $equiposConCalificaciones->where('total_evaluaciones', '>', 0)->count() }}</p>
                </div>
                <div class="summary-box summary-box-purple">
                    <p>Ganadores Asignados</p>
                    <p>{{ $equiposConCalificaciones->whereNotNull('puesto_actual')->count() }}</p>
                </div>
            </div>
        </div>

        {{-- Ranking de Equipos --}}
        <div class="ranking-card">
            <h3 class="text-lg mb-6">🏆 Ranking de Equipos</h3>

            @forelse($equiposConCalificaciones as $index => $data)
                <div class="team-item">
                    <div class="flex items-start justify-between">
                        {{-- Info del Equipo --}}
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                {{-- Posición en ranking --}}
                                <div class="position-badge 
                                    {{ $index == 0 ? 'position-1' : '' }}
                                    {{ $index == 1 ? 'position-2' : '' }}
                                    {{ $index == 2 ? 'position-3' : '' }}
                                    {{ $index > 2 ? 'position-default' : '' }}">
                                    {{ $index + 1 }}
                                </div>

                                {{-- Nombre del equipo y proyecto --}}
                                <div>
                                    <h4 class="team-name">{{ $data['equipo']->nombre }}</h4>
                                    @if($data['proyecto'])
                                        <p class="team-project">{{ $data['proyecto']->nombre }}</p>
                                    @else
                                        <p class="team-project" style="font-style: italic;">Sin proyecto</p>
                                    @endif
                                </div>

                                {{-- Badge de puesto ganador --}}
                                @if($data['puesto_actual'])
                                    <span class="puesto-badge
                                        {{ $data['puesto_actual'] == 1 ? 'puesto-1' : '' }}
                                        {{ $data['puesto_actual'] == 2 ? 'puesto-2' : '' }}
                                        {{ $data['puesto_actual'] == 3 ? 'puesto-3' : '' }}
                                        {{ $data['puesto_actual'] > 3 ? 'puesto-other' : '' }}">
                                        {{ $data['puesto_actual'] }}° Lugar
                                    </span>
                                @endif
                            </div>

                            {{-- Calificaciones --}}
                            <div style="margin-left: 3.25rem; margin-top: 0.5rem;">
                                @if($data['promedio_general'])
                                    <div class="flex items-center gap-4">
                                        <div>
                                            <span class="score-label">Promedio General:</span>
                                            <span class="score-value">{{ $data['promedio_general'] }}/100</span>
                                        </div>
                                        <div class="eval-count">
                                            ({{ $data['total_evaluaciones'] }} evaluación{{ $data['total_evaluaciones'] != 1 ? 'es' : '' }})
                                        </div>
                                    </div>

                                    {{-- Detalle de evaluaciones --}}
                                    @if($data['evaluaciones']->count() > 0)
                                        <details class="mt-2">
                                            <summary class="details-summary">
                                                Ver detalle de evaluaciones
                                            </summary>
                                            <div class="mt-2 ml-4 space-y-2">
                                                @foreach($data['evaluaciones'] as $evaluacion)
                                                    <div class="eval-detail-box">
                                                        <p>
                                                            Jurado: {{ $evaluacion->jurado->user->nombre }} {{ $evaluacion->jurado->user->app_paterno }}
                                                        </p>
                                                        <p>Calificación: {{ $evaluacion->calificacion_final }}/100</p>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </details>
                                    @endif
                                @else
                                    <p style="font-size: 0.875rem; color: #9ca3af; font-style: italic;">Sin evaluaciones finalizadas</p>
                                @endif
                            </div>
                        </div>

                        {{-- Acciones de Administrador --}}
                        <div class="flex flex-col gap-2 ml-4">
                            @if($data['puesto_actual'])
                                {{-- Quitar puesto --}}
                                <form action="{{ route('admin.eventos.resultados.quitar-puesto', $evento) }}" method="POST"
                                      onsubmit="return confirm('¿Quitar puesto ganador?')">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="id_inscripcion" value="{{ $data['inscripcion']->id_inscripcion }}">
                                    <button type="submit" class="btn-remove">
                                        Quitar Puesto
                                    </button>
                                </form>
                            @else
                                {{-- Asignar puesto --}}
                                <form action="{{ route('admin.eventos.resultados.asignar-puesto', $evento) }}" method="POST" class="flex gap-2">
                                    @csrf
                                    <input type="hidden" name="id_inscripcion" value="{{ $data['inscripcion']->id_inscripcion }}">
                                    <select name="puesto" class="neuro-select">
                                        <option value="">Puesto...</option>
                                        @for($i = 1; $i <= 10; $i++)
                                            <option value="{{ $i }}">{{ $i }}° Lugar</option>
                                        @endfor
                                    </select>
                                    <button type="submit" class="btn-assign">
                                        Asignar
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <p>No hay equipos registrados en este evento</p>
                </div>
            @endforelse
        </div>

        {{-- Información Adicional --}}
        <div class="info-box">
            <div class="flex items-start">
                <svg class="w-5 h-5 mr-2 flex-shrink-0" style="color: #3b82f6;" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <p>Cálculo de Calificaciones</p>
                    <p style="margin-top: 0.25rem; font-weight: 400;">El promedio general se calcula con las evaluaciones finalizadas de todos los jurados asignados al evento.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection