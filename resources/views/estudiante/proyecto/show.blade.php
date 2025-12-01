@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
    
    /* Fondo degradado */
    .proyecto-page {
        background: linear-gradient(to bottom, #FFFDF4, #FFEEE2);
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
    }
    
    /* Textos */
    .proyecto-page h2,
    .proyecto-page h3,
    .proyecto-page h4 {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
    }
    
    .proyecto-page p {
        font-family: 'Poppins', sans-serif;
        color: #6b6b6b;
    }
    
    .proyecto-page a {
        font-family: 'Poppins', sans-serif;
        transition: all 0.2s ease;
    }
    
    /* Cards neuromórficas */
    .neuro-card {
        background: #FFEEE2;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
        transition: all 0.3s ease;
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
    
    /* Links normales */
    .link-accent {
        color: #e89a3c;
    }
    
    .link-accent:hover {
        color: #d98a2c;
        opacity: 0.8;
    }
    
    /* Quick access cards */
    .quick-access-card {
        background: rgba(255, 255, 255, 0.5);
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        border: 2px solid transparent;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }
    
    .quick-access-card:hover {
        box-shadow: 6px 6px 12px #e6d5c9, -6px -6px 12px #ffffff;
        transform: translateY(-5px);
    }
    
    .quick-access-card.border-indigo:hover {
        border-color: #6366f1;
    }
    
    .quick-access-card.border-green:hover {
        border-color: #10b981;
    }
    
    .quick-access-card.border-purple:hover {
        border-color: #8b5cf6;
    }
    
    .quick-access-card h4 {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
        font-weight: 600;
    }
    
    .quick-access-card p {
        font-family: 'Poppins', sans-serif;
        color: #6b6b6b;
        font-size: 0.875rem;
    }
    
    /* Warning alert */
    .warning-alert {
        background: rgba(254, 243, 199, 0.8);
        border-left: 4px solid #f59e0b;
        border-radius: 0 15px 15px 0;
        padding: 1.5rem;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        backdrop-filter: blur(10px);
    }
    
    .warning-alert h3 {
        color: #92400e;
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
    }
    
    .warning-alert p {
        color: #b45309;
        font-family: 'Poppins', sans-serif;
    }
    
    .warning-button {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #f59e0b, #f97316);
        color: #ffffff;
        font-weight: 600;
        box-shadow: 4px 4px 8px rgba(245, 158, 11, 0.3);
        transition: all 0.3s ease;
        border: none;
    }
    
    .warning-button:hover {
        box-shadow: 6px 6px 12px rgba(245, 158, 11, 0.4);
        transform: translateY(-2px);
    }
</style>

<div class="proyecto-page py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6 flex justify-between items-center">
            <h2 class="font-semibold text-2xl">Proyecto del Equipo</h2>
            @if($esLider && $proyecto)
                <a href="{{ route('estudiante.proyecto.edit') }}" class="neuro-button px-4 py-2 rounded-lg">
                    Editar Proyecto
                </a>
            @endif
        </div>

        @if(session('success'))
            <div class="alert-success mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if($proyecto)
            {{-- Información del Proyecto --}}
            <div class="neuro-card rounded-lg p-6 mb-6">
                <h3 class="text-xl font-bold mb-4">{{ $proyecto->nombre }}</h3>
                
                @if($proyecto->descripcion_tecnica)
                    <div class="mb-4">
                        <h4 class="font-semibold mb-2">Descripción Técnica</h4>
                        <p>{{ $proyecto->descripcion_tecnica }}</p>
                    </div>
                @endif

                @if($proyecto->repositorio_url)
                    <div class="mb-4">
                        <h4 class="font-semibold mb-2">Repositorio</h4>
                        <a href="{{ $proyecto->repositorio_url }}" target="_blank" class="link-accent underline">
                            {{ $proyecto->repositorio_url }}
                        </a>
                    </div>
                @endif

                <div class="text-sm mt-4" style="color: #9ca3af;">
                    Creado: {{ $proyecto->created_at->format('d/m/Y H:i') }}
                    @if($proyecto->updated_at != $proyecto->created_at)
                        | Actualizado: {{ $proyecto->updated_at->format('d/m/Y H:i') }}
                    @endif
                </div>
            </div>

            {{-- Accesos Rápidos --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('estudiante.tareas.index') }}" class="quick-access-card border-indigo p-6 rounded-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4>Tareas del Proyecto</h4>
                            <p class="mt-1">Gestiona el checklist</p>
                        </div>
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                    </div>
                </a>

                <a href="{{ route('estudiante.avances.index') }}" class="quick-access-card border-green p-6 rounded-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4>Avances Registrados</h4>
                            <p class="mt-1">Timeline de entregas</p>
                        </div>
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </a>

                <a href="{{ route('estudiante.equipo.index') }}" class="quick-access-card border-purple p-6 rounded-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4>Mi Equipo</h4>
                            <p class="mt-1">Ver miembros</p>
                        </div>
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </a>
            </div>

        @else
            {{-- No hay proyecto --}}
            <div class="warning-alert">
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-yellow-600 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <div>
                        <h3 class="mb-2">No hay proyecto creado</h3>
                        <p class="mb-4">Tu equipo aún no ha creado un proyecto. El líder debe crear el proyecto para comenzar.</p>
                        
                        @if($esLider)
                            <a href="{{ route('estudiante.proyecto.create') }}" class="warning-button inline-block px-6 py-2 rounded-lg">
                                Crear Proyecto Ahora
                            </a>
                        @else
                            <p class="text-sm" style="color: #d97706;">Contacta al líder de tu equipo para que cree el proyecto.</p>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection