@extends('layouts.app')

@section('content')
<div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex items-center">
            <a href="{{ route('admin.eventos.index') }}" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 mb-6">
                Detalle del Evento
            </h2>
        </div>
            <div class="bg-white overflow-hidden shadow-xl rounded-lg">
                @if ($evento->ruta_imagen)
                    <img class="h-64 w-full object-cover" src="{{ asset('storage/' . $evento->ruta_imagen) }}" alt="Imagen del evento: {{ $evento->nombre }}">
                @endif
                
                <div class="p-6 sm:p-8">
                    <div class="flex justify-between items-start">
                        <div>
                            <h1 class="font-bold text-3xl text-gray-800">{{ $evento->nombre }}</h1>
                            <p class="text-gray-500 text-sm mt-1">
                                Del {{ $evento->fecha_inicio->format('d/m/Y') }} al {{ $evento->fecha_fin->format('d/m/Y') }}
                            </p>
                        </div>
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                            @if ($evento->estado == 'Activo') bg-black text-white
                            @elseif ($evento->estado == 'Próximo') bg-blue-200 text-blue-800
                            @elseif ($evento->estado == 'Cerrado') bg-yellow-200 text-yellow-800
                            @else bg-red-200 text-red-800 @endif">
                            {{ $evento->estado }}
                        </span>
                    </div>

                    <div class="mt-6 border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-medium text-gray-900">Descripción del Evento</h3>
                        <p class="mt-2 text-gray-600">
                            {{ $evento->descripcion ?: 'No hay descripción disponible.' }}
                        </p>
                    </div>

                    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Columna de Jurados -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">
                                Jurados Asignados ({{ $evento->jurados->count() }})
                            </h3>
                            <div class="mt-4 bg-gray-50 rounded-lg p-4">
                                <ul class="space-y-3">
                                    @forelse($evento->jurados as $jurado)
                                        <li class="flex items-center space-x-3">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                            <a href="{{ route('admin.users.edit', $jurado->user) }}" class="text-gray-700 hover:text-indigo-600 hover:underline">
                                                {{ $jurado->user->nombre }} {{ $jurado->user->app_paterno }}
                                            </a>
                                        </li>
                                    @empty
                                        <li class="text-gray-500 text-sm">No hay jurados asignados a este evento.</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>

                        <!-- Columna de Equipos -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">
                                Equipos Inscritos ({{ $evento->inscripciones->count() }} / {{ $evento->cupo_max_equipos }})
                            </h3>
                            <div class="mt-4 bg-gray-50 rounded-lg p-4">
                                <ul class="space-y-3">
                                    @forelse($evento->inscripciones as $inscripcion)
                                        <li class="flex items-center space-x-3">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                            <a href="{{ route('admin.equipos.show', $inscripcion->equipo) }}" class="text-gray-700 hover:text-indigo-600 hover:underline">
                                                <span class="{{ $inscripcion->puesto_ganador ? 'font-bold' : '' }}">
                                                    @if($inscripcion->puesto_ganador == 1) 🥇 @endif
                                                    @if($inscripcion->puesto_ganador == 2) 🥈 @endif
                                                    @if($inscripcion->puesto_ganador == 3) 🥉 @endif
                                                    {{ $inscripcion->equipo->nombre }}
                                                </span>
                                            </a>
                                        </li>
                                    @empty
                                        <li class="text-gray-500 text-sm">No hay equipos inscritos en este evento.</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>

                    {{-- Proyecto del Evento (si está publicado) --}}
                    @if($evento->tipo_proyecto && ($evento->tipo_proyecto === 'general' && $evento->proyectoGeneral && $evento->proyectoGeneral->publicado))
                        <div class="mt-8 border-t border-gray-200 pt-6">
                            <div class="flex justify-between items-start mb-4">
                                <h3 class="text-lg font-medium text-gray-900">📋 Proyecto del Evento</h3>
                                <span class="px-3 py-1 bg-green-100 text-green-700 text-sm font-semibold rounded-full">
                                    ✓ Publicado
                                </span>
                            </div>
                            <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-lg p-6 border border-indigo-200">
                                <h4 class="text-xl font-bold text-gray-900 mb-3">{{ $evento->proyectoGeneral->titulo }}</h4>
                                
                                @if($evento->proyectoGeneral->descripcion_completa)
                                    <div class="mb-4">
                                        <h5 class="font-semibold text-gray-700 mb-2">Descripción:</h5>
                                        <p class="text-gray-600 whitespace-pre-line">{{ Str::limit($evento->proyectoGeneral->descripcion_completa, 300) }}</p>
                                    </div>
                                @endif

                                @if($evento->proyectoGeneral->objetivo)
                                    <div class="mb-4">
                                        <h5 class="font-semibold text-gray-700 mb-2">🎯 Objetivo:</h5>
                                        <p class="text-gray-600">{{ $evento->proyectoGeneral->objetivo }}</p>
                                    </div>
                                @endif

                                <div class="mt-4 flex flex-wrap gap-3">
                                    @if($evento->proyectoGeneral->archivo_bases)
                                        <a href="{{ Storage::url($evento->proyectoGeneral->archivo_bases) }}" 
                                           target="_blank"
                                           class="inline-flex items-center px-4 py-2 bg-white border border-indigo-300 rounded-lg text-indigo-700 hover:bg-indigo-50 transition">
                                            📄 Descargar Bases
                                        </a>
                                    @endif
                                    @if($evento->proyectoGeneral->archivo_recursos)
                                        <a href="{{ Storage::url($evento->proyectoGeneral->archivo_recursos) }}" 
                                           target="_blank"
                                           class="inline-flex items-center px-4 py-2 bg-white border border-purple-300 rounded-lg text-purple-700 hover:bg-purple-50 transition">
                                            📦 Descargar Recursos
                                        </a>
                                    @endif
                                    @if($evento->proyectoGeneral->url_externa)
                                        <a href="{{ $evento->proyectoGeneral->url_externa }}" 
                                           target="_blank"
                                           class="inline-flex items-center px-4 py-2 bg-white border border-blue-300 rounded-lg text-blue-700 hover:bg-blue-50 transition">
                                            🔗 Recursos Externos
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @elseif($evento->tipo_proyecto === 'individual')
                        <div class="mt-8 border-t border-gray-200 pt-6">
                            <h3 class="text-lg font-medium text-gray-900">📝 Proyectos Individuales</h3>
                            <div class="mt-4 bg-purple-50 rounded-lg p-4 border border-purple-200">
                                <p class="text-sm text-purple-700">
                                    Este evento usa <strong>proyectos individuales</strong>. Cada equipo puede tener un proyecto diferente.
                                </p>
                                <a href="{{ route('admin.proyectos-evento.asignar', $evento) }}" 
                                   class="inline-block mt-3 text-purple-600 hover:text-purple-800 font-semibold">
                                    Ver estado de asignaciones →
                                </a>
                            </div>
                        </div>
                    @endif

                    <!-- Acciones de Administrador -->
                    <div class="mt-8 border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-medium text-gray-900">Acciones de Administrador</h3>
                        <div class="mt-4 flex flex-wrap gap-3">
                            <a href="{{ route('admin.eventos.asignar', $evento) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 font-semibold">
                                Gestionar Jurados
                            </a>

                            @if($evento->estado === 'Próximo')
                                <form action="{{ route('admin.eventos.activar', $evento) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres activar este evento? Los usuarios podrán inscribirse.');">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 font-semibold">
                                        Activar Evento
                                    </button>
                                </form>
                            @elseif($evento->estado === 'Activo')
                                <form action="{{ route('admin.eventos.cerrar', $evento) }}" method="POST" onsubmit="return confirm('¿Cerrar inscripciones? Los equipos no podrán unirse.');">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700 font-semibold">
                                        🔒 Cerrar Inscripciones
                                    </button>
                                </form>
                                <form action="{{ route('admin.eventos.finalizar', $evento) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres finalizar este evento?');">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 font-semibold">
                                        Finalizar Evento
                                    </button>
                                </form>
                                <form action="{{ route('admin.eventos.desactivar', $evento) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres mover este evento a Próximos? Se cerrarán las inscripciones.');">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 font-semibold">
                                        Mover a Próximos
                                    </button>
                                </form>
                            @elseif($evento->estado === 'Cerrado')
                                <!-- Configuración de Proyectos del Evento -->
                                @if(!$evento->tipo_proyecto)
                                    <button onclick="document.getElementById('modalTipoProyecto').classList.remove('hidden')" 
                                            class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 font-semibold">
                                        📋 Configurar Tipo de Proyecto
                                    </button>
                                @else
                                    @if($evento->tipo_proyecto === 'general')
                                        @if($evento->proyectoGeneral)
                                            <a href="{{ route('admin.proyectos-evento.edit', $evento->proyectoGeneral) }}" 
                                               class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 font-semibold">
                                                ✏️ Editar Proyecto General
                                            </a>
                                            @if($evento->proyectoGeneral->publicado)
                                                <form action="{{ route('admin.proyectos-evento.despublicar', $evento->proyectoGeneral) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 font-semibold">
                                                        👁️‍🗨️ Despublicar
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('admin.proyectos-evento.publicar', $evento->proyectoGeneral) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 font-semibold">
                                                        🚀 Publicar Proyecto
                                                    </button>
                                                </form>
                                            @endif
                                        @else
                                            <a href="{{ route('admin.proyectos-evento.create', $evento) }}" 
                                               class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 font-semibold">
                                                ➕ Crear Proyecto General
                                            </a>
                                        @endif
                                    @else
                                        <a href="{{ route('admin.proyectos-evento.asignar', $evento) }}" 
                                           class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 font-semibold">
                                            📝 Asignar Proyectos Individuales
                                        </a>
                                    @endif

                                    {{-- Botón para cambiar tipo de proyecto --}}
                                    @if($evento->tipo_proyecto === 'general')
                                        <button onclick="document.getElementById('modalTipoProyecto').classList.remove('hidden')" 
                                                class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 font-semibold">
                                            🔄 Cambiar a Individual
                                        </button>
                                    @endif
                                @endif

                                <form action="{{ route('admin.eventos.reactivar', $evento) }}" method="POST" onsubmit="return confirm('¿Reabrir inscripciones?');">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-4 py-2 bg-orange-600 text-white rounded-md hover:bg-orange-700 font-semibold">
                                        🔓 Reabrir Inscripciones
                                    </button>
                                </form>

                                <form action="{{ route('admin.eventos.finalizar', $evento) }}" method="POST" onsubmit="return confirm('¿Finalizar evento?');">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 font-semibold">
                                        Finalizar Evento
                                    </button>
                                </form>
                            @elseif($evento->estado === 'Finalizado')
                                <a href="{{ route('admin.eventos.resultados', $evento) }}" 
                                   class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 font-semibold">
                                    🏆 Ver Resultados
                                </a>
                                <form action="{{ route('admin.eventos.reactivar', $evento) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres reactivar este evento?');">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 font-semibold">
                                        Reactivar Evento
                                    </button>
                                </form>
                            @endif

                            <a href="{{ route('admin.eventos.edit', $evento) }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 font-semibold">
                                Editar Evento
                            </a>
                        </div>
                    </div>

                    <!-- Modal Tipo de Proyecto -->
                    <div id="modalTipoProyecto" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
                        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">
                                {{ $evento->tipo_proyecto ? 'Cambiar Tipo de Proyecto' : 'Configurar Tipo de Proyecto' }}
                            </h3>
                            
                            @if($evento->tipo_proyecto === 'general')
                                <div class="mb-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                                    <p class="text-sm text-yellow-700">
                                        ⚠️ <strong>Nota:</strong> Cambiar a proyectos individuales mantendrá el proyecto general creado, pero ya no será visible para los equipos.
                                    </p>
                                </div>
                            @elseif($evento->tipo_proyecto === 'individual')
                                <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg">
                                    <p class="text-sm text-red-700">
                                        🚫 <strong>No se puede cambiar:</strong> Ya tienes proyectos individuales asignados. Cambiar a proyecto general eliminaría los archivos de cada equipo.
                                    </p>
                                </div>
                            @else
                                <p class="text-sm text-gray-600 mb-4">Elige cómo se asignarán los proyectos a los equipos:</p>
                            @endif
                            
                            <form action="{{ route('admin.eventos.configurar-proyectos', $evento) }}" method="POST">
                                @csrf
                                <div class="space-y-3">
                                    <label class="flex items-start p-4 border-2 {{ $evento->tipo_proyecto === 'general' ? 'border-indigo-500 bg-indigo-50' : 'border-gray-200' }} rounded-lg cursor-pointer hover:border-indigo-500">
                                        <input type="radio" name="tipo_proyecto" value="general" 
                                               class="mt-1" 
                                               {{ $evento->tipo_proyecto === 'general' ? 'checked' : '' }}
                                               {{ $evento->tipo_proyecto === 'individual' ? 'disabled' : 'required' }}>
                                        <div class="ml-3">
                                            <div class="font-semibold text-gray-900">📋 Proyecto General</div>
                                            <div class="text-sm text-gray-600">Un solo proyecto para todos los equipos</div>
                                            @if($evento->tipo_proyecto === 'general')
                                                <div class="text-xs text-indigo-600 mt-1">✓ Tipo actual</div>
                                            @elseif($evento->tipo_proyecto === 'individual')
                                                <div class="text-xs text-red-600 mt-1">⚠️ No disponible</div>
                                            @endif
                                        </div>
                                    </label>
                                    <label class="flex items-start p-4 border-2 {{ $evento->tipo_proyecto === 'individual' ? 'border-purple-500 bg-purple-50' : 'border-gray-200' }} rounded-lg cursor-pointer hover:border-purple-500">
                                        <input type="radio" name="tipo_proyecto" value="individual" 
                                               class="mt-1" 
                                               {{ $evento->tipo_proyecto === 'individual' ? 'checked' : '' }}
                                               {{ !$evento->tipo_proyecto || $evento->tipo_proyecto === 'general' ? 'required' : '' }}>
                                        <div class="ml-3">
                                            <div class="font-semibold text-gray-900">📝 Proyectos Individuales</div>
                                            <div class="text-sm text-gray-600">Proyectos diferentes por equipo</div>
                                            @if($evento->tipo_proyecto === 'individual')
                                                <div class="text-xs text-purple-600 mt-1">✓ Tipo actual</div>
                                            @endif
                                        </div>
                                    </label>
                                </div>
                                <div class="mt-6 flex justify-end space-x-3">
                                    <button type="button" onclick="document.getElementById('modalTipoProyecto').classList.add('hidden')" 
                                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                                        Cancelar
                                    </button>
                                    @if($evento->tipo_proyecto !== 'individual')
                                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                                            {{ $evento->tipo_proyecto ? 'Cambiar Tipo' : 'Confirmar' }}
                                        </button>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

