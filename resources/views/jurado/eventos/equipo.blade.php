@extends('jurado.layouts.app')

@section('content')
<div class="py-8 px-6 lg:px-12" style="background-color: #FFFDF4; min-height: 100vh;">
    <div class="max-w-7xl mx-auto">
        {{-- Sección Superior: Detalles del Equipo e Integrantes --}}
        <div class="flex flex-col lg:flex-row gap-8 mb-8">
            
            {{-- Detalles del Equipo/Proyecto --}}
            <div class="lg:w-1/3">
                <h2 class="text-xl font-semibold mb-4" style="color: #4B4B4B;">Nombre del equipo</h2>
                <div class="rounded-2xl overflow-hidden shadow-md" style="background-color: #FFEFDC;">
                    {{-- Imagen del equipo --}}
                    <div class="h-48 overflow-hidden">
                        @if($equipo->ruta_imagen)
                            <img src="{{ asset('storage/' . $equipo->ruta_imagen) }}" alt="Imagen del equipo" class="w-full h-full object-cover">
                        @else
                            <img src="{{ asset('images/team-default.jpg') }}" alt="Imagen del equipo" class="w-full h-full object-cover">
                        @endif
                    </div>
                    {{-- Nombre del proyecto --}}
                    <div class="px-4 py-3" style="background-color: #CE894D;">
                        <h3 class="text-white font-semibold text-lg">{{ $proyecto->nombre ?? 'Sin proyecto' }}</h3>
                    </div>
                    {{-- Información del proyecto --}}
                    <div class="p-4">
                        <p class="text-sm mb-3" style="color: #4B4B4B;">
                            <span class="font-medium">Creación:</span> 
                            <span style="color: #A4AEB7;">{{ $equipo->created_at->translatedFormat('d \\d\\e F \\d\\e\\l Y') }}</span>
                        </p>
                        <div class="rounded-xl p-3" style="background-color: rgba(255, 255, 255, 0.5); border: 1px solid #E5E7EB;">
                            <p class="text-sm" style="color: #4B4B4B;">{{ $proyecto->descripcion_tecnica ?? 'Objetivo del proyecto' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Integrantes --}}
            <div class="lg:w-2/3">
                <h2 class="text-xl font-semibold mb-4" style="color: #4B4B4B;">Integrantes :</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @forelse($miembros as $index => $miembro)
                        @php
                            $isLastAndOdd = ($loop->last && $miembros->count() % 2 != 0);
                        @endphp
                        <div class="flex items-center gap-4 rounded-2xl p-4 shadow-sm {{ $isLastAndOdd ? 'md:col-span-2 md:w-1/2 md:mx-auto' : '' }}" style="background-color: #FFEFDC;">
                            <div class="w-20 h-20 rounded-xl overflow-hidden flex-shrink-0" style="background-color: #FFFDF4;">
                                <img src="{{ $miembro->user->foto_perfil_url }}" alt="Foto de {{ $miembro->user->nombre }}" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1">
                                <h4 class="font-semibold text-base" style="color: #4B4B4B;">{{ $miembro->user->nombre }} {{ $miembro->user->app_paterno }}</h4>
                                <h4 class="font-semibold text-base mb-2" style="color: #4B4B4B;">{{ $miembro->user->app_materno }}</h4>
                                <p class="text-sm" style="color: #4B4B4B;">
                                    <span class="font-medium">Rol :</span> 
                                    <span style="color: #A4AEB7;">{{ $miembro->rol->nombre ?? 'Sin rol asignado' }}</span>
                                </p>
                                <p class="text-sm" style="color: #4B4B4B;">
                                    <span class="font-medium">Carrera :</span> 
                                    <span style="color: #A4AEB7;">{{ $miembro->user->estudiante->carrera->nombre ?? 'Sin carrera' }}</span>
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="md:col-span-2 text-center py-8">
                            <p style="color: #A4AEB7;">No hay miembros registrados en este equipo para este evento.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Sección Avances --}}
        <div>
            <h2 class="text-xl font-semibold mb-4" style="color: #4B4B4B;">Avances</h2>
            <div class="flex flex-col lg:flex-row gap-6">
                {{-- Estadísticas de Avances --}}
                <div class="lg:w-2/3">
                    <div class="rounded-2xl p-6 shadow-sm" style="background-color: #FFEFDC;">
                        <div class="grid grid-cols-3 gap-4">
                            {{-- Avances --}}
                            <div class="text-center">
                                <div class="text-3xl font-bold mb-2" style="color: #4B4B4B;">{{ $totalAvances }}</div>
                                <div class="flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" style="color: #A4AEB7;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                    </svg>
                                    <span style="color: #4B4B4B;" class="font-medium">Avances</span>
                                </div>
                            </div>
                            {{-- Progreso --}}
                            <div class="text-center">
                                <div class="text-3xl font-bold mb-2" style="color: #4B4B4B;">{{ $progreso }}%</div>
                                <div class="flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" style="color: #A4AEB7;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span style="color: #4B4B4B;" class="font-medium">Progreso</span>
                                </div>
                            </div>
                            {{-- Tareas --}}
                            <div class="text-center">
                                <div class="text-3xl font-bold mb-2" style="color: #4B4B4B;">{{ $totalTareas }}</div>
                                <div class="flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" style="color: #A4AEB7;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                    </svg>
                                    <span style="color: #4B4B4B;" class="font-medium">Tareas</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Ver Avances Disponibles --}}
                <div class="lg:w-1/3">
                    <div class="rounded-2xl p-6 shadow-sm" style="background-color: #FFEFDC;">
                        <h3 class="text-base font-semibold text-center mb-4" style="color: #4B4B4B;">Ver Avances Disponibles</h3>
                        <div class="mb-4">
                            <div class="relative">
                                <select id="avance-selector" class="w-full rounded-xl px-4 py-3 appearance-none focus:outline-none focus:ring-2" style="background-color: rgba(255, 255, 255, 0.5); border: 1px solid #E5E7EB; color: #4B4B4B;">
                                    <option value="">Avances</option>
                                    @foreach($avances as $avance)
                                        <option value="{{ $avance->id_avance }}">{{ $avance->titulo ?? 'Avance #' . $loop->iteration }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5" style="color: #F0BC7B;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <button onclick="calificarAvance()" class="w-full rounded-full py-3 text-white font-semibold transition-colors hover:opacity-90" style="background-color: #F0BC7B;">
                            Calificar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function calificarAvance() {
        const selector = document.getElementById('avance-selector');
        const avanceId = selector.value;
        
        if (!avanceId) {
            alert('Por favor selecciona un avance para calificar');
            return;
        }
        
        // Redirigir a la página de calificación (puedes ajustar esta ruta)
        window.location.href = `/jurado/avances/${avanceId}/calificar`;
    }
</script>
@endsection