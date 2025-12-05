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

<div class="py-8 px-6 lg:px-12" style="background-color: #FFFDF4; min-height: 100vh;">
    <div class="max-w-4xl mx-auto">
        {{-- Botón Volver --}}
        <a href="{{ route('jurado.eventos.equipo_evento', [$evento, $equipo]) }}" class="back-btn">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" width="20" height="20">
                <path d="M15 6L9 12L15 18" stroke="#e89a3c" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Volver al Equipo
        </a>

        {{-- Título de la página --}}
        <h1 class="text-2xl font-bold mb-6" style="color: #4B4B4B;">
            {{ isset($evaluacionExistente) && $evaluacionExistente ? 'Reevaluar Avance' : 'Calificar Avance' }}
        </h1>

        @if(isset($evaluacionExistente) && $evaluacionExistente)
        {{-- Alerta de reevaluación --}}
        <div class="rounded-2xl p-4 mb-6 flex items-center gap-3" style="background-color: #FEF3C7; border: 1px solid #F59E0B;">
            <svg class="w-6 h-6 flex-shrink-0" style="color: #D97706;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
            <div>
                <p class="font-semibold" style="color: #92400E;">Este avance ya fue calificado</p>
                <p class="text-sm" style="color: #B45309;">
                    Calificación anterior: <strong>{{ $evaluacionExistente->calificacion }}/100</strong> 
                    · Fecha: {{ $evaluacionExistente->fecha_evaluacion->translatedFormat('d/m/Y H:i') }}
                </p>
            </div>
        </div>
        @endif

        {{-- Información del Avance --}}
        <div class="rounded-2xl p-6 shadow-md mb-6" style="background-color: #FFEFDC;">
            <div class="mb-4">
                <h2 class="text-lg font-semibold" style="color: #4B4B4B;">{{ $avance->titulo ?? 'Sin título' }}</h2>
                <p class="text-sm" style="color: #A4AEB7;">
                    Registrado por: {{ $avance->usuarioRegistro->nombre ?? 'Desconocido' }} {{ $avance->usuarioRegistro->app_paterno ?? '' }}
                </p>
                <p class="text-sm" style="color: #A4AEB7;">
                    Fecha: {{ $avance->created_at->translatedFormat('d \\d\\e F \\d\\e\\l Y, H:i') }}
                </p>
            </div>

            {{-- Descripción del avance --}}
            <div class="mb-4">
                <h3 class="text-base font-semibold mb-2" style="color: #4B4B4B;">Descripción</h3>
                <div class="rounded-xl p-4" style="background-color: rgba(255, 255, 255, 0.5); border: 1px solid #E5E7EB;">
                    <p style="color: #4B4B4B;">{{ $avance->descripcion ?? 'Sin descripción' }}</p>
                </div>
            </div>

            {{-- Archivo de evidencia --}}
            @if($avance->archivo_evidencia)
            <div class="mb-4">
                <h3 class="text-base font-semibold mb-2" style="color: #4B4B4B;">Archivo de Evidencia</h3>
                <a href="{{ asset('storage/' . $avance->archivo_evidencia) }}" target="_blank" 
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl transition-colors"
                   style="background-color: rgba(255, 255, 255, 0.5); border: 1px solid #E5E7EB; color: #CE894D;">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Ver/Descargar Archivo
                </a>
            </div>
            @else
            <div class="mb-4">
                <h3 class="text-base font-semibold mb-2" style="color: #4B4B4B;">Archivo de Evidencia</h3>
                <p class="text-sm" style="color: #A4AEB7;">No se adjuntó ningún archivo</p>
            </div>
            @endif
        </div>

        {{-- Formulario de Calificación --}}
        <div class="rounded-2xl p-6 shadow-md" style="background-color: #FFEFDC;">
            <h2 class="text-lg font-semibold mb-4" style="color: #4B4B4B;">
                {{ isset($evaluacionExistente) && $evaluacionExistente ? 'Nueva Calificación' : 'Calificación' }}
            </h2>

            <form action="{{ route('jurado.eventos.guardar_calificacion', [$evento, $equipo, $avance]) }}" method="POST">
                @csrf

                {{-- Calificación --}}
                <div class="mb-4">
                    <label for="calificacion" class="block text-sm font-medium mb-2" style="color: #4B4B4B;">
                        Calificación (1-100)
                    </label>
                    <input type="number" 
                           id="calificacion" 
                           name="calificacion" 
                           min="1" 
                           max="100" 
                           step="1"
                           required
                           value="{{ old('calificacion', isset($evaluacionExistente) && $evaluacionExistente ? $evaluacionExistente->calificacion : '') }}"
                           class="w-full rounded-xl px-4 py-3 focus:outline-none focus:ring-2"
                           style="background-color: rgba(255, 255, 255, 0.5); border: 1px solid #E5E7EB; color: #4B4B4B;"
                           placeholder="Ingresa una calificación del 1 al 100"
                           oninput="validarCalificacion(this)"
                           onkeydown="return validarTecla(event)">
                    <p id="error-calificacion" class="text-sm mt-1 hidden" style="color: #DC2626;">La calificación debe ser un número entero entre 1 y 100</p>
                    @error('calificacion')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Comentarios --}}
                <div class="mb-6">
                    <label for="comentarios" class="block text-sm font-medium mb-2" style="color: #4B4B4B;">
                        Comentarios (opcional)
                    </label>
                    <textarea id="comentarios" 
                              name="comentarios" 
                              rows="4"
                              class="w-full rounded-xl px-4 py-3 focus:outline-none focus:ring-2 resize-none"
                              style="background-color: rgba(255, 255, 255, 0.5); border: 1px solid #E5E7EB; color: #4B4B4B;"
                              placeholder="Escribe tus comentarios sobre este avance...">{{ old('comentarios', isset($evaluacionExistente) && $evaluacionExistente ? $evaluacionExistente->comentarios : '') }}</textarea>
                    @error('comentarios')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Botones --}}
                <div class="flex gap-4">
                    <button type="submit" 
                            id="btn-submit"
                            class="flex-1 rounded-full py-3 text-white font-semibold transition-colors hover:opacity-90"
                            style="background-color: {{ isset($evaluacionExistente) && $evaluacionExistente ? '#CE894D' : '#F0BC7B' }};">
                        {{ isset($evaluacionExistente) && $evaluacionExistente ? 'Actualizar Calificación' : 'Guardar Calificación' }}
                    </button>
                    <a href="{{ route('jurado.eventos.equipo_evento', [$evento, $equipo]) }}" 
                       class="flex-1 rounded-full py-3 text-center font-semibold transition-colors"
                       style="background-color: rgba(255, 255, 255, 0.5); border: 1px solid #E5E7EB; color: #4B4B4B;">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Validar que solo se ingresen números enteros del 1 al 100
    function validarCalificacion(input) {
        const valor = input.value;
        const errorMsg = document.getElementById('error-calificacion');
        const btnSubmit = document.getElementById('btn-submit');
        
        // Eliminar decimales si los hay
        if (valor.includes('.') || valor.includes(',')) {
            input.value = Math.floor(parseFloat(valor.replace(',', '.')));
        }
        
        const numero = parseInt(input.value);
        
        if (input.value === '' || isNaN(numero)) {
            errorMsg.classList.add('hidden');
            btnSubmit.disabled = false;
            btnSubmit.style.opacity = '1';
            return;
        }
        
        if (numero < 1 || numero > 100) {
            errorMsg.classList.remove('hidden');
            btnSubmit.disabled = true;
            btnSubmit.style.opacity = '0.5';
            
            // Corregir automáticamente valores fuera de rango
            if (numero < 1) {
                input.value = 1;
            } else if (numero > 100) {
                input.value = 100;
            }
            
            setTimeout(() => {
                errorMsg.classList.add('hidden');
                btnSubmit.disabled = false;
                btnSubmit.style.opacity = '1';
            }, 1500);
        } else {
            errorMsg.classList.add('hidden');
            btnSubmit.disabled = false;
            btnSubmit.style.opacity = '1';
        }
    }
    
    // Prevenir caracteres no numéricos
    function validarTecla(event) {
        // Permitir: backspace, delete, tab, escape, enter, flechas
        if ([8, 9, 27, 13, 46, 37, 38, 39, 40].includes(event.keyCode)) {
            return true;
        }
        
        // Permitir Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X
        if ((event.keyCode === 65 || event.keyCode === 67 || event.keyCode === 86 || event.keyCode === 88) && event.ctrlKey) {
            return true;
        }
        
        // Bloquear punto, coma y signo menos
        if (event.key === '.' || event.key === ',' || event.key === '-' || event.key === 'e' || event.key === 'E') {
            event.preventDefault();
            return false;
        }
        
        // Permitir solo números
        if (event.key >= '0' && event.key <= '9') {
            return true;
        }
        
        event.preventDefault();
        return false;
    }
    
    // Validar al enviar el formulario
    document.querySelector('form').addEventListener('submit', function(e) {
        const input = document.getElementById('calificacion');
        const valor = parseInt(input.value);
        
        if (isNaN(valor) || valor < 1 || valor > 100) {
            e.preventDefault();
            document.getElementById('error-calificacion').classList.remove('hidden');
            input.focus();
        }
    });
</script>
@endsection
