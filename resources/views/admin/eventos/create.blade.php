@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
    
    /* Fondo degradado */
    .evento-create-page {
        background: linear-gradient(to bottom, #FFFDF4, #FFEEE2);
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
    }
    
    /* Textos */
    .evento-create-page h2,
    .evento-create-page h3 {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
    }
    
    .evento-create-page p,
    .evento-create-page label {
        font-family: 'Poppins', sans-serif;
        color: #6b6b6b;
    }
    
    /* Back button */
    .back-button {
        color: #2c2c2c;
        transition: all 0.2s ease;
    }
    
    .back-button:hover {
        color: #6366f1;
    }
    
    /* Main card */
    .main-card {
        background: #FFEEE2;
        border-radius: 20px;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
        overflow: hidden;
        padding: 2rem;
    }
    
    /* Section card */
    .section-card {
        background: rgba(255, 255, 255, 0.4);
        border-radius: 16px;
        padding: 1.5rem;
        margin-top: 1.5rem;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
    }
    
    .section-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid rgba(99, 102, 241, 0.2);
    }
    
    .section-icon {
        width: 2.5rem;
        height: 2.5rem;
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 3px 3px 6px rgba(99, 102, 241, 0.3);
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
    }
    
    /* Info box */
    .info-box {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(139, 92, 246, 0.1));
        border-left: 4px solid #6366f1;
        border-radius: 0 12px 12px 0;
        padding: 1rem 1.25rem;
        margin-bottom: 1.5rem;
    }
    
    .info-box p {
        color: #4338ca;
        font-size: 0.875rem;
        line-height: 1.5;
    }
    
    .info-box strong {
        color: #3730a3;
    }
    
    /* Alert error */
    .alert-error {
        background: rgba(254, 226, 226, 0.8);
        border-left: 4px solid #ef4444;
        color: #991b1b;
        padding: 1rem;
        margin-bottom: 1.5rem;
        border-radius: 0 12px 12px 0;
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
        background: rgba(255, 255, 255, 0.6);
        border: 1px solid rgba(0, 0, 0, 0.05);
        box-shadow: inset 3px 3px 6px #e6d5c9, inset -3px -3px 6px #ffffff;
        transition: all 0.2s ease;
        color: #2c2c2c;
        width: 100%;
        padding: 0.625rem 0.875rem;
        border-radius: 10px;
    }
    
    .neuro-input:focus,
    .neuro-textarea:focus {
        outline: none;
        border-color: #6366f1;
        box-shadow: inset 3px 3px 6px #e6d5c9, inset -3px -3px 6px #ffffff, 0 0 0 3px rgba(99, 102, 241, 0.1);
    }
    
    /* Criterio card */
    .criterio-card {
        background: rgba(255, 255, 255, 0.5);
        border: 1px solid rgba(99, 102, 241, 0.2);
        border-radius: 12px;
        padding: 1.25rem;
        margin-bottom: 1rem;
        position: relative;
        transition: all 0.3s ease;
    }
    
    .criterio-card:hover {
        border-color: rgba(99, 102, 241, 0.4);
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.1);
    }
    
    .criterio-number {
        position: absolute;
        top: -0.5rem;
        left: 1rem;
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: white;
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        box-shadow: 2px 2px 4px rgba(99, 102, 241, 0.3);
    }
    
    .criterio-grid {
        display: grid;
        grid-template-columns: 1fr 1fr auto;
        gap: 1rem;
        align-items: start;
    }
    
    @media (max-width: 768px) {
        .criterio-grid {
            grid-template-columns: 1fr;
        }
    }
    
    .ponderacion-input-wrapper {
        position: relative;
    }
    
    .ponderacion-input-wrapper .neuro-input {
        padding-right: 2.5rem;
        text-align: center;
        font-weight: 600;
    }
    
    .ponderacion-suffix {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #6b6b6b;
        font-weight: 500;
        pointer-events: none;
    }
    
    /* Remove button */
    .btn-remove-criterio {
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
        border: none;
        border-radius: 8px;
        padding: 0.5rem;
        cursor: pointer;
        transition: all 0.2s ease;
        margin-top: 1.5rem;
    }
    
    .btn-remove-criterio:hover {
        background: rgba(239, 68, 68, 0.2);
    }
    
    /* Add button */
    .btn-add-criterio {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        width: 100%;
        padding: 0.875rem;
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(139, 92, 246, 0.1));
        border: 2px dashed rgba(99, 102, 241, 0.4);
        border-radius: 12px;
        color: #4f46e5;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .btn-add-criterio:hover {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.15), rgba(139, 92, 246, 0.15));
        border-color: rgba(99, 102, 241, 0.6);
    }
    
    /* Ponderación total */
    .ponderacion-total {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem 1.25rem;
        background: rgba(255, 255, 255, 0.6);
        border-radius: 12px;
        margin-top: 1rem;
    }
    
    .ponderacion-total-label {
        font-weight: 500;
        color: #2c2c2c;
    }
    
    .ponderacion-total-value {
        font-size: 1.5rem;
        font-weight: 700;
    }
    
    .ponderacion-total-value.complete {
        color: #059669;
    }
    
    .ponderacion-total-value.incomplete {
        color: #dc2626;
    }
    
    .ponderacion-status {
        font-size: 0.75rem;
        margin-left: 0.5rem;
    }
    
    /* Submit button */
    .submit-button {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: #ffffff;
        font-weight: 600;
        padding: 0.75rem 2rem;
        border-radius: 10px;
        box-shadow: 4px 4px 12px rgba(99, 102, 241, 0.3);
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }
    
    .submit-button:hover {
        box-shadow: 6px 6px 16px rgba(99, 102, 241, 0.4);
        transform: translateY(-2px);
    }
    
    .submit-button:disabled {
        background: #9ca3af;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }
</style>

<div class="evento-create-page py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="flex items-center mb-6">
            <a href="{{ route('admin.eventos.index') }}" class="back-button">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <h2 class="font-semibold text-xl ml-2">
                Crear Nuevo Evento
            </h2>
        </div>
        
        <div class="main-card">
            @if ($errors->any())
                <div class="alert-error">
                    <strong>¡Ups!</strong> Hubo algunos problemas con tus datos.
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.eventos.store') }}" method="POST" enctype="multipart/form-data" id="eventoForm">
                @csrf

                {{-- SECCIÓN: Información del Evento --}}
                <div class="section-card" style="margin-top: 0;">
                    <div class="section-header">
                        <div class="section-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="section-title">Información del Evento</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="nombre" class="form-label">Nombre del Evento</label>
                            <input type="text" name="nombre" id="nombre" class="neuro-input" value="{{ old('nombre') }}" required placeholder="Ej: Hackathon 2025">
                        </div>

                        <div>
                            <label for="cupo_max_equipos" class="form-label">Cupo Máximo de Equipos</label>
                            <input type="number" name="cupo_max_equipos" id="cupo_max_equipos" class="neuro-input" value="{{ old('cupo_max_equipos') }}" required min="1" placeholder="Ej: 20">
                        </div>

                        <div>
                            <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                            <input type="date" name="fecha_inicio" id="fecha_inicio" class="neuro-input" value="{{ old('fecha_inicio') }}" required>
                        </div>

                        <div>
                            <label for="fecha_fin" class="form-label">Fecha de Fin</label>
                            <input type="date" name="fecha_fin" id="fecha_fin" class="neuro-input" value="{{ old('fecha_fin') }}" required>
                        </div>
                    </div>

                    <div class="mt-5">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea name="descripcion" id="descripcion" rows="3" class="neuro-textarea" placeholder="Describe brevemente el evento...">{{ old('descripcion') }}</textarea>
                    </div>

                    <div class="mt-5">
                        <label for="ruta_imagen" class="form-label">Imagen del Evento</label>
                        <input type="file" name="ruta_imagen" id="ruta_imagen" class="neuro-file" accept="image/*">
                    </div>
                </div>

                {{-- SECCIÓN: Criterios de Evaluación --}}
                <div class="section-card">
                    <div class="section-header">
                        <div class="section-icon" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed);">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <h3 class="section-title">Criterios de Evaluación</h3>
                    </div>

                    <div class="info-box">
                        <p>
                            <strong>¿Cómo funciona?</strong> Define los aspectos que los jurados evaluarán en cada proyecto. 
                            Cada criterio tiene un <strong>porcentaje</strong> que indica su importancia en la calificación final.
                        </p>
                        <p class="mt-2">
                            <strong>Importante:</strong> La suma de todos los porcentajes debe ser exactamente <strong>100%</strong>.
                            Por ejemplo: Innovación (30%) + Funcionalidad (25%) + Presentación (20%) + Impacto (25%) = 100%
                        </p>
                    </div>

                    <div id="criterios-container">
                        {{-- Criterio 1 (por defecto) --}}
                        <div class="criterio-card" data-criterio="1">
                            <span class="criterio-number">Criterio 1</span>
                            <div class="criterio-grid">
                                <div>
                                    <label class="form-label">Nombre del criterio</label>
                                    <input type="text" name="criterios[0][nombre]" class="neuro-input" required placeholder="Ej: Innovación y Creatividad">
                                </div>
                                <div>
                                    <label class="form-label">Descripción (opcional)</label>
                                    <input type="text" name="criterios[0][descripcion]" class="neuro-input" placeholder="Ej: Originalidad del proyecto">
                                </div>
                                <div>
                                    <label class="form-label">Porcentaje</label>
                                    <div class="ponderacion-input-wrapper">
                                        <input type="number" name="criterios[0][ponderacion]" class="neuro-input ponderacion-input" required min="1" max="100" placeholder="25" oninput="calcularTotal()">
                                        <span class="ponderacion-suffix">%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn-add-criterio" onclick="agregarCriterio()">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Agregar otro criterio
                    </button>

                    <div class="ponderacion-total">
                        <span class="ponderacion-total-label">Total de porcentajes:</span>
                        <div>
                            <span id="ponderacion-total-value" class="ponderacion-total-value incomplete">0%</span>
                            <span id="ponderacion-status" class="ponderacion-status text-red-500">(Debe ser 100%)</span>
                        </div>
                    </div>
                </div>

                {{-- Botón de Envío --}}
                <div class="flex items-center justify-end mt-8">
                    <button type="submit" class="submit-button" id="submitBtn">
                        <span class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Crear Evento
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let criterioCount = 1;

    function agregarCriterio() {
        criterioCount++;
        const container = document.getElementById('criterios-container');
        
        const criterioHtml = `
            <div class="criterio-card" data-criterio="${criterioCount}">
                <span class="criterio-number">Criterio ${criterioCount}</span>
                <div class="criterio-grid">
                    <div>
                        <label class="form-label">Nombre del criterio</label>
                        <input type="text" name="criterios[${criterioCount - 1}][nombre]" class="neuro-input" required placeholder="Ej: Funcionalidad">
                    </div>
                    <div>
                        <label class="form-label">Descripción (opcional)</label>
                        <input type="text" name="criterios[${criterioCount - 1}][descripcion]" class="neuro-input" placeholder="Ej: Calidad del código">
                    </div>
                    <div>
                        <label class="form-label">Porcentaje</label>
                        <div class="ponderacion-input-wrapper">
                            <input type="number" name="criterios[${criterioCount - 1}][ponderacion]" class="neuro-input ponderacion-input" required min="1" max="100" placeholder="25" oninput="calcularTotal()">
                            <span class="ponderacion-suffix">%</span>
                        </div>
                    </div>
                    <button type="button" class="btn-remove-criterio" onclick="eliminarCriterio(this)">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        `;
        
        container.insertAdjacentHTML('beforeend', criterioHtml);
        calcularTotal();
    }

    function eliminarCriterio(button) {
        const card = button.closest('.criterio-card');
        card.remove();
        renumerarCriterios();
        calcularTotal();
    }

    function renumerarCriterios() {
        const cards = document.querySelectorAll('.criterio-card');
        cards.forEach((card, index) => {
            card.querySelector('.criterio-number').textContent = `Criterio ${index + 1}`;
            card.querySelectorAll('input').forEach(input => {
                const name = input.getAttribute('name');
                if (name) {
                    input.setAttribute('name', name.replace(/criterios\[\d+\]/, `criterios[${index}]`));
                }
            });
        });
        criterioCount = cards.length;
    }

    function calcularTotal() {
        const inputs = document.querySelectorAll('.ponderacion-input');
        let total = 0;
        
        inputs.forEach(input => {
            const value = parseInt(input.value) || 0;
            total += value;
        });

        const totalElement = document.getElementById('ponderacion-total-value');
        const statusElement = document.getElementById('ponderacion-status');
        const submitBtn = document.getElementById('submitBtn');

        totalElement.textContent = total + '%';

        if (total === 100) {
            totalElement.className = 'ponderacion-total-value complete';
            statusElement.textContent = '✓ ¡Perfecto!';
            statusElement.className = 'ponderacion-status text-green-600';
            submitBtn.disabled = false;
        } else if (total > 100) {
            totalElement.className = 'ponderacion-total-value incomplete';
            statusElement.textContent = `(Excede por ${total - 100}%)`;
            statusElement.className = 'ponderacion-status text-red-500';
            submitBtn.disabled = true;
        } else {
            totalElement.className = 'ponderacion-total-value incomplete';
            statusElement.textContent = `(Faltan ${100 - total}%)`;
            statusElement.className = 'ponderacion-status text-red-500';
            submitBtn.disabled = true;
        }
    }

    // Calcular al cargar la página
    document.addEventListener('DOMContentLoaded', calcularTotal);
</script>
@endsection