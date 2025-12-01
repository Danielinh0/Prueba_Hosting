@extends('layouts.prueba')

@section('title', 'Inicio')

@section('content')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
        
        /* Fondo degradado */
        body {
            background: linear-gradient(to bottom, #FFFDF4, #FFEEE2);
            min-height: 100vh;
        }
        
        /* Configuración global */
        .left-col,
        .right-col {
            font-family: 'Poppins', sans-serif;
        }
        
        /* Títulos de sección */
        .section-title {
            font-family: 'Poppins', sans-serif;
            color: #2c2c2c;
        }
        
        /* Cards neuromórficas */
        .neu-card {
            background: #FFEEE2;
            box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
            transition: all 0.3s ease;
        }
        
        .neu-card:hover {
            box-shadow: 10px 10px 20px #e6d5c9, -10px -10px 20px #ffffff;
            transform: translateY(-3px);
        }
        
        /* Event cards */
        .event-card-header {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #e89a3c, #f5a847);
            color: #ffffff;
        }
        
        .event-card-body {
            background: #FFEEE2;
        }
        
        .event-desc {
            font-family: 'Poppins', sans-serif;
            color: #2c2c2c;
        }
        
        .event-date,
        .event-participants {
            font-family: 'Poppins', sans-serif;
            color: #6b6b6b;
        }
        
        .event-card-body a {
            font-family: 'Poppins', sans-serif;
            color: #e89a3c;
            transition: all 0.2s ease;
        }
        
        .event-card-body a:hover {
            color: #d98a2c;
            opacity: 0.8;
        }
        
        /* Progress card */
        .info-item {
            font-family: 'Poppins', sans-serif;
            background: rgba(255, 255, 255, 0.44);
            color: #2c2c2c;
            box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
            backdrop-filter: blur(10px);
        }
        
        .progress-ring {
            background: linear-gradient(135deg, #e89a3c 0%, #f5a847 100%);
            box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
        }
        
        .progress-ring::before {
            background: #FFEEE2;
            box-shadow: inset 4px 4px 8px #e6d5c9, inset -4px -4px 8px #ffffff;
        }
        
        .progress-text span {
            font-family: 'Poppins', sans-serif;
            color: #6b6b6b;
        }
        
        .progress-text strong {
            font-family: 'Poppins', sans-serif;
            color: #e89a3c;
        }
        
        .progress-main-card a {
            font-family: 'Poppins', sans-serif;
            color: #e89a3c;
        }
        
        .progress-main-card a:hover {
            color: #d98a2c;
            opacity: 0.8;
        }
        
        /* Small cards */
        .small-card {
            background: #FFEEE2;
            box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
            transition: all 0.3s ease;
        }
        
        .small-card:hover {
            box-shadow: 10px 10px 20px #e6d5c9, -10px -10px 20px #ffffff;
            transform: translateY(-5px);
        }
        
        .card-icon-box {
            box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .icon-athena,
        .icon-projects {
            background: linear-gradient(135deg, #e89a3c, #f5a847);
        }
        
        .icon-const,
        .icon-teams {
            background: linear-gradient(135deg, #f5a847, #e89a3c);
        }
        
        .card-content-box h4 {
            font-family: 'Poppins', sans-serif;
            color: #2c2c2c;
        }
        
        .card-content-box p {
            font-family: 'Poppins', sans-serif;
            color: #6b6b6b;
        }
    </style>

    <section class="left-col">
        <h3 class="section-title">Eventos actuales</h3>
        
        @if ($miInscripcion)
            {{-- Evento Activo --}}
            <div class="event-card-container neu-card">
                <div class="event-card-header">{{ $miInscripcion->evento->nombre }}</div>
                <div class="event-card-body">
                    <p class="event-desc">{{ Str::limit($miInscripcion->evento->descripcion ?? 'Sin descripción disponible', 100) }}</p>
                    <p class="event-date">{{ $miInscripcion->evento->fecha_inicio->format('d \d\e F, Y') }}</p>
                    <p class="event-participants">
                        Participantes: {{ $miInscripcion->evento->inscripciones->count() }}
                    </p>
                    <div class="mt-4">
                        <a href="{{ route('estudiante.eventos.show', $miInscripcion->evento) }}">
                            Ver detalles del evento →
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="event-card-container neu-card">
                <div class="event-card-header">No hay eventos activos</div>
                <div class="event-card-body">
                    <p class="event-desc">Actualmente no estás participando en ningún evento. Explora los eventos disponibles para unirte.</p>
                </div>
            </div>
        @endif

        <h3 class="section-title">Eventos disponibles</h3>
        
        @forelse ($eventosDisponibles->take(2) as $evento)
            <div class="event-card-container neu-card">
                <div class="event-card-header">{{ $evento->nombre }}</div>
                <div class="event-card-body">
                    <p class="event-desc">{{ Str::limit($evento->descripcion ?? 'Sin descripción', 100) }}</p>
                    <p class="event-date">Inicia: {{ $evento->fecha_inicio->format('d \d\e F, Y') }}</p>
                    <p class="event-participants">
                        Participantes: {{ $evento->inscripciones->count() }}
                    </p>
                    <div class="mt-4">
                        <a href="{{ route('estudiante.eventos.show', $evento) }}">
                            Ver detalles →
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="event-card-container neu-card">
                <div class="event-card-header">Sin eventos disponibles</div>
                <div class="event-card-body">
                    <p class="event-desc">No hay eventos disponibles en este momento. Vuelve pronto para ver nuevas oportunidades.</p>
                </div>
            </div>
        @endforelse
    </section>

    <section class="right-col">
        <h3 class="section-title">Progreso del proyecto actual</h3>
        
        <div class="progress-main-card neu-card">
            @if($miInscripcion && $miInscripcion->equipo)
                <div class="progress-info-items">
                    <div class="info-item">{{ $miInscripcion->equipo->nombre }}</div>
                    <div class="info-item">{{ $miInscripcion->evento->nombre }}</div>
                    <div class="info-item">
                        {{ $miInscripcion->equipo->miembros->where('id_estudiante', Auth::user()->estudiante->id_estudiante)->first()->rol->nombre ?? 'Miembro' }}
                    </div>
                </div>
                <div class="progress-circle-container">
                    <div class="progress-ring"></div>
                    <div class="progress-text">
                        <span>Avance</span>
                        <strong>0%</strong>
                    </div>
                </div>
                <div class="mt-4 text-center">
                    <a href="{{ route('estudiante.equipo.index') }}">
                        Ver detalles del equipo →
                    </a>
                </div>
            @else
                <div class="progress-info-items">
                    <div class="info-item">Sin equipo asignado</div>
                    <div class="info-item">Sin evento activo</div>
                    <div class="info-item">Sin rol</div>
                </div>
                <div class="progress-circle-container">
                    <div class="progress-ring"></div>
                    <div class="progress-text">
                        <span>Avance</span>
                        <strong>0%</strong>
                    </div>
                </div>
            @endif
        </div>

        <div class="cards-grid">
            <a href="{{ route('estudiante.eventos.index') }}" class="small-card neu-card">
                <div class="card-icon-box icon-athena"><i class="fas fa-calendar-alt"></i></div>
                <div class="card-content-box">
                    <h4>EVENTOS ACTIVOS</h4>
                    <p>Verifica los eventos en curso</p>
                </div>
            </a>

            <div class="small-card neu-card">
                <div class="card-icon-box icon-const"><i class="fas fa-certificate"></i></div>
                <div class="card-content-box">
                    <h4>CONSTANCIAS</h4>
                    <p>Genera tus constancias</p>
                </div>
            </div>

            @if($miInscripcion && $miInscripcion->proyecto)
                <a href="#" class="small-card neu-card">
                    <div class="card-icon-box icon-projects"><i class="fas fa-cogs"></i></div>
                    <div class="card-content-box">
                        <h4>MIS PROYECTOS</h4>
                        <p>Verifica tus proyectos</p>
                    </div>
                </a>
            @else
                <div class="small-card neu-card">
                    <div class="card-icon-box icon-projects"><i class="fas fa-cogs"></i></div>
                    <div class="card-content-box">
                        <h4>MIS PROYECTOS</h4>
                        <p>Sin proyectos activos</p>
                    </div>
                </div>
            @endif

            <a href="{{ route('estudiante.equipo.index') }}" class="small-card neu-card">
                <div class="card-icon-box icon-teams"><i class="fas fa-users"></i></div>
                <div class="card-content-box">
                    <h4>EQUIPOS</h4>
                    <p>Verifica los equipos disponibles</p>
                </div>
            </a>
        </div>

        

    </section>
@endsection