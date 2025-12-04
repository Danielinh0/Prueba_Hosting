@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
    
    /* Fondo degradado */
    .evento-edit-page {
        background: linear-gradient(to bottom, #FFFDF4, #FFEEE2);
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
    }
    
    /* Textos */
    .evento-edit-page h2 {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
    }
    
    .evento-edit-page p,
    .evento-edit-page label {
        font-family: 'Poppins', sans-serif;
        color: #6b6b6b;
    }
    
    /* Back button */
    .back-button {
        color: #2c2c2c;
        transition: all 0.2s ease;
    }
    
    .back-button:hover {
        color: #e89a3c;
    }
    
    /* Main card */
    .main-card {
        background: #FFEEE2;
        border-radius: 20px;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
        overflow: hidden;
        padding: 2rem;
    }
    
    /* Alert error */
    .alert-error {
        background: rgba(254, 226, 226, 0.8);
        border-left: 4px solid #ef4444;
        color: #991b1b;
        padding: 1rem;
        margin-bottom: 1.5rem;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        backdrop-filter: blur(10px);
    }
    
    .alert-error strong {
        font-weight: 700;
    }
    
    .alert-error ul {
        list-style: disc;
        margin-left: 1.5rem;
        margin-top: 0.5rem;
    }
    
    .alert-error li {
        font-family: 'Poppins', sans-serif;
        color: #991b1b;
    }
    
    /* Labels */
    .form-label {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
        font-size: 0.875rem;
        font-weight: 500;
        display: block;
        margin-bottom: 0.5rem;
    }
    
    /* Inputs y textareas */
    .neuro-input,
    .neuro-textarea,
    .neuro-file {
        font-family: 'Poppins', sans-serif;
        background: rgba(255, 255, 255, 0.5);
        border: none;
        box-shadow: inset 4px 4px 8px #e6d5c9, inset -4px -4px 8px #ffffff;
        transition: all 0.2s ease;
        backdrop-filter: blur(10px);
        color: #2c2c2c;
        width: 100%;
        padding: 0.5rem 0.75rem;
        border-radius: 0.375rem;
        margin-top: 0.25rem;
    }
    
    .neuro-input:focus,
    .neuro-textarea:focus,
    .neuro-file:focus {
        outline: none;
        box-shadow: inset 6px 6px 12px #e6d5c9, inset -6px -6px 12px #ffffff;
    }
    
    /* Image preview */
    .image-preview {
        margin-top: 1rem;
    }
    
    .image-preview img {
        height: 8rem;
        width: auto;
        border-radius: 15px;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        margin-top: 0.5rem;
    }
    
    .image-preview p {
        font-size: 0.875rem;
        color: #9ca3af;
        margin-top: 0.5rem;
    }
    
    /* Submit button */
    .submit-button {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #2c2c2c, #1a1a1a);
        color: #ffffff;
        font-weight: 600;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
        border: none;
    }
    
    .submit-button:hover {
        box-shadow: 6px 6px 12px rgba(0, 0, 0, 0.3);
        transform: translateY(-2px);
    }

    /* Criterios Section */
    .criterios-section {
        background: rgba(255, 255, 255, 0.3);
        border-radius: 15px;
        padding: 1.5rem;
        margin-top: 1.5rem;
        box-shadow: inset 2px 2px 4px #e6d5c9, inset -2px -2px 4px #ffffff;
    }

    .criterios-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .criterios-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: #2c2c2c;
    }

    .add-criterio-btn {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 500;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.15);
    }

    .add-criterio-btn:hover {
        transform: translateY(-1px);
        box-shadow: 3px 3px 8px rgba(0, 0, 0, 0.2);
    }

    .criterio-item {
        background: rgba(255, 255, 255, 0.5);
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 1rem;
        box-shadow: 3px 3px 6px #e6d5c9, -3px -3px 6px #ffffff;
    }

    .criterio-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.75rem;
    }

    .criterio-number {
        font-weight: 600;
        color: #e89a3c;
    }

    .remove-criterio-btn {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 6px;
        font-size: 0.75rem;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .remove-criterio-btn:hover {
        transform: scale(1.05);
    }

    .criterio-row {
        display: grid;
        grid-template-columns: 1fr 2fr 100px;
        gap: 1rem;
        align-items: start;
    }

    .ponderacion-counter {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1rem;
        background: rgba(255, 255, 255, 0.6);
        border-radius: 10px;
        box-shadow: inset 2px 2px 4px #e6d5c9, inset -2px -2px 4px #ffffff;
    }

    .ponderacion-value {
        font-size: 1.25rem;
        font-weight: 700;
    }

    .ponderacion-ok {
        color: #10b981;
    }

    .ponderacion-warning {
        color: #f59e0b;
    }

    .ponderacion-error {
        color: #ef4444;
    }

    .info-box {
        background: rgba(59, 130, 246, 0.1);
        border-left: 4px solid #3b82f6;
        padding: 1rem;
        margin-bottom: 1.5rem;
        border-radius: 0 10px 10px 0;
    }

    .info-box p {
        color: #1e40af;
        font-size: 0.875rem;
        margin: 0;
    }

    .info-box strong {
        font-weight: 600;
    }

    .warning-box {
        background: rgba(245, 158, 11, 0.1);
        border-left: 4px solid #f59e0b;
        padding: 1rem;
        margin-bottom: 1.5rem;
        border-radius: 0 10px 10px 0;
    }

    .warning-box p {
        color: #92400e;
        font-size: 0.875rem;
        margin: 0;
    }

    .readonly-criterios {
        background: rgba(156, 163, 175, 0.1);
        border-radius: 12px;
        padding: 1rem;
    }

    .readonly-criterio {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem;
        background: rgba(255, 255, 255, 0.5);
        border-radius: 8px;
        margin-bottom: 0.5rem;
    }

    .readonly-criterio:last-child {
        margin-bottom: 0;
    }

    .readonly-criterio-name {
        font-weight: 500;
        color: #2c2c2c;
    }

    .readonly-criterio-pond {
        font-weight: 600;
        color: #e89a3c;
    }
</style>

<div class="evento-edit-page py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex items-center mb-6">
            <a href="{{ route('admin.eventos.index') }}" class="back-button">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <h2 class="font-semibold text-xl ml-2">
                {{ __('Editar Evento') }}
            </h2>
        </div>
        
        <div class="main-card">
            @if ($errors->any())
                <div class="alert-error">
                    <strong>¡Ups!</strong> Hubo algunos problemas con tus datos.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.eventos.update', $evento) }}" method="POST" enctype="multipart/form-data"
                  x-data="{
                      criterios: {{ json_encode($evento->criteriosEvaluacion->map(fn($c) => ['nombre' => $c->nombre, 'descripcion' => $c->descripcion ?? '', 'ponderacion' => $c->ponderacion])->values()->toArray()) }},
                      get totalPonderacion() {
                          return this.criterios.reduce((sum, c) => sum + (parseFloat(c.ponderacion) || 0), 0);
                      },
                      agregarCriterio() {
                          this.criterios.push({ nombre: '', descripcion: '', ponderacion: 0 });
                      },
                      eliminarCriterio(index) {
                          if (this.criterios.length > 1) {
                              this.criterios.splice(index, 1);
                          }
                      }
                  }">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nombre del Evento -->
                    <div>
                        <label for="nombre" class="form-label">Nombre del Evento</label>
                        <input type="text" name="nombre" id="nombre" class="neuro-input" value="{{ old('nombre', $evento->nombre) }}" required>
                    </div>

                    <!-- Cupo Máximo de Equipos -->
                    <div>
                        <label for="cupo_max_equipos" class="form-label">Cupo Máximo de Equipos</label>
                        <input type="number" name="cupo_max_equipos" id="cupo_max_equipos" class="neuro-input" value="{{ old('cupo_max_equipos', $evento->cupo_max_equipos) }}" required min="1">
                    </div>

                    <!-- Fecha de Inicio -->
                    <div>
                        <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                        <input type="date" name="fecha_inicio" id="fecha_inicio" class="neuro-input" value="{{ old('fecha_inicio', $evento->fecha_inicio->format('Y-m-d')) }}" required>
                    </div>

                    <!-- Fecha de Fin -->
                    <div>
                        <label for="fecha_fin" class="form-label">Fecha de Fin</label>
                        <input type="date" name="fecha_fin" id="fecha_fin" class="neuro-input" value="{{ old('fecha_fin', $evento->fecha_fin->format('Y-m-d')) }}" required>
                    </div>
                </div>

                <!-- Descripción -->
                <div class="mt-6">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea name="descripcion" id="descripcion" rows="4" class="neuro-textarea">{{ old('descripcion', $evento->descripcion) }}</textarea>
                </div>

                <!-- Imagen del Evento -->
                <div class="mt-6">
                    <label for="ruta_imagen" class="form-label">Nueva Imagen del Evento (Opcional)</label>
                    <input type="file" name="ruta_imagen" id="ruta_imagen" class="neuro-file">
                </div>

                <!-- Imagen Actual -->
                <div class="image-preview">
                    <label class="form-label">Imagen Actual</label>
                    @if ($evento->ruta_imagen)
                        <img src="{{ asset('storage/' . $evento->ruta_imagen) }}" alt="Imagen actual">
                    @else
                        <p>No hay imagen actualmente.</p>
                    @endif
                </div>

                <!-- Criterios de Evaluación -->
                <div class="criterios-section">
                    <div class="criterios-header">
                        <h3 class="criterios-title">📋 Criterios de Evaluación</h3>
                        @if($evento->puedeCambiarCriterios())
                            <div class="ponderacion-counter">
                                <span>Total:</span>
                                <span class="ponderacion-value" 
                                      :class="{
                                          'ponderacion-ok': Math.abs(totalPonderacion - 100) < 0.01,
                                          'ponderacion-warning': totalPonderacion > 0 && totalPonderacion < 100,
                                          'ponderacion-error': totalPonderacion > 100
                                      }"
                                      x-text="totalPonderacion.toFixed(0) + '%'">0%</span>
                            </div>
                        @endif
                    </div>

                    @if($evento->puedeCambiarCriterios())
                        <div class="info-box">
                            <p><strong>💡 Ponderación:</strong> Cada criterio tiene un porcentaje que indica su peso en la calificación final. La suma de todos los criterios debe ser exactamente <strong>100%</strong>.</p>
                        </div>

                        <!-- Lista de criterios dinámicos -->
                        <template x-for="(criterio, index) in criterios" :key="index">
                            <div class="criterio-item">
                                <div class="criterio-header">
                                    <span class="criterio-number" x-text="'Criterio #' + (index + 1)"></span>
                                    <button type="button" 
                                            class="remove-criterio-btn" 
                                            x-show="criterios.length > 1"
                                            @click="eliminarCriterio(index)">
                                        ✕ Eliminar
                                    </button>
                                </div>
                                <div class="criterio-row">
                                    <div>
                                        <label class="form-label">Nombre *</label>
                                        <input type="text" 
                                               :name="'criterios[' + index + '][nombre]'"
                                               x-model="criterio.nombre"
                                               class="neuro-input"
                                               placeholder="Ej: Innovación"
                                               required>
                                    </div>
                                    <div>
                                        <label class="form-label">Descripción</label>
                                        <input type="text" 
                                               :name="'criterios[' + index + '][descripcion]'"
                                               x-model="criterio.descripcion"
                                               class="neuro-input"
                                               placeholder="Descripción opcional del criterio">
                                    </div>
                                    <div>
                                        <label class="form-label">Pond. %</label>
                                        <input type="number" 
                                               :name="'criterios[' + index + '][ponderacion]'"
                                               x-model.number="criterio.ponderacion"
                                               class="neuro-input"
                                               min="1"
                                               max="100"
                                               step="1"
                                               required>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <!-- Botón agregar criterio -->
                        <button type="button" 
                                class="add-criterio-btn"
                                @click="agregarCriterio()">
                            + Agregar Criterio
                        </button>

                        <!-- Validación visual -->
                        <div x-show="totalPonderacion !== 100" class="mt-4">
                            <p class="text-sm" :class="totalPonderacion > 100 ? 'text-red-600' : 'text-amber-600'">
                                <span x-show="totalPonderacion < 100">⚠️ Faltan <span x-text="(100 - totalPonderacion).toFixed(0)"></span>% para completar el 100%</span>
                                <span x-show="totalPonderacion > 100">❌ Excediste por <span x-text="(totalPonderacion - 100).toFixed(0)"></span>% el límite del 100%</span>
                            </p>
                        </div>
                        <div x-show="totalPonderacion === 100" class="mt-4">
                            <p class="text-sm text-green-600">✅ ¡Perfecto! Los criterios suman exactamente 100%</p>
                        </div>
                    @else
                        <div class="warning-box">
                            <p><strong>⚠️ Criterios bloqueados:</strong> No se pueden modificar los criterios porque el evento ya no está en estado "Próximo". Solo se pueden editar criterios cuando el evento aún no ha comenzado.</p>
                        </div>

                        <div class="readonly-criterios">
                            @forelse($evento->criteriosEvaluacion as $criterio)
                                <div class="readonly-criterio">
                                    <div>
                                        <span class="readonly-criterio-name">{{ $criterio->nombre }}</span>
                                        @if($criterio->descripcion)
                                            <span class="text-gray-500 text-sm ml-2">- {{ $criterio->descripcion }}</span>
                                        @endif
                                    </div>
                                    <span class="readonly-criterio-pond">{{ $criterio->ponderacion }}%</span>
                                </div>
                            @empty
                                <p class="text-gray-500 text-sm text-center py-4">No hay criterios definidos para este evento.</p>
                            @endforelse
                        </div>
                    @endif
                </div>

                <!-- Botón de Envío -->
                <div class="flex items-center justify-end mt-6">
                    <button type="submit" class="submit-button"
                            @if($evento->puedeCambiarCriterios())
                            :disabled="Math.abs(totalPonderacion - 100) >= 0.01"
                            :class="{ 'opacity-50 cursor-not-allowed': Math.abs(totalPonderacion - 100) >= 0.01 }"
                            @endif>
                        Actualizar Evento
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection