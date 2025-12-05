@extends('jurado.layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
    
    .evaluacion-page {
        background: linear-gradient(135deg, #FFFDF4 0%, #FFF8EE 100%);
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
    }
    
    .criterio-card {
        background: linear-gradient(145deg, #ffffff, #fff8f0);
        border-radius: 16px;
        border: 1px solid rgba(232, 154, 60, 0.15);
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
        background: linear-gradient(90deg, #e89a3c, #f0bc7b);
    }
    
    .criterio-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(232, 154, 60, 0.15);
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
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }
    
    .ponderacion-badge svg {
        width: 12px;
        height: 12px;
    }
    
    .criterio-input {
        background: linear-gradient(145deg, #fffdf4, #fff8ee);
        border: 2px solid rgba(232, 154, 60, 0.2);
        border-radius: 12px;
        padding: 0.875rem 1rem;
        font-size: 1.25rem;
        font-weight: 600;
        text-align: center;
        color: #2c2c2c;
        width: 100%;
        transition: all 0.3s ease;
    }
    
    .criterio-input:focus {
        outline: none;
        border-color: #e89a3c;
        box-shadow: 0 0 0 3px rgba(232, 154, 60, 0.15);
    }
    
    .criterio-input:disabled {
        background: #f5f5f5;
        color: #9ca3af;
        cursor: not-allowed;
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
        background: rgba(0, 0, 0, 0.1);
        border-radius: 3px;
        overflow: hidden;
    }
    
    .score-fill {
        height: 100%;
        border-radius: 3px;
        transition: width 0.3s ease, background 0.3s ease;
    }
    
    .calificacion-final-card {
        background: linear-gradient(135deg, #2c2c2c, #1a1a1a);
        border-radius: 20px;
        padding: 1.5rem;
        color: white;
        position: relative;
        overflow: hidden;
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
        background: linear-gradient(135deg, #e89a3c, #f0bc7b);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .criterios-legend {
        background: linear-gradient(145deg, #fff8ee, #ffffff);
        border: 1px solid rgba(232, 154, 60, 0.2);
        border-radius: 16px;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
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
    }
    
    .btn-guardar {
        background: linear-gradient(135deg, #6b7280, #4b5563);
        color: white;
        padding: 0.875rem 2rem;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
    }
    
    .btn-guardar:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(107, 114, 128, 0.4);
    }
    
    .btn-finalizar {
        background: linear-gradient(135deg, #e89a3c, #d4842c);
        color: white;
        padding: 0.875rem 2rem;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
    }
    
    .btn-finalizar:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(232, 154, 60, 0.4);
    }
    
    .feedback-card {
        background: white;
        border-radius: 16px;
        border: 1px solid rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }
    
    .feedback-header {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.08);
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
    }
    
    .feedback-textarea {
        width: 100%;
        border: none;
        padding: 1rem 1.5rem;
        resize: none;
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
        background: transparent;
    }
    
    .feedback-textarea:focus {
        outline: none;
    }
    
    .feedback-textarea::placeholder {
        color: #a4aeb7;
    }
    
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
        margin-bottom: 1rem;
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
    
    /* Modal de Confirmación */
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
        background: linear-gradient(145deg, #ffffff, #fff8f0);
        border-radius: 20px;
        padding: 2rem;
        max-width: 420px;
        width: 90%;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15), 0 0 0 1px rgba(232, 154, 60, 0.1);
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
        background: linear-gradient(135deg, rgba(232, 154, 60, 0.15), rgba(232, 154, 60, 0.05));
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
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
        background: rgba(239, 68, 68, 0.1);
        border: 1px solid rgba(239, 68, 68, 0.2);
        border-radius: 10px;
        padding: 0.75rem 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
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
    }
    
    .modal-buttons {
        display: flex;
        gap: 0.75rem;
        justify-content: center;
    }
    
    .modal-btn-cancel {
        background: rgba(255, 255, 255, 0.9);
        color: #6b7280;
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 0.9rem;
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        border: 1px solid #e5e7eb;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.05);
    }
    
    .modal-btn-cancel:hover {
        background: #f3f4f6;
        transform: translateY(-2px);
    }
    
    .modal-btn-confirm {
        background: linear-gradient(135deg, #e89a3c, #d4842c);
        color: white;
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 0.9rem;
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(232, 154, 60, 0.3);
    }
    
    .modal-btn-confirm:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(232, 154, 60, 0.4);
    }
</style>

<div class="evaluacion-page py-8 px-6 lg:px-12">
    <div class="max-w-6xl mx-auto">
        {{-- Header --}}
        <div class="mb-6">
            <a href="{{ route('jurado.eventos.equipo_evento', [$inscripcion->evento, $equipo]) }}" class="back-btn">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" width="20" height="20">
                    <path d="M15 6L9 12L15 18" stroke="#e89a3c" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Volver al Equipo
            </a>
            <h1 class="text-2xl font-bold" style="color: #2c2c2c;">Evaluación Final del Proyecto</h1>
            <p class="mt-1" style="color: #6b7280;">{{ $equipo->nombre }} - {{ $proyecto->nombre ?? 'Sin proyecto' }}</p>
        </div>

        {{-- Alertas --}}
        @if(session('success'))
            <div class="rounded-2xl p-4 mb-6 flex items-center gap-3" style="background-color: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.3);">
                <svg class="w-6 h-6 flex-shrink-0" style="color: #059669;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="font-medium" style="color: #059669;">{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="rounded-2xl p-4 mb-6 flex items-center gap-3" style="background-color: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.3);">
                <svg class="w-6 h-6 flex-shrink-0" style="color: #dc2626;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="font-medium" style="color: #dc2626;">{{ session('error') }}</p>
            </div>
        @endif

        @if($evaluacion->estado == 'Finalizada')
            <div class="rounded-2xl p-4 mb-6 flex items-center gap-3" style="background-color: rgba(59, 130, 246, 0.15); border: 1px solid rgba(59, 130, 246, 0.3);">
                <svg class="w-6 h-6 flex-shrink-0" style="color: #2563EB;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <p class="font-semibold" style="color: #1D4ED8;">Esta evaluación ya ha sido finalizada</p>
                    <p class="text-sm" style="color: #3B82F6;">No es posible realizar más modificaciones</p>
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
                <p class="text-sm" style="color: #6b7280;">
                    Cada criterio tiene un peso (%) que indica su importancia en la calificación final. 
                    La nota final se calcula automáticamente sumando cada calificación × su ponderación.
                </p>
                <div class="flex flex-wrap gap-4 mt-3">
                    <div class="legend-item">
                        <div class="legend-dot" style="background: #10b981;"></div>
                        <span class="text-sm" style="color: #6b7280;">80-100: Excelente</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-dot" style="background: #f59e0b;"></div>
                        <span class="text-sm" style="color: #6b7280;">60-79: Bueno</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-dot" style="background: #f97316;"></div>
                        <span class="text-sm" style="color: #6b7280;">40-59: Regular</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-dot" style="background: #ef4444;"></div>
                        <span class="text-sm" style="color: #6b7280;">0-39: Insuficiente</span>
                    </div>
                </div>
            </div>

            {{-- Criterios de Evaluación Dinámicos --}}
            <div class="rounded-2xl p-6 shadow-sm mb-6" style="background-color: #FFEFDC;">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #e89a3c, #d4842c);">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold" style="color: #2c2c2c;">Criterios de Evaluación</h2>
                            <p class="text-sm" style="color: #6b7280;">Califica cada criterio del 0 al 100</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                    @foreach($criterios as $index => $criterio)
                        <div class="criterio-card p-5">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <h3 class="font-semibold text-base" style="color: #2c2c2c;">{{ $criterio->nombre }}</h3>
                                    @if($criterio->descripcion)
                                        <p class="text-xs mt-1" style="color: #6b7280;">{{ $criterio->descripcion }}</p>
                                    @endif
                                </div>
                                <div class="ponderacion-badge ml-2">
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
                                       step="0.5"
                                       class="criterio-input"
                                       placeholder="0-100"
                                       {{ $evaluacion->estado == 'Finalizada' ? 'disabled' : '' }}>
                                
                                <div class="score-indicator">
                                    <span class="text-xs font-medium" style="color: #9ca3af;">0</span>
                                    <div class="score-bar">
                                        <div class="score-fill" 
                                             :style="'width: ' + (criterios[{{ $criterio->id_criterio }}] || 0) + '%; background: ' + getScoreColor(criterios[{{ $criterio->id_criterio }}])">
                                        </div>
                                    </div>
                                    <span class="text-xs font-medium" style="color: #9ca3af;">100</span>
                                </div>
                            </div>
                            
                            @error("criterio_{$criterio->id_criterio}")
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    @endforeach
                </div>

                {{-- Calificación Final Preview --}}
                <div class="calificacion-final-card mt-6">
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
            <div class="rounded-2xl p-6 shadow-sm mb-6" style="background-color: #FFEFDC;">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #e89a3c, #d4842c);">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold" style="color: #2c2c2c;">Retroalimentación</h2>
                        <p class="text-sm" style="color: #6b7280;">Comparte tus comentarios con el equipo</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    {{-- Fortalezas --}}
                    <div class="feedback-card">
                        <div class="feedback-header" style="background: rgba(16, 185, 129, 0.1);">
                            <div class="feedback-icon" style="background: #10b981;">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <span class="font-semibold" style="color: #059669;">Fortalezas del Proyecto</span>
                        </div>
                        <textarea name="comentarios_fortalezas" rows="4" class="feedback-textarea"
                                  placeholder="¿Qué aspectos destacan positivamente del proyecto?"
                                  {{ $evaluacion->estado == 'Finalizada' ? 'disabled' : '' }}>{{ old('comentarios_fortalezas', $evaluacion->comentarios_fortalezas) }}</textarea>
                    </div>

                    {{-- Áreas de Mejora --}}
                    <div class="feedback-card">
                        <div class="feedback-header" style="background: rgba(245, 158, 11, 0.1);">
                            <div class="feedback-icon" style="background: #f59e0b;">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                            </div>
                            <span class="font-semibold" style="color: #d97706;">Áreas de Mejora</span>
                        </div>
                        <textarea name="comentarios_areas_mejora" rows="4" class="feedback-textarea"
                                  placeholder="¿Qué aspectos podría mejorar el equipo?"
                                  {{ $evaluacion->estado == 'Finalizada' ? 'disabled' : '' }}>{{ old('comentarios_areas_mejora', $evaluacion->comentarios_areas_mejora) }}</textarea>
                    </div>

                    {{-- Comentarios Generales --}}
                    <div class="feedback-card lg:col-span-2">
                        <div class="feedback-header" style="background: rgba(107, 114, 128, 0.1);">
                            <div class="feedback-icon" style="background: #6b7280;">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </div>
                            <span class="font-semibold" style="color: #4b5563;">Comentarios Generales</span>
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
                       class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-full font-semibold transition-all"
                       style="background: white; border: 1px solid #e5e7eb; color: #4b5563;">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Cancelar
                    </a>
                    <button type="submit" name="finalizar" value="0" class="btn-guardar inline-flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                        </svg>
                        Guardar Borrador
                    </button>
                    <button type="button" class="btn-finalizar inline-flex items-center justify-center gap-2"
                            onclick="openFinalizarModal()">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Finalizar Evaluación
                    </button>
                </div>
            @else
                <div class="flex justify-end">
                    <a href="{{ route('jurado.eventos.equipo_evento', [$inscripcion->evento, $equipo]) }}"
                       class="btn-finalizar inline-flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
        // Obtener el formulario por ID
        const form = document.getElementById('evaluacionForm');
        if (!form) {
            console.error('Formulario no encontrado');
            return;
        }
        
        // Verificar si ya existe el input hidden
        let input = form.querySelector('input[name="finalizar"]');
        if (!input) {
            input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'finalizar';
            form.appendChild(input);
        }
        input.value = '1';
        
        // Cerrar el modal
        closeFinalizarModal();
        
        // Enviar el formulario
        form.submit();
    }
    
    // Cerrar con tecla Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeFinalizarModal();
        }
    });
</script>
@endsection
