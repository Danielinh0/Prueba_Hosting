@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="flex items-center mb-6">
                <a href="{{ route('estudiante.eventos.equipos.index', $evento) }}" class="text-gray-800 hover:text-gray-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </a>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight ml-2">
                    {{ $inscripcion->equipo->nombre }}
                </h2>
            </div>

            <div class="bg-white overflow-hidden shadow-xl rounded-lg">
                @if ($inscripcion->equipo->ruta_imagen)
                    <img class="h-64 w-full object-cover" src="{{ asset('storage/' . $inscripcion->equipo->ruta_imagen) }}" alt="Imagen del equipo">
                @endif
                
                <div class="p-6 sm:p-8">
                    <!-- Información del Equipo -->
                    <div class="border-b pb-6">
                        <h1 class="font-bold text-3xl text-gray-800">{{ $inscripcion->equipo->nombre }}</h1>
                        <p class="text-gray-600 text-sm mt-2">
                            Evento: 
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

                        <!-- Estado del Equipo -->
                        <div class="mt-4 flex items-center space-x-3">
                            <span class="text-sm text-gray-600">
                                <strong>Estado:</strong>
                                @if($inscripcion->status_registro === 'Completo')
                                    <span class="text-green-600 font-semibold">Equipo Completo</span>
                                @else
                                    <span class="text-yellow-600 font-semibold">Buscando Miembros</span>
                                @endif
                            </span>
                            <span class="text-sm text-gray-600">
                                <strong>Miembros:</strong> {{ $inscripcion->miembros->count() }}
                            </span>
                        </div>
                    </div>

                    <!-- Lista de Miembros (Solo lectura) -->
                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            Miembros del Equipo
                        </h3>
                        <ul class="divide-y divide-gray-200">
                            @foreach($inscripcion->miembros as $miembro)
                                <li class="py-4 flex items-center space-x-4">
                                    <!-- Foto de Perfil -->
                                    <img src="{{ $miembro->user->foto_perfil_url }}" 
                                         alt="{{ $miembro->user->nombre }}" 
                                         class="w-12 h-12 rounded-full object-cover border-2 border-gray-200">
                                    
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-2">
                                            <p class="text-gray-800 font-semibold">
                                                {{ $miembro->user->nombre }} {{ $miembro->user->app_paterno }}
                                            </p>
                                            @if($miembro->es_lider)
                                                <span class="text-xs font-bold uppercase px-2 py-1 bg-yellow-400 text-yellow-900 rounded-full">
                                                    Líder
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-sm text-gray-500">
                                            {{ $miembro->user->estudiante->carrera->nombre ?? 'Carrera no disponible' }}
                                        </p>
                                        <p class="text-xs text-gray-400 mt-0.5">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-indigo-100 text-indigo-800">
                                                {{ $miembro->rol->nombre ?? 'Rol no asignado' }}
                                            </span>
                                        </p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Botón de Solicitud -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        @if ($evento->estado === 'Activo' && $inscripcion->status_registro !== 'Completo')
                            @if ($miInscripcionDeEquipoId)
                                {{-- El usuario YA es miembro de un equipo en este evento --}}
                                @if ($miInscripcionDeEquipoId === $inscripcion->equipo->id_equipo)
                                    <div class="p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded">
                                        <p class="font-semibold">✓ Ya eres miembro de este equipo</p>
                                        <a href="{{ route('estudiante.equipo.index') }}" class="text-sm text-green-800 hover:underline mt-1 inline-block">
                                            Ir a Mi Equipo →
                                        </a>
                                    </div>
                                @else
                                    <div class="p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 rounded">
                                        <p class="font-semibold">Ya eres miembro de otro equipo en este evento</p>
                                        <p class="text-sm mt-1">No puedes estar en dos equipos simultáneamente.</p>
                                    </div>
                                @endif
                            @else
                                {{-- El usuario NO es miembro de ningún equipo --}}
                                @if ($solicitudActual)
                                    @if ($solicitudActual->status === 'pendiente')
                                        <div class="p-4 bg-blue-100 border-l-4 border-blue-500 text-blue-700 rounded">
                                            <p class="font-semibold">⏳ Solicitud enviada</p>
                                            <p class="text-sm mt-1">El líder del equipo está revisando tu solicitud.</p>
                                        </div>
                                    @elseif ($solicitudActual->status === 'aceptada')
                                        <div class="p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded">
                                            <p class="font-semibold">✓ Solicitud aceptada</p>
                                            <p class="text-sm mt-1">Ya eres parte de este equipo.</p>
                                        </div>
                                    @elseif ($solicitudActual->status === 'rechazada')
                                        <div class="p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded mb-4">
                                            <p class="font-semibold">Tu solicitud fue rechazada</p>
                                            <p class="text-sm mt-1">Puedes volver a solicitar unirte si lo deseas.</p>
                                        </div>
                                        <form action="{{ route('estudiante.solicitudes.store', $inscripcion->equipo) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="w-full px-6 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 font-semibold transition shadow-sm">
                                                Volver a Solicitar Unirme
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    {{-- No hay solicitud, puede enviar una --}}
                                    <form action="{{ route('estudiante.solicitudes.store', $inscripcion->equipo) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full px-6 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 font-semibold transition shadow-sm">
                                            Solicitar Unirme a este Equipo
                                        </button>
                                    </form>
                                    <p class="text-xs text-gray-500 text-center mt-2">
                                        El líder del equipo recibirá tu solicitud y decidirá si aceptarte.
                                    </p>
                                @endif
                            @endif
                        @elseif ($inscripcion->status_registro === 'Completo')
                            <div class="p-4 bg-gray-100 border-l-4 border-gray-500 text-gray-700 rounded">
                                <p class="font-semibold">Equipo completo</p>
                                <p class="text-sm mt-1">Este equipo ya alcanzó el número máximo de miembros.</p>
                            </div>
                        @else
                            <div class="p-4 bg-gray-100 border-l-4 border-gray-500 text-gray-700 rounded">
                                <p class="font-semibold">Inscripciones no disponibles</p>
                                <p class="text-sm mt-1">El evento aún no está activo.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
