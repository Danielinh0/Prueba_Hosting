@extends('layouts.app')

@section('content')


<div class="evento-edit-page py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('admin.eventos.index') }}" class="back-link">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver a Gestión de Eventos
        </a>
        <div class="flex items-center mb-6">
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