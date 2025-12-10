@extends('layouts.app')

@section('title', 'Inicio')
@section('with-container', true)

@section('content')
{{-- MENSAJES DE ALERTA --}}
    @if(session('success'))
        <div style="position: fixed; top: 80px; right: 20px; z-index: 9999; padding: 1rem 1.5rem; background: linear-gradient(135deg, #d1fae5, #a7f3d0); color: #065f46; border-radius: 12px; box-shadow: 4px 4px 12px rgba(0,0,0,0.15); font-family: 'Poppins', sans-serif; font-weight: 500; max-width: 400px; animation: slideInRight 0.5s ease;">
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <i class="fas fa-check-circle" style="font-size: 1.25rem;"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div style="position: fixed; top: 80px; right: 20px; z-index: 9999; padding: 1rem 1.5rem; background: linear-gradient(135deg, #fee2e2, #fecaca); color: #991b1b; border-radius: 12px; box-shadow: 4px 4px 12px rgba(0,0,0,0.15); font-family: 'Poppins', sans-serif; font-weight: 500; max-width: 400px; animation: slideInRight 0.5s ease;">
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <i class="fas fa-exclamation-circle" style="font-size: 1.25rem;"></i>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif
    

    <!-- SVG Gradients for Charts -->
    <svg style="position: absolute; width: 0; height: 0;">
        <defs>
            <linearGradient id="gradientOrange" x1="0%" y1="0%" x2="100%" y2="0%">
                <stop offset="0%" stop-color="#ef4444"/>
                <stop offset="100%" stop-color="#f87171"/>
            </linearGradient>
            <linearGradient id="gradientGreen" x1="0%" y1="0%" x2="100%" y2="0%">
                <stop offset="0%" stop-color="#10b981"/>
                <stop offset="100%" stop-color="#059669"/>
            </linearGradient>
            <linearGradient id="gradientPurple" x1="0%" y1="0%" x2="100%" y2="0%">
                <stop offset="0%" stop-color="#8b5cf6"/>
                <stop offset="100%" stop-color="#6366f1"/>
            </linearGradient>
            <linearGradient id="gradientBlue" x1="0%" y1="0%" x2="100%" y2="0%">
                <stop offset="0%" stop-color="#3b82f6"/>
                <stop offset="100%" stop-color="#1d4ed8"/>
            </linearGradient>
        </defs>
    </svg>

    <!-- Welcome Banner -->
    <div class="welcome-banner-dbshdE animate-in-dbshdE" style="grid-column: 1 / -1;">
        <svg class="welcome-svg-dbshdE" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="50" cy="50" r="45" stroke="white" stroke-width="2"/>
            <path d="M35 50 L45 60 L65 40" stroke="white" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <h2>¡Hola, <span class="welcome-highlight-dbshdE">{{ Auth::user()->nombre }}</span>!</h2>
        <p>Panel de estudiante — {{ now()->translatedFormat('d \\d\\e F, Y') }}</p>
    </div>

    <section class="left-col-dbshdE">
        <h3 class="section-title-dbshdE animate-in-dbshdE">
            <i class="fas fa-calendar-check"></i>
            Evento Actual
        </h3>
        
        @if ($miInscripcion)
            {{-- Evento Activo --}}
            <div class="event-card-container neu-card animate-in-dbshdE delay-1-dbshdE">
                <div class="event-card-header-dbshdE">
                    <span class="event-badge-dbshdE" style="color: #ffffff">
                        <i class="fas fa-star"></i> Activo
                    </span>
                    {{ $miInscripcion->evento->nombre }}
                </div>
                <div class="event-card-body-dbshdE">
                    <p class="event-desc-dbshdE">{{ Str::limit($miInscripcion->evento->descripcion ?? 'Sin descripción disponible', 100) }}</p>
                    <p class="event-date">
                        <i class="fas fa-calendar-alt"></i>
                        {{ $miInscripcion->evento->fecha_inicio->format('d \d\e F, Y') }}
                    </p>
                    <p class="event-participants">
                        <i class="fas fa-users"></i>
                        Equipos que Participan: {{ $miInscripcion->evento->inscripciones->count() }}
                    </p>
                    <div class="mt-4">
                        <a href="{{ route('estudiante.eventos.show', $miInscripcion->evento) }}">
                            Ver detalles del evento <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="event-card-container neu-card animate-in-dbshdE delay-1-dbshdE">
                <div class="event-card-header-dbshdE">No hay eventos activos</div>
                <div class="event-card-body-dbshdE">
                    <p class="event-desc-dbshdE">Actualmente no estás participando en ningún evento. Explora los eventos disponibles para unirte.</p>
                </div>
            </div>
        @endif

        {{-- CARRUSEL DE EVENTOS DISPONIBLES --}}
        <h3 class="section-title-dbshdE animate-in-dbshdE delay-2-dbshdE">
            <i class="fas fa-calendar-star"></i>
            Eventos Disponibles
        </h3>
        
        @if($eventosDisponibles->count() > 0)
            <div class="carousel-container-dbshdE animate-in-dbshdE delay-2-dbshdE" id="eventosCarousel">
                <div class="carousel-track-container-dbshdE">
                    <div class="carousel-track-dbshdE" id="eventosTrack">
                        @foreach ($eventosDisponibles as $evento)
                            <div class="carousel-slide-dbshdE">
                                <div class="event-card-container neu-card event-card-with-image" style="margin-bottom: 0;" id="cardEv">
                                    @if($evento->ruta_imagen)
                                        <div class="event-image">
                                            <img src="{{ asset('storage/' . $evento->ruta_imagen) }}" alt="{{ $evento->nombre }}">
                                            <span class="event-badge-dbshdE">
                                                <i class="fas fa-clock"></i> Próximo
                                            </span>
                                        </div>
                                    @else
                                        <div class="event-image event-image-placeholder">
                                            <i class="fas fa-calendar-alt" id="ical"></i>
                                            <span class="event-badge-dbshdE">
                                                <i class="fas fa-clock"></i> Próximo
                                            </span>
                                        </div>
                                    @endif
                                    <div class="event-card-content">
                                        <h4 class="event-title-dbshdE">{{ $evento->nombre }}</h4>
                                        <p class="event-desc-dbshdE">{{ Str::limit($evento->descripcion ?? 'Sin descripción', 80) }}</p>
                                        <div class="event-meta-dbshdE">
                                            <p class="event-date">
                                                <i class="fas fa-calendar-alt"></i>
                                                {{ $evento->fecha_inicio->format('d M, Y') }}
                                            </p>
                                            <p class="event-participants">
                                                <i class="fas fa-users"></i>
                                                {{ $evento->inscripciones->count() }} equipos
                                            </p>
                                        </div>
                                        <a href="{{ route('estudiante.eventos.show', $evento) }}" class="event-link">
                                            Ver detalles <i class="fas fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Navegación debajo del contenido -->
                <div class="carousel-nav-dbshdE">
                    <button class="carousel-arrow-dbshdE prev" onclick="eventosCarousel.prev()">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <div class="carousel-dots-dbshdE" id="eventosDots"></div>
                    <button class="carousel-arrow-dbshdE next" onclick="eventosCarousel.next()">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
                <div class="carousel-progress-dbshdE">
                    <div class="carousel-progress-bar-dbshdE" id="eventosProgress"></div>
                </div>
            </div>
        @else
            <div class="event-card-container neu-card animate-in-dbshdE delay-2-dbshdE">
                <div class="empty-state-dbshdE">
                    <i class="fas fa-calendar-times"></i>
                    <p>No hay eventos disponibles en este momento.</p>
                </div>
            </div>
        @endif

        {{-- CARRUSEL DE EQUIPOS --}}
        <h3 class="section-title-dbshdE animate-in-dbshdE delay-3-dbshdE">
            <i class="fas fa-users-cog"></i>
            Equipos Disponibles
        </h3>
        
        @php
            $userId = auth()->id();
            
            // Obtener los IDs de eventos donde el usuario ya está inscrito
            $eventosDelUsuario = \App\Models\InscripcionEvento::whereHas('miembros', function($q) use ($userId) {
                $q->where('id_estudiante', $userId);
            })->pluck('id_evento')->toArray();
            
            // Obtener equipos disponibles:
            // - En eventos 'Próximo' o 'Activo'
            // - NO en eventos donde el usuario ya está
            $equiposDisponibles = \App\Models\InscripcionEvento::whereHas('evento', function($q) {
                $q->whereIn('estado', ['Próximo', 'Activo']);
            })
            ->when(count($eventosDelUsuario) > 0, function($q) use ($eventosDelUsuario) {
                $q->whereNotIn('id_evento', $eventosDelUsuario);
            })
            ->withCount('miembros')
            ->with(['equipo', 'evento', 'miembros.user'])
            ->get()
            ->filter(function($inscripcion) {
                return $inscripcion->miembros_count < 5;
            })
            ->take(6);
        @endphp

        @if($equiposDisponibles->count() > 0)
            <div class="carousel-container-dbshdE animate-in-dbshdE delay-3-dbshdE" id="equiposCarousel">
                <div class="carousel-track-container-dbshdE">
                    <div class="carousel-track-dbshdE" id="equiposTrack">
                        @foreach ($equiposDisponibles as $inscripcion)
                            <div class="carousel-slide-dbshdE">
                                <div class="team-card-dbshdE" onclick="window.location.href='{{ route('estudiante.equipos.vista-previa', $inscripcion->equipo) }}'" style="cursor: pointer;">
                                    <div class="team-header-dbshdE">
                                        <div class="team-avatar-dbshdE">
                                            <i class="fas fa-users" style="color:#ffffff"></i>
                                        </div>
                                        <div class="team-info-dbshdE">
                                            <h4>{{ $inscripcion->equipo->nombre }}</h4>
                                            <p>{{ $inscripcion->evento->nombre }}</p>
                                        </div>
                                    </div>

                                    <div class="team-members-dbshdE">
                                        @foreach($inscripcion->miembros->take(4) as $miembro)
                                            <div class="member-avatar-dbshdE" title="{{ $miembro->estudiante->user->nombre ?? 'Miembro' }}">
                                                {{ strtoupper(substr($miembro->estudiante->user->nombre ?? 'M', 0, 1)) }}
                                            </div>
                                        @endforeach
                                        @if($inscripcion->miembros->count() > 4)
                                            <div class="member-avatar-dbshdE more">
                                                +{{ $inscripcion->miembros->count() - 4 }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="team-status-dbshdE {{ $inscripcion->miembros->count() >= 5 ? 'completo' : 'incompleto' }}">
                                        <i class="fas {{ $inscripcion->miembros->count() >= 5 ? 'fa-check-circle' : 'fa-user-plus' }}"></i>
                                        {{ $inscripcion->miembros->count() >= 5 ? 'Equipo Completo' : (5 - $inscripcion->miembros->count()) . ' espacio' . ((5 - $inscripcion->miembros->count()) != 1 ? 's' : '') . ' disponible' }}
                                    </div>

                                    <div class="team-view-btn-dbshdE">
                                        <i class="fas fa-eye"></i>
                                        Ver Detalles
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <div class="carousel-nav-dbshdE">
                    <button class="carousel-arrow-dbshdE prev" onclick="equiposCarousel.prev()">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <div class="carousel-dots-dbshdE" id="equiposDots"></div>
                    <button class="carousel-arrow-dbshdE next" onclick="equiposCarousel.next()">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
                <div class="carousel-progress-dbshdE">
                    <div class="carousel-progress-bar-dbshdE" id="equiposProgress"></div>
                </div>
            </div>
        @else
            <div class="event-card-container neu-card animate-in-dbshdE delay-3-dbshdE">
                <div class="empty-state-dbshdE">
                    <i class="fas fa-users-slash"></i>
                    <p>No hay equipos buscando miembros en este momento.</p>
                </div>
            </div>
        @endif
    </section>

    <section class="right-col-dbshdE">
        {{-- ACCESO RÁPIDO --}}
        <h3 class="section-title-dbshdE animate-in-dbshdE">
            <i class="fas fa-bolt"></i>
            Acceso Rápido
        </h3>

        <div class="cards-grid animate-in-dbshdE delay-1-dbshdE">
            <a href="{{ route('estudiante.eventos.index') }}" class="small-card neu-card">
                <div class="card-icon-box icon-athena"><i class="fas fa-calendar-alt"></i></div>
                <div class="card-content-box">
                    <h4>EVENTOS ACTIVOS</h4>
                    <p>Verifica los eventos en curso</p>
                </div>
            </a>

            @if($miInscripcion && $miInscripcion->evento->estado === 'En Progreso')
                @php
                    $evento = $miInscripcion->evento;
                    $proyectoEvento = $evento->tipo_proyecto === 'general' 
                        ? $evento->proyectoGeneral 
                        : $miInscripcion->proyectoEvento;
                @endphp
                
                @if($proyectoEvento && $proyectoEvento->publicado)
                    <a href="{{ route('estudiante.proyecto-evento.show') }}" class="small-card neu-card">
                        <div class="card-icon-box icon-const"><i class="fas fa-clipboard-list"></i></div>
                        <div class="card-content-box">
                            <h4>PROYECTO DEL EVENTO</h4>
                            <p>{{ Str::limit($proyectoEvento->titulo, 30) }}</p>
                        </div>
                    </a>
                @else
                    <div class="small-card neu-card">
                        <div class="card-icon-box icon-const"><i class="fas fa-clipboard-list"></i></div>
                        <div class="card-content-box">
                            <h4>PROYECTO DEL EVENTO</h4>
                            <p>Esperando publicación...</p>
                        </div>
                    </div>
                @endif
            @else
            <a href="{{ route('estudiante.constancias.index') }}">
                <div class="small-card neu-card">
                    <div class="card-icon-box icon-const"><i class="fas fa-certificate"></i></div>
                    <div class="card-content-box">
                        <h4>CONSTANCIAS</h4>
                        <p>Aquí puedes generar constancias de tus eventos</p>
                    </div>
                </div>
            </a>
            @endif

            @if($miInscripcion && $miInscripcion->proyecto)
                <a href="{{ route('estudiante.proyectos.index') }}" class="small-card neu-card">
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

        {{-- GRÁFICAS DE PROGRESO DE PROYECTOS --}}
        <h3 class="section-title-dbshdE animate-in-dbshdE delay-2-dbshdE" id="titulodescuadrado">
            <i class="fas fa-chart-pie"></i>
            Progreso de Proyectos
        </h3>
        
        @php
            $tieneProyecto = $miInscripcion && $miInscripcion->proyecto;
            $progressData = [];
            $totalTareas = 0;
            $tareasCompletadas = 0;
            $porcentajeGeneral = 0;

            if ($tieneProyecto) {
                $proyecto = $miInscripcion->proyecto;
                $tareas = $proyecto->tareas;
                $totalTareas = $tareas->count();
                $tareasCompletadas = $tareas->where('completada', true)->count();
                $porcentajeGeneral = $totalTareas > 0 ? round(($tareasCompletadas / $totalTareas) * 100) : 0;

                $tareasAlta = $tareas->where('prioridad', 'Alta');
                $tareasMedia = $tareas->where('prioridad', 'Media');
                $tareasBaja = $tareas->where('prioridad', 'Baja');

                $progressData = [
                    [
                        'name' => 'Alta Prioridad',
                        'total' => $tareasAlta->count(),
                        'completadas' => $tareasAlta->where('completada', true)->count(),
                        'percentage' => $tareasAlta->count() > 0 ? round(($tareasAlta->where('completada', true)->count() / $tareasAlta->count()) * 100) : 0,
                        'color' => 'orange',
                        'icon' => 'fa-exclamation-circle'
                    ],
                    [
                        'name' => 'Media Prioridad',
                        'total' => $tareasMedia->count(),
                        'completadas' => $tareasMedia->where('completada', true)->count(),
                        'percentage' => $tareasMedia->count() > 0 ? round(($tareasMedia->where('completada', true)->count() / $tareasMedia->count()) * 100) : 0,
                        'color' => 'green',
                        'icon' => 'fa-minus-circle'
                    ],
                    [
                        'name' => 'Baja Prioridad',
                        'total' => $tareasBaja->count(),
                        'completadas' => $tareasBaja->where('completada', true)->count(),
                        'percentage' => $tareasBaja->count() > 0 ? round(($tareasBaja->where('completada', true)->count() / $tareasBaja->count()) * 100) : 0,
                        'color' => 'purple',
                        'icon' => 'fa-arrow-down'
                    ],
                    [
                        'name' => 'Total',
                        'total' => $totalTareas,
                        'completadas' => $tareasCompletadas,
                        'percentage' => $porcentajeGeneral,
                        'color' => 'blue',
                        'icon' => 'fa-tasks'
                    ],
                ];
            }
        @endphp

        @if($tieneProyecto && $totalTareas > 0)
            <div class="progress-charts-container animate-in-dbshdE delay-1-dbshdE">
                @foreach($progressData as $index => $data)
                    @if($data['total'] > 0)
                        <div class="progress-chart-card" data-percentage="{{ $data['percentage'] }}" data-color="{{ $data['color'] }}">
                            <div class="circular-progress">
                                <svg viewBox="0 0 100 100" width="120" height="120">
                                    <circle class="bg" cx="50" cy="50" r="40" fill="none" stroke="#e5e7eb" stroke-width="6"/>
                                    <circle class="progress {{ $data['color'] }}" cx="50" cy="50" r="40" fill="none" stroke-width="6"/>
                                </svg>
                                <div class="percentage">
                                    <span>{{ $data['percentage'] }}%</span>
                                </div>
                            </div>
                            <h5>{{ $data['name'] }}</h5>
                            <p class="progress-value">{{ $data['completadas'] }}/{{ $data['total'] }} tareas</p>
                        </div>
                    @endif
                @endforeach
            </div>
        @else
            <div class="neu-card animate-in-dbshdE delay-1-dbshdE" style="padding: 2rem; text-align: center;">
                <div class="empty-state-dbshdE">
                    <i class="fas fa-clipboard-list"></i>
                    <p>@if(!$miInscripcion)
                        No estás inscrito en ningún evento activo.
                    @elseif(!$miInscripcion->proyecto)
                        Tu equipo aún no tiene un proyecto asignado.
                    @else
                        No hay tareas registradas en el proyecto.
                    @endif</p>
                </div>
            </div>
        @endif

        <h3 class="section-title-dbshdE animate-in-dbshdE delay-2-dbshdE" id="titulodescuadrado">
            <i class="fas fa-tasks"></i>
            Progreso del Proyecto Actual
        </h3>
        
        <div class="progress-main-card neu-card animate-in-dbshdE delay-2-dbshdE">
            @if($miInscripcion && $miInscripcion->equipo)
                <div class="progress-info-items">
                    <div class="info-item">
                        <i class="fas fa-users"></i> {{ $miInscripcion->equipo->nombre }}
                    </div>
                    <div class="info-item">
                        <i class="fas fa-calendar"></i> {{ $miInscripcion->evento->nombre }}
                    </div>
                    <div class="info-item">
                        <i class="fas fa-user-tag"></i>
                        {{ $miInscripcion->equipo->miembros->where('id_estudiante', Auth::user()->estudiante->id_estudiante)->first()->rol->nombre ?? 'Miembro' }}
                    </div>
                </div>
                <div class="progress-circle-container">
                    <svg class="progress-ring-de" viewBox="0 0 100 100" width="120" height="120">
                        <defs>
                            <linearGradient id="progressGradientMain" x1="0%" y1="0%" x2="100%" y2="0%">
                                <stop offset="0%" stop-color="#10b981"/>
                                <stop offset="100%" stop-color="#14b8a6"/>
                            </linearGradient>
                        </defs>
                        <circle class="progress-ring-bg" cx="50" cy="50" r="40" fill="none" stroke="#fbfbfbff" stroke-width="6"/>
                        <circle class="progress-ring-fill" cx="50" cy="50" r="40" fill="none" stroke="url(#progressGradientMain)" stroke-width="6"/>
                    </svg>
                    <div class="progress-text" >
                        <span style="color: #ffffffff;">Avance</span>
                        <strong style="color: #151515ff;">0%</strong>
                    </div>
                </div>
                <div class="mt-4 text-center">
                    <a href="{{ route('estudiante.equipo.index') }}">
                        Ver detalles del equipo <i class="fas fa-arrow-right"></i>
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
    </section>

    <script>
        class Carousel {
            constructor(trackId, dotsId, progressId, autoPlayDelay = 5000) {
                this.track = document.getElementById(trackId);
                this.dotsContainer = document.getElementById(dotsId);
                this.progressBar = document.getElementById(progressId);
                
                if (!this.track) return;
                
                this.slides = this.track.querySelectorAll('.carousel-slide-dbshdE');
                this.currentIndex = 0;
                this.autoPlayDelay = autoPlayDelay;
                this.autoPlayTimer = null;
                this.progressTimer = null;
                this.progressInterval = null;
                
                this.init();
            }
            
            init() {
                if (this.slides.length === 0) return;
                
                this.createDots();
                this.updateCarousel();
                
                if (this.autoPlayDelay > 0) {
                    this.startAutoPlay();
                }
                
                const container = this.track.closest('.carousel-container-dbshdE');
                if (container) {
                    container.addEventListener('mouseenter', () => this.pauseAutoPlay());
                    container.addEventListener('mouseleave', () => this.startAutoPlay());
                }
                
                this.initTouchSupport();
            }
            
            createDots() {
                if (!this.dotsContainer) return;
                
                this.dotsContainer.innerHTML = '';
                this.slides.forEach((_, index) => {
                    const dot = document.createElement('div');
                    dot.classList.add('carousel-dot-dbshdE');
                    if (index === 0) dot.classList.add('active');
                    dot.addEventListener('click', () => this.goTo(index));
                    this.dotsContainer.appendChild(dot);
                });
            }
            
            updateCarousel() {
                this.track.style.transform = `translateX(-${this.currentIndex * 100}%)`;
                
                if (this.dotsContainer) {
                    const dots = this.dotsContainer.querySelectorAll('.carousel-dot-dbshdE');
                    dots.forEach((dot, index) => {
                        dot.classList.toggle('active', index === this.currentIndex);
                    });
                }
            }
            
            next() {
                this.currentIndex = (this.currentIndex + 1) % this.slides.length;
                this.updateCarousel();
                this.resetProgress();
            }
            
            prev() {
                this.currentIndex = (this.currentIndex - 1 + this.slides.length) % this.slides.length;
                this.updateCarousel();
                this.resetProgress();
            }
            
            goTo(index) {
                this.currentIndex = index;
                this.updateCarousel();
                this.resetProgress();
            }
            
            startAutoPlay() {
                if (this.autoPlayDelay <= 0 || this.slides.length <= 1) return;
                
                this.pauseAutoPlay();
                this.startProgress();
                
                this.autoPlayTimer = setInterval(() => {
                    this.next();
                }, this.autoPlayDelay);
            }
            
            pauseAutoPlay() {
                if (this.autoPlayTimer) {
                    clearInterval(this.autoPlayTimer);
                    this.autoPlayTimer = null;
                }
                this.pauseProgress();
            }
            
            startProgress() {
                if (!this.progressBar) return;
                
                let progress = 0;
                const increment = 100 / (this.autoPlayDelay / 50);
                
                this.progressBar.style.width = '0%';
                
                this.progressInterval = setInterval(() => {
                    progress += increment;
                    if (progress >= 100) {
                        progress = 0;
                    }
                    this.progressBar.style.width = `${progress}%`;
                }, 50);
            }
            
            pauseProgress() {
                if (this.progressInterval) {
                    clearInterval(this.progressInterval);
                    this.progressInterval = null;
                }
            }
            
            resetProgress() {
                if (!this.progressBar) return;
                this.progressBar.style.width = '0%';
                this.pauseProgress();
                if (this.autoPlayTimer) {
                    this.startProgress();
                }
            }
            
            initTouchSupport() {
                let startX = 0;
                let endX = 0;
                
                this.track.addEventListener('touchstart', (e) => {
                    startX = e.touches[0].clientX;
                    this.pauseAutoPlay();
                }, { passive: true });
                
                this.track.addEventListener('touchmove', (e) => {
                    endX = e.touches[0].clientX;
                }, { passive: true });
                
                this.track.addEventListener('touchend', () => {
                    const diff = startX - endX;
                    const threshold = 50;
                    
                    if (Math.abs(diff) > threshold) {
                        if (diff > 0) {
                            this.next();
                        } else {
                            this.prev();
                        }
                    }
                    
                    this.startAutoPlay();
                });
            }
        }
        
        let eventosCarousel, equiposCarousel;

        document.addEventListener('DOMContentLoaded', function() {
            console.log('Initializing carousels...');

            // Initialize events carousel
            try {
                eventosCarousel = new Carousel('eventosTrack', 'eventosDots', 'eventosProgress', 6000);
                console.log('Events carousel initialized');
            } catch (error) {
                console.error('Error initializing events carousel:', error);
            }

            // Initialize teams carousel
            try {
                equiposCarousel = new Carousel('equiposTrack', 'equiposDots', 'equiposProgress', 5000);
                console.log('Teams carousel initialized');
            } catch (error) {
                console.error('Error initializing teams carousel:', error);
            }

            animateProgressCharts();

            const alerts = document.querySelectorAll('[style*="slideInRight"]');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.style.animation = 'slideOutRight 0.3s ease forwards';
                setTimeout(() => alert.remove(), 300);
            }, 3000);
        });


        });
        
        function animateProgressCharts() {
            const charts = document.querySelectorAll('.progress-chart-card');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const card = entry.target;
                        const percentage = parseInt(card.dataset.percentage);
                        const progressCircle = card.querySelector('.progress');
                        
                        if (progressCircle) {
                            const circumference = 251;
                            const offset = circumference - (percentage / 100) * circumference;
                            
                            setTimeout(() => {
                                progressCircle.style.strokeDashoffset = offset;
                            }, 300);
                        }
                        
                        observer.unobserve(card);
                    }
                });
            }, { threshold: 0.5 });
            
            charts.forEach(chart => observer.observe(chart));
        }
    </script>
@endsection