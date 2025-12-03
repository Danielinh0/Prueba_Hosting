@extends('jurado.layouts.app')

@section('content')
<div class="py-8 px-6 lg:px-12" style="background-color: #FFFDF4; min-height: 100vh;">
    <div class="max-w-7xl mx-auto">
        {{-- Sección Superior: Detalles del Equipo e Integrantes --}}
        <div class="flex flex-col lg:flex-row gap-8 mb-8">
            
            {{-- Detalles del Equipo --}}
            <div class="lg:w-1/3">
                <h2 class="text-xl font-semibold mb-4" style="color: #4B4B4B;">Detalles del Equipo :</h2>
                <div class="rounded-2xl overflow-hidden shadow-md" style="background-color: #FFEFDC;">
                    {{-- Imagen del equipo --}}
                    <div class="h-48 overflow-hidden">
                        @if($equipo->ruta_imagen)
                            <img src="{{ asset('storage/' . $equipo->ruta_imagen) }}" alt="Imagen del equipo" class="w-full h-full object-cover">
                        @else
                            <img src="{{ asset('images/team-default.jpg') }}" alt="Imagen del equipo" class="w-full h-full object-cover">
                        @endif
                    </div>
                    {{-- Nombre del equipo --}}
                    <div class="px-4 py-3" style="background-color: #CE894D;">
                        <h3 class="text-white font-semibold text-lg">{{ $equipo->nombre }}</h3>
                    </div>
                    {{-- Información del equipo --}}
                    <div class="p-4">
                        <p class="text-sm mb-3" style="color: #A4AEB7;">
                            <span class="font-medium">Creación:</span> {{ $equipo->created_at->translatedFormat('d \\d\\e F \\d\\e\\l Y') }}
                        </p>
                        <div class="rounded-xl p-3" style="background-color: rgba(255, 255, 255, 0.5); border: 1px solid #E5E7EB;">
                            <p class="text-sm" style="color: #A4AEB7;">{{ $equipo->descripcion ?? 'Sin descripción' }}</p>
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
                                    <span style="color: #F0BC7B;">{{ $miembro->rol->nombre ?? 'Sin rol asignado' }}</span>
                                </p>
                                <p class="text-sm" style="color: #4B4B4B;">
                                    <span class="font-medium">Carrera :</span> 
                                    <span style="color: #F0BC7B;">{{ $miembro->user->estudiante->carrera->nombre ?? 'Sin carrera' }}</span>
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

        {{-- Sección Avance --}}
        <div>
            <h2 class="text-xl font-semibold mb-4" style="color: #4B4B4B;">Ultimo avance registrado</h2>
            <div class="flex flex-col lg:flex-row gap-6">
                {{-- Formulario de Avance --}}
                <div class="lg:w-2/3">
                    <div class="rounded-2xl p-6 shadow-sm" style="background-color: #FFEFDC;">
                        <div class="mb-4">
                            <label class="block text-base font-medium mb-2" style="color: #4B4B4B;">Titulo del Avance</label>
                        </div>
                        <div class="rounded-xl p-4" style="background-color: rgba(255, 255, 255, 0.5); border: 1px solid #E5E7EB;">
                            <p style="color: #A4AEB7;">Descripcion del avance</p>
                        </div>
                    </div>
                </div>

                {{-- Ver Avances Disponibles --}}
                <div class="lg:w-1/3">
                    <div class="rounded-2xl p-6 shadow-sm" style="background-color: #FFEFDC;">
                        <h3 class="text-base font-semibold text-center mb-4" style="color: #4B4B4B;">Ver Avances Disponibles</h3>
                        <div class="mb-4">
                            <div class="relative">
                                <select class="w-full rounded-xl px-4 py-3 appearance-none focus:outline-none focus:ring-2" style="background-color: rgba(255, 255, 255, 0.5); border: 1px solid #E5E7EB; color: #A4AEB7;">
                                    <option>Avances</option>
                                    <option>Avance 1</option>
                                    <option>Avance 2</option>
                                    <option>Avance 3</option>
                                </select>
                                <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5" style="color: #F0BC7B;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <button class="w-full rounded-full py-3 text-white font-semibold transition-colors hover:opacity-90" style="background-color: #F0BC7B;">
                            Calificar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection