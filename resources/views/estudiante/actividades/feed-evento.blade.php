@extends('layouts.appEstudiante')

@section('content')

<div class="feed-page">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="header-section">
            <h2>Feed de Actividad</h2>
            <p>{{ $evento->nombre }}</p>
        </div>

        <!-- Timeline de Actividades -->
        <div class="main-card">
            @if($actividades->isEmpty())
                <div class="empty-state">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p>Aún no hay actividades</p>
                </div>
            @else
                <div class="timeline-container">
                    <ul class="timeline-list">
                        @foreach($actividades as $actividad)
                            <li class="timeline-item">
                                @if(!$loop->last)
                                    <span class="timeline-line" aria-hidden="true"></span>
                                @endif
                                
                                <div class="timeline-content-wrapper">
                                    <!-- Icono -->
                                    <div class="icon-circle">
                                        <span>{{ $actividad->icono }}</span>
                                    </div>
                                    
                                    <!-- Contenido -->
                                    <div class="activity-content">
                                        <div class="activity-details">
                                            <p class="activity-text">
                                                <span class="user-name">{{ $actividad->usuario->nombre }}</span>
                                                {{ $actividad->descripcion }}
                                            </p>
                                            @if($actividad->equipo)
                                                <p class="team-info">
                                                    Equipo: {{ $actividad->equipo->nombre }}
                                                </p>
                                            @endif
                                        </div>
                                        <div class="activity-time">
                                            <time datetime="{{ $actividad->created_at }}">{{ $actividad->created_at->diffForHumans() }}</time>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
    
    /* Fondo degradado */
    .feed-page {
        background: linear-gradient(to bottom, #FFFDF4, #FFEEE2);
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
        padding: 3rem 0;
    }
    
    /* Header section */
    .header-section {
        margin-bottom: 2rem;
    }
    
    .header-section h2 {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
        font-size: 1.875rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
    }
    
    .header-section p {
        font-family: 'Poppins', sans-serif;
        color: #6b6b6b;
        font-size: 1rem;
        margin: 0;
    }
    
    /* Main card */
    .main-card {
        background: #FFEEE2;
        border-radius: 20px;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
        padding: 2rem;
    }
    
    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
    }
    
    .empty-state svg {
        margin: 0 auto 1rem;
        width: 4rem;
        height: 4rem;
        color: #9ca3af;
    }
    
    .empty-state p {
        font-family: 'Poppins', sans-serif;
        color: #9ca3af;
        font-size: 1rem;
        margin: 0;
    }
    
    /* Timeline */
    .timeline-container {
        position: relative;
    }
    
    .timeline-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .timeline-item {
        position: relative;
        padding-bottom: 2rem;
    }
    
    .timeline-item:last-child {
        padding-bottom: 0;
    }
    
    /* Timeline line */
    .timeline-line {
        position: absolute;
        top: 2rem;
        left: 1rem;
        margin-left: -1px;
        height: calc(100% - 2rem);
        width: 2px;
        background: linear-gradient(180deg, rgba(232, 154, 60, 0.3), rgba(232, 154, 60, 0.1));
    }
    
    /* Timeline content wrapper */
    .timeline-content-wrapper {
        position: relative;
        display: flex;
        gap: 1rem;
    }
    
    /* Icon circle */
    .icon-circle {
        flex-shrink: 0;
        width: 2rem;
        height: 2rem;
        border-radius: 50%;
        background: linear-gradient(135deg, rgba(224, 231, 255, 0.9), rgba(199, 210, 254, 0.9));
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        position: relative;
        z-index: 2;
    }
    
    .icon-circle::before {
        content: '';
        position: absolute;
        inset: -4px;
        border-radius: 50%;
        background: #FFEEE2;
        z-index: -1;
    }
    
    .icon-circle span {
        font-size: 1.125rem;
    }
    
    /* Activity content */
    .activity-content {
        flex: 1;
        min-width: 0;
        display: flex;
        justify-content: space-between;
        gap: 1rem;
        align-items: flex-start;
        padding-top: 0.25rem;
    }
    
    .activity-details {
        flex: 1;
        min-width: 0;
    }
    
    .activity-text {
        font-family: 'Poppins', sans-serif;
        color: #4b5563;
        font-size: 0.875rem;
        line-height: 1.5;
        margin: 0;
    }
    
    .activity-text .user-name {
        font-weight: 600;
        color: #2c2c2c;
    }
    
    .team-info {
        font-family: 'Poppins', sans-serif;
        color: #9ca3af;
        font-size: 0.75rem;
        margin: 0.25rem 0 0 0;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    .team-info::before {
        content: '👥';
        font-size: 0.875rem;
    }
    
    /* Timestamp */
    .activity-time {
        flex-shrink: 0;
        text-align: right;
    }
    
    .activity-time time {
        font-family: 'Poppins', sans-serif;
        color: #9ca3af;
        font-size: 0.75rem;
        white-space: nowrap;
    }
    
    /* Activity card variation */
    .activity-card {
        background: rgba(255, 255, 255, 0.3);
        border-radius: 12px;
        padding: 1rem;
        box-shadow: inset 2px 2px 4px #e6d5c9, inset -2px -2px 4px #ffffff;
        margin-bottom: 1rem;
    }
    
    .activity-card:last-child {
        margin-bottom: 0;
    }
    
    .activity-card .timeline-content-wrapper {
        gap: 0.75rem;
    }
    
    .activity-card .icon-circle {
        width: 2.5rem;
        height: 2.5rem;
    }
    
    .activity-card .icon-circle span {
        font-size: 1.25rem;
    }
    
    /* Responsive */
    @media (max-width: 640px) {
        .feed-page {
            padding: 1.5rem 0;
        }
        
        .main-card {
            padding: 1.5rem;
        }
        
        .header-section h2 {
            font-size: 1.5rem;
        }
        
        .activity-content {
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .activity-time {
            text-align: left;
        }
        
        .timeline-item {
            padding-bottom: 1.5rem;
        }
    }
</style>
@endsection