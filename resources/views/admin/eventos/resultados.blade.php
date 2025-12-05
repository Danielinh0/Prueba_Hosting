@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
    
    /* Fondo degradado */
    .resultados-page {
        background: linear-gradient(to bottom, #FFFDF4, #FFEEE2);
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
    }
    
    /* Textos */
    .resultados-page h2,
    .resultados-page h3,
    .resultados-page h4 {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
    }
    
    .resultados-page p,
    .resultados-page span {
        font-family: 'Poppins', sans-serif;
        color: #6b6b6b;
    }
    
    /* Back link */
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
    
    /* Alerts */
    .alert-success {
        background: rgba(209, 250, 229, 0.8);
        border: 1px solid #10b981;
        color: #065f46;
        padding: 1rem;
        border-radius: 15px;
        margin-bottom: 1rem;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        font-family: 'Poppins', sans-serif;
    }
    
    .alert-error {
        background: rgba(254, 226, 226, 0.8);
        border: 1px solid #ef4444;
        color: #991b1b;
        padding: 1rem;
        border-radius: 15px;
        margin-bottom: 1rem;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        font-family: 'Poppins', sans-serif;
    }
    
    /* Summary card */
    .summary-card {
        background: #FFEEE2;
        border-radius: 20px;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .summary-card h3 {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
        font-weight: 700;
    }
    
    /* Summary boxes */
    .summary-box {
        border-radius: 15px;
        padding: 1rem;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
    }
    
    .summary-box-blue {
        background: linear-gradient(135deg, rgba(219, 234, 254, 0.5), rgba(191, 219, 254, 0.5));
    }
    
    .summary-box-blue p:first-child {
        color: #2563eb;
        font-weight: 500;
        font-size: 0.875rem;
    }
    
    .summary-box-blue p:last-child {
        color: #1e3a8a;
        font-size: 1.875rem;
        font-weight: 700;
        margin-top: 0.25rem;
    }
    
    .summary-box-green {
        background: linear-gradient(135deg, rgba(209, 250, 229, 0.5), rgba(167, 243, 208, 0.5));
    }
    
    .summary-box-green p:first-child {
        color: #059669;
        font-weight: 500;
        font-size: 0.875rem;
    }
    
    .summary-box-green p:last-child {
        color: #064e3b;
        font-size: 1.875rem;
        font-weight: 700;
        margin-top: 0.25rem;
    }
    
    .summary-box-purple {
        background: linear-gradient(135deg, rgba(237, 233, 254, 0.5), rgba(221, 214, 254, 0.5));
    }
    
    .summary-box-purple p:first-child {
        color: #7c3aed;
        font-weight: 500;
        font-size: 0.875rem;
    }
    
    .summary-box-purple p:last-child {
        color: #5b21b6;
        font-size: 1.875rem;
        font-weight: 700;
        margin-top: 0.25rem;
    }
    
    /* Ranking card */
    .ranking-card {
        background: #FFEEE2;
        border-radius: 20px;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
        padding: 1.5rem;
    }
    
    .ranking-card h3 {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
        font-weight: 700;
    }
    
    /* Team item */
    .team-item {
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid rgba(232, 154, 60, 0.2);
    }
    
    .team-item:last-child {
        border-bottom: none;
    }
    
    /* Position badge */
    .position-badge {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.125rem;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
    }
    
    .position-1 {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        color: #92400e;
    }
    
    .position-2 {
        background: linear-gradient(135deg, #d1d5db, #9ca3af);
        color: #374151;
    }
    
    .position-3 {
        background: linear-gradient(135deg, #fed7aa, #fdba74);
        color: #9a3412;
    }
    
    .position-default {
        background: rgba(243, 244, 246, 0.8);
        color: #6b7280;
    }
    
    /* Team name */
    .team-name {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
        font-weight: 600;
        font-size: 1.125rem;
    }
    
    .team-project {
        font-family: 'Poppins', sans-serif;
        color: #6b6b6b;
        font-size: 0.875rem;
    }
    
    /* Puesto badge */
    .puesto-badge {
        font-family: 'Poppins', sans-serif;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .puesto-1 {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        color: #92400e;
    }
    
    .puesto-2 {
        background: rgba(229, 231, 235, 0.8);
        color: #374151;
    }
    
    .puesto-3 {
        background: linear-gradient(135deg, #fed7aa, #fdba74);
        color: #9a3412;
    }
    
    .puesto-other {
        background: rgba(219, 234, 254, 0.8);
        color: #1e40af;
    }
    
    /* Score display */
    .score-label {
        font-size: 0.875rem;
        color: #6b6b6b;
    }
    
    .score-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #6366f1;
        margin-left: 0.5rem;
    }
    
    .eval-count {
        font-size: 0.875rem;
        color: #9ca3af;
    }
    
    /* Details */
    .details-summary {
        cursor: pointer;
        font-size: 0.875rem;
        color: #e89a3c;
        transition: all 0.2s ease;
    }
    
    .details-summary:hover {
        color: #d98a2c;
    }
    
    .eval-detail-box {
        background: rgba(255, 255, 255, 0.3);
        border-radius: 10px;
        padding: 0.75rem;
        font-size: 0.875rem;
        box-shadow: inset 2px 2px 4px #e6d5c9, inset -2px -2px 4px #ffffff;
    }
    
    .eval-detail-box p {
        font-family: 'Poppins', sans-serif;
        font-size: 0.875rem;
    }
    
    .eval-detail-box p:first-child {
        font-weight: 500;
        color: #2c2c2c;
    }
    
    .eval-detail-box p:last-child {
        color: #6b6b6b;
    }
    
    /* Form elements */
    .neuro-select {
        font-family: 'Poppins', sans-serif;
        background: rgba(255, 255, 255, 0.5);
        border: none;
        box-shadow: inset 2px 2px 4px #e6d5c9, inset -2px -2px 4px #ffffff;
        padding: 0.25rem 0.5rem;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        color: #2c2c2c;
        backdrop-filter: blur(10px);
    }
    
    .neuro-select:focus {
        outline: none;
        box-shadow: inset 4px 4px 8px #e6d5c9, inset -4px -4px 8px #ffffff;
    }
    
    /* Buttons */
    .btn-assign {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: #ffffff;
        padding: 0.25rem 0.75rem;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        font-weight: 600;
        border: none;
        box-shadow: 2px 2px 4px rgba(99, 102, 241, 0.3);
        transition: all 0.3s ease;
    }
    
    .btn-assign:hover {
        box-shadow: 4px 4px 8px rgba(99, 102, 241, 0.4);
        transform: translateY(-2px);
    }
    
    .btn-remove {
        font-family: 'Poppins', sans-serif;
        color: #ef4444;
        font-size: 0.875rem;
        font-weight: 600;
        background: none;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .btn-remove:hover {
        color: #dc2626;
    }
    
    /* Info box */
    .info-box {
        background: linear-gradient(135deg, rgba(219, 234, 254, 0.5), rgba(191, 219, 254, 0.5));
        border-left: 4px solid #3b82f6;
        padding: 1rem;
        border-radius: 0 15px 15px 0;
        margin-top: 1.5rem;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
    }
    
    .info-box p {
        font-family: 'Poppins', sans-serif;
        color: #1e40af;
        font-size: 0.875rem;
    }
    
    .info-box p:first-of-type {
        font-weight: 600;
    }
    
    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 3rem 0;
    }
    
    .empty-state p {
        font-family: 'Poppins', sans-serif;
        color: #6b6b6b;
        font-weight: 600;
    }
</style>

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