@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
    
    /* Fondo degradado */
    .avances-page {
        background: linear-gradient(to bottom, #FFFDF4, #FFEEE2);
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
    }
    
    /* Textos */
    .avances-page h2,
    .avances-page h3,
    .avances-page h4 {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
    }
    
    .avances-page p {
        font-family: 'Poppins', sans-serif;
        color: #6b6b6b;
    }
    
    .avances-page a {
        font-family: 'Poppins', sans-serif;
        transition: all 0.2s ease;
    }
    
    /* Links normales */
    .link-accent {
        color: #e89a3c;
    }
    
    .link-accent:hover {
        color: #d98a2c;
        opacity: 0.8;
    }
    
    /* Cards neuromórficas */
    .neuro-card {
        background: #FFEEE2;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
    }
    
    /* Botón principal */
    .neuro-button {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #e89a3c, #f5a847);
        color: #ffffff;
        font-weight: 600;
        box-shadow: 4px 4px 8px rgba(232, 154, 60, 0.3);
        transition: all 0.3s ease;
        border: none;
    }
    
    .neuro-button:hover {
        box-shadow: 6px 6px 12px rgba(232, 154, 60, 0.4);
        transform: translateY(-2px);
    }
    
    /* Alert success */
    .alert-success {
        background: rgba(209, 250, 229, 0.8);
        border: 1px solid #10b981;
        color: #065f46;
        border-radius: 15px;
        padding: 1rem 1.5rem;
        font-family: 'Poppins', sans-serif;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
    }
    
    /* Timeline container */
    .timeline-border {
        border-left: 2px solid rgba(232, 154, 60, 0.3);
    }
    
    .timeline-border.last-item {
        border-left: 2px solid transparent;
    }
    
    /* Timeline dot */
    .timeline-dot {
        position: absolute;
        left: -0.5rem;
        top: 0;
        width: 1rem;
        height: 1rem;
        background: linear-gradient(135deg, #e89a3c, #f5a847);
        border-radius: 50%;
        box-shadow: 0 0 0 4px #FFEEE2, 2px 2px 4px rgba(232, 154, 60, 0.3);
    }
    
    /* Avance item */
    .avance-item {
        background: rgba(255, 255, 255, 0.5);
        border-radius: 15px;
        padding: 1.25rem;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }
    
    .avance-item:hover {
        box-shadow: 6px 6px 12px #e6d5c9, -6px -6px 12px #ffffff;
    }
    
    .avance-item h4 {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
        font-weight: 600;
        font-size: 1.125rem;
    }
    
    .avance-item .meta-info {
        font-family: 'Poppins', sans-serif;
        color: #6b6b6b;
        font-size: 0.875rem;
    }
    
    .avance-item .meta-info .author {
        font-weight: 500;
    }
    
    .avance-item .description {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
    }
    
    /* Archivo adjunto link */
    .attachment-link {
        font-family: 'Poppins', sans-serif;
        color: #e89a3c;
        transition: all 0.2s ease;
    }
    
    .attachment-link:hover {
        color: #d98a2c;
    }
    
    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 3rem 0;
    }
    
    .empty-state svg {
        margin: 0 auto;
        color: #6b6b6b;
    }
    
    .empty-state p {
        font-family: 'Poppins', sans-serif;
        color: #6b6b6b;
    }
    
    .empty-state .title {
        font-size: 1.125rem;
        font-weight: 600;
    }
    
    /* Info alert */
    .info-alert {
        background: rgba(219, 234, 254, 0.8);
        border-left: 4px solid #3b82f6;
        border-radius: 0 15px 15px 0;
        padding: 1rem;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        backdrop-filter: blur(10px);
    }
    
    .info-alert p {
        font-family: 'Poppins', sans-serif;
        color: #1e40af;
        font-size: 0.875rem;
    }
    
    .info-alert .title {
        font-weight: 600;
    }
</style>

<div class="avances-page py-12">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-2xl">Avances del Proyecto</h2>
                <p class="mt-1">{{ $proyecto->nombre }}</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('estudiante.proyecto.show') }}" class="link-accent">
                    ← Volver
                </a>
                <a href="{{ route('estudiante.avances.create') }}" 
                   class="neuro-button px-4 py-2 rounded-lg">
                    + Registrar Avance
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert-success mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- Timeline de Avances --}}
        <div class="neuro-card rounded-lg p-6">
            <h3 class="font-semibold mb-6">📊 Timeline de Entregas</h3>
            
            @forelse($avances as $avance)
                <div class="relative pl-8 pb-8 last:pb-0 {{ $loop->last ? 'timeline-border last-item' : 'timeline-border' }}">
                    {{-- Punto del Timeline --}}
                    <div class="timeline-dot"></div>
                    
                    <div class="avance-item">
                        {{-- Header --}}
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                @if($avance->titulo)
                                    <h4>{{ $avance->titulo }}</h4>
                                @endif
                                <p class="meta-info mt-1">
                                    Registrado por <span class="author">{{ $avance->usuarioRegistro->nombre }}</span>
                                    · {{ $avance->created_at->format('d/m/Y H:i') }}
                                   <span style="color: #9ca3af; font-size: 0.75rem;">({{ $avance->created_at->diffForHumans() }})</span>
                                </p>
                            </div>
                        </div>

                        {{-- Descripción --}}
                        <div class="description mb-3 whitespace-pre-line">
                            {{ $avance->descripcion }}
                        </div>

                        {{-- Archivo Adjunto --}}
                        @if($avance->archivo_evidencia)
                            <div class="mt-3 pt-3" style="border-top: 1px solid rgba(107, 107, 107, 0.2);">
                                <a href="{{ Storage::url($avance->archivo_evidencia) }}" target="_blank"
                                   class="attachment-link inline-flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                    </svg>
                                    Ver archivo adjunto
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="title">No hay avances registrados</p>
                    <p class="text-sm mt-2">Registra el primer avance de tu proyecto para que los jurados puedan evaluarlo</p>
                    <a href="{{ route('estudiante.avances.create') }}" 
                       class="neuro-button inline-block mt-4 px-6 py-2 rounded-lg">
                        Registrar Primer Avance
                    </a>
                </div>
            @endforelse
        </div>

        {{-- Información Adicional --}}
        @if($avances->count() > 0)
            <div class="info-alert mt-6">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-blue-600 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <p class="title">Estos avances son visibles para los jurados del evento</p>
                        <p class="mt-1">Son utilizados para evaluar el progreso de tu proyecto durante el evento.</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection