@extends('jurado.layouts.app')

@section('content')

<div class="evaluacion-page">
    <div class="max-w-6xl mx-auto">
        {{-- Header --}}
        <div class="mb-6">
            <a href="{{ route('jurado.eventos.equipo_evento', [$inscripcion->evento, $equipo]) }}" class="back-link">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver al Equipo
            </a>
            <h1 class="page-title">Evaluación Final del Proyecto</h1>
            <p class="page-subtitle">{{ $equipo->nombre }} - {{ $proyecto->nombre ?? 'Sin proyecto' }}</p>
        </div>

        {{-- Alertas --}}
        @if(session('success'))
            <div class="alert alert-success">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p>{{ session('error') }}</p>
            </div>
        @endif

        @if($evaluacion->estado == 'Finalizada')
            <div class="alert alert-info">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <p>Esta evaluación ya ha sido finalizada</p>
                    <small>No es posible realizar más modificaciones</small>
                </div>
            </div>
        @endif

        <form id="evaluacionForm" action="{{ route('jurado.evaluaciones.store', $inscripcion) }}" method="POST"
              x-data="{
                  criterios: {
                      @foreach($criterios as $criterio)
                      {{ $criterio->id_criterio }}: {{ $calificacionesCriterios->get($criterio->id_criterio)?->calificacion ?? 'null' }},
                      @endforeach
                  },
                  ponderaciones: {
                      @foreach($criterios as $criterio)
                      {{ $criterio->id_criterio }}: {{ $criterio->ponderacion }},
                      @endforeach
                  },
                  get calificacionFinal() {
                      let total = 0;
                      let todosCalificados = true;
                      for (const [id, pond] of Object.entries(this.ponderaciones)) {
                          const calif = this.criterios[id];
                          if (calif !== null && calif !== '' && !isNaN(calif)) {
                              total += (parseFloat(calif) * parseFloat(pond)) / 100;
                          } else {
                              todosCalificados = false;
                          }
                      }
                      return todosCalificados ? total.toFixed(2) : '--';
                  },
                  getScoreColor(score) {
                      if (score === null || score === '') return '#e5e7eb';
                      score = parseFloat(score);
                      if (score >= 80) return '#10b981';
                      if (score >= 60) return '#f59e0b';
                      if (score >= 40) return '#f97316';
                      return '#ef4444';
                  }
              }">
            @csrf

            {{-- Leyenda de Criterios --}}
            <div class="criterios-legend">
                <div class="flex items-center gap-2 mb-3">
                    <svg class="w-5 h-5" style="color: #e89a3c;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="font-semibold" style="color: #2c2c2c;">Sistema de Ponderación</span>
                </div>
                <p class="text-sm" style="color: #6b7280; margin-bottom: 0.75rem;">
                    Cada criterio tiene un peso (%) que indica su importancia en la calificación final. 
                    La nota final se calcula automáticamente sumando cada calificación × su ponderación.
                </p>
                <div class="flex flex-wrap gap-4">
                    <div class="legend-item">
                        <div class="legend-dot" style="background: #10b981;"></div>
                        <span>80-100: Excelente</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-dot" style="background: #f59e0b;"></div>
                        <span>60-79: Bueno</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-dot" style="background: #f97316;"></div>
                        <span>40-59: Regular</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-dot" style="background: #ef4444;"></div>
                        <span>0-39: Insuficiente</span>
                    </div>
                </div>
            </div>

            {{-- Criterios de Evaluación --}}
            <div class="neu-card">
                <div class="section-header">
                    <div class="section-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="section-title">Criterios de Evaluación</h2>
                        <p class="section-subtitle">Califica cada criterio del 0 al 100</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                    @foreach($criterios as $criterio)
                        <div class="criterio-card">
                            <div class="criterio-header">
                                <div class="criterio-info">
                                    <h3 class="criterio-name">{{ $criterio->nombre }}</h3>
                                    @if($criterio->descripcion)
                                        <p class="criterio-desc">{{ $criterio->descripcion }}</p>
                                    @endif
                                </div>
                                <div class="ponderacion-badge">
                                    <svg fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $criterio->ponderacion }}%
                                </div>
                            </div>
                            
                            <div>
                                <input type="number" 
                                       name="criterio_{{ $criterio->id_criterio }}" 
                                       id="criterio_{{ $criterio->id_criterio }}"
                                       x-model="criterios[{{ $criterio->id_criterio }}]"
                                       @input="if($event.target.value > 100) { $event.target.value = 100; criterios[{{ $criterio->id_criterio }}] = 100; } else if($event.target.value < 0) { $event.target.value = 0; criterios[{{ $criterio->id_criterio }}] = 0; }"
                                       min="0" 
                                       max="100" 
                                       step="1"
                                       class="criterio-input"
                                       placeholder="0-100"
                                       {{ $evaluacion->estado == 'Finalizada' ? 'disabled' : '' }}>
                                
                                <div class="score-indicator">
                                    <span>0</span>
                                    <div class="score-bar">
                                        <div class="score-fill" 
                                             :style="'width: ' + (criterios[{{ $criterio->id_criterio }}] || 0) + '%; background: ' + getScoreColor(criterios[{{ $criterio->id_criterio }}])">
                                        </div>
                                    </div>
                                    <span>100</span>
                                </div>
                            </div>
                            
                            @error("criterio_{$criterio->id_criterio}")
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    @endforeach
                </div>

                {{-- Calificación Final Preview - MANTENER OSCURO --}}
                <div class="calificacion-final-card">
                    <div class="flex items-center justify-between relative z-10">
                        <div>
                            <p class="text-sm opacity-80">Calificación Final Calculada</p>
                            <p class="text-xs opacity-60 mt-1">Basada en los criterios ponderados</p>
                        </div>
                        <div class="text-right">
                            <span class="final-score" x-text="calificacionFinal"></span>
                            <span class="text-lg opacity-60">/100</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Retroalimentación --}}
            <div class="neu-card">
                <div class="section-header">
                    <div class="section-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="section-title">Retroalimentación</h2>
                        <p class="section-subtitle">Comparte tus comentarios con el equipo</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    {{-- Fortalezas --}}
                    <div class="feedback-card">
                        <div class="feedback-header">
                            <div class="feedback-icon feedback-icon-green">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <span class="feedback-title feedback-title-green">Fortalezas del Proyecto</span>
                        </div>
                        <textarea name="comentarios_fortalezas" rows="4" class="feedback-textarea"
                                  placeholder="¿Qué aspectos destacan positivamente del proyecto?"
                                  {{ $evaluacion->estado == 'Finalizada' ? 'disabled' : '' }}>{{ old('comentarios_fortalezas', $evaluacion->comentarios_fortalezas) }}</textarea>
                    </div>

                    {{-- Áreas de Mejora --}}
                    <div class="feedback-card">
                        <div class="feedback-header">
                            <div class="feedback-icon feedback-icon-orange">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                            </div>
                            <span class="feedback-title feedback-title-orange">Áreas de Mejora</span>
                        </div>
                        <textarea name="comentarios_areas_mejora" rows="4" class="feedback-textarea"
                                  placeholder="¿Qué aspectos podría mejorar el equipo?"
                                  {{ $evaluacion->estado == 'Finalizada' ? 'disabled' : '' }}>{{ old('comentarios_areas_mejora', $evaluacion->comentarios_areas_mejora) }}</textarea>
                    </div>

                    {{-- Comentarios Generales --}}
                    <div class="feedback-card lg:col-span-2">
                        <div class="feedback-header">
                            <div class="feedback-icon feedback-icon-gray">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </div>
                            <span class="feedback-title feedback-title-gray">Comentarios Generales</span>
                        </div>
                        <textarea name="comentarios_generales" rows="3" class="feedback-textarea"
                                  placeholder="Cualquier otro comentario u observación..."
                                  {{ $evaluacion->estado == 'Finalizada' ? 'disabled' : '' }}>{{ old('comentarios_generales', $evaluacion->comentarios_generales) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Botones de Acción --}}
            @if($evaluacion->estado != 'Finalizada')
                <div class="flex flex-col sm:flex-row justify-end gap-3">
                    <a href="{{ route('jurado.eventos.equipo_evento', [$inscripcion->evento, $equipo]) }}"
                       class="btn-action btn-cancel">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Cancelar
                    </a>
                    <button type="submit" name="finalizar" value="0" class="btn-action btn-guardar">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                        </svg>
                        Guardar Borrador
                    </button>
                    <button type="button" class="btn-action btn-finalizar"
                            onclick="openFinalizarModal()">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Finalizar Evaluación
                    </button>
                </div>
            @else
                <div class="flex justify-end">
                    <a href="{{ route('jurado.eventos.equipo_evento', [$inscripcion->evento, $equipo]) }}"
                       class="btn-action btn-finalizar">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Volver al Equipo
                    </a>
                </div>
            @endif
        </form>
    </div>
</div>

{{-- Modal de Confirmación --}}
<div id="finalizarModal" class="modal-overlay" onclick="closeFinalizarModal(event)">
    <div class="modal-content" onclick="event.stopPropagation()">
        <div class="modal-icon">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <h3 class="modal-title">¿Finalizar Evaluación?</h3>
        <p class="modal-message">
            Estás a punto de finalizar la evaluación del proyecto. Una vez finalizada, la calificación quedará registrada permanentemente.
        </p>
        <div class="modal-warning">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
            <span>Esta acción no se puede deshacer</span>
        </div>
        <div class="modal-buttons">
            <button type="button" class="modal-btn-cancel" onclick="closeFinalizarModal()">
                Cancelar
            </button>
            <button type="button" class="modal-btn-confirm" onclick="submitFinalizar()">
                Sí, Finalizar
            </button>
        </div>
    </div>
</div>

<script>
    function openFinalizarModal() {
        document.getElementById('finalizarModal').classList.add('active');
        document.body.style.overflow = 'hidden';
    }
    
    function closeFinalizarModal(event) {
        if (event && event.target !== event.currentTarget) return;
        document.getElementById('finalizarModal').classList.remove('active');
        document.body.style.overflow = '';
    }
    
    function submitFinalizar() {
        const form = document.getElementById('evaluacionForm');
        if (!form) {
            console.error('Formulario no encontrado');
            return;
        }
        
        let input = form.querySelector('input[name="finalizar"]');
        if (!input) {
            input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'finalizar';
            form.appendChild(input);
        }
        input.value = '1';
        
        closeFinalizarModal();
        form.submit();
    }
    
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeFinalizarModal();
        }
    });
</script>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
    
    .evaluacion-page {
        background: linear-gradient(to bottom, #FFFDF4, #FFEEE2);
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
        padding: 2rem;
    }
    
    /* Back link neuromórfico */
    .back-link {
        font-family: 'Poppins', sans-serif;
        display: inline-flex;
        align-items: center;
        color: #e89a3c;
        font-size: 0.875rem;
        font-weight: 500;
        margin-bottom: 1rem;
        padding: 0.5rem 1rem;
        background: rgba(255, 253, 244, 0.9);
        border-radius: 10px;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        transition: all 0.2s ease;
        text-decoration: none;
    }
    
    .back-link:hover {
        color: #d98a2c;
        box-shadow: 6px 6px 12px #e6d5c9, -6px -6px 12px #ffffff;
        transform: translateY(-2px);
    }
    
    .back-link svg {
        width: 1rem;
        height: 1rem;
        margin-right: 0.5rem;
    }

    /* Page header */
    .page-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2c2c2c;
        margin-bottom: 0.25rem;
    }

    .page-subtitle {
        color: #6b7280;
        font-size: 0.875rem;
    }

    /* Alerts neuromórficos */
    .alert {
        border-radius: 16px;
        padding: 1rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
    }

    .alert svg {
        width: 1.5rem;
        height: 1.5rem;
        flex-shrink: 0;
    }

    .alert p {
        margin: 0;
        font-weight: 500;
        font-family: 'Poppins', sans-serif;
    }

    .alert-success {
        background: linear-gradient(135deg, rgba(209, 250, 229, 0.8), rgba(167, 243, 208, 0.8));
    }

    .alert-success svg {
        color: #059669;
    }

    .alert-success p {
        color: #059669;
    }

    .alert-error {
        background: linear-gradient(135deg, rgba(254, 226, 226, 0.8), rgba(252, 211, 211, 0.8));
    }

    .alert-error svg {
        color: #dc2626;
    }

    .alert-error p {
        color: #dc2626;
    }

    .alert-info {
        background: linear-gradient(135deg, rgba(219, 234, 254, 0.8), rgba(191, 219, 254, 0.8));
    }

    .alert-info svg {
        color: #2563eb;
    }

    .alert-info p {
        color: #1d4ed8;
    }

    .alert-info small {
        font-size: 0.875rem;
        color: #3b82f6;
    }
    
    /* Criterio card neuromórfica */
    .criterio-card {
        background: #FFEEE2;
        border-radius: 16px;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
        padding: 1.25rem;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .criterio-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #e89a3c, #f5a847);
    }
    
    .criterio-card:hover {
        transform: translateY(-2px);
        box-shadow: 12px 12px 24px #e6d5c9, -12px -12px 24px #ffffff;
    }

    .criterio-header {
        display: flex;
        align-items: start;
        justify-content: space-between;
        margin-bottom: 1rem;
    }

    .criterio-info {
        flex: 1;
    }

    .criterio-name {
        font-weight: 600;
        font-size: 1rem;
        color: #2c2c2c;
        font-family: 'Poppins', sans-serif;
        margin-bottom: 0.25rem;
    }

    .criterio-desc {
        font-size: 0.75rem;
        color: #6b7280;
        font-family: 'Poppins', sans-serif;
    }
    
    .ponderacion-badge {
        background: linear-gradient(135deg, #2c2c2c, #1a1a1a);
        color: #fff;
        font-weight: 700;
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        margin-left: 0.5rem;
        flex-shrink: 0;
    }
    
    .ponderacion-badge svg {
        width: 12px;
        height: 12px;
    }
    
    .criterio-input {
        background: rgba(255, 255, 255, 0.5);
        border: none;
        border-radius: 12px;
        padding: 0.875rem 1rem;
        font-size: 1.25rem;
        font-weight: 600;
        text-align: center;
        color: #2c2c2c;
        width: 100%;
        font-family: 'Poppins', sans-serif;
        box-shadow: inset 3px 3px 6px #e6d5c9, inset -3px -3px 6px #ffffff;
        transition: all 0.3s ease;
    }
    
    .criterio-input:focus {
        outline: none;
        box-shadow: inset 4px 4px 8px #e6d5c9, inset -4px -4px 8px #ffffff;
    }
    
    .criterio-input:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    .criterio-input::placeholder {
        color: #9ca3af;
    }
    
    .score-indicator {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        margin-top: 0.5rem;
    }
    
    .score-bar {
        flex: 1;
        height: 6px;
        background: rgba(255, 255, 255, 0.6);
        border-radius: 3px;
        overflow: hidden;
        box-shadow: inset 2px 2px 4px #e6d5c9, inset -2px -2px 4px #ffffff;
    }
    
    .score-fill {
        height: 100%;
        border-radius: 3px;
        transition: width 0.3s ease, background 0.3s ease;
    }

    .score-indicator span {
        font-size: 0.75rem;
        font-weight: 500;
        color: #9ca3af;
        font-family: 'Poppins', sans-serif;
    }
    
    /* Calificación Final - MANTENER OSCURO */
    .calificacion-final-card {
        background: linear-gradient(135deg, #2c2c2c, #1a1a1a);
        border-radius: 20px;
        padding: 1.5rem;
        color: white;
        position: relative;
        overflow: hidden;
        margin-top: 1.5rem;
    }
    
    .calificacion-final-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle, rgba(232, 154, 60, 0.2) 0%, transparent 70%);
    }
    
    .final-score {
        font-size: 3rem;
        font-weight: 800;
        background: linear-gradient(135deg, #e89a3c, #f5a847);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    /* Leyenda neuromórfica */
    .criterios-legend {
        background: #FFEEE2;
        border-radius: 16px;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
    }
    
    .legend-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.5rem 0;
    }
    
    .legend-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
    }

    .legend-item span {
        font-size: 0.875rem;
        color: #6b7280;
        font-family: 'Poppins', sans-serif;
    }

    /* Main card neuromórfica */
    .neu-card {
        background: #FFEEE2;
        border-radius: 20px;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .section-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
    }

    .section-icon {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #e89a3c, #f5a847);
        box-shadow: 4px 4px 8px rgba(232, 154, 60, 0.3);
    }

    .section-icon svg {
        width: 1.25rem;
        height: 1.25rem;
        color: white;
    }

    .section-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: #2c2c2c;
        margin: 0;
        font-family: 'Poppins', sans-serif;
    }

    .section-subtitle {
        font-size: 0.875rem;
        color: #6b7280;
        margin: 0;
        font-family: 'Poppins', sans-serif;
    }

    /* Feedback cards */
    .feedback-card {
        background: rgba(255, 255, 255, 0.5);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: inset 3px 3px 6px #e6d5c9, inset -3px -3px 6px #ffffff;
    }
    
    .feedback-header {
        padding: 1rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .feedback-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
    }

    .feedback-icon svg {
        width: 1.25rem;
        height: 1.25rem;
        color: white;
    }

    .feedback-icon-green {
        background: linear-gradient(135deg, #10b981, #059669);
    }

    .feedback-icon-orange {
        background: linear-gradient(135deg, #f59e0b, #d97706);
    }

    .feedback-icon-gray {
        background: linear-gradient(135deg, #6b7280, #4b5563);
    }

    .feedback-title {
        font-weight: 600;
        font-family: 'Poppins', sans-serif;
        font-size: 0.95rem;
    }

    .feedback-title-green {
        color: #059669;
    }

    .feedback-title-orange {
        color: #d97706;
    }

    .feedback-title-gray {
        color: #4b5563;
    }
    
    .feedback-textarea {
        width: 100%;
        border: none;
        padding: 1rem 1.5rem;
        resize: none;
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
        background: transparent;
        font-size: 0.875rem;
    }
    
    .feedback-textarea:focus {
        outline: none;
    }
    
    .feedback-textarea::placeholder {
        color: #9ca3af;
    }

    .feedback-textarea:disabled {
        opacity: 0.6;
    }
    
    /* Botones neuromórficos */
    .btn-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        border-radius: 20px;
        font-weight: 600;
        font-family: 'Poppins', sans-serif;
        font-size: 0.9rem;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .btn-action svg {
        width: 1.25rem;
        height: 1.25rem;
    }

    .btn-cancel {
        background: rgba(255, 255, 255, 0.5);
        color: #4b5563;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
    }

    .btn-cancel:hover {
        transform: translateY(-2px);
        box-shadow: 6px 6px 12px #e6d5c9, -6px -6px 12px #ffffff;
    }
    
    .btn-guardar {
        background: linear-gradient(135deg, #6b7280, #4b5563);
        color: white;
        box-shadow: 4px 4px 8px rgba(107, 114, 128, 0.3);
    }
    
    .btn-guardar:hover {
        transform: translateY(-2px);
        box-shadow: 6px 6px 12px rgba(107, 114, 128, 0.4);
    }
    
    .btn-finalizar {
        background: linear-gradient(135deg, #e89a3c, #f5a847);
        color: white;
        box-shadow: 4px 4px 8px rgba(232, 154, 60, 0.3);
    }
    
    .btn-finalizar:hover {
        transform: translateY(-2px);
        box-shadow: 6px 6px 12px rgba(232, 154, 60, 0.4);
    }
    
    /* Modal neuromórfico */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }
    
    .modal-overlay.active {
        opacity: 1;
        visibility: visible;
    }
    
    .modal-content {
        background: #FFEEE2;
        border-radius: 20px;
        padding: 2rem;
        max-width: 420px;
        width: 90%;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
        transform: scale(0.9) translateY(20px);
        transition: all 0.3s ease;
    }
    
    .modal-overlay.active .modal-content {
        transform: scale(1) translateY(0);
    }
    
    .modal-icon {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: linear-gradient(135deg, rgba(232, 154, 60, 0.2), rgba(232, 154, 60, 0.1));
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
    }
    
    .modal-icon svg {
        width: 32px;
        height: 32px;
        color: #e89a3c;
    }
    
    .modal-title {
        font-family: 'Poppins', sans-serif;
        font-size: 1.25rem;
        font-weight: 700;
        color: #2c2c2c;
        text-align: center;
        margin-bottom: 0.75rem;
    }
    
    .modal-message {
        font-family: 'Poppins', sans-serif;
        font-size: 0.95rem;
        color: #6b7280;
        text-align: center;
        margin-bottom: 1.5rem;
        line-height: 1.6;
    }
    
    .modal-warning {
        background: linear-gradient(135deg, rgba(254, 226, 226, 0.8), rgba(252, 211, 211, 0.8));
        border-radius: 10px;
        padding: 0.75rem 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 4px 4px 8px rgba(239, 68, 68, 0.2);
    }
    
    .modal-warning svg {
        width: 18px;
        height: 18px;
        color: #dc2626;
        flex-shrink: 0;
    }
    
    .modal-warning span {
        font-size: 0.8rem;
        color: #dc2626;
        font-weight: 500;
        font-family: 'Poppins', sans-serif;
    }
    
    .modal-buttons {
        display: flex;
        gap: 0.75rem;
        justify-content: center;
    }
    
    .modal-btn-cancel {
        background: rgba(255, 255, 255, 0.5);
        color: #6b7280;
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 0.9rem;
        padding: 0.75rem 1.5rem;
        border-radius: 20px;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
    }
    
    .modal-btn-cancel:hover {
        transform: translateY(-2px);
        box-shadow: 6px 6px 12px #e6d5c9, -6px -6px 12px #ffffff;
    }
    
    .modal-btn-confirm {
        background: linear-gradient(135deg, #e89a3c, #f5a847);
        color: white;
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 0.9rem;
        padding: 0.75rem 1.5rem;
        border-radius: 20px;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 4px 4px 8px rgba(232, 154, 60, 0.3);
    }
    
    .modal-btn-confirm:hover {
        transform: translateY(-2px);
        box-shadow: 6px 6px 12px rgba(232, 154, 60, 0.4);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .evaluacion-page {
            padding: 1rem;
        }

        .final-score {
            font-size: 2rem;
        }
    }
</style>
@endsection