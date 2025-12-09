@extends('layouts.prueba')

@section('content')

<div class="equipo-detalle-page">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="page-header">
            <div class="header-info">
                <a href="{{ route('dashboard') }}" class="back-link">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Volver al Dashboard
                </a>
                <h2>{{ $equipo->nombre }}</h2>
                <p>Evento: {{ $evento->nombre }}</p>
            </div>
            @if($inscripcion->proyecto)
                <a href="{{ route('jurado.evaluaciones.create', $inscripcion) }}" class="btn-evaluar">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Evaluar Proyecto
                </a>
            @endif
        </div>

        @if($proyecto)
            {{-- Información del Proyecto --}}
            <div class="neu-card">
                <h3 class="card-title">
                    <span class="card-title-icon">📁</span>
                    {{ $proyecto->nombre }}
                </h3>
                
                @if($proyecto->descripcion_tecnica)
                    <div class="proyecto-section">
                        <h4 class="section-label">Descripción Técnica</h4>
                        <p class="section-content">{{ $proyecto->descripcion_tecnica }}</p>
                    </div>
                @endif

                @if($proyecto->repositorio_url)
                    <div class="proyecto-section">
                        <h4 class="section-label">Repositorio</h4>
                        <a href="{{ $proyecto->repositorio_url }}" target="_blank" class="repo-link">
                            <svg fill="currentColor" viewBox="0 0 20 20">
                                <path d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z"></path>
                                <path d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z"></path>
                            </svg>
                            {{ $proyecto->repositorio_url }}
                        </a>
                    </div>
                @endif

                <div class="card-footer">
                    Proyecto registrado: {{ $proyecto->created_at->format('d/m/Y H:i') }}
                </div>
            </div>

            {{-- Miembros del Equipo --}}
            <div class="neu-card">
                <h3 class="card-title">
                    <span class="card-title-icon">👥</span>
                    Miembros del Equipo
                </h3>
                <div class="miembros-grid">
                    @foreach($inscripcion->miembros as $miembro)
                        <div class="miembro-card">
                            <div class="miembro-avatar">
                                {{ substr($miembro->user->nombre, 0, 1) }}{{ substr($miembro->user->app_paterno, 0, 1) }}
                            </div>
                            <div class="miembro-info">
                                <div class="miembro-nombre">
                                    <span>{{ $miembro->user->nombre }} {{ $miembro->user->app_paterno }}</span>
                                    @if($miembro->es_lider)
                                        <span class="badge-lider">Líder</span>
                                    @endif
                                </div>
                                <p class="miembro-rol">{{ $miembro->rolEquipo->nombre }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Avances del Proyecto --}}
            <div class="neu-card">
                <div class="avances-header">
                    <h3 class="card-title" style="margin-bottom: 0;">
                        <span class="card-title-icon">📈</span>
                        Avances Registrados
                    </h3>
                    <span class="avances-count">{{ $proyecto->avances->count() }}</span>
                </div>

                @forelse($proyecto->avances->sortByDesc('created_at') as $avance)
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            
                            <div class="avance-card">
                                <div class="avance-header">
                                    @if($avance->titulo)
                                        <h4 class="avance-titulo">{{ $avance->titulo }}</h4>
                                    @endif
                                    <div class="avance-meta">
                                        <span>Por <span class="meta-autor">{{ $avance->registradoPor->nombre }} {{ $avance->registradoPor->app_paterno }}</span></span>
                                        <span>·</span>
                                        <span>{{ $avance->created_at->format('d/m/Y H:i') }}</span>
                                        <span class="meta-time">({{ $avance->created_at->diffForHumans() }})</span>
                                    </div>
                                </div>

                                <div class="avance-descripcion">{{ $avance->descripcion }}</div>

                                @if($avance->archivo_evidencia)
                                    <div class="avance-archivo">
                                        <a href="{{ Storage::url($avance->archivo_evidencia) }}" target="_blank" class="archivo-link">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                            </svg>
                                            Ver archivo adjunto
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h4>No hay avances registrados aún</h4>
                        <p>El equipo aún no ha reportado avances en su proyecto</p>
                    </div>
                @endforelse
            </div>

        @else
            {{-- Sin Proyecto --}}
            <div class="alert-sin-proyecto">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                <div class="alert-content">
                    <h3>Este equipo aún no ha creado su proyecto</h3>
                    <p>El líder del equipo debe crear el proyecto para comenzar a registrar avances.</p>
                </div>
            </div>
        @endif
    </div>
</div>


<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

    .equipo-detalle-page {
        background: linear-gradient(to bottom, #FFFDF4, #FFEEE2);
        min-height: 100vh;
        padding: 3rem 1rem;
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
        margin-bottom: 1rem;
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
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .header-info h2 {
        font-family: 'Poppins', sans-serif;
        font-size: 1.75rem;
        font-weight: 700;
        color: #2c2c2c;
        margin: 0 0 0.25rem 0;
    }

    .header-info p {
        font-family: 'Poppins', sans-serif;
        font-size: 0.875rem;
        color: #6b7280;
        margin: 0;
    }

    /* Botón evaluar proyecto */
    .btn-evaluar {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        border-radius: 20px;
        background: linear-gradient(135deg, #8b5cf6, #a78bfa);
        color: white;
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 0.9rem;
        text-decoration: none;
        box-shadow: 4px 4px 8px rgba(139, 92, 246, 0.3);
        transition: all 0.3s ease;
    }

    .btn-evaluar:hover {
        transform: translateY(-2px);
        box-shadow: 6px 6px 12px rgba(139, 92, 246, 0.4);
        color: white;
    }

    .btn-evaluar svg {
        width: 1.25rem;
        height: 1.25rem;
    }

    /* Cards neuromórficas */
    .neu-card {
        background: #FFEEE2;
        border-radius: 20px;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .card-title {
        font-family: 'Poppins', sans-serif;
        font-size: 1.25rem;
        font-weight: 700;
        color: #2c2c2c;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .card-title-icon {
        font-size: 1.5rem;
    }

    /* Proyecto info */
    .proyecto-section {
        margin-bottom: 1rem;
    }

    .section-label {
        font-family: 'Poppins', sans-serif;
        font-size: 0.875rem;
        font-weight: 600;
        color: #6b7280;
        margin-bottom: 0.5rem;
    }

    .section-content {
        font-family: 'Poppins', sans-serif;
        font-size: 0.95rem;
        color: #2c2c2c;
        line-height: 1.6;
    }

    .repo-link {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: #e89a3c;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .repo-link:hover {
        color: #d98a2c;
    }

    .repo-link svg {
        width: 1.25rem;
        height: 1.25rem;
    }

    .card-footer {
        font-size: 0.8rem;
        color: #9ca3af;
        padding-top: 1rem;
        border-top: 1px solid rgba(0, 0, 0, 0.05);
        margin-top: 1rem;
        font-family: 'Poppins', sans-serif;
    }

    /* Miembros grid */
    .miembros-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1rem;
    }

    .miembro-card {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: rgba(255, 255, 255, 0.4);
        border-radius: 12px;
        box-shadow: inset 2px 2px 4px #e6d5c9, inset -2px -2px 4px #ffffff;
        transition: all 0.3s ease;
    }

    .miembro-card:hover {
        transform: translateY(-2px);
    }

    .miembro-avatar {
        width: 3rem;
        height: 3rem;
        border-radius: 50%;
        background: linear-gradient(135deg, #e89a3c, #f5a847);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1.125rem;
        box-shadow: 4px 4px 8px rgba(232, 154, 60, 0.3);
        flex-shrink: 0;
    }

    .miembro-info {
        flex: 1;
    }

    .miembro-nombre {
        font-family: 'Poppins', sans-serif;
        font-size: 0.95rem;
        font-weight: 600;
        color: #2c2c2c;
        margin-bottom: 0.25rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .badge-lider {
        display: inline-block;
        padding: 0.25rem 0.5rem;
        background: linear-gradient(135deg, rgba(251, 191, 36, 0.8), rgba(245, 158, 11, 0.8));
        color: #78350f;
        font-size: 0.7rem;
        font-weight: 600;
        border-radius: 8px;
        box-shadow: 2px 2px 4px rgba(251, 191, 36, 0.3);
    }

    .miembro-rol {
        font-family: 'Poppins', sans-serif;
        font-size: 0.8rem;
        color: #6b7280;
    }

    /* Avances section */
    .avances-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .avances-count {
        font-size: 2rem;
        font-weight: 800;
        color: #e89a3c;
        font-family: 'Poppins', sans-serif;
    }

    /* Timeline neuromórfico */
    .timeline {
        position: relative;
        padding-left: 2rem;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 0.5rem;
        top: 0;
        bottom: 2rem;
        width: 2px;
        background: linear-gradient(to bottom, #e89a3c, transparent);
    }

    .timeline-item {
        position: relative;
        padding-bottom: 2rem;
    }

    .timeline-item:last-child {
        padding-bottom: 0;
    }

    .timeline-item:last-child::after {
        display: none;
    }

    .timeline-dot {
        position: absolute;
        left: -1.5rem;
        top: 0;
        width: 1rem;
        height: 1rem;
        background: linear-gradient(135deg, #e89a3c, #f5a847);
        border-radius: 50%;
        box-shadow: 0 0 0 4px #FFEEE2, 4px 4px 8px rgba(232, 154, 60, 0.3);
        z-index: 1;
    }

    .avance-card {
        background: rgba(255, 255, 255, 0.4);
        border-radius: 16px;
        padding: 1.25rem;
        box-shadow: inset 3px 3px 6px #e6d5c9, inset -3px -3px 6px #ffffff;
    }

    .avance-header {
        margin-bottom: 0.75rem;
    }

    .avance-titulo {
        font-family: 'Poppins', sans-serif;
        font-size: 1.125rem;
        font-weight: 600;
        color: #2c2c2c;
        margin-bottom: 0.5rem;
    }

    .avance-meta {
        font-family: 'Poppins', sans-serif;
        font-size: 0.8rem;
        color: #6b7280;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .meta-autor {
        font-weight: 500;
        color: #2c2c2c;
    }

    .meta-time {
        color: #9ca3af;
        font-size: 0.75rem;
    }

    .avance-descripcion {
        font-family: 'Poppins', sans-serif;
        font-size: 0.9rem;
        color: #2c2c2c;
        line-height: 1.6;
        white-space: pre-line;
        margin-bottom: 0.75rem;
    }

    .avance-archivo {
        padding-top: 0.75rem;
        border-top: 1px solid rgba(0, 0, 0, 0.05);
    }

    .archivo-link {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: #e89a3c;
        font-family: 'Poppins', sans-serif;
        font-size: 0.875rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .archivo-link:hover {
        color: #d98a2c;
    }

    .archivo-link svg {
        width: 1.25rem;
        height: 1.25rem;
    }

    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        background: rgba(255, 255, 255, 0.3);
        border-radius: 16px;
        box-shadow: inset 2px 2px 4px #e6d5c9, inset -2px -2px 4px #ffffff;
    }

    .empty-state svg {
        width: 4rem;
        height: 4rem;
        color: #e89a3c;
        margin: 0 auto 1rem;
        opacity: 0.4;
    }

    .empty-state h4 {
        font-family: 'Poppins', sans-serif;
        font-size: 1.125rem;
        font-weight: 600;
        color: #2c2c2c;
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        font-family: 'Poppins', sans-serif;
        font-size: 0.875rem;
        color: #6b7280;
    }

    /* Alert sin proyecto */
    .alert-sin-proyecto {
        background: linear-gradient(135deg, rgba(254, 243, 199, 0.8), rgba(253, 230, 138, 0.8));
        border-left: 4px solid #f59e0b;
        border-radius: 16px;
        padding: 1.5rem;
        display: flex;
        align-items: start;
        gap: 1rem;
        box-shadow: 4px 4px 8px rgba(245, 158, 11, 0.2);
    }

    .alert-sin-proyecto svg {
        width: 1.5rem;
        height: 1.5rem;
        color: #d97706;
        flex-shrink: 0;
    }

    .alert-content h3 {
        font-family: 'Poppins', sans-serif;
        font-size: 1rem;
        font-weight: 600;
        color: #92400e;
        margin-bottom: 0.5rem;
    }

    .alert-content p {
        font-family: 'Poppins', sans-serif;
        font-size: 0.875rem;
        color: #b45309;
        margin: 0;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .equipo-detalle-page {
            padding: 2rem 0.75rem;
        }

        .page-header {
            flex-direction: column;
        }

        .header-info h2 {
            font-size: 1.5rem;
        }

        .miembros-grid {
            grid-template-columns: 1fr;
        }

        .btn-evaluar {
            width: 100%;
            justify-content: center;
        }
    }
</style>

@endsection