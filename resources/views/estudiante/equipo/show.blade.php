@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="font-semibold text-xl text-gray-800 mb-6">Mi Equipo</h2>
            <div class="bg-white overflow-hidden shadow-xl rounded-lg">
                @if ($inscripcion->equipo->ruta_imagen)
                    <img class="h-64 w-full object-cover" src="{{ asset('storage/' . $inscripcion->equipo->ruta_imagen) }}" alt="Imagen del equipo">
                @endif
                
                <div class="p-6 sm:p-8">
                    <!-- Información del Equipo y Evento -->
                    <div class="border-b pb-6">
                        <div class="flex items-center justify-between">
                            <h1 class="font-bold text-3xl text-gray-800">{{ $inscripcion->equipo->nombre }}</h1>
                            <div class="flex items-center space-x-3">
                                @if($esLider)
                                    <a href="{{ route('estudiante.equipo.edit') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                                        Editar Equipo
                                    </a>
                                @else
                                    {{-- Botón para que miembros NO líderes salgan del equipo --}}
                                    <form action="{{ route('estudiante.miembros.leave') }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres abandonar este equipo?');">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:ring focus:ring-red-300 disabled:opacity-25 transition">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                            </svg>
                                            Salir del Equipo
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                        <p class="text-gray-600 text-sm mt-2">
                            Participando en el evento: 
                            <a href="{{ route('estudiante.eventos.show', $inscripcion->evento) }}" class="text-indigo-600 hover:underline">
                                {{ $inscripcion->evento->nombre }}
                            </a>
                        </p>

                        @if($inscripcion->equipo->descripcion)
                            <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                                <h3 class="font-semibold text-gray-700 mb-2">Descripción del Equipo</h3>
                                <p class="text-gray-600 text-sm leading-relaxed">{{ $inscripcion->equipo->descripcion }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Lista de Miembros -->
                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-gray-900">
                            Miembros del Equipo ({{ $inscripcion->equipo->miembros->count() }})
                        </h3>
                        <div class="mt-4">
                            <ul class="divide-y divide-gray-200">
                                @foreach($inscripcion->equipo->miembros as $miembro)
                                    <li class="py-4 flex items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            <!-- Foto de Perfil -->
                                            <img src="{{ $miembro->user->foto_perfil_url }}" alt="{{ $miembro->user->nombre }}" class="w-12 h-12 rounded-full object-cover border-2 border-gray-200">
                                            
                                            <div>
                                                <div class="flex items-center space-x-2">
                                                    <p class="text-gray-800 font-semibold">{{ $miembro->user->nombre }} {{ $miembro->user->app_paterno }}</p>
                                                    @if($miembro->es_lider)
                                                        <span class="text-xs font-bold uppercase px-2 py-1 bg-yellow-400 text-yellow-900 rounded-full">Líder</span>
                                                    @endif
                                                </div>
                                                <p class="text-sm text-gray-500">{{ $miembro->user->estudiante->carrera->nombre ?? 'Carrera no disponible' }}</p>
                                                <p class="text-xs text-gray-400 mt-0.5">
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-indigo-100 text-indigo-800">
                                                        {{ $miembro->rol->nombre ?? 'Rol no asignado' }}
                                                    </span>
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Controles del Líder para otros miembros -->
                                        @if($esLider && !$miembro->es_lider)
                                            <div class="flex items-center space-x-2">
                                                <!-- Formulario para Cambiar Rol -->
                                                <form action="{{ route('estudiante.miembros.updateRole', $miembro) }}" method="POST" class="flex items-center space-x-2">
                                                    @csrf
                                                    @method('PATCH')
                                                    <select name="id_rol_equipo" class="block w-full rounded-md border-gray-300 shadow-sm text-xs">
                                                        @foreach($roles as $rol)
                                                            <option value="{{ $rol->id_rol_equipo }}" @if($rol->id_rol_equipo == $miembro->id_rol_equipo) selected @endif>
                                                                {{ $rol->nombre }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <button type="submit" class="px-2 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-xs">Actualizar</button>
                                                </form>
                                                <!-- Formulario para Eliminar -->
                                                <form action="{{ route('estudiante.miembros.destroy', $miembro) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar a este miembro del equipo?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-2 py-1 bg-red-600 text-white rounded-md hover:bg-red-700 text-xs">Quitar</button>
                                                </form>
                                            </div>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <!-- Acciones de Líder (Solo visible para el líder) -->
                    @if($esLider)
                        <div class="mt-8 border-t border-gray-200 pt-6">
                            <h3 class="text-lg font-medium text-gray-900">Gestionar Solicitudes</h3>
                            <div class="mt-4">
                                @forelse($solicitudes as $solicitud)
                                    <div class="p-4 bg-gray-50 rounded-lg flex items-center justify-between mb-2">
                                        <div>
                                            <p class="font-semibold text-gray-800">{{ $solicitud->estudiante->user->nombre }} {{ $solicitud->estudiante->user->app_paterno }}</p>
                                            <p class="text-sm text-gray-500">Quiere unirse al equipo</p>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <!-- Formulario para Aceptar -->
                                            <form action="{{ route('estudiante.solicitudes.accept', $solicitud) }}" method="POST" class="flex items-center space-x-2">
                                                @csrf
                                                <select name="id_rol_equipo" class="block w-full rounded-md border-gray-300 shadow-sm text-xs" required>
                                                    <option value="">Asignar Rol...</option>
                                                    @foreach($roles as $rol)
                                                        <option value="{{ $rol->id_rol_equipo }}">{{ $rol->nombre }}</option>
                                                    @endforeach
                                                </select>
                                                <button type="submit" class="px-3 py-1 bg-green-600 text-white rounded-md hover:bg-green-700 text-xs font-semibold">Aceptar</button>
                                            </form>
                                            <!-- Formulario para Rechazar -->
                                            <form action="{{ route('estudiante.solicitudes.reject', $solicitud) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded-md hover:bg-red-700 text-xs font-semibold">Rechazar</button>
                                            </form>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-gray-600">No hay solicitudes pendientes.</p>
                                @endforelse
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Accesos Rápidos -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">⚡ Accesos Rápidos</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <!-- Recursos -->
                    <a href="{{ route('estudiante.recursos.index', $inscripcion->equipo) }}" class="bg-blue-50 hover:bg-blue-100 p-4 rounded-lg text-center transition transform hover:-translate-y-1 duration-200">
                        <svg class="w-10 h-10 mx-auto mb-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p class="text-sm font-semibold text-blue-900">Recursos</p>
                        <p class="text-xs text-blue-600 mt-1">{{ $inscripcion->equipo->recursos->count() }} archivos</p>
                    </a>
                    
                    <!-- Proyecto/Hitos -->
                    <a href="#" class="bg-green-50 hover:bg-green-100 p-4 rounded-lg text-center transition transform hover:-translate-y-1 duration-200">
                        <svg class="w-10 h-10 mx-auto mb-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-sm font-semibold text-green-900">Hitos</p>
                        <p class="text-xs text-green-600 mt-1">{{ $inscripcion->proyecto ? $inscripcion->proyecto->hitos->where('completado', true)->count() . '/' . $inscripcion->proyecto->hitos->count() : '0/0' }}</p>
                    </a>
                    
                    <!-- Tecnologías -->
                    <a href="#" class="bg-purple-50 hover:bg-purple-100 p-4 rounded-lg text-center transition transform hover:-translate-y-1 duration-200">
                        <svg class="w-10 h-10 mx-auto mb-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                        </svg>
                        <p class="text-sm font-semibold text-purple-900">Tecnologías</p>
                        <p class="text-xs text-purple-600 mt-1">{{ $inscripcion->proyecto ? $inscripcion->proyecto->tecnologias->count() : 0 }} tags</p>
                    </a>
                    
                    <!-- Actividad -->
                    <a href="{{ route('estudiante.actividades.equipo', $inscripcion->equipo) }}" class="bg-yellow-50 hover:bg-yellow-100 p-4 rounded-lg text-center transition transform hover:-translate-y-1 duration-200">
                        <svg class="w-10 h-10 mx-auto mb-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        <p class="text-sm font-semibold text-yellow-900">Actividad</p>
                        <p class="text-xs text-yellow-600 mt-1">Feed del equipo</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
