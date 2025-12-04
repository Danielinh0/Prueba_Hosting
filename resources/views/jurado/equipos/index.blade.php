@extends('jurado.layouts.app')

@section('content')
<style>
    .equipos-container {
        min-height: 100vh;
        background: linear-gradient(135deg, #fef3e2 0%, #fde8d0 100%);
        padding: 2rem;
    }

    .page-header {
        margin-bottom: 2rem;
    }

    .page-header h1 {
        font-family: 'Poppins', sans-serif;
        font-size: 2rem;
        font-weight: 700;
        color: #2c2c2c;
    }

    .evento-section {
        margin-bottom: 2.5rem;
    }

    .evento-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
        padding: 1rem 1.5rem;
        background: linear-gradient(135deg, #e89a3c, #f5a847);
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(232, 154, 60, 0.3);
    }

    .evento-header svg {
        width: 2rem;
        height: 2rem;
        color: white;
    }

    .evento-header h2 {
        font-family: 'Poppins', sans-serif;
        font-size: 1.25rem;
        font-weight: 600;
        color: white;
        margin: 0;
    }

    .evento-badge {
        margin-left: auto;
        padding: 0.25rem 0.75rem;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        color: #e89a3c;
    }

    .equipos-grid {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .equipo-card {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr auto;
        align-items: center;
        gap: 1rem;
        padding: 1rem 1.5rem;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 15px;
        box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.08), -2px -2px 8px rgba(255, 255, 255, 0.9);
        transition: all 0.3s ease;
    }

    .equipo-card:hover {
        transform: translateY(-2px);
        box-shadow: 6px 6px 15px rgba(0, 0, 0, 0.12), -3px -3px 10px rgba(255, 255, 255, 1);
    }

    .equipo-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        background: rgba(254, 243, 226, 0.8);
        border-radius: 10px;
    }

    .equipo-info svg {
        width: 1.25rem;
        height: 1.25rem;
        color: #d4a056;
        flex-shrink: 0;
    }

    .equipo-info span {
        font-family: 'Poppins', sans-serif;
        font-size: 0.9rem;
        color: #5c5c5c;
        font-weight: 500;
    }

    .equipo-nombre {
        font-weight: 600;
        color: #2c2c2c;
    }

    .btn-accion {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.25rem;
        border-radius: 10px;
        font-family: 'Poppins', sans-serif;
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        white-space: nowrap;
    }

    .btn-accion svg {
        width: 1rem;
        height: 1rem;
    }

    /* Estado: Pendiente de evaluar */
    .btn-pendiente {
        background: linear-gradient(135deg, #e89a3c, #f5a847);
        color: white;
        box-shadow: 0 4px 10px rgba(232, 154, 60, 0.3);
    }

    .btn-pendiente:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(232, 154, 60, 0.4);
        color: white;
    }

    /* Estado: En progreso */
    .btn-progreso {
        background: linear-gradient(135deg, #3b82f6, #60a5fa);
        color: white;
        box-shadow: 0 4px 10px rgba(59, 130, 246, 0.3);
    }

    .btn-progreso:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(59, 130, 246, 0.4);
        color: white;
    }

    /* Estado: Evaluado */
    .btn-evaluado {
        background: linear-gradient(135deg, #10b981, #34d399);
        color: white;
        box-shadow: 0 4px 10px rgba(16, 185, 129, 0.3);
    }

    .btn-evaluado:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(16, 185, 129, 0.4);
        color: white;
    }

    /* Estado: Sin avances */
    .btn-sin-avances {
        background: linear-gradient(135deg, #9ca3af, #d1d5db);
        color: #4b5563;
        box-shadow: 0 4px 10px rgba(156, 163, 175, 0.3);
    }

    .btn-sin-avances:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(156, 163, 175, 0.4);
        color: #4b5563;
    }

    .status-indicator {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.75rem;
        color: #6b7280;
        margin-top: 0.25rem;
    }

    .status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
    }

    .status-dot.pendiente { background: #f59e0b; }
    .status-dot.progreso { background: #3b82f6; }
    .status-dot.evaluado { background: #10b981; }
    .status-dot.sin-avances { background: #9ca3af; }

    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        background: rgba(255, 255, 255, 0.7);
        border-radius: 15px;
        margin-top: 1rem;
    }

    .empty-state svg {
        width: 4rem;
        height: 4rem;
        color: #d1d5db;
        margin-bottom: 1rem;
    }

    .empty-state h3 {
        font-family: 'Poppins', sans-serif;
        font-size: 1.25rem;
        font-weight: 600;
        color: #6b7280;
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: #9ca3af;
        font-size: 0.9rem;
    }

    .avances-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        padding: 0.25rem 0.5rem;
        background: rgba(232, 154, 60, 0.15);
        border-radius: 6px;
        font-size: 0.7rem;
        color: #d97706;
        font-weight: 600;
    }

    .stats-summary {
        display: flex;
        gap: 1.5rem;
        margin-bottom: 2rem;
        flex-wrap: wrap;
    }

    .stat-card {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem 1.5rem;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 12px;
        box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.08);
    }

    .stat-icon {
        width: 3rem;
        height: 3rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
    }

    .stat-icon svg {
        width: 1.5rem;
        height: 1.5rem;
        color: white;
    }

    .stat-icon.orange { background: linear-gradient(135deg, #e89a3c, #f5a847); }
    .stat-icon.blue { background: linear-gradient(135deg, #3b82f6, #60a5fa); }
    .stat-icon.green { background: linear-gradient(135deg, #10b981, #34d399); }
    .stat-icon.gray { background: linear-gradient(135deg, #6b7280, #9ca3af); }

    .stat-info h4 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2c2c2c;
        line-height: 1;
    }

    .stat-info p {
        font-size: 0.8rem;
        color: #6b7280;
        margin: 0;
    }

    @media (max-width: 768px) {
        .equipo-card {
            grid-template-columns: 1fr;
            text-align: center;
        }

        .equipo-info {
            justify-content: center;
        }

        .btn-accion {
            width: 100%;
            justify-content: center;
        }

        .stats-summary {
            flex-direction: column;
        }
    }
</style>

<div class="equipos-container">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="page-header">
            <h1>Equipos por Evaluar</h1>
        </div>

        @php
            $totalEquipos = 0;
            $equiposPendientes = 0;
            $equiposEnProgreso = 0;
            $equiposEvaluados = 0;
            
            foreach($eventos as $evento) {
                foreach($evento->inscripciones as $inscripcion) {
                    $totalEquipos++;
                    $evaluacionJurado = $inscripcion->evaluaciones->where('id_jurado', $jurado->id_usuario)->first();
                    $avances = $inscripcion->proyecto?->avances ?? collect();
                    
                    if ($evaluacionJurado && $evaluacionJurado->estado === 'Completada') {
                        $equiposEvaluados++;
                    } elseif ($evaluacionJurado || $avances->count() > 0) {
                        $equiposEnProgreso++;
                    } else {
                        $equiposPendientes++;
                    }
                }
            }
        @endphp

        <!-- Stats Summary -->
        <div class="stats-summary">
            <div class="stat-card">
                <div class="stat-icon orange">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div class="stat-info">
                    <h4>{{ $totalEquipos }}</h4>
                    <p>Total Equipos</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon blue">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="stat-info">
                    <h4>{{ $equiposPendientes }}</h4>
                    <p>Pendientes</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon gray">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
                <div class="stat-info">
                    <h4>{{ $equiposEnProgreso }}</h4>
                    <p>En Progreso</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon green">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="stat-info">
                    <h4>{{ $equiposEvaluados }}</h4>
                    <p>Evaluados</p>
                </div>
            </div>
        </div>

        @if($eventos->isEmpty())
            <div class="empty-state">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <h3>No tienes eventos asignados</h3>
                <p>Cuando te asignen eventos como jurado, los equipos aparecerán aquí.</p>
            </div>
        @else
            @foreach($eventos as $evento)
                <div class="evento-section">
                    <div class="evento-header">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <h2>{{ $evento->nombre }}</h2>
                        <span class="evento-badge">
                            {{ $evento->inscripciones->count() }} equipo(s)
                        </span>
                    </div>

                    @if($evento->inscripciones->isEmpty())
                        <div class="empty-state">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <h3>Sin equipos inscritos</h3>
                            <p>Aún no hay equipos completos inscritos en este evento.</p>
                        </div>
                    @else
                        <div class="equipos-grid">
                            @foreach($evento->inscripciones as $inscripcion)
                                @php
                                    $equipo = $inscripcion->equipo;
                                    $lider = $inscripcion->miembros->where('rol.nombre', 'Líder')->first();
                                    if (!$lider) {
                                        $lider = $inscripcion->miembros->where('es_lider', true)->first();
                                    }
                                    $numMiembros = $inscripcion->miembros->count();
                                    $proyecto = $inscripcion->proyecto;
                                    $avances = $proyecto?->avances ?? collect();
                                    $avancesPendientes = 0;
                                    $avancesEvaluados = 0;
                                    
                                    foreach($avances as $avance) {
                                        $evaluacionAvance = $avance->evaluaciones->where('id_jurado', $jurado->id_usuario)->first();
                                        if ($evaluacionAvance) {
                                            $avancesEvaluados++;
                                        } else {
                                            $avancesPendientes++;
                                        }
                                    }
                                    
                                    $evaluacionJurado = $inscripcion->evaluaciones->where('id_jurado', $jurado->id_usuario)->first();
                                    
                                    // Determinar estado
                                    if ($evaluacionJurado && $evaluacionJurado->estado === 'Completada') {
                                        $estado = 'evaluado';
                                        $btnClass = 'btn-evaluado';
                                        $btnText = 'Ver Evaluación';
                                        $btnIcon = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>';
                                    } elseif ($avances->count() > 0 && $avancesPendientes > 0) {
                                        $estado = 'progreso';
                                        $btnClass = 'btn-progreso';
                                        $btnText = $avancesPendientes . ' avance(s) por evaluar';
                                        $btnIcon = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>';
                                    } elseif ($avances->count() > 0 && $avancesPendientes == 0) {
                                        $estado = 'evaluado';
                                        $btnClass = 'btn-evaluado';
                                        $btnText = 'Todos evaluados';
                                        $btnIcon = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>';
                                    } else {
                                        $estado = 'sin-avances';
                                        $btnClass = 'btn-sin-avances';
                                        $btnText = 'Sin avances';
                                        $btnIcon = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>';
                                    }
                                @endphp
                                
                                <div class="equipo-card">
                                    <div class="equipo-info">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        <span class="equipo-nombre">{{ $equipo->nombre }}</span>
                                    </div>

                                    <div class="equipo-info">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        <span>Líder: {{ $lider?->user?->nombre ?? 'Sin asignar' }}</span>
                                    </div>

                                    <div class="equipo-info">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                        </svg>
                                        <span>{{ $numMiembros }} miembro(s)</span>
                                        @if($avances->count() > 0)
                                            <span class="avances-badge">
                                                {{ $avances->count() }} avance(s)
                                            </span>
                                        @endif
                                    </div>

                                    <a href="{{ route('jurado.eventos.equipo_evento', ['evento' => $evento->id_evento, 'equipo' => $equipo->id_equipo]) }}" 
                                       class="btn-accion {{ $btnClass }}">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            {!! $btnIcon !!}
                                        </svg>
                                        {{ $btnText }}
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        @endif
    </div>
</div>
@endsection
