@extends('jurado.layouts.app')

@section('content')

<div class="equipo-evento-page">
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
                <h2 class="section-title">Nombre del equipo</h2>
                <div class="equipo-card">
                    {{-- Imagen del equipo --}}
                    <div>
                        @if($equipo->ruta_imagen)
                            <img src="{{ asset('storage/' . $equipo->ruta_imagen) }}" alt="Imagen del equipo">
                        @else
                            <div style="height: 12rem; background: linear-gradient(135deg, #2c2c2c, #1a1a1a); display: flex; align-items: center; justify-content: center;">
                                <svg style="width: 4rem; height: 4rem; color: rgba(232, 154, 60, 0.3);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                        @endif
                    </div>
                    {{-- Nombre del proyecto --}}
                    <div class="equipo-header">
                        <h3>{{ $proyecto->nombre ?? 'Sin proyecto' }}</h3>
                    </div>
                    {{-- Información del proyecto --}}
                    <div class="equipo-info">
                        <p>
                            <span class="font-medium">Creación:</span> 
                            <span>{{ $equipo->created_at->translatedFormat('d \\d\\e F \\d\\e\\l Y') }}</span>
                        </p>
                        <div class="equipo-description">
                            <p>{{ $proyecto->descripcion_tecnica ?? 'Objetivo del proyecto' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Integrantes --}}
            <div class="lg:w-2/3">
                <h2 class="section-title">Integrantes:</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @forelse($miembros as $miembro)
                        @php
                            $isLastAndOdd = ($loop->last && $miembros->count() % 2 != 0);
                        @endphp
                        <div class="miembro-card {{ $isLastAndOdd ? 'md:col-span-2 md:w-1/2 md:mx-auto' : '' }}">
                            <div class="miembro-avatar">
                                <img src="{{ $miembro->user->foto_perfil_url }}" alt="Foto de {{ $miembro->user->nombre }}">
                            </div>
                            <div class="miembro-info flex-1">
                                <h4>{{ $miembro->user->nombre }} {{ $miembro->user->app_paterno }}</h4>
                                <h4 style="margin-bottom: 0.5rem;">{{ $miembro->user->app_materno }}</h4>
                                <p>
                                    <span class="font-medium">Rol:</span> 
                                    <span>{{ $miembro->rol->nombre ?? 'Sin rol asignado' }}</span>
                                </p>
                                <p>
                                    <span class="font-medium">Carrera:</span> 
                                    <span>{{ $miembro->user->estudiante->carrera->nombre ?? 'Sin carrera' }}</span>
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="md:col-span-2">
                            <div class="empty-state">
                                <p>No hay miembros registrados en este equipo para este evento.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Sección Avances --}}
        <div>
            <h2 class="section-title">Avances</h2>
            <div class="flex flex-col lg:flex-row gap-6">
                {{-- Estadísticas de Avances --}}
                <div class="lg:w-2/3">
                    <div class="stats-card">
                        <div class="stats-grid">
                            {{-- Avances --}}
                            <div class="stat-item">
                                <div class="stat-value">{{ $totalAvances }}</div>
                                <div class="stat-label">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                    </svg>
                                    <span>Avances</span>
                                </div>
                            </div>
                            {{-- Avances Calificados --}}
                            <div class="stat-item">
                                <div class="stat-value">{{ $avancesCalificados }}</div>
                                <div class="stat-label">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>Calificados</span>
                                </div>
                            </div>
                            {{-- Progreso --}}
                            <div class="stat-item">
                                <div class="stat-value">{{ $progreso }}%</div>
                                <div class="stat-label">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>Porcentaje de tareas</span>
                                </div>
                            </div>
                            {{-- Tareas --}}
                            <div class="stat-item">
                                <div class="stat-value">{{ $totalTareas }}</div>
                                <div class="stat-label">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                    </svg>
                                    <span>Tareas</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Botón Evaluar Proyecto --}}
                    <div class="mt-4">
                        @if($yaEvaluoProyecto)
                            {{-- Ya evaluado --}}
                            <a href="{{ route('jurado.evaluaciones.show', $evaluacionFinalExistente->id_evaluacion) }}" 
                               class="btn-evaluar-proyecto btn-success">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Ver Mi Evaluación</span>
                            </a>
                            <p class="help-message success">
                                Ya has evaluado este proyecto ({{ number_format($evaluacionFinalExistente->calificacion_final, 1) }}/100)
                            </p>
                        @elseif($evaluacionEnBorrador)
                            {{-- Evaluación en borrador --}}
                            <a href="{{ route('jurado.evaluaciones.create', $inscripcion->id_inscripcion) }}" 
                               class="btn-evaluar-proyecto btn-warning">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                <span>Retomar Evaluación</span>
                            </a>
                            <p class="help-message warning">
                                Tienes una evaluación en borrador pendiente de finalizar
                            </p>
                        @else
                            <button type="button" 
                                    id="btn-evaluar-proyecto"
                                    onclick="mostrarModalEvaluarProyecto()"
                                    class="btn-evaluar-proyecto"
                                    {{ $todosCalificados ? '' : 'disabled' }}>
                                Evaluar Proyecto
                            </button>
                            @if(!$todosCalificados && $totalAvances > 0)
                                <p class="help-message">
                                    Debes calificar todos los avances ({{ $avancesCalificados }}/{{ $totalAvances }}) antes de evaluar el proyecto
                                </p>
                            @elseif($totalAvances == 0)
                                <p class="help-message">
                                    No hay avances registrados para este proyecto
                                </p>
                            @endif
                        @endif
                    </div>
                </div>

                {{-- Ver Avances Disponibles --}}
                <div class="lg:w-1/3">
                    <div class="avances-card">
                        <h3 class="avances-title">Ver Avances Disponibles</h3>
                        
                        @if($yaEvaluoProyecto)
                            {{-- Mensaje de bloqueo cuando ya se evaluó --}}
                            <div class="alert-box alert-success">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                <div>
                                    <strong>Evaluación Finalizada</strong>
                                    <small>Los avances ya no pueden ser modificados</small>
                                </div>
                            </div>
                            {{-- Selector deshabilitado --}}
                            <div class="neu-select-wrapper" style="opacity: 0.6;">
                                <select disabled class="neu-select">
                                    <option>{{ $totalAvances }} avance(s) calificado(s)</option>
                                </select>
                                <div class="neu-select-icon">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                            {{-- Botones deshabilitados --}}
                            <div class="action-buttons">
                                <button type="button" disabled class="btn-action btn-calificar">
                                    Calificar
                                </button>
                                <button type="button" disabled class="btn-action btn-reevaluar">
                                    Reevaluar
                                </button>
                            </div>
                        @else
                            <div class="neu-select-wrapper">
                                <select id="avance-selector" class="neu-select">
                                    <option value="">Seleccionar avance...</option>
                                    @foreach($avances as $avance)
                                        @php
                                            $yaCalificado = in_array($avance->id_avance, $avancesCalificadosIds);
                                        @endphp
                                        <option value="{{ $avance->id_avance }}" data-calificado="{{ $yaCalificado ? 'true' : 'false' }}">
                                            {{ $avance->titulo ?? 'Avance #' . $loop->iteration }} {{ $yaCalificado ? ' (Calificado)' : '' }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="neu-select-icon">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="action-buttons">
                                <button type="button" id="btn-calificar" class="btn-action btn-calificar">
                                    Calificar
                                </button>
                                <button type="button" id="btn-reevaluar" class="btn-action btn-reevaluar" disabled>
                                    Reevaluar
                                </button>
                            </div>
                            <p id="hint-calificar" class="hint-message hint-calificar hidden">
                                Este avance aún no ha sido calificado
                            </p>
                            <p id="hint-reevaluar" class="hint-message hint-reevaluar hidden">
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
        modalContent.style.backgroundColor = '#FFEEE2';
        modalContent.style.boxShadow = '8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff';

        // Header
        const header = document.createElement('div');
        header.className = 'px-6 py-4 border-b';
        header.style.borderColor = 'rgba(232, 154, 60, 0.2)';
        header.innerHTML = `
            <div class="flex items-center gap-3">
                ${esConfirmacion ? 
                    `<div style="width: 2.5rem; height: 2.5rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, rgba(232, 154, 60, 0.2), rgba(245, 168, 71, 0.2)); box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;">
                        <svg style="width: 1.25rem; height: 1.25rem; color: #e89a3c;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>` : 
                    `<div style="width: 2.5rem; height: 2.5rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, rgba(232, 154, 60, 0.2), rgba(245, 168, 71, 0.2)); box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;">
                        <svg style="width: 1.25rem; height: 1.25rem; color: #e89a3c;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>`
                }
                <h3 style="font-size: 1.125rem; font-weight: 600; color: #2c2c2c; font-family: Poppins, sans-serif;">${titulo}</h3>
            </div>
        `;

        // Body
        const body = document.createElement('div');
        body.className = 'px-6 py-4';
        body.innerHTML = `<p style="color: #6b6b6b; white-space: pre-line; font-family: Poppins, sans-serif;">${mensaje}</p>`;

        // Footer
        const footer = document.createElement('div');
        footer.className = 'px-6 py-4 flex gap-3 justify-end';

        if (esConfirmacion) {
            // Botón Cancelar
            const btnCancelar = document.createElement('button');
            btnCancelar.className = 'px-5 py-2 rounded-full font-semibold transition-all';
            btnCancelar.style.cssText = 'background: rgba(255, 255, 255, 0.5); color: #6b6b6b; font-family: Poppins, sans-serif; box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;';
            btnCancelar.textContent = 'Cancelar';
            btnCancelar.onclick = () => cerrarModal(overlay);
            btnCancelar.onmouseover = () => {
                btnCancelar.style.transform = 'translateY(-2px)';
                btnCancelar.style.boxShadow = '6px 6px 12px #e6d5c9, -6px -6px 12px #ffffff';
            };
            btnCancelar.onmouseout = () => {
                btnCancelar.style.transform = '';
                btnCancelar.style.boxShadow = '4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff';
            };

            // Botón Confirmar
            const btnConfirmar = document.createElement('button');
            btnConfirmar.className = 'px-5 py-2 rounded-full font-semibold text-white transition-all';
            btnConfirmar.style.cssText = 'background: linear-gradient(135deg, #e89a3c, #f5a847); font-family: Poppins, sans-serif; box-shadow: 4px 4px 8px rgba(232, 154, 60, 0.3);';
            btnConfirmar.textContent = textoConfirmar;
            btnConfirmar.onclick = () => {
                cerrarModal(overlay);
                if (onConfirm) onConfirm();
            };
            btnConfirmar.onmouseover = () => {
                btnConfirmar.style.transform = 'translateY(-2px)';
                btnConfirmar.style.boxShadow = '6px 6px 12px rgba(232, 154, 60, 0.4)';
            };
            btnConfirmar.onmouseout = () => {
                btnConfirmar.style.transform = '';
                btnConfirmar.style.boxShadow = '4px 4px 8px rgba(232, 154, 60, 0.3)';
            };

            footer.appendChild(btnCancelar);
            footer.appendChild(btnConfirmar);
        } else {
            // Solo botón Aceptar
            const btnAceptar = document.createElement('button');
            btnAceptar.className = 'px-5 py-2 rounded-full font-semibold text-white transition-all';
            btnAceptar.style.cssText = 'background: linear-gradient(135deg, #e89a3c, #f5a847); font-family: Poppins, sans-serif; box-shadow: 4px 4px 8px rgba(232, 154, 60, 0.3);';
            btnAceptar.textContent = 'Aceptar';
            btnAceptar.onclick = () => cerrarModal(overlay);
            btnAceptar.onmouseover = () => {
                btnAceptar.style.transform = 'translateY(-2px)';
                btnAceptar.style.boxShadow = '6px 6px 12px rgba(232, 154, 60, 0.4)';
            };
            btnAceptar.onmouseout = () => {
                btnAceptar.style.transform = '';
                btnAceptar.style.boxShadow = '4px 4px 8px rgba(232, 154, 60, 0.3)';
            };

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


<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

    /* Página principal */
    .equipo-evento-page {
        background: linear-gradient(to bottom, #FFFDF4, #FFEEE2);
        min-height: 100vh;
        padding: 2rem;
        font-family: 'Poppins', sans-serif;
    }

    /* Botón volver neuromórfico */
    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(255, 253, 244, 0.9);
        color: #e89a3c;
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 0.9rem;
        padding: 0.75rem 1.25rem;
        border-radius: 10px;
        text-decoration: none;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        transition: all 0.3s ease;
        margin-bottom: 1.5rem;
    }

    .back-btn:hover {
        color: #d98a2c;
        transform: translateY(-2px);
        box-shadow: 6px 6px 12px #e6d5c9, -6px -6px 12px #ffffff;
    }

    .back-btn svg path {
        stroke: #e89a3c;
        transition: all 0.3s ease;
    }

    .back-btn:hover svg path {
        stroke: #d98a2c;
    }

    /* Títulos de sección */
    .section-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #2c2c2c;
        margin-bottom: 1rem;
        font-family: 'Poppins', sans-serif;
    }

    /* Card neuromórfica base */
    .neu-card {
        background: #FFEEE2;
        border-radius: 20px;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
        overflow: hidden;
    }

    /* Card de detalles del equipo */
    .equipo-card {
        background: #FFEEE2;
        border-radius: 20px;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
        overflow: hidden;
    }

    .equipo-card img {
        width: 100%;
        height: 12rem;
        object-fit: cover;
    }

    .equipo-header {
        background: linear-gradient(135deg, #e89a3c, #f5a847);
        padding: 0.75rem 1rem;
        text-align: center;
    }

    .equipo-header h3 {
        color: white;
        font-weight: 600;
        font-size: 1.125rem;
        margin: 0;
        font-family: 'Poppins', sans-serif;
    }

    .equipo-info {
        padding: 1rem;
    }

    .equipo-info p {
        font-size: 0.875rem;
        margin-bottom: 0.75rem;
        color: #2c2c2c;
        font-family: 'Poppins', sans-serif;
    }

    .equipo-info span {
        color: #6b6b6b;
    }

    .equipo-description {
        background: rgba(255, 255, 255, 0.4);
        border-radius: 12px;
        padding: 0.75rem;
        box-shadow: inset 2px 2px 4px #e6d5c9, inset -2px -2px 4px #ffffff;
    }

    .equipo-description p {
        font-size: 0.875rem;
        color: #6b6b6b;
        margin: 0;
        line-height: 1.6;
        font-family: 'Poppins', sans-serif;
    }

    /* Card de integrante */
    .miembro-card {
        background: #FFEEE2;
        border-radius: 20px;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
        padding: 1rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .miembro-avatar {
        width: 5rem;
        height: 5rem;
        border-radius: 12px;
        overflow: hidden;
        flex-shrink: 0;
        background: rgba(255, 255, 255, 0.4);
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
    }

    .miembro-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .miembro-info h4 {
        font-size: 1rem;
        font-weight: 600;
        color: #2c2c2c;
        margin-bottom: 0.25rem;
        font-family: 'Poppins', sans-serif;
    }

    .miembro-info p {
        font-size: 0.875rem;
        color: #2c2c2c;
        margin-bottom: 0.25rem;
        font-family: 'Poppins', sans-serif;
    }

    .miembro-info span {
        color: #6b6b6b;
    }

    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 2rem;
        background: #FFEEE2;
        border-radius: 20px;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
    }

    .empty-state p {
        color: #6b6b6b;
        font-family: 'Poppins', sans-serif;
    }

    /* Card de estadísticas */
    .stats-card {
        background: #FFEEE2;
        border-radius: 20px;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
        padding: 1.5rem;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
    }

    .stat-item {
        text-align: center;
    }

    .stat-value {
        font-size: 1.875rem;
        font-weight: 700;
        color: #e89a3c;
        margin-bottom: 0.5rem;
        font-family: 'Poppins', sans-serif;
    }

    .stat-label {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        font-size: 0.875rem;
        font-weight: 500;
        color: #2c2c2c;
        font-family: 'Poppins', sans-serif;
    }

    .stat-label svg {
        width: 1.25rem;
        height: 1.25rem;
        color: #e89a3c;
    }

    /* Botón evaluar proyecto */
    .btn-evaluar-proyecto {
        width: 100%;
        border-radius: 20px;
        padding: 0.75rem;
        color: white;
        font-weight: 600;
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #e89a3c, #f5a847);
        box-shadow: 4px 4px 8px rgba(232, 154, 60, 0.3);
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .btn-evaluar-proyecto:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 6px 6px 12px rgba(232, 154, 60, 0.4);
    }

    .btn-evaluar-proyecto:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .btn-evaluar-proyecto svg {
        width: 1.25rem;
        height: 1.25rem;
    }

    .btn-success {
        background: linear-gradient(135deg, #10b981, #059669);
    }

    .btn-warning {
        background: linear-gradient(135deg, #f59e0b, #d97706);
    }

    /* Mensaje de ayuda */
    .help-message {
        text-align: center;
        font-size: 0.875rem;
        color: #6b6b6b;
        margin-top: 0.5rem;
        font-family: 'Poppins', sans-serif;
    }

    .help-message.success {
        color: #10b981;
    }

    .help-message.warning {
        color: #f59e0b;
    }

    /* Card de avances */
    .avances-card {
        background: #FFEEE2;
        border-radius: 20px;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
        padding: 1.5rem;
    }

    .avances-title {
        font-size: 1rem;
        font-weight: 600;
        color: #2c2c2c;
        text-align: center;
        margin-bottom: 1rem;
        font-family: 'Poppins', sans-serif;
    }

    /* Selector neuromórfico */
    .neu-select-wrapper {
        position: relative;
        margin-bottom: 1rem;
    }

    .neu-select {
        width: 100%;
        border-radius: 12px;
        padding: 0.75rem 1rem;
        padding-right: 2.5rem;
        appearance: none;
        border: none;
        background: rgba(255, 255, 255, 0.5);
        color: #2c2c2c;
        font-family: 'Poppins', sans-serif;
        font-size: 0.875rem;
        box-shadow: inset 3px 3px 6px #e6d5c9, inset -3px -3px 6px #ffffff;
        cursor: pointer;
    }

    .neu-select:focus {
        outline: none;
        box-shadow: inset 4px 4px 8px #e6d5c9, inset -4px -4px 8px #ffffff;
    }

    .neu-select:disabled {
        cursor: not-allowed;
        opacity: 0.6;
    }

    .neu-select-icon {
        position: absolute;
        right: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none;
        color: #e89a3c;
    }

    .neu-select-icon svg {
        width: 1.25rem;
        height: 1.25rem;
    }

    /* Botones de acción */
    .action-buttons {
        display: flex;
        gap: 0.5rem;
    }

    .btn-action {
        flex: 1;
        border-radius: 20px;
        padding: 0.75rem;
        font-weight: 600;
        font-family: 'Poppins', sans-serif;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 0.875rem;
    }

    .btn-calificar {
        background: linear-gradient(135deg, #e89a3c, #f5a847);
        color: white;
        box-shadow: 4px 4px 8px rgba(232, 154, 60, 0.3);
    }

    .btn-calificar:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 6px 6px 12px rgba(232, 154, 60, 0.4);
    }

    .btn-reevaluar {
        background: linear-gradient(135deg, #6366f1, #818cf8);
        color: white;
        box-shadow: 4px 4px 8px rgba(99, 102, 241, 0.3);
    }

    .btn-reevaluar:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 6px 6px 12px rgba(99, 102, 241, 0.4);
    }

    .btn-action:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* Hint messages */
    .hint-message {
        text-align: center;
        font-size: 0.75rem;
        margin-top: 0.5rem;
        font-family: 'Poppins', sans-serif;
    }

    .hint-calificar {
        color: #6b6b6b;
    }

    .hint-reevaluar {
        color: #6366f1;
    }

    /* Alert box neuromórfico */
    .alert-box {
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
    }

    .alert-success {
        background: linear-gradient(135deg, rgba(209, 250, 229, 0.8), rgba(167, 243, 208, 0.8));
    }

    .alert-success svg {
        width: 1.5rem;
        height: 1.5rem;
        color: #059669;
        flex-shrink: 0;
    }

    .alert-success p {
        margin: 0;
        font-size: 0.875rem;
        color: #065f46;
        font-family: 'Poppins', sans-serif;
    }

    .alert-success strong {
        display: block;
        font-weight: 600;
    }

    .alert-success small {
        font-size: 0.75rem;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .equipo-evento-page {
            padding: 1rem;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection