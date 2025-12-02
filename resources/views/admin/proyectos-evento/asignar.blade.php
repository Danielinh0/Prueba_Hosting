@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
    
    /* Fondo degradado */
    .asignar-proyectos-page {
        background: linear-gradient(to bottom, #FFFDF4, #FFEEE2);
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
    }
    
    /* Textos */
    .asignar-proyectos-page h2,
    .asignar-proyectos-page h3 {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
    }
    
    .asignar-proyectos-page p {
        font-family: 'Poppins', sans-serif;
        color: #6b6b6b;
    }
    
    /* Back link */
    .back-link {
        font-family: 'Poppins', sans-serif;
        color: #e89a3c;
        font-size: 0.875rem;
        transition: all 0.2s ease;
    }
    
    .back-link:hover {
        color: #d98a2c;
    }
    
    /* Info box */
    .info-box {
        background: linear-gradient(135deg, rgba(237, 233, 254, 0.5), rgba(250, 245, 255, 0.5));
        border: 1px solid rgba(168, 85, 247, 0.2);
        border-radius: 15px;
        padding: 0.75rem;
        margin-top: 0.5rem;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        backdrop-filter: blur(10px);
    }
    
    .info-box p {
        font-family: 'Poppins', sans-serif;
        color: #6b21a8;
        font-size: 0.875rem;
    }
    
    /* Main card */
    .main-card {
        background: #FFEEE2;
        border-radius: 20px;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
        overflow: hidden;
    }
    
    /* Table container */
    .table-header {
        background: rgba(255, 255, 255, 0.3);
        backdrop-filter: blur(5px);
    }
    
    .table-header th {
        padding: 0.75rem 1.5rem;
        text-align: left;
        font-size: 0.75rem;
        font-weight: 600;
        color: #2c2c2c;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-family: 'Poppins', sans-serif;
    }
    
    .table-body tr {
        border-bottom: 1px solid rgba(107, 107, 107, 0.1);
        transition: all 0.2s ease;
    }
    
    .table-body tr:hover {
        background: rgba(232, 154, 60, 0.05);
    }
    
    .table-body tr:last-child {
        border-bottom: none;
    }
    
    .table-body td {
        padding: 1rem 1.5rem;
        font-family: 'Poppins', sans-serif;
    }
    
    .team-name {
        font-weight: 600;
        color: #2c2c2c;
        font-size: 0.875rem;
    }
    
    .team-code {
        color: #6b6b6b;
        font-size: 0.875rem;
    }
    
    .project-title {
        font-weight: 500;
        color: #2c2c2c;
        font-size: 0.875rem;
    }
    
    /* Badges */
    .badge {
        font-family: 'Poppins', sans-serif;
        padding: 0.25rem 0.5rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        display: inline-flex;
        align-items: center;
    }
    
    .badge-published {
        background: rgba(209, 250, 229, 0.8);
        color: #065f46;
    }
    
    .badge-draft {
        background: rgba(254, 240, 138, 0.8);
        color: #854d0e;
    }
    
    .badge-complete {
        background: rgba(209, 250, 229, 0.8);
        color: #065f46;
    }
    
    .badge-pending {
        background: rgba(254, 240, 138, 0.8);
        color: #854d0e;
    }
    
    .badge-none {
        background: rgba(229, 231, 235, 0.8);
        color: #374151;
    }
    
    /* Action links */
    .action-link {
        font-family: 'Poppins', sans-serif;
        color: #e89a3c;
        font-weight: 600;
        transition: all 0.2s ease;
        font-size: 0.875rem;
    }
    
    .action-link:hover {
        color: #d98a2c;
    }
    
    .action-button {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: #ffffff;
        font-weight: 600;
        padding: 0.375rem 0.75rem;
        border-radius: 0.375rem;
        box-shadow: 2px 2px 4px rgba(99, 102, 241, 0.3);
        transition: all 0.3s ease;
        border: none;
        font-size: 0.75rem;
    }
    
    .action-button:hover {
        box-shadow: 4px 4px 8px rgba(99, 102, 241, 0.4);
        transform: translateY(-2px);
    }
    
    .publish-button {
        font-family: 'Poppins', sans-serif;
        color: #059669;
        font-weight: 600;
        transition: all 0.2s ease;
        background: none;
        border: none;
        cursor: pointer;
        font-size: 0.875rem;
    }
    
    .publish-button:hover {
        color: #047857;
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
    
    .empty-state h3,
    .empty-state p {
        font-family: 'Poppins', sans-serif;
        color: #6b6b6b;
    }
    
    /* Summary box */
    .summary-box {
        background: rgba(255, 255, 255, 0.3);
        border-radius: 15px;
        padding: 1rem;
        margin-top: 1.5rem;
        box-shadow: inset 2px 2px 4px #e6d5c9, inset -2px -2px 4px #ffffff;
    }
    
    .summary-item .number {
        font-family: 'Poppins', sans-serif;
        font-size: 1.5rem;
        font-weight: 700;
    }
    
    .summary-item .label {
        font-family: 'Poppins', sans-serif;
        font-size: 0.75rem;
        color: #6b6b6b;
    }
</style>

<div class="asignar-proyectos-page py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('admin.eventos.show', $evento) }}" class="back-link mb-2 inline-block">
                ← Volver al Evento
            </a>
            <h2 class="font-semibold text-2xl">
                Asignar Proyectos Individuales
            </h2>
            <p class="mt-1">{{ $evento->nombre }}</p>
            <div class="info-box">
                <p>
                     <strong>Modo Individual:</strong> Cada equipo tendrá un proyecto diferente asignado por ti.
                </p>
            </div>
        </div>

        <div class="main-card">
            <div class="p-6">
                <h3 class="text-lg font-medium mb-4">
                    Equipos Inscritos ({{ $inscripciones->count() }})
                </h3>

                @if($inscripciones->isEmpty())
                    <div class="empty-state">
                        <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium">No hay equipos inscritos</h3>
                        <p class="mt-1 text-sm">Los equipos aparecerán aquí cuando se registren al evento.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="table-header">
                                <tr>
                                    <th>Equipo</th>
                                    <th>Integrantes</th>
                                    <th>Proyecto Asignado</th>
                                    <th>Estado</th>
                                    <th class="text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="table-body">
                                @foreach($inscripciones as $inscripcion)
                                    <tr>
                                        <td>
                                            <div class="team-name">{{ $inscripcion->equipo->nombre }}</div>
                                            <div class="team-code">Código: {{ $inscripcion->codigo_acceso_equipo }}</div>
                                        </td>
                                        <td>
                                            <div class="text-sm" style="color: #2c2c2c;">
                                                {{ $inscripcion->equipo->miembros->count() }} miembros
                                            </div>
                                        </td>
                                        <td>
                                            @if($inscripcion->proyectoEvento)
                                                <div class="text-sm">
                                                    <div class="project-title">{{ $inscripcion->proyectoEvento->titulo }}</div>
                                                    @if($inscripcion->proyectoEvento->publicado)
                                                        <span class="badge badge-published mt-1">✓ Publicado</span>
                                                    @else
                                                        <span class="badge badge-draft mt-1">⏳ Borrador</span>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-sm" style="color: #9ca3af; font-style: italic;">Sin asignar</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($inscripcion->proyectoEvento && $inscripcion->proyectoEvento->publicado)
                                                <span class="badge badge-complete">Completo</span>
                                            @elseif($inscripcion->proyectoEvento)
                                                <span class="badge badge-pending">Pendiente</span>
                                            @else
                                                <span class="badge badge-none">Sin proyecto</span>
                                            @endif
                                        </td>
                                        <td class="text-right">
                                            @if($inscripcion->proyectoEvento)
                                                <div class="flex justify-end space-x-2">
                                                    <a href="{{ route('admin.proyectos-evento.edit', $inscripcion->proyectoEvento) }}" 
                                                       class="action-link">
                                                        Editar
                                                    </a>
                                                    @if(!$inscripcion->proyectoEvento->publicado)
                                                        <form action="{{ route('admin.proyectos-evento.publicar', $inscripcion->proyectoEvento) }}" 
                                                              method="POST" class="inline">
                                                            @csrf
                                                            <button type="submit" class="publish-button">
                                                                Publicar
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            @else
                                                <a href="{{ route('admin.proyectos-evento.create-individual', [$evento, $inscripcion]) }}" 
                                                   class="action-button inline-flex items-center">
                                                     Asignar Proyecto
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Resumen --}}
                    <div class="summary-box">
                        <div class="grid grid-cols-3 gap-4 text-center">
                            <div class="summary-item">
                                <div class="number" style="color: #2c2c2c;">
                                    {{ $inscripciones->filter(fn($i) => $i->proyectoEvento && $i->proyectoEvento->publicado)->count() }}
                                </div>
                                <div class="label">Proyectos Publicados</div>
                            </div>
                            <div class="summary-item">
                                <div class="number" style="color: #d97706;">
                                    {{ $inscripciones->filter(fn($i) => $i->proyectoEvento && !$i->proyectoEvento->publicado)->count() }}
                                </div>
                                <div class="label">En Borrador</div>
                            </div>
                            <div class="summary-item">
                                <div class="number" style="color: #9ca3af;">
                                    {{ $inscripciones->filter(fn($i) => !$i->proyectoEvento)->count() }}
                                </div>
                                <div class="label">Sin Asignar</div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection