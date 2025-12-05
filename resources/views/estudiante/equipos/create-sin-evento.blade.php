@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
    
    /* Fondo degradado */
    .crear-equipo-page {
        background: linear-gradient(to bottom, #FFFDF4, #FFEEE2);
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
        padding: 3rem 0;
    }
    
    /* Back link */
    .back-link {
        font-family: 'Poppins', sans-serif;
        display: inline-flex;
        align-items: center;
        color: black;
        font-size: 0.875rem;
        font-weight: 500;
        margin-bottom: 1rem;
        padding: 0.5rem 1rem;
        background: #FFEEE2;
        border-radius: 10px;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        transition: all 0.2s ease;
        text-decoration: none;
    }
    
    .back-link:hover {
        color: #4f46e5;
        box-shadow: 6px 6px 12px #e6d5c9, -6px -6px 12px #ffffff;
        transform: translateY(-2px);
    }
    
    .back-link svg {
        width: 1rem;
        height: 1rem;
        margin-right: 0.5rem;
    }
    
    /* Header section */
    .header-section {
        margin-bottom: 1.5rem;
    }
    
    .header-section h2 {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
        font-size: 1.5rem;
        font-weight: 600;
        margin: 0.5rem 0;
    }
    
    .header-section p {
        font-family: 'Poppins', sans-serif;
        color: #6b6b6b;
        font-size: 0.9375rem;
        margin-top: 0.5rem;
    }
    
    /* Main card */
    .main-card {
        background: #FFEEE2;
        border-radius: 20px;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
        padding: 2rem;
    }
    
    /* Form sections */
    .form-section {
        margin-bottom: 1.5rem;
    }
    
    /* Labels */
    .form-label {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
        font-size: 0.875rem;
        font-weight: 600;
        display: block;
        margin-bottom: 0.5rem;
    }
    
    .form-label .required {
        color: #ef4444;
    }
    
    /* Inputs y textareas */
    .neuro-input,
    .neuro-textarea {
        font-family: 'Poppins', sans-serif;
        background: rgba(255, 255, 255, 0.5);
        border: none;
        box-shadow: inset 4px 4px 8px #e6d5c9, inset -4px -4px 8px #ffffff;
        transition: all 0.2s ease;
        backdrop-filter: blur(10px);
        color: #2c2c2c;
        width: 100%;
        padding: 0.625rem 0.875rem;
        border-radius: 10px;
        font-size: 0.875rem;
    }
    
    .neuro-input::placeholder,
    .neuro-textarea::placeholder {
        color: #9ca3af;
        font-family: 'Poppins', sans-serif;
    }
    
    .neuro-input:focus,
    .neuro-textarea:focus {
        outline: none;
        box-shadow: inset 6px 6px 12px #e6d5c9, inset -6px -6px 12px #ffffff;
    }
    
    .neuro-textarea {
        resize: vertical;
        min-height: 100px;
    }
    
    /* Input error state */
    .neuro-input.error,
    .neuro-textarea.error {
        box-shadow: inset 4px 4px 8px rgba(239, 68, 68, 0.2), inset -4px -4px 8px #ffffff;
    }
    
    /* Helper text */
    .help-text {
        font-family: 'Poppins', sans-serif;
        font-size: 0.75rem;
        color: #9ca3af;
        margin-top: 0.375rem;
        display: block;
    }
    
    /* Error text */
    .error-text {
        font-family: 'Poppins', sans-serif;
        font-size: 0.875rem;
        color: #ef4444;
        margin-top: 0.375rem;
        display: block;
    }
    
    /* File input wrapper */
    .file-input-wrapper {
        position: relative;
        margin-top: 0.5rem;
    }
    
    .file-input-label {
        font-family: 'Poppins', sans-serif;
        display: inline-block;
        padding: 0.625rem 1.25rem;
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: white;
        border-radius: 10px;
        cursor: pointer;
        font-size: 0.875rem;
        font-weight: 500;
        box-shadow: 4px 4px 8px rgba(99, 102, 241, 0.3);
        transition: all 0.3s ease;
    }
    
    .file-input-label:hover {
        box-shadow: 6px 6px 12px rgba(99, 102, 241, 0.4);
        transform: translateY(-2px);
    }
    
    .file-input-label svg {
        display: inline-block;
        width: 1rem;
        height: 1rem;
        margin-right: 0.5rem;
        vertical-align: middle;
    }
    
    .neuro-file {
        position: absolute;
        opacity: 0;
        width: 0.1px;
        height: 0.1px;
        pointer-events: none;
    }
    
    .file-name-display {
        font-family: 'Poppins', sans-serif;
        font-size: 0.75rem;
        color: #6b6b6b;
        margin-top: 0.5rem;
        padding: 0.5rem;
        background: rgba(255, 255, 255, 0.3);
        border-radius: 8px;
        box-shadow: inset 2px 2px 4px #e6d5c9, inset -2px -2px 4px #ffffff;
        display: none;
    }
    
    .file-name-display.show {
        display: block;
    }
    
    /* Info box */
    .info-box {
        background: linear-gradient(135deg, rgba(224, 231, 255, 0.9), rgba(199, 210, 254, 0.9));
        border-left: 4px solid #6366f1;
        border-radius: 12px;
        padding: 1rem 1.25rem;
        margin-bottom: 1.5rem;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        backdrop-filter: blur(10px);
    }
    
    .info-box h3 {
        font-family: 'Poppins', sans-serif;
        color: #312e81;
        font-size: 0.9375rem;
        font-weight: 600;
        margin: 0 0 0.75rem 0;
        display: flex;
        align-items: center;
    }
    
    .info-box h3 .icon {
        margin-right: 0.5rem;
        font-size: 1.125rem;
    }
    
    .info-box ul {
        list-style: none;
        margin: 0;
        padding: 0;
    }
    
    .info-box li {
        font-family: 'Poppins', sans-serif;
        color: #4338ca;
        font-size: 0.875rem;
        margin: 0.5rem 0;
        padding-left: 1.25rem;
        position: relative;
    }
    
    .info-box li::before {
        content: '•';
        position: absolute;
        left: 0;
        color: #6366f1;
        font-weight: bold;
    }
    
    .info-box strong {
        font-weight: 600;
        color: #312e81;
    }
    
    /* Button container */
    .button-container {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 0.75rem;
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid rgba(232, 154, 60, 0.2);
    }
    
    /* Cancel button */
    .btn-cancel {
        font-family: 'Poppins', sans-serif;
        background: rgba(255, 253, 244, 0.9);
        color: #2c2c2c;
        font-weight: 500;
        padding: 0.625rem 1.5rem;
        border-radius: 12px;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        transition: all 0.3s ease;
        border: 1px solid rgba(232, 154, 60, 0.2);
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        font-size: 0.9375rem;
    }
    
    .btn-cancel:hover {
        box-shadow: 6px 6px 12px #e6d5c9, -6px -6px 12px #ffffff;
        transform: translateY(-2px);
        background: rgba(255, 253, 244, 1);
    }
    
    /* Submit button */
    .btn-submit {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: #ffffff;
        font-weight: 600;
        padding: 0.625rem 1.5rem;
        border-radius: 12px;
        box-shadow: 4px 4px 8px rgba(99, 102, 241, 0.3);
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        font-size: 0.9375rem;
    }
    
    .btn-submit:hover {
        box-shadow: 6px 6px 12px rgba(99, 102, 241, 0.4);
        transform: translateY(-2px);
    }
    
    .btn-submit:active {
        transform: translateY(0);
        box-shadow: 3px 3px 6px rgba(99, 102, 241, 0.3);
    }
    
    /* Responsive */
    @media (max-width: 640px) {
        .crear-equipo-page {
            padding: 1.5rem 0;
        }
        
        .main-card {
            padding: 1.5rem;
        }
        
        .header-section h2 {
            font-size: 1.25rem;
        }
        
        .button-container {
            flex-direction: column-reverse;
            gap: 0.5rem;
        }
        
        .btn-cancel,
        .btn-submit {
            width: 100%;
            text-align: center;
        }
    }
</style>

<div class="crear-equipo-page">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="header-section">
            <a href="{{ route('estudiante.equipo.index') }}" class="back-link">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver a mis Equipos
            </a>
            <h2>Crear Equipo</h2>
            <p>Crea tu equipo con anticipación y regístralo a un evento cuando esté disponible</p>
        </div>

        <div class="main-card">
            <form action="{{ route('estudiante.equipos.store-sin-evento') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Nombre del Equipo --}}
                <div class="form-section">
                    <label for="nombre" class="form-label">
                        Nombre del Equipo <span class="required">*</span>
                    </label>
                    <input type="text" 
                           name="nombre" 
                           id="nombre" 
                           value="{{ old('nombre') }}"
                           class="neuro-input @error('nombre') error @enderror"
                           required 
                           maxlength="100"
                           placeholder="Ej: Caballeros del Código">
                    @error('nombre')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Descripción --}}
                <div class="form-section">
                    <label for="descripcion" class="form-label">
                        Descripción del Equipo
                    </label>
                    <textarea name="descripcion" 
                              id="descripcion" 
                              rows="4"
                              class="neuro-textarea @error('descripcion') error @enderror"
                              maxlength="1000"
                              placeholder="Describe a tu equipo, habilidades, intereses...">{{ old('descripcion') }}</textarea>
                    <span class="help-text">Máximo 1000 caracteres</span>
                    @error('descripcion')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Imagen del Equipo --}}
                <div class="form-section">
                    <label for="ruta_imagen" class="form-label">
                        Logo/Imagen del Equipo
                    </label>
                    <div class="file-input-wrapper">
                        <label for="ruta_imagen" class="file-input-label">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Seleccionar Imagen
                        </label>
                        <input type="file" 
                               name="ruta_imagen" 
                               id="ruta_imagen" 
                               accept="image/jpeg,image/png,image/jpg,image/gif"
                               class="neuro-file @error('ruta_imagen') error @enderror"
                               onchange="displayFileName(this)">
                        <div id="file-name-display" class="file-name-display"></div>
                    </div>
                    <span class="help-text">JPG, PNG, GIF - Máximo 2MB</span>
                    @error('ruta_imagen')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Información Importante --}}
                <div class="info-box">
                    <h3>
                        <span class="icon">📌</span>
                        Importante:
                    </h3>
                    <ul>
                        <li>Serás automáticamente el <strong>líder</strong> del equipo</li>
                        <li>Podrás registrar este equipo a eventos cuando estén disponibles</li>
                        <li>El equipo quedará en tu "pool" de equipos disponibles</li>
                        <li>Puedes tener múltiples equipos diferentes</li>
                    </ul>
                </div>

                {{-- Botones --}}
                <div class="button-container">
                    <a href="{{ route('estudiante.dashboard') }}" class="btn-cancel">
                        Cancelar
                    </a>
                    <button type="submit" class="btn-submit">
                        Crear Equipo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function displayFileName(input) {
        const fileDisplay = document.getElementById('file-name-display');
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const size = (file.size / 1024 / 1024).toFixed(2); // Size in MB
            fileDisplay.textContent = `📁 ${file.name} (${size} MB)`;
            fileDisplay.classList.add('show');
        } else {
            fileDisplay.textContent = '';
            fileDisplay.classList.remove('show');
        }
    }
</script>
@endsection