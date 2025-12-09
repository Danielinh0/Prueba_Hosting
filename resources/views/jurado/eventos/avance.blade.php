@extends('jurado.layouts.app')

@section('content')

<div class="calificar-avance-page">
    <div class="max-w-4xl mx-auto">
        {{-- Botón Volver --}}
        <a href="{{ route('jurado.eventos.equipo_evento', [$evento, $equipo]) }}" class="back-btn">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" width="20" height="20">
                <path d="M15 6L9 12L15 18" stroke="#e89a3c" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Volver al Equipo
        </a>

        {{-- Título de la página --}}
        <h1 class="page-title">
            {{ isset($evaluacionExistente) && $evaluacionExistente ? 'Reevaluar Avance' : 'Calificar Avance' }}
        </h1>

        @if(isset($evaluacionExistente) && $evaluacionExistente)
        {{-- Alerta de reevaluación --}}
        <div class="alert-reevaluacion">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
            <div>
                <p class="alert-title">Este avance ya fue calificado</p>
                <p class="alert-details">
                    Calificación anterior: <strong>{{ $evaluacionExistente->calificacion }}/100</strong>
                    · Fecha: {{ $evaluacionExistente->fecha_evaluacion->translatedFormat('d/m/Y H:i') }}
                </p>
            </div>
        </div>
        @endif

        {{-- Información del Avance --}}
        <div class="neu-card">
            <div class="info-section">
                <h2>{{ $avance->titulo ?? 'Sin título' }}</h2>
                <p>
                    Registrado por: {{ $avance->usuarioRegistro->nombre ?? 'Desconocido' }} {{ $avance->usuarioRegistro->app_paterno ?? '' }}
                </p>
                <p>
                    Fecha: {{ $avance->created_at->translatedFormat('d \\d\\e F \\d\\e\\l Y, H:i') }}
                </p>
            </div>

            {{-- Descripción del avance --}}
            <div class="info-section">
                <h3>Descripción</h3>
                <div class="text-box">
                    <p>{{ $avance->descripcion ?? 'Sin descripción' }}</p>
                </div>
            </div>

            {{-- Archivo de evidencia --}}
            <div class="info-section" style="margin-bottom: 0;">
                <h3>Archivo de Evidencia</h3>
                @if($avance->archivo_evidencia)
                    <a href="{{ asset('storage/' . $avance->archivo_evidencia) }}" target="_blank" class="file-btn">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Ver/Descargar Archivo
                    </a>
                @else
                    <p style="font-size: 0.875rem; color: #9ca3af;">No se adjuntó ningún archivo</p>
                @endif
            </div>
        </div>

        {{-- Formulario de Calificación --}}
        <div class="neu-card">
            <h2 style="font-size: 1.125rem; font-weight: 600; color: #2c2c2c; margin-bottom: 1rem; font-family: 'Poppins', sans-serif;">
                {{ isset($evaluacionExistente) && $evaluacionExistente ? 'Nueva Calificación' : 'Calificación' }}
            </h2>

            <form action="{{ route('jurado.eventos.guardar_calificacion', [$evento, $equipo, $avance]) }}" method="POST">
                @csrf

                {{-- Calificación --}}
                <div class="form-group">
                    <label for="calificacion" class="form-label">
                        Calificación (1-100)
                    </label>
                    <div class="criterio-input-container">
                        <input type="number"
                               id="calificacion"
                               name="calificacion"
                               min="1"
                               max="100"
                               step="1"
                               required
                               value="{{ old('calificacion', isset($evaluacionExistente) && $evaluacionExistente ? $evaluacionExistente->calificacion : '') }}"
                               class="criterio-input"
                               placeholder="1-100"
                               oninput="actualizarBarra(this)"
                               onkeydown="return validarTecla(event)">

                        <div class="score-indicator">
                            <span>0</span>
                            <div class="score-bar">
                                <div class="score-fill" id="calificacion-bar"></div>
                            </div>
                            <span>100</span>
                        </div>
                    </div>
                    <p id="error-calificacion" class="error-message hidden">La calificación debe ser un número entero entre 1 y 100</p>
                    @error('calificacion')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Comentarios --}}
                <div class="form-group">
                    <label for="comentarios" class="form-label">
                        Comentarios (opcional)
                    </label>
                    <textarea id="comentarios"
                              name="comentarios"
                              rows="4"
                              class="form-textarea"
                              placeholder="Escribe tus comentarios sobre este avance...">{{ old('comentarios', isset($evaluacionExistente) && $evaluacionExistente ? $evaluacionExistente->comentarios : '') }}</textarea>
                    @error('comentarios')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Botones --}}
                <div class="action-buttons">
                    <button type="submit"
                            id="btn-submit"
                            class="btn-action btn-submit">
                        {{ isset($evaluacionExistente) && $evaluacionExistente ? 'Actualizar Calificación' : 'Guardar Calificación' }}
                    </button>
                    <a href="{{ route('jurado.eventos.equipo_evento', [$evento, $equipo]) }}"
                       class="btn-action btn-cancel">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Función para actualizar la barra de calificación
    function actualizarBarra(input) {
        const valor = input.value;
        const barra = document.getElementById('calificacion-bar');
        const errorMsg = document.getElementById('error-calificacion');
        const btnSubmit = document.getElementById('btn-submit');

        // Eliminar decimales si los hay
        if (valor.includes('.') || valor.includes(',')) {
            input.value = Math.floor(parseFloat(valor.replace(',', '.')));
        }

        const numero = parseInt(input.value) || 0;

        // Actualizar la barra
        barra.style.width = numero + '%';

        // Cambiar color según la calificación
        if (numero >= 80) {
            barra.style.background = '#10b981'; // Verde
        } else if (numero >= 60) {
            barra.style.background = '#f59e0b'; // Amarillo
        } else if (numero >= 40) {
            barra.style.background = '#f97316'; // Naranja
        } else {
            barra.style.background = '#ef4444'; // Rojo
        }

        // Validar rango
        if (numero < 1 || numero > 100) {
            if (numero !== 0) {
                errorMsg.classList.remove('hidden');
                btnSubmit.disabled = true;
                btnSubmit.style.opacity = '0.5';

                // Corregir automáticamente
                if (numero < 1) {
                    input.value = 1;
                    actualizarBarra(input);
                } else if (numero > 100) {
                    input.value = 100;
                    actualizarBarra(input);
                }

                setTimeout(() => {
                    errorMsg.classList.add('hidden');
                    btnSubmit.disabled = false;
                    btnSubmit.style.opacity = '1';
                }, 1500);
            }
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

    // Inicializar la barra al cargar la página
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('calificacion');
        if (input && input.value) {
            actualizarBarra(input);
        }
    });

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

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

    /* Página principal */
    .calificar-avance-page {
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

    /* Título de página */
    .page-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2c2c2c;
        margin-bottom: 1.5rem;
        font-family: 'Poppins', sans-serif;
    }

    /* Alert de reevaluación */
    .alert-reevaluacion {
        background: linear-gradient(135deg, rgba(254, 243, 199, 0.8), rgba(253, 230, 138, 0.8));
        border-radius: 16px;
        padding: 1rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        border-left: 4px solid #f59e0b;
    }

    .alert-reevaluacion svg {
        width: 1.5rem;
        height: 1.5rem;
        color: #d97706;
        flex-shrink: 0;
    }

    .alert-reevaluacion p {
        margin: 0;
        font-family: 'Poppins', sans-serif;
    }

    .alert-reevaluacion .alert-title {
        font-weight: 600;
        color: #92400e;
    }

    .alert-reevaluacion .alert-details {
        font-size: 0.875rem;
        color: #b45309;
    }

    /* Card neuromórfica */
    .neu-card {
        background: #FFEEE2;
        border-radius: 20px;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    /* Sección de información */
    .info-section {
        margin-bottom: 1.5rem;
    }

    .info-section h2,
    .info-section h3 {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .info-section h2 {
        font-size: 1.125rem;
    }

    .info-section h3 {
        font-size: 1rem;
    }

    .info-section p {
        font-family: 'Poppins', sans-serif;
        font-size: 0.875rem;
        color: #6b6b6b;
        margin-bottom: 0.25rem;
    }

    /* Text box neuromórfico */
    .text-box {
        background: rgba(255, 255, 255, 0.4);
        border-radius: 12px;
        padding: 1rem;
        box-shadow: inset 3px 3px 6px #e6d5c9, inset -3px -3px 6px #ffffff;
    }

    .text-box p {
        color: #2c2c2c;
        margin: 0;
        line-height: 1.6;
        font-family: 'Poppins', sans-serif;
    }

    /* Botón de archivo */
    .file-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1rem;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.4);
        color: #e89a3c;
        font-family: 'Poppins', sans-serif;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
    }

    .file-btn:hover {
        transform: translateY(-2px);
        box-shadow: 6px 6px 12px #e6d5c9, -6px -6px 12px #ffffff;
    }

    .file-btn svg {
        width: 1.25rem;
        height: 1.25rem;
    }

    /* Form elements */
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 500;
        color: #2c2c2c;
        margin-bottom: 0.5rem;
        font-family: 'Poppins', sans-serif;
    }

    .form-input,
    .form-textarea {
        width: 100%;
        border-radius: 12px;
        padding: 0.75rem 1rem;
        border: none;
        background: rgba(255, 255, 255, 0.5);
        color: #2c2c2c;
        font-family: 'Poppins', sans-serif;
        box-shadow: inset 3px 3px 6px #e6d5c9, inset -3px -3px 6px #ffffff;
        transition: all 0.2s ease;
    }

    .form-input:focus,
    .form-textarea:focus {
        outline: none;
        box-shadow: inset 4px 4px 8px #e6d5c9, inset -4px -4px 8px #ffffff;
    }

    .form-input::placeholder,
    .form-textarea::placeholder {
        color: #9ca3af;
    }

    .form-textarea {
        resize: none;
    }

    /* Estilos para la barra personalizada de calificación */
    .criterio-input-container {
        background: rgba(255, 255, 255, 0.5);
        border: none;
        border-radius: 12px;
        padding: 1rem;
        box-shadow: inset 3px 3px 6px #e6d5c9, inset -3px -3px 6px #ffffff;
    }

    .criterio-input {
        background: transparent;
        border: none;
        border-radius: 8px;
        padding: 0.875rem 1rem;
        font-size: 1.5rem;
        font-weight: 600;
        text-align: center;
        color: #2c2c2c;
        width: 100%;
        font-family: 'Poppins', sans-serif;
        margin-bottom: 0.75rem;
        transition: all 0.3s ease;
    }

    .criterio-input:focus {
        outline: none;
        background: rgba(255, 255, 255, 0.3);
    }

    .criterio-input::placeholder {
        color: #9ca3af;
    }

    .score-indicator {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .score-bar {
        flex: 1;
        height: 8px;
        background: rgba(255, 255, 255, 0.6);
        border-radius: 4px;
        overflow: hidden;
        box-shadow: inset 2px 2px 4px #e6d5c9, inset -2px -2px 4px #ffffff;
    }

    .score-fill {
        height: 100%;
        border-radius: 4px;
        transition: width 0.3s ease, background 0.3s ease;
        width: 0%;
    }

    .score-indicator span {
        font-size: 0.875rem;
        font-weight: 500;
        color: #9ca3af;
        font-family: 'Poppins', sans-serif;
        min-width: 30px;
        text-align: center;
    }

    /* Error message */
    .error-message {
        font-size: 0.875rem;
        color: #dc2626;
        margin-top: 0.25rem;
        font-family: 'Poppins', sans-serif;
    }

    .error-message.hidden {
        display: none;
    }

    /* Botones de acción */
    .action-buttons {
        display: flex;
        gap: 1rem;
    }

    .btn-action {
        flex: 1;
        border-radius: 20px;
        padding: 0.75rem;
        font-weight: 600;
        font-family: 'Poppins', sans-serif;
        text-align: center;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }

    .btn-submit {
        background: linear-gradient(135deg, #e89a3c, #f5a847);
        color: white;
        box-shadow: 4px 4px 8px rgba(232, 154, 60, 0.3);
    }

    .btn-submit:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 6px 6px 12px rgba(232, 154, 60, 0.4);
    }

    .btn-submit:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .btn-cancel {
        background: rgba(255, 255, 255, 0.5);
        color: #2c2c2c;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
    }

    .btn-cancel:hover {
        transform: translateY(-2px);
        box-shadow: 6px 6px 12px #e6d5c9, -6px -6px 12px #ffffff;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .calificar-avance-page {
            padding: 1rem;
        }

        .action-buttons {
            flex-direction: column;
        }
    }
</style>
@endsection