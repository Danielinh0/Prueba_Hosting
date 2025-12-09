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

@endsection