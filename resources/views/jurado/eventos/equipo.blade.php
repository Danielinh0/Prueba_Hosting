@extends('jurado.layouts.app')

@section('content')
<style>
    /* Botón volver */
    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(255, 255, 255, 0.9);
        color: #e89a3c;
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 0.9rem;
        padding: 0.75rem 1.25rem;
        border-radius: 10px;
        text-decoration: none;
        box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.08), -2px -2px 8px rgba(255, 255, 255, 0.9);
        transition: all 0.3s ease;
        margin-bottom: 1.5rem;
    }

    .back-btn:hover {
        background: linear-gradient(135deg, #e89a3c, #f5a847);
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(232, 154, 60, 0.3);
    }

    .back-btn:hover svg path {
        stroke: #ffffff;
    }
</style>

<div class="py-8 px-6 lg:px-12" style="background: linear-gradient(135deg, #fef3e2 0%, #fde8d0 100%); min-height: 100vh;">
    <div class="max-w-7xl mx-auto">
        <!-- Botón volver al evento -->
        <a href="{{ route('jurado.eventos.show', $evento->id_evento) }}" class="back-btn">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" width="20" height="20">
                <path d="M15 6L9 12L15 18" stroke="#e89a3c" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Volver al Evento
        </a>

        {{-- Sección Superior: Detalles del Equipo e Integrantes --}}
        <div class="flex flex-col lg:flex-row gap-8 mb-8">
            
            {{-- Detalles del Equipo/Proyecto --}}
            <div class="lg:w-1/3">
                <h2 class="text-xl font-semibold mb-4" style="color: #2c2c2c; font-family: 'Poppins', sans-serif;">Nombre del equipo</h2>
                <div class="rounded-2xl overflow-hidden" style="background: rgba(255, 255, 255, 0.9); box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.08), -2px -2px 8px rgba(255, 255, 255, 0.9);">
                    {{-- Imagen del equipo --}}
                    <div class="h-48 overflow-hidden">
                        @if($equipo->ruta_imagen)
                            <img src="{{ asset('storage/' . $equipo->ruta_imagen) }}" alt="Imagen del equipo" class="w-full h-full object-cover">
                        @else
                            <img src="{{ asset('images/team-default.jpg') }}" alt="Imagen del equipo" class="w-full h-full object-cover">
                        @endif
                    </div>
                    {{-- Nombre del proyecto --}}
                    <div class="px-4 py-3" style="background: linear-gradient(135deg, #e89a3c, #f5a847);">
                        <h3 class="text-white font-semibold text-lg" style="font-family: 'Poppins', sans-serif;">{{ $proyecto->nombre ?? 'Sin proyecto' }}</h3>
                    </div>
                    {{-- Información del proyecto --}}
                    <div class="p-4" style="background: rgba(254, 243, 226, 0.5);">
                        <p class="text-sm mb-3" style="color: #2c2c2c; font-family: 'Poppins', sans-serif;">
                            <span class="font-medium">Creación:</span> 
                            <span style="color: #5c5c5c;">{{ $equipo->created_at->translatedFormat('d \\d\\e F \\d\\e\\l Y') }}</span>
                        </p>
                        <div class="rounded-xl p-3" style="background-color: rgba(255, 255, 255, 0.7); border: 1px solid rgba(232, 154, 60, 0.2);">
                            <p class="text-sm" style="color: #5c5c5c; font-family: 'Poppins', sans-serif;">{{ $proyecto->descripcion_tecnica ?? 'Objetivo del proyecto' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Integrantes --}}
            <div class="lg:w-2/3">
                <h2 class="text-xl font-semibold mb-4" style="color: #2c2c2c; font-family: 'Poppins', sans-serif;">Integrantes :</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @forelse($miembros as $index => $miembro)
                        @php
                            $isLastAndOdd = ($loop->last && $miembros->count() % 2 != 0);
                        @endphp
                        <div class="flex items-center gap-4 rounded-2xl p-4 {{ $isLastAndOdd ? 'md:col-span-2 md:w-1/2 md:mx-auto' : '' }}" style="background: rgba(255, 255, 255, 0.9); box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.08), -2px -2px 8px rgba(255, 255, 255, 0.9);">
                            <div class="w-20 h-20 rounded-xl overflow-hidden flex-shrink-0" style="background: rgba(254, 243, 226, 0.8);">
                                <img src="{{ $miembro->user->foto_perfil_url }}" alt="Foto de {{ $miembro->user->nombre }}" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1">
                                <h4 class="font-semibold text-base" style="color: #2c2c2c; font-family: 'Poppins', sans-serif;">{{ $miembro->user->nombre }} {{ $miembro->user->app_paterno }}</h4>
                                <h4 class="font-semibold text-base mb-2" style="color: #2c2c2c; font-family: 'Poppins', sans-serif;">{{ $miembro->user->app_materno }}</h4>
                                <p class="text-sm" style="color: #2c2c2c; font-family: 'Poppins', sans-serif;">
                                    <span class="font-medium">Rol :</span> 
                                    <span style="color: #5c5c5c;">{{ $miembro->rol->nombre ?? 'Sin rol asignado' }}</span>
                                </p>
                                <p class="text-sm" style="color: #2c2c2c; font-family: 'Poppins', sans-serif;">
                                    <span class="font-medium">Carrera :</span> 
                                    <span style="color: #5c5c5c;">{{ $miembro->user->estudiante->carrera->nombre ?? 'Sin carrera' }}</span>
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="md:col-span-2 text-center py-8">
                            <p style="color: #5c5c5c; font-family: 'Poppins', sans-serif;">No hay miembros registrados en este equipo para este evento.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Sección Avances --}}
        <div>
            <h2 class="text-xl font-semibold mb-4" style="color: #2c2c2c; font-family: 'Poppins', sans-serif;">Avances</h2>
            <div class="flex flex-col lg:flex-row gap-6">
                {{-- Estadísticas de Avances --}}
                <div class="lg:w-2/3">
                    <div class="rounded-2xl p-6" style="background: rgba(255, 255, 255, 0.9); box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.08), -2px -2px 8px rgba(255, 255, 255, 0.9);">
                        <div class="grid grid-cols-4 gap-4">
                            {{-- Avances --}}
                            <div class="text-center">
                                <div class="text-3xl font-bold mb-2" style="color: #e89a3c; font-family: 'Poppins', sans-serif;">{{ $totalAvances }}</div>
                                <div class="flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" style="color: #d4a056;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                    </svg>
                                    <span style="color: #2c2c2c; font-family: 'Poppins', sans-serif;" class="font-medium">Avances</span>
                                </div>
                            </div>
                            {{-- Avances Calificados --}}
                            <div class="text-center">
                                <div class="text-3xl font-bold mb-2" style="color: #e89a3c; font-family: 'Poppins', sans-serif;">{{ $avancesCalificados }}</div>
                                <div class="flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" style="color: #d4a056;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span style="color: #2c2c2c; font-family: 'Poppins', sans-serif;" class="font-medium text-sm">Calificados</span>
                                </div>
                            </div>
                            {{-- Progreso --}}
                            <div class="text-center">
                                <div class="text-3xl font-bold mb-2" style="color: #e89a3c; font-family: 'Poppins', sans-serif;">{{ $progreso }}%</div>
                                <div class="flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" style="color: #d4a056;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span style="color: #2c2c2c; font-family: 'Poppins', sans-serif;" class="font-medium">Porcentaje de tareas</span>
                                </div>
                            </div>
                            {{-- Tareas --}}
                            <div class="text-center">
                                <div class="text-3xl font-bold mb-2" style="color: #e89a3c; font-family: 'Poppins', sans-serif;">{{ $totalTareas }}</div>
                                <div class="flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" style="color: #d4a056;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                    </svg>
                                    <span style="color: #2c2c2c; font-family: 'Poppins', sans-serif;" class="font-medium">Tareas</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Botón Evaluar Proyecto --}}
                    <div class="mt-4">
                        @if($yaEvaluoProyecto)
                            {{-- Ya evaluado (Finalizada) - mostrar botón ver evaluación --}}
                            <a href="{{ route('jurado.evaluaciones.show', $evaluacionFinalExistente->id_evaluacion) }}" 
                               class="block w-full rounded-full py-3 text-white font-semibold transition-colors hover:opacity-90 text-center"
                               style="background-color: #10B981;">
                                <span class="flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Ver Mi Evaluación
                                </span>
                            </a>
                            <p class="text-center text-sm mt-2" style="color: #10B981;">
                                Ya has evaluado este proyecto ({{ number_format($evaluacionFinalExistente->calificacion_final, 1) }}/100)
                            </p>
                        @elseif($evaluacionEnBorrador)
                            {{-- Evaluación en borrador - mostrar botón retomar --}}
                            <a href="{{ route('jurado.evaluaciones.create', $inscripcion->id_inscripcion) }}" 
                               class="block w-full rounded-full py-3 text-white font-semibold transition-colors hover:opacity-90 text-center"
                               style="background-color: #F59E0B;">
                                <span class="flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Retomar Evaluación
                                </span>
                            </a>
                            <p class="text-center text-sm mt-2" style="color: #F59E0B;">
                                Tienes una evaluación en borrador pendiente de finalizar
                            </p>
                        @else
                            <button type="button" 
                                    id="btn-evaluar-proyecto"
                                    onclick="mostrarModalEvaluarProyecto()"
                                    class="w-full rounded-full py-3 text-white font-semibold transition-colors {{ $todosCalificados ? 'hover:opacity-90' : 'opacity-50 cursor-not-allowed' }}"
                                    style="background: linear-gradient(135deg, #e89a3c, #f5a847); font-family: 'Poppins', sans-serif;"
                                    {{ $todosCalificados ? '' : 'disabled' }}>
                                Evaluar Proyecto
                            </button>
                            @if(!$todosCalificados && $totalAvances > 0)
                                <p class="text-center text-sm mt-2" style="color: #5c5c5c; font-family: 'Poppins', sans-serif;">
                                    Debes calificar todos los avances ({{ $avancesCalificados }}/{{ $totalAvances }}) antes de evaluar el proyecto
                                </p>
                            @elseif($totalAvances == 0)
                                <p class="text-center text-sm mt-2" style="color: #5c5c5c; font-family: 'Poppins', sans-serif;">
                                    No hay avances registrados para este proyecto
                                </p>
                            @endif
                        @endif
                    </div>
                </div>

                {{-- Ver Avances Disponibles --}}
                <div class="lg:w-1/3">
                    <div class="rounded-2xl p-6" style="background: rgba(255, 255, 255, 0.9); box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.08), -2px -2px 8px rgba(255, 255, 255, 0.9);">
                        <h3 class="text-base font-semibold text-center mb-4" style="color: #2c2c2c; font-family: 'Poppins', sans-serif;">Ver Avances Disponibles</h3>
                        
                        @if($yaEvaluoProyecto)
                            {{-- Mensaje de bloqueo cuando ya se evaluó --}}
                            <div class="rounded-xl p-4 mb-4" style="background-color: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.3);">
                                <div class="flex items-center gap-3">
                                    <svg class="w-6 h-6 flex-shrink-0" style="color: #059669;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                    <div>
                                        <p class="font-semibold text-sm" style="color: #059669;">Evaluación Finalizada</p>
                                        <p class="text-xs" style="color: #10B981;">Los avances ya no pueden ser modificados</p>
                                    </div>
                                </div>
                            </div>
                            {{-- Selector deshabilitado --}}
                            <div class="mb-4 opacity-60">
                                <div class="relative">
                                    <select disabled class="w-full rounded-xl px-4 py-3 appearance-none cursor-not-allowed" style="background-color: rgba(255, 255, 255, 0.5); border: 1px solid rgba(232, 154, 60, 0.3); color: #5c5c5c; font-family: 'Poppins', sans-serif;">
                                        <option>{{ $totalAvances }} avance(s) calificado(s)</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5" style="color: #d4a056;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            {{-- Botones deshabilitados --}}
                            <div class="flex gap-2">
                                <button type="button" disabled class="flex-1 rounded-full py-3 text-white font-semibold opacity-50 cursor-not-allowed" style="background: linear-gradient(135deg, #e89a3c, #f5a847); font-family: 'Poppins', sans-serif;">
                                    Calificar
                                </button>
                                <button type="button" disabled class="flex-1 rounded-full py-3 font-semibold opacity-50 cursor-not-allowed" style="background: linear-gradient(135deg, #d4a056, #c9914a); color: white; font-family: 'Poppins', sans-serif;">
                                    Reevaluar
                                </button>
                            </div>
                        @else
                            <div class="mb-4">
                                <div class="relative">
                                    <select id="avance-selector" class="w-full rounded-xl px-4 py-3 appearance-none focus:outline-none focus:ring-2" style="background-color: rgba(255, 255, 255, 0.7); border: 1px solid rgba(232, 154, 60, 0.3); color: #2c2c2c; font-family: 'Poppins', sans-serif;">
                                        <option value="">Seleccionar avance...</option>
                                        @foreach($avances as $avance)
                                            @php
                                                $yaCalificado = in_array($avance->id_avance, $avancesCalificadosIds);
                                            @endphp
                                            <option value="{{ $avance->id_avance }}" data-calificado="{{ $yaCalificado ? 'true' : 'false' }}">
                                                {!! $avance->titulo ?? 'Avance #' . $loop->iteration !!} {!! $yaCalificado ? ' (Calificado)' : '' !!}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5" style="color: #e89a3c;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <button type="button" id="btn-calificar" class="flex-1 rounded-full py-3 text-white font-semibold transition-colors hover:opacity-90" style="background: linear-gradient(135deg, #e89a3c, #f5a847); font-family: 'Poppins', sans-serif;">
                                    Calificar
                                </button>
                                <button type="button" id="btn-reevaluar" class="flex-1 rounded-full py-3 font-semibold transition-colors hover:opacity-90 opacity-50 cursor-not-allowed" style="background: linear-gradient(135deg, #d4a056, #c9914a); color: white; font-family: 'Poppins', sans-serif;" disabled>
                                    Reevaluar
                                </button>
                            </div>
                            <p id="hint-calificar" class="text-center text-xs mt-2 hidden" style="color: #5c5c5c; font-family: 'Poppins', sans-serif;">
                                Este avance aún no ha sido calificado
                            </p>
                            <p id="hint-reevaluar" class="text-center text-xs mt-2 hidden" style="color: #d4a056; font-family: 'Poppins', sans-serif;">
                                Este avance ya fue calificado, puedes reevaluarlo
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    @if(!$yaEvaluoProyecto)
    const avancesCalificadosIds = @json($avancesCalificadosIds);
    const selector = document.getElementById('avance-selector');
    const btnCalificar = document.getElementById('btn-calificar');
    const btnReevaluar = document.getElementById('btn-reevaluar');
    const hintCalificar = document.getElementById('hint-calificar');
    const hintReevaluar = document.getElementById('hint-reevaluar');

    // Función para actualizar estado de botones según avance seleccionado
    function actualizarBotones() {
        const avanceId = parseInt(selector.value);
        const yaCalificado = avancesCalificadosIds.includes(avanceId);

        // Ocultar hints primero
        hintCalificar.classList.add('hidden');
        hintReevaluar.classList.add('hidden');

        if (!avanceId) {
            // Sin selección - ambos deshabilitados
            btnCalificar.disabled = true;
            btnCalificar.classList.add('opacity-50', 'cursor-not-allowed');
            btnReevaluar.disabled = true;
            btnReevaluar.classList.add('opacity-50', 'cursor-not-allowed');
        } else if (yaCalificado) {
            // Ya calificado - solo Reevaluar activo
            btnCalificar.disabled = true;
            btnCalificar.classList.add('opacity-50', 'cursor-not-allowed');
            btnReevaluar.disabled = false;
            btnReevaluar.classList.remove('opacity-50', 'cursor-not-allowed');
            hintReevaluar.classList.remove('hidden');
        } else {
            // No calificado - solo Calificar activo
            btnCalificar.disabled = false;
            btnCalificar.classList.remove('opacity-50', 'cursor-not-allowed');
            btnReevaluar.disabled = true;
            btnReevaluar.classList.add('opacity-50', 'cursor-not-allowed');
            hintCalificar.classList.remove('hidden');
        }
    }

    // Escuchar cambios en el selector
    selector.addEventListener('change', actualizarBotones);

    // Inicializar estado al cargar
    actualizarBotones();

    // Función para ir a calificar/reevaluar
    function irACalificar() {
        const avanceId = selector.value;
        if (!avanceId) {
            mostrarModalAlerta('Sin selección', 'Por favor selecciona un avance antes de continuar.');
            return;
        }
        const url = "{{ route('jurado.eventos.calificar_avance', [$evento->id_evento, $equipo->id_equipo, ':avanceId']) }}".replace(':avanceId', avanceId);
        window.location.href = url;
    }

    btnCalificar.addEventListener('click', function() {
        if (!this.disabled) irACalificar();
    });

    btnReevaluar.addEventListener('click', function() {
        if (!this.disabled) {
            mostrarModalConfirmar(
                'Reevaluar Avance',
                '¿Estás seguro de que deseas reevaluar este avance? La calificación anterior será reemplazada.',
                'Sí, reevaluar',
                irACalificar
            );
        }
    });

    function mostrarModalEvaluarProyecto() {
        @if($todosCalificados)
            mostrarModalConfirmar(
                'Evaluar Proyecto',
                '¿Estás seguro de que deseas evaluar el proyecto completo? Ya has calificado todos los avances ({{ $avancesCalificados }}/{{ $totalAvances }}).',
                'Sí, evaluar proyecto',
                function() {
                    window.location.href = "{{ route('jurado.evaluaciones.create', $inscripcion->id_inscripcion ?? 0) }}";
                }
            );
        @else
            mostrarModalAlerta(
                'Avances pendientes',
                'Debes calificar todos los avances antes de poder evaluar el proyecto.\n\nAvances calificados: {{ $avancesCalificados }}/{{ $totalAvances }}'
            );
        @endif
    }
    @endif

    // ========== FUNCIONES DE MODALES ==========

    function mostrarModalAlerta(titulo, mensaje) {
        const modal = crearModal(titulo, mensaje, false);
        document.body.appendChild(modal);
        setTimeout(() => modal.classList.remove('opacity-0'), 10);
    }

    function mostrarModalConfirmar(titulo, mensaje, textoConfirmar, onConfirm) {
        const modal = crearModal(titulo, mensaje, true, textoConfirmar, onConfirm);
        document.body.appendChild(modal);
        setTimeout(() => modal.classList.remove('opacity-0'), 10);
    }

    function crearModal(titulo, mensaje, esConfirmacion, textoConfirmar = 'Confirmar', onConfirm = null) {
        // Contenedor del modal
        const overlay = document.createElement('div');
        overlay.className = 'fixed inset-0 z-50 flex items-center justify-center p-4 opacity-0 transition-opacity duration-300';
        overlay.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
        overlay.onclick = function(e) {
            if (e.target === overlay) cerrarModal(overlay);
        };

        // Contenido del modal
        const modalContent = document.createElement('div');
        modalContent.className = 'rounded-2xl shadow-xl max-w-md w-full transform scale-95 transition-transform duration-300';
        modalContent.style.backgroundColor = 'rgba(255, 255, 255, 0.95)';
        modalContent.style.boxShadow = '4px 4px 20px rgba(0, 0, 0, 0.15)';

        // Header
        const header = document.createElement('div');
        header.className = 'px-6 py-4 border-b';
        header.style.borderColor = 'rgba(232, 154, 60, 0.2)';
        header.innerHTML = `
            <div class="flex items-center gap-3">
                ${esConfirmacion ? 
                    `<div class="w-10 h-10 rounded-full flex items-center justify-center" style="background: linear-gradient(135deg, rgba(232, 154, 60, 0.2), rgba(245, 168, 71, 0.2));">
                        <svg class="w-5 h-5" style="color: #e89a3c;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>` : 
                    `<div class="w-10 h-10 rounded-full flex items-center justify-center" style="background: linear-gradient(135deg, rgba(232, 154, 60, 0.2), rgba(245, 168, 71, 0.2));">
                        <svg class="w-5 h-5" style="color: #e89a3c;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>`
                }
                <h3 class="text-lg font-semibold" style="color: #2c2c2c; font-family: 'Poppins', sans-serif;">${titulo}</h3>
            </div>
        `;

        // Body
        const body = document.createElement('div');
        body.className = 'px-6 py-4';
        body.innerHTML = `<p style="color: #5c5c5c; white-space: pre-line; font-family: 'Poppins', sans-serif;">${mensaje}</p>`;

        // Footer
        const footer = document.createElement('div');
        footer.className = 'px-6 py-4 flex gap-3 justify-end';

        if (esConfirmacion) {
            // Botón Cancelar
            const btnCancelar = document.createElement('button');
            btnCancelar.className = 'px-5 py-2 rounded-full font-semibold transition-colors';
            btnCancelar.style.cssText = 'background-color: rgba(232, 154, 60, 0.15); color: #5c5c5c; font-family: Poppins, sans-serif;';
            btnCancelar.textContent = 'Cancelar';
            btnCancelar.onclick = () => cerrarModal(overlay);
            btnCancelar.onmouseover = () => btnCancelar.style.backgroundColor = 'rgba(232, 154, 60, 0.25)';
            btnCancelar.onmouseout = () => btnCancelar.style.backgroundColor = 'rgba(232, 154, 60, 0.15)';

            // Botón Confirmar
            const btnConfirmar = document.createElement('button');
            btnConfirmar.className = 'px-5 py-2 rounded-full font-semibold text-white transition-colors';
            btnConfirmar.style.cssText = 'background: linear-gradient(135deg, #e89a3c, #f5a847); font-family: Poppins, sans-serif;';
            btnConfirmar.textContent = textoConfirmar;
            btnConfirmar.onclick = () => {
                cerrarModal(overlay);
                if (onConfirm) onConfirm();
            };
            btnConfirmar.onmouseover = () => btnConfirmar.style.background = 'linear-gradient(135deg, #d4a056, #e89a3c)';
            btnConfirmar.onmouseout = () => btnConfirmar.style.background = 'linear-gradient(135deg, #e89a3c, #f5a847)';

            footer.appendChild(btnCancelar);
            footer.appendChild(btnConfirmar);
        } else {
            // Solo botón Aceptar
            const btnAceptar = document.createElement('button');
            btnAceptar.className = 'px-5 py-2 rounded-full font-semibold text-white transition-colors';
            btnAceptar.style.cssText = 'background: linear-gradient(135deg, #e89a3c, #f5a847); font-family: Poppins, sans-serif;';
            btnAceptar.textContent = 'Aceptar';
            btnAceptar.onclick = () => cerrarModal(overlay);
            btnAceptar.onmouseover = () => btnAceptar.style.background = 'linear-gradient(135deg, #d4a056, #e89a3c)';
            btnAceptar.onmouseout = () => btnAceptar.style.background = 'linear-gradient(135deg, #e89a3c, #f5a847)';

            footer.appendChild(btnAceptar);
        }

        modalContent.appendChild(header);
        modalContent.appendChild(body);
        modalContent.appendChild(footer);
        overlay.appendChild(modalContent);

        // Animación de entrada
        setTimeout(() => modalContent.classList.remove('scale-95'), 10);

        return overlay;
    }

    function cerrarModal(overlay) {
        overlay.classList.add('opacity-0');
        const content = overlay.querySelector('div');
        if (content) content.classList.add('scale-95');
        setTimeout(() => overlay.remove(), 300);
    }
</script>
@endsection