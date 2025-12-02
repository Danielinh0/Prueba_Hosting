@extends('jurado.layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

    :root {
        --color-primary: #DB8C57;
        --color-secondary: #E77F30;
        --color-bg: #FFEFDC;
        --color-card-bg: #FFF8F0; /* Un crema un poco más claro para las tarjetas */
        --text-dark: #000000;
        --text-gray: #A4AEB7;
        --text-white: #FFFFFF;
    }

    body {
        font-family: 'Poppins', sans-serif;
        color: var(--text-dark);
    }

    .dashboard-container {
        padding: 40px;
        max-width: 1400px;
        margin: 0 auto;
    }

    .section-title {
        font-size: 1.2rem;
        font-weight: 700;
        margin-bottom: 20px;
        color: var(--text-dark);
    }

    /* Cards Generales */
    .custom-card {
        background-color: var(--color-card-bg);
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        margin-bottom: 30px;
    }

    /* Sección Etapas de Revisión */
    .revision-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
        padding: 0 10px;
        font-weight: 700;
        font-size: 1rem;
    }

    .revision-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .btn-equipo {
        background-color: #FCFCFC;
        color: #A4AEB7;
        padding: 12px 20px;
        border-radius: 12px;
        font-weight: 600;
        width: 45%;
        text-align: center;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }

    .btn-fecha {
        background-color: #EBC08D; /* Tono naranja suave/dorado */
        color: white;
        padding: 12px 20px;
        border-radius: 12px;
        font-weight: 600;
        width: 45%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }

    /* Sección Progreso */
    .project-title {
        text-align: center;
        font-weight: 700;
        font-size: 1.2rem;
        margin-bottom: 25px;
    }

    .progress-content {
        display: flex;
        gap: 30px;
        align-items: center;
    }

    .inputs-container {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .custom-input {
        background-color: #FCFCFC;
        border: none;
        padding: 12px;
        border-radius: 10px;
        color: #A4AEB7;
        font-weight: 500;
        text-align: center;
        width: 100%;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }

    .chart-wrapper {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    /* Sección Eventos Actuales */
    .event-card {
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }

    .event-header {
        background-color: #DB8C57;
        color: white;
        padding: 15px;
        text-align: center;
        font-weight: 700;
        font-size: 1.1rem;
    }

    .event-body {
        background-color: var(--color-card-bg);
        padding: 25px;
        color: #666;
        font-size: 0.95rem;
        line-height: 1.6;
    }

    /* Grid Inferior de Tarjetas */
    .bottom-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin-top: 20px;
    }

    .info-card {
        background-color: var(--color-card-bg);
        border-radius: 20px;
        overflow: hidden;
        display: flex;
        height: 100px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        transition: transform 0.2s;
    }
    
    .info-card:hover {
        transform: translateY(-3px);
    }

    .card-img {
        width: 35%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .card-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .card-img.blue-icon { background-color: #002B5C; color: white; }
    .card-img.purple-icon { background-color: #2D2A4A; color: white; }
    .card-img.photo { background-color: #333; }

    .card-content {
        width: 65%;
        padding: 15px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .card-content h5 {
        font-weight: 700;
        font-size: 0.9rem;
        margin-bottom: 5px;
        color: var(--text-dark);
        text-transform: uppercase;
    }

    .card-content p {
        font-size: 0.75rem;
        color: #A4AEB7;
        font-weight: 500;
        line-height: 1.2;
    }

    @media (max-width: 768px) {
        .progress-content {
            flex-direction: column;
        }
        .bottom-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="dashboard-container">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        
        <!-- Columna Izquierda -->
        <div class="space-y-10">
            
            <!-- Etapas de revisión -->
            <div>
                <h3 class="section-title">Etapas de revision</h3>
                <div class="custom-card">
                    <div class="revision-header">
                        <span>Equipos</span>
                        <span>Fecha de revision</span>
                    </div>
                    
                    <div class="space-y-4">
                        @if($etapasRevision->count() > 0)
                            @foreach($etapasRevision as $etapa)
                                <div class="revision-row">
                                    <div class="btn-equipo">{{ $etapa->equipo }}</div>
                                    <div class="btn-fecha">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $etapa->fecha->format('d de F') }}
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center text-gray-500 py-4">No hay revisiones pendientes</div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Eventos actuales -->
            <div>
                <h3 class="section-title">Eventos actuales</h3>
                <div class="event-card">
                    @if($eventoActual)
                        <div class="event-header">
                            {{ $eventoActual->nombre }}
                        </div>
                        <div class="event-body">
                            <p class="mb-4">{{ Str::limit($eventoActual->descripcion, 100) }}</p>
                            <p class="mb-4">{{ $eventoActual->fecha_inicio->format('d de F, Y') }}</p>
                            <p>Equipos Participantes: {{ $eventoActual->inscripciones_count }}</p>
                        </div>
                    @else
                        <div class="event-header">Sin Eventos</div>
                        <div class="event-body text-center">
                            No tienes eventos asignados actualmente.
                        </div>
                    @endif
                </div>
            </div>

        </div>

        <!-- Columna Derecha -->
        <div class="space-y-10">
            
            <!-- Progreso Actual -->
            <div>
                <h3 class="section-title">Progreso Actual del proyecto</h3>
                <div class="custom-card">
                    @if($proyectoDestacado)
                        <h4 class="project-title">{{ $proyectoDestacado->nombre }}</h4>
                        
                        <div class="progress-content">
                            <div class="inputs-container">
                                <div class="custom-input">{{ $nombreEquipoProyecto }}</div>
                                <div class="custom-input">{{ $nombreEventoProyecto }}</div>
                                <div class="custom-input" style="height: 45px;"></div>
                            </div>
                            
                            <div class="chart-wrapper">
                                <div class="relative w-40 h-40">
                                    <svg class="w-full h-full" viewBox="0 0 100 100">
                                        <circle cx="50" cy="50" r="40" fill="none" stroke="#FFE0B2" stroke-width="8" />
                                        <circle cx="50" cy="50" r="40" fill="none" stroke="#FF9800" stroke-width="8" stroke-dasharray="251.2" stroke-dashoffset="{{ 251.2 - (251.2 * $avancePorcentaje / 100) }}" stroke-linecap="round" transform="rotate(-90 50 50)" />
                                    </svg>
                                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                                        <span class="text-gray-400 font-bold text-sm">Avance</span>
                                        <span class="text-4xl font-bold text-yellow-500">{{ $avancePorcentaje }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <h4 class="project-title">Sin proyectos activos</h4>
                        <div class="text-center text-gray-500 py-8">
                            No hay proyectos para mostrar progreso.
                        </div>
                    @endif
                </div>
            </div>

            <!-- Grid de Tarjetas Pequeñas -->
            <div class="bottom-grid">
                
                <!-- Card 1 -->
                <div class="info-card">
                    <div class="card-img blue-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 0 1 0 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 0 1 0-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                    </div>
                    <div class="card-content">
                        <h5>EVENTOS ACTIVOS</h5>
                        <p>{{ $eventosActivosCount }} eventos en curso</p>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="info-card">
                    <div class="card-img purple-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                        </svg>
                    </div>
                    <div class="card-content">
                        <h5>Acuses</h5>
                        <p>{{ $acusesCount }} acuses generados</p>
                    </div>
                </div>

                <!-- Card 3 -->
                <a href="{{ route('jurado.proyectos.index') }}" class="info-card" style="text-decoration: none;">
                    <div class="card-img photo">
                        <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=60" alt="Proyectos">
                    </div>
                    <div class="card-content">
                        <h5>PROYECTOS</h5>
                        <p>{{ $proyectosCount }} proyectos asignados</p>
                    </div>
                </a>

                <!-- Card 4 -->
                <div class="info-card">
                    <div class="card-img photo">
                        <img src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=60" alt="Equipos">
                    </div>
                    <div class="card-content">
                        <h5>EQUIPOS</h5>
                        <p>{{ $equiposCount }} equipos a evaluar</p>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection

