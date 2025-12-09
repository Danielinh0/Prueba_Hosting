@extends('jurado.layouts.app')

@section('content')

    <div class="jurado-dashboard">
        <!-- Welcome Banner -->
        <div class="welcome-banner animate-in">
            <svg class="welcome-svg" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="50" cy="50" r="45" stroke="white" stroke-width="2"/>
                <path d="M50 20 L50 50 L70 60" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                <circle cx="50" cy="50" r="5" fill="white"/>
            </svg>
            <h2>¡Hola, <span class="welcome-highlight">{{ Auth::user()->nombre }}</span>!</h2>
            <p>Panel de evaluación de jurado - {{ now()->format('d \d\e F, Y') }}</p>
        </div>

        <div class="dashboard-container">
            <section class="left-col">
                <!-- Stats Grid -->
                <h3 class="section-title animate-in">
                    <i class="fas fa-chart-bar"></i>
                    Resumen General
                </h3>
                
                <div class="stats-grid animate-in delay-1">
                    <div class="stat-card">
                        <div class="stat-icon orange">
                            <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" width="28" height="28">
                                <rect x="15" y="15" width="70" height="70" rx="8" stroke="white" stroke-width="4"/>
                                <path d="M30 35 L70 35" stroke="white" stroke-width="4" stroke-linecap="round"/>
                                <path d="M30 50 L55 50" stroke="white" stroke-width="4" stroke-linecap="round"/>
                                <path d="M30 65 L45 65" stroke="white" stroke-width="4" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <div class="stat-value">{{ $estadisticas['eventosActivos'] }}</div>
                        <div class="stat-label">Eventos Activos</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon blue">
                            <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" width="28" height="28">
                                <circle cx="50" cy="35" r="18" stroke="white" stroke-width="4"/>
                                <path d="M20 85 C20 60 80 60 80 85" stroke="white" stroke-width="4" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <div class="stat-value">{{ $estadisticas['totalEquipos'] }}</div>
                        <div class="stat-label">Equipos Asignados</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon green">
                            <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" width="28" height="28">
                                <circle cx="50" cy="50" r="38" stroke="white" stroke-width="4"/>
                                <path d="M30 50 L45 65 L70 35" stroke="white" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <div class="stat-value">{{ $estadisticas['evaluacionesCompletadas'] }}</div>
                        <div class="stat-label">Evaluaciones Finalizadas</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon purple">
                            <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" width="28" height="28">
                                <rect x="15" y="40" width="25" height="45" rx="4" stroke="white" stroke-width="4"/>
                                <rect x="55" y="20" width="25" height="65" rx="4" stroke="white" stroke-width="4"/>
                            </svg>
                        </div>
                        <div class="stat-value">{{ $estadisticas['avancesPorCalificar'] }}</div>
                        <div class="stat-label">Avances por Calificar</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon yellow">
                            <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" width="28" height="28">
                                <rect x="20" y="10" width="60" height="80" rx="6" stroke="white" stroke-width="4"/>
                                <path d="M35 30 L65 30" stroke="white" stroke-width="3"/>
                                <path d="M35 45 L65 45" stroke="white" stroke-width="3"/>
                                <path d="M35 60 L55 60" stroke="white" stroke-width="3"/>
                                <path d="M35 75 L50 75" stroke="white" stroke-width="3"/>
                            </svg>
                        </div>
                        <div class="stat-value">{{ $estadisticas['borradores'] }}</div>
                        <div class="stat-label">Borradores Guardados</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon red">
                            <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" width="28" height="28">
                                <rect x="20" y="10" width="60" height="80" rx="6" stroke="white" stroke-width="4"/>
                                <path d="M35 30 L65 30" stroke="white" stroke-width="3"/>
                                <circle cx="35" cy="48" r="5" fill="white"/>
                                <path d="M48 48 L65 48" stroke="white" stroke-width="3"/>
                                <circle cx="35" cy="66" r="5" fill="white"/>
                                <path d="M48 66 L65 66" stroke="white" stroke-width="3"/>
                            </svg>
                        </div>
                        <div class="stat-value">{{ $estadisticas['evalFinalPendiente'] }}</div>
                        <div class="stat-label">Eval. Final Pendiente</div>
                    </div>
                </div>

                <!-- Carrusel de Eventos Asignados -->
                <h3 class="section-title animate-in delay-2">
                    <i class="fas fa-calendar-alt"></i>
                    Eventos Asignados
                </h3>

                @if($eventosAsignados->count() > 0)
                    <div class="carousel-container animate-in delay-2" id="eventosCarousel">
                        <div class="carousel-track-container">
                            <div class="carousel-track" id="eventosTrack">
                                @foreach($eventosAsignados as $evento)
                                    <div class="carousel-slide">
                                        <div class="neu-card" style="margin-bottom: 0;">
                                            <div class="event-card-header">
                                                <span class="event-badge {{ strtolower(str_replace(' ', '', $evento->estado)) }}">
                                                    <i class="fas fa-{{ $evento->estado === 'Activo' ? 'bolt' : ($evento->estado === 'En Progreso' ? 'spinner' : 'flag-checkered') }}"></i>
                                                    {{ $evento->estado }}
                                                </span>
                                                {{ $evento->nombre }}
                                            </div>
                                            <div class="event-card-body">
                                                <p class="event-desc">{{ Str::limit($evento->descripcion ?? 'Sin descripción disponible', 100) }}</p>
                                                <div class="event-meta">
                                                    <p class="event-date">
                                                        <i class="fas fa-calendar-alt"></i>
                                                        {{ $evento->fecha_inicio ? $evento->fecha_inicio->format('d M, Y') : 'Sin fecha' }}
                                                    </p>
                                                    <p class="event-participants">
                                                        <i class="fas fa-users"></i>
                                                        {{ $evento->inscripciones_count }} equipos
                                                    </p>
                                                </div>
                                                <a href="{{ route('jurado.eventos.show', $evento->id_evento) }}" class="event-link">
                                                    Ver equipos <i class="fas fa-arrow-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <div class="carousel-nav">
                            <button class="carousel-arrow prev" onclick="eventosCarousel.prev()">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15 6L9 12L15 18" stroke="#e89a3c" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                            <div class="carousel-dots" id="eventosDots"></div>
                            <button class="carousel-arrow next" onclick="eventosCarousel.next()">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9 6L15 12L9 18" stroke="#e89a3c" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>
                        <div class="carousel-progress">
                            <div class="carousel-progress-bar" id="eventosProgress"></div>
                        </div>
                    </div>
                @else
                    <div class="neu-card animate-in delay-2" style="padding: 1.5rem;">
                        <div class="empty-state">
                            <i class="fas fa-calendar-times"></i>
                            <p>No tienes eventos asignados actualmente.</p>
                        </div>
                    </div>
                @endif

                <!-- Borradores Section -->
                @if($borradores->count() > 0)
                    <h3 class="section-title animate-in delay-3">
                        <i class="fas fa-file-alt"></i>
                        Borradores Guardados
                    </h3>
                    <div class="animate-in delay-3">
                        @foreach($borradores->take(3) as $borrador)
                            <div class="borrador-card">
                                <div class="borrador-header">
                                    <h4 class="borrador-title">{{ $borrador->equipo->nombre }}</h4>
                                    <span class="borrador-time">{{ $borrador->updated_at->diffForHumans() }}</span>
                                </div>
                                <p class="borrador-meta">
                                    <i class="fas fa-flag"></i> {{ $borrador->evento->nombre ?? 'Evento' }}
                                    @if($borrador->proyecto)
                                        · <i class="fas fa-project-diagram"></i> {{ Str::limit($borrador->proyecto->nombre, 25) }}
                                    @endif
                                </p>
                                <a href="{{ route('jurado.eventos.equipo_evento', ['evento' => $borrador->evento->id_evento ?? 0, 'equipo' => $borrador->equipo->id_equipo]) }}" class="borrador-btn">
                                    <i class="fas fa-edit"></i> Retomar evaluación
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>

            <section class="right-col">
                <!-- Carrusel de Evaluaciones Pendientes -->
                <h3 class="section-title animate-in">
                    <i class="fas fa-clipboard-check"></i>
                    Evaluaciones Pendientes
                </h3>

                @if($evaluacionesPendientes->count() > 0)
                    <div class="carousel-container animate-in delay-1" id="evalCarousel">
                        <div class="carousel-track-container">
                            <div class="carousel-track" id="evalTrack">
                                @foreach($evaluacionesPendientes as $pendiente)
                                    <div class="carousel-slide">
                                        <div class="eval-card" style="margin-bottom: 0;">
                                            <div class="eval-header">
                                                <div class="eval-avatar">
                                                    <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" width="26" height="26">
                                                        <circle cx="50" cy="32" r="16" stroke="white" stroke-width="4"/>
                                                        <path d="M22 82 C22 58 78 58 78 82" stroke="white" stroke-width="4" stroke-linecap="round"/>
                                                    </svg>
                                                </div>
                                                <div class="eval-info">
                                                    <h4>{{ $pendiente->equipo->nombre ?? 'Equipo' }}</h4>
                                                    <p>{{ $pendiente->evento->nombre ?? 'Evento' }}</p>
                                                </div>
                                            </div>
                                            
                                            @if($pendiente->totalAvances > 0)
                                                <div class="eval-progress">
                                                    <div class="progress-bar-container">
                                                        @php
                                                            $porcentaje = ($pendiente->avancesCalificados / $pendiente->totalAvances) * 100;
                                                        @endphp
                                                        <div class="progress-bar {{ $porcentaje == 100 ? 'complete' : '' }}" style="width: {{ $porcentaje }}%"></div>
                                                    </div>
                                                    <span class="progress-text">{{ $pendiente->avancesCalificados }}/{{ $pendiente->totalAvances }}</span>
                                                </div>
                                            @endif
                                            
                                            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem;">
                                                @if($pendiente->tieneBorrador)
                                                    <span class="eval-status borrador">
                                                        <i class="fas fa-file-alt"></i> Borrador guardado
                                                    </span>
                                                @elseif($pendiente->totalAvances === 0)
                                                    <span class="eval-status sin-avances">
                                                        <i class="fas fa-inbox"></i> No hay avances
                                                    </span>
                                                @elseif($pendiente->todosAvancesCalificados)
                                                    <span class="eval-status listo">
                                                        <i class="fas fa-check-circle"></i> Listo para evaluar
                                                    </span>
                                                @else
                                                    <span class="eval-status pendiente">
                                                        <i class="fas fa-clock"></i> Avances pendientes
                                                    </span>
                                                @endif
                                                
                                                <a href="{{ route('jurado.eventos.equipo_evento', ['evento' => $pendiente->evento->id_evento, 'equipo' => $pendiente->equipo->id_equipo]) }}" class="event-link">
                                                    Evaluar <i class="fas fa-arrow-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <div class="carousel-nav">
                            <button class="carousel-arrow prev" onclick="evalCarousel.prev()">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15 6L9 12L15 18" stroke="#e89a3c" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                            <div class="carousel-dots" id="evalDots"></div>
                            <button class="carousel-arrow next" onclick="evalCarousel.next()">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9 6L15 12L9 18" stroke="#e89a3c" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>
                        <div class="carousel-progress">
                            <div class="carousel-progress-bar" id="evalProgress"></div>
                        </div>
                    </div>
                @else
                    <div class="neu-card animate-in delay-1" style="padding: 1.5rem;">
                        <div class="empty-state">
                            <i class="fas fa-clipboard-check"></i>
                            <p>¡Excelente! No tienes evaluaciones pendientes.</p>
                        </div>
                    </div>
                @endif

                <!-- Quick Actions -->
                <h3 class="section-title animate-in delay-2" style="margin-top: 2rem;">
                    <i class="fas fa-bolt"></i>
                    Acciones Rápidas
                </h3>
                
                <div class="quick-actions animate-in delay-2">
                    <a href="{{ route('jurado.eventos.index') }}" class="action-card">
                        <div class="action-icon" style="background: linear-gradient(135deg, #e89a3c, #d98a2c);">
                            <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" width="26" height="26">
                                <rect x="15" y="15" width="70" height="70" rx="8" stroke="white" stroke-width="4"/>
                                <path d="M30 35 L70 35" stroke="white" stroke-width="4" stroke-linecap="round"/>
                                <path d="M30 50 L55 50" stroke="white" stroke-width="4" stroke-linecap="round"/>
                                <path d="M30 65 L45 65" stroke="white" stroke-width="4" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <div class="action-content">
                            <h4>MIS EVENTOS</h4>
                            <p>Ver todos los eventos</p>
                        </div>
                    </a>
                    
                    @if($eventosAsignados->whereIn('estado', ['Activo', 'En Progreso'])->first())
                        <a href="{{ route('jurado.eventos.show', $eventosAsignados->whereIn('estado', ['Activo', 'En Progreso'])->first()->id_evento) }}" class="action-card">
                            <div class="action-icon" style="background: linear-gradient(135deg, #10b981, #059669);">
                                <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" width="26" height="26">
                                    <circle cx="35" cy="35" r="14" stroke="white" stroke-width="4"/>
                                    <circle cx="65" cy="35" r="14" stroke="white" stroke-width="4"/>
                                    <path d="M15 80 C15 62 55 62 55 80" stroke="white" stroke-width="4" stroke-linecap="round"/>
                                    <path d="M45 80 C45 62 85 62 85 80" stroke="white" stroke-width="4" stroke-linecap="round"/>
                                </svg>
                            </div>
                            <div class="action-content">
                                <h4>EVALUAR EQUIPOS</h4>
                                <p>Evento activo</p>
                            </div>
                        </a>
                    @else
                        <div class="action-card" style="opacity: 0.6; cursor: not-allowed;">
                            <div class="action-icon" style="background: linear-gradient(135deg, #E8C99B, #D4A96A);">
                                <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" width="26" height="26">
                                    <circle cx="35" cy="35" r="14" stroke="white" stroke-width="4"/>
                                    <circle cx="65" cy="35" r="14" stroke="white" stroke-width="4"/>
                                    <path d="M15 80 C15 62 55 62 55 80" stroke="white" stroke-width="4" stroke-linecap="round"/>
                                    <path d="M45 80 C45 62 85 62 85 80" stroke="white" stroke-width="4" stroke-linecap="round"/>
                                </svg>
                            </div>
                            <div class="action-content">
                                <h4>EVALUAR EQUIPOS</h4>
                                <p>Sin eventos activos</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Evaluaciones Recientes -->
                <h3 class="section-title animate-in delay-3" style="margin-top: 1rem;">
                    <i class="fas fa-history"></i>
                    Evaluaciones Recientes
                </h3>
                
                <div class="neu-card animate-in delay-3" style="padding: 1.25rem;">
                    @if($evaluacionesRecientes->count() > 0)
                        @foreach($evaluacionesRecientes as $reciente)
                            <div class="recent-item">
                                <div class="recent-icon success">
                                    <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" width="18" height="18">
                                        <path d="M20 50 L40 70 L80 25" stroke="white" stroke-width="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <div class="recent-info">
                                    <h5>{{ $reciente->inscripcion->equipo->nombre ?? 'Equipo' }}</h5>
                                    <p>{{ $reciente->inscripcion->evento->nombre ?? 'Evento' }} · {{ $reciente->updated_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="empty-state" style="padding: 1.5rem;">
                            <i class="fas fa-history"></i>
                            <p>Aún no has completado evaluaciones.</p>
                        </div>
                    @endif
                </div>
            </section>
        </div>
    </div>

    <script>
        class Carousel {
            constructor(trackId, dotsId, progressId, autoPlayDelay = 5000) {
                this.track = document.getElementById(trackId);
                this.dotsContainer = document.getElementById(dotsId);
                this.progressBar = document.getElementById(progressId);
                
                if (!this.track) return;
                
                this.slides = this.track.querySelectorAll('.carousel-slide');
                this.currentIndex = 0;
                this.autoPlayDelay = autoPlayDelay;
                this.autoPlayTimer = null;
                this.progressInterval = null;
                
                this.init();
            }
            
            init() {
                if (this.slides.length === 0) return;
                
                this.createDots();
                this.updateCarousel();
                
                if (this.autoPlayDelay > 0 && this.slides.length > 1) {
                    this.startAutoPlay();
                }
                
                const container = this.track.closest('.carousel-container');
                if (container) {
                    container.addEventListener('mouseenter', () => this.pauseAutoPlay());
                    container.addEventListener('mouseleave', () => this.startAutoPlay());
                }
                
                this.initTouchSupport();
            }
            
            createDots() {
                if (!this.dotsContainer || this.slides.length <= 1) return;
                
                this.dotsContainer.innerHTML = '';
                this.slides.forEach((_, index) => {
                    const dot = document.createElement('div');
                    dot.classList.add('carousel-dot');
                    if (index === 0) dot.classList.add('active');
                    dot.addEventListener('click', () => this.goTo(index));
                    this.dotsContainer.appendChild(dot);
                });
            }
            
            updateCarousel() {
                this.track.style.transform = `translateX(-${this.currentIndex * 100}%)`;
                
                if (this.dotsContainer) {
                    const dots = this.dotsContainer.querySelectorAll('.carousel-dot');
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
                    if (progress >= 100) progress = 0;
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
                if (this.autoPlayTimer) this.startProgress();
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
                        if (diff > 0) this.next();
                        else this.prev();
                    }
                    
                    this.startAutoPlay();
                });
            }
        }
        
        let eventosCarousel, evalCarousel;
        
        document.addEventListener('DOMContentLoaded', function() {
            eventosCarousel = new Carousel('eventosTrack', 'eventosDots', 'eventosProgress', 6000);
            evalCarousel = new Carousel('evalTrack', 'evalDots', 'evalProgress', 5000);
        });
    </script>



<style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
    
        :root {
            --color-primary: #e89a3c;
            --color-primary-dark: #d98a2c;
            --color-primary-darker: #b87a2a;
            --color-accent-dark: #D4854A;
            --color-accent-light: #F5B97A;
            --color-bg-base: #FFFDF4;
            --color-bg-secondary: #FFEEE2;
            --color-card: #FFEEE2;
            --color-white: #FFFFFF;
            --color-text-primary: #8B6914;
            --color-text-secondary: #A67C3D;
            --color-text-muted: #C9A66B;
            --shadow-light: #ffffff;
            --shadow-dark: #e6d5c9;
        }
        
        body {
            background: linear-gradient(to bottom, #FFFDF4, #FFEEE2) !important;
            min-height: 100vh;
        }

        .jurado-dashboard {
            background: linear-gradient(to bottom, #FFFDF4, #FFEEE2);
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
            padding: 2rem;
        }

        .dashboard-container {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }

        @media (max-width: 1024px) {
            .dashboard-container {
                grid-template-columns: 1fr;
            }
        }

        .left-col, .right-col {
            font-family: 'Poppins', sans-serif;
        }

        /* Títulos de sección */
        .section-title {
            font-family: 'Poppins', sans-serif;
            color: var(--color-text-primary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
            font-size: 1.125rem;
            margin-bottom: 1rem;
        }

        .section-title i {
            color: var(--color-primary);
            font-size: 1.25rem;
        }

        /* =============================================== */
        /* CARRUSEL NEUROMÓRFICO */
        /* =============================================== */
        .carousel-container {
            position: relative;
            width: 100%;
            overflow: visible;
            border-radius: 20px;
            margin-bottom: 2rem;
        }

        .carousel-track-container {
            overflow: hidden;
            border-radius: 20px;
        }

        .carousel-track {
            display: flex;
            transition: transform 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        .carousel-slide {
            min-width: 100%;
            flex-shrink: 0;
            padding: 0 0.25rem;
            box-sizing: border-box;
        }

        .carousel-nav {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            margin-top: 1rem;
        }

        .carousel-arrow {
            position: relative;
            width: 48px;
            height: 48px;
            background: var(--color-card);
            border: none;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            box-shadow: 4px 4px 12px var(--shadow-dark), -4px -4px 8px var(--shadow-light);
        }

        .carousel-arrow svg {
            width: 22px;
            height: 22px;
            transition: all 0.3s ease;
        }

        .carousel-arrow:hover {
            background: linear-gradient(135deg, #F5B97A, #e89a3c);
            box-shadow: 6px 6px 16px var(--shadow-dark), -6px -6px 12px var(--shadow-light);
            transform: translateY(-3px) scale(1.05);
        }

        .carousel-arrow:hover svg path {
            stroke: white;
        }

        .carousel-dots {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
        }

        .carousel-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: rgba(232, 154, 60, 0.3);
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            box-shadow: inset 2px 2px 4px var(--shadow-dark), inset -2px -2px 4px var(--shadow-light);
        }

        .carousel-dot.active {
            background: var(--color-primary);
            width: 24px;
            border-radius: 5px;
            box-shadow: 4px 4px 8px rgba(232, 154, 60, 0.3);
        }

        .carousel-progress {
            height: 4px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 4px;
            margin-top: 0.75rem;
            overflow: hidden;
            box-shadow: inset 2px 2px 4px var(--shadow-dark), inset -2px -2px 4px var(--shadow-light);
        }

        .carousel-progress-bar {
            height: 100%;
            background: linear-gradient(90deg, var(--color-primary), var(--color-primary-dark));
            border-radius: 4px;
            transition: width 0.1s linear;
            width: 0%;
        }

        /* =============================================== */
        /* CARDS NEUROMÓRFICAS */
        /* =============================================== */
        .neu-card {
            background: var(--color-card);
            border-radius: 20px;
            box-shadow: 8px 8px 16px var(--shadow-dark), -8px -8px 16px var(--shadow-light);
            transition: all 0.3s ease;
            border: none;
        }
        
        .neu-card:hover {
            box-shadow: 12px 12px 24px var(--shadow-dark), -12px -12px 24px var(--shadow-light);
            transform: translateY(-5px);
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--color-card);
            border-radius: 16px;
            padding: 1.25rem;
            box-shadow: 8px 8px 16px var(--shadow-dark), -8px -8px 16px var(--shadow-light);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 12px 12px 24px var(--shadow-dark), -12px -12px 24px var(--shadow-light);
        }

        .stat-card {
            position: relative;
            overflow: hidden;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            color: white;
            margin-bottom: 0.75rem;
            box-shadow: 4px 4px 8px var(--shadow-dark), -4px -4px 8px var(--shadow-light);
        }

        .stat-icon.orange { background: linear-gradient(135deg, #e89a3c, #d98a2c); }
        .stat-icon.green { background: linear-gradient(135deg, #10b981, #059669); }
        .stat-icon.blue { background: linear-gradient(135deg, #3b82f6, #1d4ed8); }
        .stat-icon.purple { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
        .stat-icon.red { background: linear-gradient(135deg, #ef4444, #dc2626); }
        .stat-icon.yellow { background: linear-gradient(135deg, #f59e0b, #d97706); }

        .stat-value {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--color-text-primary);
            line-height: 1;
        }

        .stat-label {
            font-size: 0.8rem;
            color: var(--color-text-secondary);
            margin-top: 0.25rem;
        }

        /* Event Cards */
        .event-card-header {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #F5B97A, #e89a3c);
            color: var(--color-white);
            position: relative;
            overflow: hidden;
            border-radius: 20px 20px 0 0;
            padding: 1.25rem;
            font-weight: 600;
        }

        .event-card-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--color-primary), var(--color-primary-dark));
        }

        .event-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            background: linear-gradient(135deg, var(--color-primary), var(--color-primary-dark));
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
            color: var(--color-white);
            z-index: 5;
            box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.2);
        }

        .event-badge.activo { background: linear-gradient(135deg, #10b981, #059669); }
        .event-badge.progreso { background: linear-gradient(135deg, #3b82f6, #1d4ed8); }
        .event-badge.cerrado { background: linear-gradient(135deg, #6b7280, #4b5563); }
        .event-badge.borrador { background: linear-gradient(135deg, #f59e0b, #d97706); }

        .event-card-body {
            background: var(--color-card);
            padding: 1.25rem;
            border-radius: 0 0 20px 20px;
        }

        .event-title {
            font-family: 'Poppins', sans-serif;
            font-size: 1rem;
            font-weight: 600;
            color: var(--color-text-primary);
            margin: 0 0 0.5rem 0;
        }

        .event-desc {
            font-family: 'Poppins', sans-serif;
            color: var(--color-text-secondary);
            font-size: 0.875rem;
            line-height: 1.5;
            margin: 0 0 0.75rem 0;
        }

        .event-meta {
            display: flex;
            gap: 1rem;
            margin-bottom: 0.75rem;
            flex-wrap: wrap;
        }

        .event-date, .event-participants {
            font-family: 'Poppins', sans-serif;
            color: var(--color-text-secondary);
            display: flex;
            align-items: center;
            gap: 0.35rem;
            font-size: 0.75rem;
            margin: 0;
        }

        .event-date i, .event-participants i {
            color: var(--color-primary);
            width: 14px;
            font-size: 0.7rem;
        }

        .event-link {
            font-family: 'Poppins', sans-serif;
            color: var(--color-primary);
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 500;
            text-decoration: none;
            font-size: 0.875rem;
        }

        .event-link:hover {
            color: var(--color-primary-dark);
            gap: 0.75rem;
        }

        /* Evaluation Card */
        .eval-card {
            background: var(--color-card);
            border-radius: 16px;
            padding: 1.25rem;
            margin-bottom: 1rem;
            box-shadow: 8px 8px 16px var(--shadow-dark), -8px -8px 16px var(--shadow-light);
            transition: all 0.3s ease;
        }

        .eval-card:hover {
            transform: translateY(-4px);
            box-shadow: 12px 12px 24px var(--shadow-dark), -12px -12px 24px var(--shadow-light);
        }

        .eval-card {
            position: relative;
            overflow: hidden;
        }

        .eval-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .eval-avatar {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #F5B97A, #e89a3c);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--color-white);
            font-size: 1.25rem;
            box-shadow: 4px 4px 8px var(--shadow-dark), -4px -4px 8px var(--shadow-light);
        }

        .eval-info h4 {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            color: var(--color-text-primary);
            margin: 0;
            font-size: 1rem;
        }

        .eval-info p {
            font-family: 'Poppins', sans-serif;
            font-size: 0.8rem;
            color: var(--color-text-secondary);
            margin: 0;
        }

        .eval-progress {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .progress-bar-container {
            flex: 1;
            height: 8px;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 4px;
            box-shadow: inset 2px 2px 4px var(--shadow-dark), inset -2px -2px 4px var(--shadow-light);
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            background: linear-gradient(90deg, var(--color-primary), var(--color-primary-dark));
            border-radius: 4px;
            transition: width 0.5s ease;
        }

        .progress-bar.complete {
            background: linear-gradient(90deg, var(--color-primary), var(--color-primary-dark));
        }

        .progress-text {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--color-text-primary);
            min-width: 45px;
            text-align: right;
        }

        .eval-status {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .eval-status.pendiente {
            background: linear-gradient(135deg, rgba(254, 240, 138, 0.8), rgba(252, 211, 77, 0.8));
            color: #92400e;
        }

        .eval-status.sin-avances {
            background: linear-gradient(135deg, rgba(209, 213, 219, 0.8), rgba(156, 163, 175, 0.6));
            color: #4b5563;
        }

        .eval-status.listo {
            background: linear-gradient(135deg, rgba(209, 250, 229, 0.8), rgba(167, 243, 208, 0.8));
            color: #065f46;
        }

        .eval-status.borrador {
            background: linear-gradient(135deg, rgba(254, 215, 170, 0.8), rgba(251, 191, 36, 0.8));
            color: #92400e;
        }

        /* Quick Actions */
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .action-card {
            background: var(--color-card);
            border-radius: 16px;
            padding: 1.25rem;
            box-shadow: 8px 8px 16px var(--shadow-dark), -8px -8px 16px var(--shadow-light);
            transition: all 0.3s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .action-card:hover {
            transform: translateY(-4px);
            box-shadow: 12px 12px 24px var(--shadow-dark), -12px -12px 24px var(--shadow-light);
        }

        .action-card {
            position: relative;
            overflow: hidden;
        }

        .action-card::before {
            content: '';
            position: absolute;
            top: -10px;
            right: -10px;
            width: 50px;
            height: 50px;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ccircle cx='50' cy='50' r='35' fill='none' stroke='%23e89a3c' stroke-width='3' stroke-dasharray='10 5' opacity='0.12'/%3E%3C/svg%3E") no-repeat center;
            background-size: contain;
        }

        .action-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            color: white;
            box-shadow: 4px 4px 8px var(--shadow-dark), -4px -4px 8px var(--shadow-light);
        }

        .action-content h4 {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            color: var(--color-text-primary);
            margin: 0;
            font-size: 0.9rem;
        }

        .action-content p {
            font-family: 'Poppins', sans-serif;
            font-size: 0.75rem;
            color: var(--color-text-secondary);
            margin: 0;
        }

        /* Borradores Section */
        .borrador-card {
            background: var(--color-card);
            border-radius: 16px;
            padding: 1rem;
            margin-bottom: 0.75rem;
            box-shadow: 8px 8px 16px var(--shadow-dark), -8px -8px 16px var(--shadow-light);
            border-left: 4px solid #f59e0b;
            transition: all 0.3s ease;
        }

        .borrador-card:hover {
            transform: translateX(8px);
        }

        .borrador-card {
            position: relative;
            overflow: hidden;
        }

        .borrador-card::before {
            content: '';
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            width: 40px;
            height: 40px;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Cpath d='M20 80 L80 20 M70 20 L80 20 L80 30' stroke='%23f59e0b' stroke-width='4' stroke-linecap='round' fill='none' opacity='0.15'/%3E%3C/svg%3E") no-repeat center;
            background-size: contain;
        }

        .borrador-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 0.5rem;
        }

        .borrador-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            color: var(--color-text-primary);
            font-size: 0.9rem;
            margin: 0;
        }

        .borrador-time {
            font-size: 0.7rem;
            color: var(--color-text-muted);
        }

        .borrador-meta {
            font-size: 0.75rem;
            color: var(--color-text-secondary);
            margin-bottom: 0.75rem;
        }

        .borrador-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: linear-gradient(135deg, var(--color-primary), var(--color-primary-dark));
            color: white;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 4px 4px 8px var(--shadow-dark);
        }

        .borrador-btn:hover {
            transform: translateY(-2px);
            box-shadow: 6px 6px 12px var(--shadow-dark);
            color: white;
        }

        /* Recent Activity */
        .recent-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.75rem;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            margin-bottom: 0.5rem;
            box-shadow: inset 4px 4px 8px var(--shadow-dark), inset -4px -4px 8px var(--shadow-light);
        }

        .recent-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            color: white;
        }

        .recent-icon.success { background: linear-gradient(135deg, #10b981, #059669); }

        .recent-info {
            flex: 1;
        }

        .recent-info h5 {
            font-family: 'Poppins', sans-serif;
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--color-text-primary);
            margin: 0;
        }

        .recent-info p {
            font-family: 'Poppins', sans-serif;
            font-size: 0.7rem;
            color: var(--color-text-secondary);
            margin: 0;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 2.5rem 1rem;
            color: var(--color-text-muted);
        }

        .empty-state i {
            font-size: 3rem;
            color: var(--color-primary);
            margin-bottom: 1rem;
            opacity: 0.4;
        }

        .empty-state p {
            font-family: 'Poppins', sans-serif;
            color: var(--color-text-muted);
            font-size: 0.9375rem;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-in {
            animation: fadeInUp 0.6s ease forwards;
        }

        .delay-1 { animation-delay: 0.1s; opacity: 0; }
        .delay-2 { animation-delay: 0.2s; opacity: 0; }
        .delay-3 { animation-delay: 0.3s; opacity: 0; }
        .delay-4 { animation-delay: 0.4s; opacity: 0; }

        /* Welcome Banner */
        .welcome-banner {
            background: linear-gradient(135deg, #F5B97A, #e89a3c);
            border-radius: 20px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            color: white;
            position: relative;
            overflow: hidden;
            box-shadow: 8px 8px 16px var(--shadow-dark), -8px -8px 16px var(--shadow-light);
        }

        .welcome-banner::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 150px;
            height: 150px;
            background: linear-gradient(135deg, var(--color-primary), var(--color-primary-dark));
            border-radius: 50%;
            transform: translate(50%, -50%);
            opacity: 0.3;
        }

        .welcome-banner .welcome-svg {
            position: absolute;
            bottom: -5px;
            left: 20px;
            width: 90px;
            height: 90px;
            opacity: 0.25;
        }

        .welcome-banner h2 {
            font-family: 'Poppins', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0 0 0.5rem;
        }

        .welcome-banner p {
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
            opacity: 0.8;
            margin: 0;
        }

        .welcome-highlight {
            color: #292929ff;
        }
    </style>
@endsection
