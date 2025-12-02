@extends('layouts.prueba')

@section('content')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
        
        .neomorphic-page {
            font-family: 'Poppins', sans-serif;
            background: #e8d5c4;
            min-height: 100vh;
        }
        
        .neomorphic-card {
            background: #e8d5c4;
            border-radius: 20px;
            box-shadow: 8px 8px 16px #c4b5a6, -8px -8px 16px #fff5e2;
        }
        
        .neomorphic-card-inset {
            background: #e8d5c4;
            border-radius: 20px;
            box-shadow: inset 6px 6px 12px #c4b5a6, inset -6px -6px 12px #fff5e2;
        }
        
        .neomorphic-stat {
            background: #e8d5c4;
            border-radius: 15px;
            box-shadow: 6px 6px 12px #c4b5a6, -6px -6px 12px #fff5e2;
            transition: all 0.3s ease;
        }
        
        .neomorphic-stat:hover {
            box-shadow: 10px 10px 20px #c4b5a6, -10px -10px 20px #fff5e2;
            transform: translateY(-5px);
        }
        
        .neomorphic-progress {
            background: #d4c1b0;
            border-radius: 10px;
            box-shadow: inset 3px 3px 6px #b8a899, inset -3px -3px 6px #f0dac9;
        }
        
        .neomorphic-progress-bar {
            background: linear-gradient(135deg, #e89a3c, #f5a847);
            border-radius: 10px;
            box-shadow: 2px 2px 4px rgba(232, 154, 60, 0.3);
        }
        
        .neomorphic-badge {
            border-radius: 20px;
            font-weight: 600;
            padding: 8px 16px;
            box-shadow: 4px 4px 8px #c4b5a6, -4px -4px 8px #fff5e2;
        }
        
        .neomorphic-image-card {
            border-radius: 20px;
            overflow: hidden;
            background: #e8d5c4;
            box-shadow: 8px 8px 16px #c4b5a6, -8px -8px 16px #fff5e2;
        }
        
        .neomorphic-scroll-container {
            overflow-x: auto;
            scrollbar-width: thin;
            scrollbar-color: #e89a3c #e8d5c4;
        }
        
        .neomorphic-scroll-container::-webkit-scrollbar {
            height: 8px;
        }
        
        .neomorphic-scroll-container::-webkit-scrollbar-track {
            background: #d4c1b0;
            border-radius: 10px;
        }
        
        .neomorphic-scroll-container::-webkit-scrollbar-thumb {
            background: #e89a3c;
            border-radius: 10px;
        }
        
        .text-primary-neuro {
            color: #2c2c2c;
        }
        
        .text-secondary-neuro {
            color: #6b6b6b;
        }
        
        .text-accent-neuro {
            color: #e89a3c;
        }
        
        .bg-warning-neuro {
            background: #fff4e6;
            color: #e89a3c;
        }
        
        .bg-danger-neuro {
            background: #ffe6e6;
            color: #d94545;
        }
        
        .bg-success-neuro {
            background: #e6f7e6;
            color: #45a045;
        }
        
        .bg-neutral-neuro {
            background: #f0f0f0;
            color: #6b6b6b;
        }
    </style>

    <div class="neomorphic-page py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="font-bold text-2xl text-primary-neuro mb-6">Mi Panel</h2>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="neomorphic-stat p-5 text-center">
                    <div class="text-primary-neuro">
                        <p class="text-4xl font-bold">Nivel {{ Auth::user()->stats->nivel ?? 1 }}</p>
                        <p class="text-xs mt-2 text-secondary-neuro">{{ number_format(Auth::user()->stats->total_xp ?? 0) }} XP Total</p>
                        <div class="neomorphic-progress w-full h-2 mt-3">
                            <div class="neomorphic-progress-bar h-2" style="width: {{ Auth::user()->stats->progreso_nivel ?? 0 }}%"></div>
                        </div>
                    </div>
                </div>
                
                <div class="neomorphic-stat p-5 text-center">
                    <div class="text-primary-neuro">
                        <svg class="w-8 h-8 mx-auto mb-1 text-accent-neuro" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p class="text-3xl font-bold">{{ Auth::user()->stats->eventos_participados ?? 0 }}</p>
                        <p class="text-xs mt-1 text-secondary-neuro">Eventos Participados</p>
                    </div>
                </div>
                
                <div class="neomorphic-stat p-5 text-center">
                    <div class="text-primary-neuro">
                        <svg class="w-8 h-8 mx-auto mb-1 text-accent-neuro" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                        <p class="text-3xl font-bold">{{ Auth::user()->habilidades->count() }}</p>
                        <p class="text-xs mt-1 text-secondary-neuro">Habilidades</p>
                    </div>
                </div>
                
                <div class="neomorphic-stat p-5 text-center">
                    <div class="text-primary-neuro">
                        <svg class="w-8 h-8 mx-auto mb-1 text-accent-neuro" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                        </svg>
                        <p class="text-3xl font-bold">{{ Auth::user()->logros->count() }}</p>
                        <p class="text-xs mt-1 text-secondary-neuro">Logros Desbloqueados</p>
                    </div>
                </div>
            </div>

            @if($miInscripcion && $miInscripcion->evento)
                <div class="neomorphic-card p-6 mb-8">
                    <div class="flex items-center mb-4">
                        <svg class="w-6 h-6 mr-3 text-primary-neuro" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="text-xl font-bold text-primary-neuro">Próximas Fechas Importantes</h3>
                    </div>
                    
                    <div class="space-y-3">
                        <div class="neomorphic-card-inset rounded-lg p-4">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="font-semibold text-primary-neuro text-lg">{{ $miInscripcion->evento->nombre }}</p>
                                    <p class="text-sm text-secondary-neuro">Finaliza el {{ $miInscripcion->evento->fecha_fin->format('d/m/Y') }}</p>
                                </div>
                                @php
                                    $diasRestantes = now()->diffInDays($miInscripcion->evento->fecha_fin, false);
                                    $badgeColor = 'bg-neutral-neuro'; 
                                    if ($diasRestantes <= 7 && $diasRestantes > 0) {
                                        $badgeColor = 'bg-danger-neuro'; 
                                    } elseif ($diasRestantes <= 14 && $diasRestantes > 7) {
                                        $badgeColor = 'bg-warning-neuro'; 
                                    } elseif ($diasRestantes == 0) {
                                        $badgeColor = 'bg-success-neuro'; 
                                    } elseif ($diasRestantes < 0) {
                                        $badgeColor = 'bg-danger-neuro'; 
                                    }
                                @endphp
                                <span class="neomorphic-badge {{ $badgeColor }}">
                                    @if($diasRestantes > 0)
                                        En {{ $diasRestantes }} {{ $diasRestantes == 1 ? 'día' : 'días' }}
                                    @elseif($diasRestantes == 0)
                                        HOY
                                    @else
                                        Finalizado
                                    @endif
                                </span>
                            </div>
                        </div>

                        @if($miInscripcion->proyecto && $miInscripcion->proyecto->hitos->where('completado', false)->count() > 0)
                            @php
                                $proximoHito = $miInscripcion->proyecto->hitos->where('completado', false)->sortBy('fecha_limite')->first();
                            @endphp
                            @if($proximoHito && $proximoHito->fecha_limite)
                                <div class="neomorphic-card-inset rounded-lg p-4">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <p class="font-semibold text-primary-neuro">Hito: {{ $proximoHito->nombre }}</p>
                                            <p class="text-sm text-secondary-neuro">Fecha límite: {{ $proximoHito->fecha_limite->format('d/m/Y') }}</p>
                                        </div>
                                        @php
                                            $diasHito = now()->diffInDays($proximoHito->fecha_limite, false);
                                            $badgeHito = 'bg-neutral-neuro'; 
                                            if ($diasHito <= 3 && $diasHito > 0) {
                                                $badgeHito = 'bg-danger-neuro'; 
                                            } elseif ($diasHito <= 7 && $diasHito > 3) {
                                                $badgeHito = 'bg-warning-neuro'; 
                                            } elseif ($diasHito == 0) {
                                                $badgeHito = 'bg-success-neuro'; 
                                            } elseif ($diasHito < 0) {
                                                $badgeHito = 'bg-danger-neuro'; 
                                            }
                                        @endphp
                                        <span class="neomorphic-badge {{ $badgeHito }}">
                                            @if($diasHito > 0)
                                                En {{ $diasHito }} {{ $diasHito == 1 ? 'día' : 'días' }}
                                            @elseif($diasHito == 0)
                                                HOY
                                            @else
                                                Vencido
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            @endif

            @if ($miInscripcion && $miInscripcion->evento)
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
                    
                    <div class="lg:col-span-2">
                        <h3 class="text-lg font-semibold text-primary-neuro mb-4">Mi Evento Activo</h3>
                        <div class="neomorphic-image-card">
                            <a href="{{ route('estudiante.eventos.show', $miInscripcion->evento) }}">
                                <img class="h-56 w-full object-cover" src="{{ asset('storage/' . $miInscripcion->evento->ruta_imagen) }}" alt="Imagen del evento">
                            </a>
                            <div class="p-6 bg-[#e8d5c4]">
                                <h4 class="font-bold text-xl text-primary-neuro">{{ $miInscripcion->evento->nombre }}</h4>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-primary-neuro mb-4">Mi Equipo</h3>
                        <div class="neomorphic-image-card">
                            @if($miInscripcion->equipo->ruta_imagen)
                                <a href="{{ route('estudiante.equipo.index') }}">
                                    <img class="h-40 w-full object-cover" src="{{ asset('storage/' . $miInscripcion->equipo->ruta_imagen) }}" alt="Imagen del equipo">
                                </a>
                            @endif
                            <div class="p-6 bg-[#e8d5c4]">
                                <a href="{{ route('estudiante.equipo.index') }}" class="font-bold text-xl text-primary-neuro hover:text-accent-neuro transition">
                                    {{ $miInscripcion->equipo->nombre }}
                                </a>
                                
                                @if($miInscripcion->equipo->descripcion)
                                    <p class="text-sm text-secondary-neuro mt-2 line-clamp-2">{{ $miInscripcion->equipo->descripcion }}</p>
                                @endif

                                <div class="mt-4">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-xs font-semibold text-secondary-neuro">Progreso del Proyecto</span>
                                        <span class="text-xs font-semibold text-accent-neuro">0%</span>
                                    </div>
                                    <div class="neomorphic-progress w-full h-2.5">
                                        <div class="neomorphic-progress-bar h-2.5 transition-all duration-500" style="width: 0%"></div>
                                    </div>
                                    <p class="text-xs text-secondary-neuro mt-1 italic">La lógica de progreso se implementará con el sistema de avances</p>
                                </div>

                                <a href="{{ route('estudiante.equipo.index') }}" class="mt-4 inline-flex items-center text-sm text-accent-neuro font-semibold hover:opacity-80 transition">
                                    Ver Detalles del Equipo
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="neomorphic-card p-6 mb-12 border-l-4 border-accent-neuro">
                    <h3 class="font-bold text-lg text-primary-neuro">Bienvenido</h3>
                    <p class="mt-2 text-secondary-neuro">Parece que no estás participando en ningún evento activo en este momento. Explora los próximos eventos para unirte a la acción.</p>
                </div>
            @endif


            <div>
                <h3 class="text-2xl font-bold text-primary-neuro mb-6">Eventos Disponibles</h3>
                <div class="neomorphic-scroll-container flex overflow-x-auto space-x-6 pb-4">
                    @forelse ($eventosDisponibles as $evento)
                        <div class="flex-shrink-0 w-80 neomorphic-image-card transform hover:scale-105 transition-transform duration-300 ease-in-out">
                            <a href="{{ route('estudiante.eventos.show', $evento) }}">
                                <img class="h-40 w-full object-cover" src="{{ asset('storage/' . $evento->ruta_imagen) }}" alt="Imagen del evento">
                            </a>
                            <div class="p-4 bg-[#e8d5c4]">
                                <h4 class="font-semibold text-lg text-primary-neuro truncate">{{ $evento->nombre }}</h4>
                                <p class="text-secondary-neuro text-sm mt-1">
                                    Inicia: {{ $evento->fecha_inicio->format('d M, Y') }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-1 text-center py-10 w-full">
                            <p class="text-secondary-neuro">No hay eventos disponibles en este momento.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            @if ($miInscripcion && $miInscripcion->evento)
                <div class="mt-12">
                    <h3 class="text-2xl font-bold text-primary-neuro mb-6">Mis Constancias</h3>
                    <div class="neomorphic-card p-8">
                        <div class="text-center">
                            <svg class="mx-auto h-16 w-16 text-secondary-neuro" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <h3 class="mt-4 text-lg font-medium text-primary-neuro">Constancias no disponibles aún</h3>
                            <p class="mt-2 text-sm text-secondary-neuro">
                                Las constancias se generarán automáticamente cuando se complete el proyecto y se realice la evaluación final por los jurados.
                            </p>
                            <p class="mt-1 text-xs text-secondary-neuro italic">
                                Esta funcionalidad se implementará con el sistema de evaluaciones y proyectos.
                            </p>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection