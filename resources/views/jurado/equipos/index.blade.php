@extends('jurado.layouts.app')

@section('content')

<div class="equipos-container">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <a href="{{ route('dashboard') }}" class="back-link">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver al Dashboard
        </a>
        <div class="page-header">
            <h1>Equipos por Evaluar</h1>
        </div>

        @php
            $totalEquipos = 0;
            $evalFinalesPendientes = 0;
            $avancesPendientesTotal = 0;
            $equiposEvaluados = 0;
            $equiposReevaluacion = 0;
            $eventosUnicos = [];
            
            foreach($eventos as $evento) {
                $eventosUnicos[$evento->id_evento] = $evento->nombre;
                foreach($evento->inscripciones as $inscripcion) {
                    $totalEquipos++;
                    $evaluacionJurado = $inscripcion->evaluaciones->where('id_jurado', $jurado->id_usuario)->first();
                    $avances = $inscripcion->proyecto?->avances ?? collect();
                    
                    $avancesPendientesEquipo = 0;
                    $avancesCalificadosEquipo = 0;
                    foreach($avances as $avance) {
                        $evaluacionAvance = $avance->evaluaciones->where('id_jurado', $jurado->id_usuario)->first();
                        if (!$evaluacionAvance) {
                            $avancesPendientesTotal++;
                            $avancesPendientesEquipo++;
                        } else {
                            $avancesCalificadosEquipo++;
                        }
                    }
                    
                    $todosAvancesCalificados = $avances->count() > 0 && $avancesPendientesEquipo == 0;
                    $noHaEvaluadoProyecto = !$evaluacionJurado || $evaluacionJurado->estado !== 'Completada';
                    
                    if ($todosAvancesCalificados && $noHaEvaluadoProyecto) {
                        $evalFinalesPendientes++;
                    }
                    
                    if ($evaluacionJurado && $evaluacionJurado->estado === 'Completada') {
                        $equiposEvaluados++;
                        $equiposReevaluacion++;
                    }
                }
            }
        @endphp

        <!-- Stats Summary -->
        <div class="stats-summary">
            <div class="stat-card active" data-filter="todos" onclick="filterByStatus('todos')">
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

            <div class="stat-card" data-filter="eval-final" onclick="filterByStatus('eval-final')">
                <div class="stat-icon purple">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                </div>
                <div class="stat-info">
                    <h4>{{ $evalFinalesPendientes }}</h4>
                    <p>Eval. Final Pend.</p>
                </div>
            </div>

            <div class="stat-card" data-filter="avances" onclick="filterByStatus('avances')">
                <div class="stat-icon blue">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
                <div class="stat-info">
                    <h4>{{ $avancesPendientesTotal }}</h4>
                    <p>Avances Pend.</p>
                </div>
            </div>

            <div class="stat-card" data-filter="evaluados" onclick="filterByStatus('evaluados')">
                <div class="stat-icon green">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="stat-info">
                    <h4>{{ $equiposEvaluados }}</h4>
                    <p>Completados</p>
                </div>
            </div>

            <div class="stat-card" data-filter="reevaluacion" onclick="filterByStatus('reevaluacion')">
                <div class="stat-icon gray">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                </div>
                <div class="stat-info">
                    <h4>{{ $equiposReevaluacion }}</h4>
                    <p>Reevaluación</p>
                </div>
            </div>
        </div>

        <!-- Barra de búsqueda y filtros -->
        <div class="search-filter-container">
            <div class="search-box">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" id="searchInput" placeholder="Buscar por equipo, líder o proyecto..." oninput="applyFilters()">
            </div>
            
            <select class="filter-select" id="eventoFilter" onchange="applyFilters()">
                <option value="">Todos los eventos</option>
                @foreach($eventosUnicos as $idEvento => $nombreEvento)
                    <option value="{{ $idEvento }}">{{ $nombreEvento }}</option>
                @endforeach
            </select>
            
            <button class="clear-filters" onclick="clearFilters()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                Limpiar
            </button>
        </div>

        <!-- Mensaje de no resultados -->
        <div id="no-results" class="no-results" style="display: none;">
            <div style="font-size: 3rem; font-weight: 700; color: #2c2c2c; margin-bottom: 0.5rem;">
                404
            </div>
            <p>No se encontraron equipos con los filtros seleccionados</p>
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
                <div class="evento-section" data-evento="{{ $evento->id_evento }}">
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
                                    
                                    $tieneAvancesPendientes = $avancesPendientes > 0;
                                    $estaCompleto = $evaluacionJurado && $evaluacionJurado->estado === 'Completada';
                                    $listoParaEvalFinal = ($avances->count() > 0 && $avancesPendientes == 0) && (!$evaluacionJurado || $evaluacionJurado->estado !== 'Completada');
                                    $puedeReevaluar = $estaCompleto;
                                @endphp
                                
                                <div class="equipo-card" 
                                     data-nombre="{{ strtolower($equipo->nombre) }}" 
                                     data-lider="{{ strtolower($lider?->user?->nombre ?? '') }}"
                                     data-proyecto="{{ strtolower($proyecto?->nombre ?? '') }}"
                                     data-evento="{{ $evento->id_evento }}"
                                     data-eval-final="{{ $listoParaEvalFinal ? '1' : '0' }}"
                                     data-avances="{{ $tieneAvancesPendientes ? '1' : '0' }}"
                                     data-completo="{{ $estaCompleto ? '1' : '0' }}"
                                     data-reevaluacion="{{ $puedeReevaluar ? '1' : '0' }}">
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
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <span>{{ $proyecto?->nombre ?? 'Sin proyecto' }}</span>
                                    </div>

                                    <div class="acciones-grupo">
                                        @if($evaluacionJurado && $evaluacionJurado->estado === 'Completada')
                                            <a href="{{ route('jurado.eventos.equipo_evento', ['evento' => $evento->id_evento, 'equipo' => $equipo->id_equipo]) }}" 
                                               class="btn-accion btn-evaluado">
                                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                Evaluación completa
                                            </a>
                                        @else
                                            @if($avancesPendientes > 0)
                                                <a href="{{ route('jurado.eventos.equipo_evento', ['evento' => $evento->id_evento, 'equipo' => $equipo->id_equipo]) }}" 
                                                   class="btn-accion-small btn-avances">
                                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                    {{ $avancesPendientes }} Avance(s)
                                                </a>
                                            @elseif($avances->count() == 0)
                                                <span class="btn-accion-small btn-sin-avances">
                                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    Sin avances
                                                </span>
                                            @else
                                                <span class="btn-accion-small btn-evaluado">
                                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    Avances OK
                                                </span>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        @endif
    </div>
</div>

<script>
    let currentStatusFilter = 'todos';

    function filterByStatus(status) {
        currentStatusFilter = status;
        
        document.querySelectorAll('.stat-card').forEach(card => {
            card.classList.remove('active');
            if (card.dataset.filter === status) {
                card.classList.add('active');
            }
        });
        
        applyFilters();
    }

    function applyFilters() {
        const searchText = document.getElementById('searchInput').value.toLowerCase();
        const eventoFilter = document.getElementById('eventoFilter').value;
        
        let visibleCount = 0;
        
        document.querySelectorAll('.equipo-card').forEach(card => {
            const nombre = card.dataset.nombre || '';
            const lider = card.dataset.lider || '';
            const proyecto = card.dataset.proyecto || '';
            const evento = card.dataset.evento || '';
            const tieneEvalFinal = card.dataset.evalFinal === '1';
            const tieneAvances = card.dataset.avances === '1';
            const estaCompleto = card.dataset.completo === '1';
            const puedeReevaluar = card.dataset.reevaluacion === '1';
            
            let visible = true;
            
            if (searchText && !nombre.includes(searchText) && !lider.includes(searchText) && !proyecto.includes(searchText)) {
                visible = false;
            }
            
            if (eventoFilter && evento !== eventoFilter) {
                visible = false;
            }
            
            if (currentStatusFilter === 'eval-final' && !tieneEvalFinal) {
                visible = false;
            } else if (currentStatusFilter === 'avances' && !tieneAvances) {
                visible = false;
            } else if (currentStatusFilter === 'evaluados' && !estaCompleto) {
                visible = false;
            } else if (currentStatusFilter === 'reevaluacion' && !puedeReevaluar) {
                visible = false;
            }
            
            card.classList.toggle('hidden', !visible);
            if (visible) visibleCount++;
        });
        
        document.querySelectorAll('.evento-section').forEach(section => {
            const visibleCards = section.querySelectorAll('.equipo-card:not(.hidden)').length;
            section.classList.toggle('hidden', visibleCards === 0);
        });
        
        const noResultsDiv = document.getElementById('no-results');
        if (visibleCount === 0) {
            noResultsDiv.style.display = 'block';
        } else {
            noResultsDiv.style.display = 'none';
        }
    }

    function clearFilters() {
        document.getElementById('searchInput').value = '';
        document.getElementById('eventoFilter').value = '';
        filterByStatus('todos');
    }
</script>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

    .equipos-container {
        min-height: 100vh;
        background: linear-gradient(to bottom, #FFFDF4, #FFEEE2);
        padding: 2rem 1rem;
        font-family: 'Poppins', sans-serif;
    }

    /* Back link neuromórfico */
    .back-link {
        font-family: 'Poppins', sans-serif;
        display: inline-flex;
        align-items: center;
        color: #e89a3c;
        font-size: 0.875rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        padding: 0.75rem 1.25rem;
        background: rgba(255, 253, 244, 0.9);
        border-radius: 12px;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        transition: all 0.3s ease;
        text-decoration: none;
    }
    
    .back-link:hover {
        color: #d98a2c;
        box-shadow: 6px 6px 12px #e6d5c9, -6px -6px 12px #ffffff;
        transform: translateY(-2px);
    }
    
    .back-link svg {
        width: 1rem;
        height: 1rem;
        margin-right: 0.5rem;
    }

    /* Page header */
    .page-header {
        margin-bottom: 2rem;
    }

    .page-header h1 {
        font-family: 'Poppins', sans-serif;
        font-size: 2rem;
        font-weight: 700;
        color: #2c2c2c;
    }

    /* Stats Summary neuromórficas */
    .stats-summary {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }

    .stat-card {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        background: #FFEEE2;
        border-radius: 12px;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
        cursor: pointer;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 12px 12px 24px #e6d5c9, -12px -12px 24px #ffffff;
    }

    .stat-card.active {
        border-color: #e89a3c;
        background: linear-gradient(135deg, rgba(254, 243, 226, 0.9), rgba(254, 238, 226, 0.9));
    }

    .stat-icon {
        width: 2.5rem;
        height: 2.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.1);
    }

    .stat-icon svg {
        width: 1.25rem;
        height: 1.25rem;
        color: white;
    }

    .stat-icon.orange { background: linear-gradient(135deg, #e89a3c, #f5a847); }
    .stat-icon.blue { background: linear-gradient(135deg, #3b82f6, #60a5fa); }
    .stat-icon.green { background: linear-gradient(135deg, #10b981, #34d399); }
    .stat-icon.gray { background: linear-gradient(135deg, #6b7280, #9ca3af); }
    .stat-icon.purple { background: linear-gradient(135deg, #8b5cf6, #a78bfa); }

    .stat-info h4 {
        font-size: 1.25rem;
        font-weight: 700;
        color: #2c2c2c;
        line-height: 1;
        margin: 0;
        font-family: 'Poppins', sans-serif;
    }

    .stat-info p {
        font-size: 0.7rem;
        color: #6b7280;
        margin: 0;
        font-family: 'Poppins', sans-serif;
    }

    /* Barra de búsqueda y filtros neuromórficos */
    .search-filter-container {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        align-items: center;
    }

    .search-box {
        flex: 1;
        min-width: 250px;
        position: relative;
    }

    .search-box input {
        width: 100%;
        padding: 0.75rem 1rem 0.75rem 2.75rem;
        border: none;
        border-radius: 12px;
        font-family: 'Poppins', sans-serif;
        font-size: 0.9rem;
        background: rgba(255, 255, 255, 0.5);
        color: #2c2c2c;
        box-shadow: inset 3px 3px 6px #e6d5c9, inset -3px -3px 6px #ffffff;
        transition: all 0.3s ease;
    }

    .search-box input:focus {
        outline: none;
        box-shadow: inset 4px 4px 8px #e6d5c9, inset -4px -4px 8px #ffffff;
    }

    .search-box input::placeholder {
        color: #9ca3af;
    }

    .search-box svg {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        width: 1.25rem;
        height: 1.25rem;
        color: #9ca3af;
        pointer-events: none;
    }

    .filter-select {
        padding: 0.75rem 2.5rem 0.75rem 1rem;
        border: none;
        border-radius: 12px;
        font-family: 'Poppins', sans-serif;
        font-size: 0.9rem;
        background: rgba(255, 255, 255, 0.5);
        color: #2c2c2c;
        cursor: pointer;
        box-shadow: inset 3px 3px 6px #e6d5c9, inset -3px -3px 6px #ffffff;
        transition: all 0.3s ease;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%239ca3af'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 1.25rem;
    }

    .filter-select:focus {
        outline: none;
        box-shadow: inset 4px 4px 8px #e6d5c9, inset -4px -4px 8px #ffffff;
    }

    .clear-filters {
        padding: 0.75rem 1rem;
        border: none;
        border-radius: 12px;
        font-family: 'Poppins', sans-serif;
        font-size: 0.85rem;
        font-weight: 500;
        background: rgba(255, 255, 255, 0.5);
        color: #6b7280;
        cursor: pointer;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .clear-filters:hover {
        transform: translateY(-2px);
        box-shadow: 6px 6px 12px #e6d5c9, -6px -6px 12px #ffffff;
    }

    .clear-filters svg {
        width: 1rem;
        height: 1rem;
    }

    /* Evento section */
    .evento-section {
        margin-bottom: 2.5rem;
    }

    .evento-section.hidden {
        display: none;
    }

    .evento-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
        padding: 1rem 1.5rem;
        background: linear-gradient(135deg, #e89a3c, #f5a847);
        border-radius: 15px;
        box-shadow: 4px 4px 8px rgba(232, 154, 60, 0.3);
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
        padding: 0.35rem 0.85rem;
        background: rgba(255, 255, 255, 0.95);
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        color: #e89a3c;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
    }

    /* Equipos grid */
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
        background: #FFEEE2;
        border-radius: 15px;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
        transition: all 0.3s ease;
    }

    .equipo-card:hover {
        transform: translateY(-2px);
        box-shadow: 12px 12px 24px #e6d5c9, -12px -12px 24px #ffffff;
    }

    .equipo-card.hidden {
        display: none;
    }

    .equipo-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        background: rgba(255, 255, 255, 0.4);
        border-radius: 10px;
        box-shadow: inset 2px 2px 4px #e6d5c9, inset -2px -2px 4px #ffffff;
    }

    .equipo-info svg {
        width: 1.25rem;
        height: 1.25rem;
        color: #e89a3c;
        flex-shrink: 0;
    }

    .equipo-info span {
        font-family: 'Poppins', sans-serif;
        font-size: 0.9rem;
        color: #6b6b6b;
        font-weight: 500;
    }

    .equipo-nombre {
        font-weight: 600;
        color: #2c2c2c;
    }

    /* Botones de acción neuromórficos */
    .acciones-grupo {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .btn-accion {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.25rem;
        border-radius: 12px;
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

    .btn-accion-small {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.5rem 0.75rem;
        border-radius: 10px;
        font-family: 'Poppins', sans-serif;
        font-size: 0.75rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        white-space: nowrap;
    }

    .btn-accion-small svg {
        width: 0.85rem;
        height: 0.85rem;
    }

    .btn-evaluado {
        background: linear-gradient(135deg, #10b981, #34d399);
        color: white;
        box-shadow: 4px 4px 8px rgba(16, 185, 129, 0.3);
    }

    .btn-evaluado:hover {
        transform: translateY(-2px);
        box-shadow: 6px 6px 12px rgba(16, 185, 129, 0.4);
        color: white;
    }

    .btn-avances {
        background: linear-gradient(135deg, #e89a3c, #f5a847);
        color: white;
        box-shadow: 4px 4px 8px rgba(232, 154, 60, 0.3);
    }

    .btn-avances:hover {
        transform: translateY(-2px);
        box-shadow: 6px 6px 12px rgba(232, 154, 60, 0.4);
        color: white;
    }

    .btn-sin-avances {
        background: linear-gradient(135deg, rgba(156, 163, 175, 0.8), rgba(209, 213, 219, 0.8));
        color: #4b5563;
        box-shadow: 4px 4px 8px rgba(156, 163, 175, 0.3);
    }

    /* Empty states neuromórficos */
    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        background: #FFEEE2;
        border-radius: 20px;
        margin-top: 1rem;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
    }

    .empty-state svg {
        width: 4rem;
        height: 4rem;
        color: #e89a3c;
        margin: 0 auto 1rem;
        opacity: 0.4;
    }

    .empty-state h3 {
        font-family: 'Poppins', sans-serif;
        font-size: 1.25rem;
        font-weight: 600;
        color: #2c2c2c;
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: #9ca3af;
        font-size: 0.9rem;
        font-family: 'Poppins', sans-serif;
    }

    .no-results {
        text-align: center;
        padding: 2rem;
        background: #FFEEE2;
        border-radius: 20px;
        margin-top: 1rem;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
    }

    .no-results svg {
        width: 3rem;
        height: 3rem;
        color: #e89a3c;
        margin-bottom: 0.75rem;
        opacity: 0.4;
    }

    .no-results p {
        color: #6b7280;
        font-size: 0.9rem;
        font-family: 'Poppins', sans-serif;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .equipo-card {
            grid-template-columns: 1fr 1fr;
            gap: 0.75rem;
        }

        .acciones-grupo {
            grid-column: 1 / -1;
            justify-content: center;
        }
    }

    @media (max-width: 768px) {
        .equipos-container {
            padding: 1rem 0.75rem;
        }

        .equipo-card {
            grid-template-columns: 1fr;
            text-align: center;
            padding: 1rem;
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

        .stat-card {
            width: 100%;
        }

        .search-filter-container {
            flex-direction: column;
        }

        .search-box {
            width: 100%;
        }

        .filter-select {
            width: 100%;
        }

        .page-header h1 {
            font-size: 1.5rem;
        }
    }

    @media (max-width: 480px) {
        .evento-header {
            flex-direction: column;
            text-align: center;
        }

        .evento-badge {
            margin-left: 0;
            margin-top: 0.5rem;
        }
    }
</style>
@endsection