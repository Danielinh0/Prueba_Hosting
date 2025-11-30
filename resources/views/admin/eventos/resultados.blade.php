@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="mb-6 flex justify-between items-center">
            <div>
                <a href="{{ route('admin.eventos.show', $evento) }}" class="text-indigo-600 hover:text-indigo-800 text-sm mb-2 inline-block">
                    ← Volver al Evento
                </a>
                <h2 class="font-semibold text-2xl text-gray-900">Resultados y Evaluaciones</h2>
                <p class="text-gray-600 mt-1">{{ $evento->nombre }}</p>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
        @endif

        {{-- Resumen de Evaluaciones --}}
        <div class="bg-white shadow-sm rounded-lg p-6 mb-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">📊 Resumen de Evaluaciones</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-blue-50 rounded-lg p-4">
                    <p class="text-sm text-blue-600 font-medium">Equipos Registrados</p>
                    <p class="text-3xl font-bold text-blue-900 mt-1">{{ $equiposConCalificaciones->count() }}</p>
                </div>
                <div class="bg-green-50 rounded-lg p-4">
                    <p class="text-sm text-green-600 font-medium">Equipos Evaluados</p>
                    <p class="text-3xl font-bold text-green-900 mt-1">
                        {{ $equiposConCalificaciones->where('total_evaluaciones', '>', 0)->count() }}
                    </p>
                </div>
                <div class="bg-purple-50 rounded-lg p-4">
                    <p class="text-sm text-purple-600 font-medium">Ganadores Asignados</p>
                    <p class="text-3xl font-bold text-purple-900 mt-1">
                        {{ $equiposConCalificaciones->whereNotNull('puesto_actual')->count() }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Ranking de Equipos --}}
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-6">🏆 Ranking de Equipos</h3>

            @forelse($equiposConCalificaciones as $index => $data)
                <div class="mb-4 pb-4 border-b border-gray-200 last:border-0">
                    <div class="flex items-start justify-between">
                        {{-- Info del Equipo --}}
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                {{-- Posición en ranking --}}
                                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center font-bold text-lg
                                    {{ $index == 0 ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $index == 1 ? 'bg-gray-300 text-gray-700' : '' }}
                                    {{ $index == 2 ? 'bg-orange-100 text-orange-700' : '' }}">
                                    {{ $index + 1 }}
                                </div>

                                {{-- Nombre del equipo y proyecto --}}
                                <div>
                                    <h4 class="font-semibold text-gray-900 text-lg">{{ $data['equipo']->nombre }}</h4>
                                    @if($data['proyecto'])
                                        <p class="text-sm text-gray-600">{{ $data['proyecto']->nombre }}</p>
                                    @else
                                        <p class="text-sm text-gray-500 italic">Sin proyecto</p>
                                    @endif
                                </div>

                                {{-- Badge de puesto ganador --}}
                                @if($data['puesto_actual'])
                                    <span class="px-3 py-1 rounded-full text-sm font-semibold
                                        {{ $data['puesto_actual'] == 1 ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $data['puesto_actual'] == 2 ? 'bg-gray-200 text-gray-700' : '' }}
                                        {{ $data['puesto_actual'] == 3 ? 'bg-orange-100 text-orange-700' : '' }}
                                        {{ $data['puesto_actual'] > 3 ? 'bg-blue-100 text-blue-700' : '' }}">
                                        {{ $data['puesto_actual'] }}° Lugar
                                    </span>
                                @endif
                            </div>

                            {{-- Calificaciones --}}
                            <div class="ml-13 mt-2">
                                @if($data['promedio_general'])
                                    <div class="flex items-center gap-4">
                                        <div>
                                            <span class="text-sm text-gray-600">Promedio General:</span>
                                            <span class="text-2xl font-bold text-indigo-600 ml-2">{{ $data['promedio_general'] }}/100</span>
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            ({{ $data['total_evaluaciones'] }} evaluación{{ $data['total_evaluaciones'] != 1 ? 'es' : '' }})
                                        </div>
                                    </div>

                                    {{-- Detalle de evaluaciones --}}
                                    @if($data['evaluaciones']->count() > 0)
                                        <details class="mt-2">
                                            <summary class="cursor-pointer text-sm text-indigo-600 hover:text-indigo-800">
                                                Ver detalle de evaluaciones
                                            </summary>
                                            <div class="mt-2 ml-4 space-y-2">
                                                @foreach($data['evaluaciones'] as $evaluacion)
                                                    <div class="text-sm bg-gray-50 p-3 rounded">
                                                        <p class="font-medium">
                                                            Jurado: {{ $evaluacion->jurado->user->nombre }} {{ $evaluacion->jurado->user->app_paterno }}
                                                        </p>
                                                        <p class="text-gray-600">Calificación: {{ $evaluacion->calificacion_final }}/100</p>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </details>
                                    @endif
                                @else
                                    <p class="text-sm text-gray-500 italic">Sin evaluaciones finalizadas</p>
                                @endif
                            </div>
                        </div>

                        {{-- Acciones de Administrador --}}
                        <div class="flex flex-col gap-2 ml-4">
                            @if($data['puesto_actual'])
                                {{-- Quitar puesto --}}
                                <form action="{{ route('admin.eventos.resultados.quitar-puesto', $evento) }}" method="POST"
                                      onsubmit="return confirm('¿Quitar puesto ganador?')">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="id_inscripcion" value="{{ $data['inscripcion']->id_inscripcion }}">
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
                                        Quitar Puesto
                                    </button>
                                </form>
                            @else
                                {{-- Asignar puesto --}}
                                <form action="{{ route('admin.eventos.resultados.asignar-puesto', $evento) }}" method="POST" class="flex gap-2">
                                    @csrf
                                    <input type="hidden" name="id_inscripcion" value="{{ $data['inscripcion']->id_inscripcion }}">
                                    <select name="puesto" class="px-2 py-1 border border-gray-300 rounded text-sm">
                                        <option value="">Puesto...</option>
                                        @for($i = 1; $i <= 10; $i++)
                                            <option value="{{ $i }}">{{ $i }}° Lugar</option>
                                        @endfor
                                    </select>
                                    <button type="submit" class="px-3 py-1 bg-indigo-600 text-white rounded text-sm hover:bg-indigo-700">
                                        Asignar
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-12 text-gray-500">
                    <p class="font-semibold">No hay equipos registrados en este evento</p>
                </div>
            @endforelse
        </div>

        {{-- Información Adicional --}}
        <div class="mt-6 bg-blue-50 border-l-4 border-blue-400 p-4 rounded-r-lg">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-blue-600 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
                <div class="text-sm text-blue-700">
                    <p class="font-semibold">Cálculo de Calificaciones</p>
                    <p class="mt-1">El promedio general se calcula con las evaluaciones finalizadas de todos los jurados asignados al evento.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
