@extends('layouts.app')

@section('content')

<div class="asignar-proyectos-page py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('admin.eventos.show', $evento) }}" class="back-link">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver al Evento
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