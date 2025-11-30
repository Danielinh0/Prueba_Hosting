@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('admin.eventos.show', $evento) }}" class="text-indigo-600 hover:text-indigo-800 text-sm mb-2 inline-block">
                ← Volver al Evento
            </a>
            <h2 class="font-semibold text-2xl text-gray-900">
                Asignar Proyectos Individuales
            </h2>
            <p class="text-gray-600 mt-1">{{ $evento->nombre }}</p>
            <div class="mt-2 p-3 bg-purple-50 border border-purple-200 rounded-lg">
                <p class="text-sm text-purple-700">
                    💡 <strong>Modo Individual:</strong> Cada equipo tendrá un proyecto diferente asignado por ti.
                </p>
            </div>
        </div>

        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    Equipos Inscritos ({{ $inscripciones->count() }})
                </h3>

                @if($inscripciones->isEmpty())
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No hay equipos inscritos</h3>
                        <p class="mt-1 text-sm text-gray-500">Los equipos aparecerán aquí cuando se registren al evento.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Equipo
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Integrantes
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Proyecto Asignado
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Estado
                                    </th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($inscripciones as $inscripcion)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $inscripcion->equipo->nombre }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        Código: {{ $inscripcion->codigo_acceso_equipo }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ $inscripcion->equipo->miembros->count() }} miembros
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($inscripcion->proyectoEvento)
                                                <div class="text-sm">
                                                    <div class="font-medium text-gray-900">{{ $inscripcion->proyectoEvento->titulo }}</div>
                                                    @if($inscripcion->proyectoEvento->publicado)
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 mt-1">
                                                            ✓ Publicado
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800 mt-1">
                                                            ⏳ Borrador
                                                        </span>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-sm text-gray-400 italic">Sin asignar</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($inscripcion->proyectoEvento && $inscripcion->proyectoEvento->publicado)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Completo
                                                </span>
                                            @elseif($inscripcion->proyectoEvento)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    Pendiente
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                    Sin proyecto
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            @if($inscripcion->proyectoEvento)
                                                <div class="flex justify-end space-x-2">
                                                    <a href="{{ route('admin.proyectos-evento.edit', $inscripcion->proyectoEvento) }}" 
                                                       class="text-indigo-600 hover:text-indigo-900">
                                                        Editar
                                                    </a>
                                                    @if(!$inscripcion->proyectoEvento->publicado)
                                                        <form action="{{ route('admin.proyectos-evento.publicar', $inscripcion->proyectoEvento) }}" 
                                                              method="POST" class="inline">
                                                            @csrf
                                                            <button type="submit" class="text-green-600 hover:text-green-900">
                                                                Publicar
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            @else
                                                <a href="{{ route('admin.proyectos-evento.create-individual', [$evento, $inscripcion]) }}" 
                                                   class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                                    ➕ Asignar Proyecto
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Resumen --}}
                    <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                        <div class="grid grid-cols-3 gap-4 text-center">
                            <div>
                                <div class="text-2xl font-bold text-gray-900">
                                    {{ $inscripciones->filter(fn($i) => $i->proyectoEvento && $i->proyectoEvento->publicado)->count() }}
                                </div>
                                <div class="text-xs text-gray-500">Proyectos Publicados</div>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-yellow-600">
                                    {{ $inscripciones->filter(fn($i) => $i->proyectoEvento && !$i->proyectoEvento->publicado)->count() }}
                                </div>
                                <div class="text-xs text-gray-500">En Borrador</div>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-gray-400">
                                    {{ $inscripciones->filter(fn($i) => !$i->proyectoEvento)->count() }}
                                </div>
                                <div class="text-xs text-gray-500">Sin Asignar</div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
