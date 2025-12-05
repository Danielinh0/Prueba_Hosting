@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
    
    /* Fondo degradado */
    .editar-equipo-page {
        background: linear-gradient(to bottom, #FFFDF4, #FFEEE2);
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
    }
    
    /* Textos */
    .editar-equipo-page h2 {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
    }
    
    .editar-equipo-page p,
    .editar-equipo-page label {
        font-family: 'Poppins', sans-serif;
        color: #6b6b6b;
    }
    
    /* Back button */
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
    
    .alert-error p {
        font-family: 'Poppins', sans-serif;
        color: #991b1b;
    }
    
    .alert-error .font-bold {
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
    .neuro-textarea {
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
    
    .neuro-input::placeholder,
    .neuro-textarea::placeholder {
        color: #9ca3af;
    }
    
    .neuro-input:focus,
    .neuro-textarea:focus {
        outline: none;
        box-shadow: inset 6px 6px 12px #e6d5c9, inset -6px -6px 12px #ffffff;
    }
    
    /* Helper text */
    .help-text {
        font-size: 0.75rem;
        color: #9ca3af;
        margin-top: 0.25rem;
    }
    
    /* Current image */
    .current-image-label {
        font-weight: 500;
        font-size: 0.875rem;
        color: #6b6b6b;
        margin-bottom: 0.5rem;
    }
    
    .current-image {
        height: 10rem;
        width: 10rem;
        object-fit: cover;
        border-radius: 15px;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        border: 2px solid rgba(232, 154, 60, 0.3);
    }
    
    /* No image placeholder */
    .no-image-placeholder {
        margin: 1rem 0;
        padding: 1rem;
        background: rgba(249, 250, 251, 0.5);
        border-radius: 15px;
        border: 2px dashed rgba(209, 213, 219, 0.8);
        box-shadow: inset 2px 2px 4px #e6d5c9, inset -2px -2px 4px #ffffff;
    }
    
    .no-image-placeholder p {
        font-size: 0.875rem;
        color: #9ca3af;
        text-align: center;
    }
    
    .no-image-placeholder svg {
        margin: 0 auto;
        height: 3rem;
        width: 3rem;
        color: #9ca3af;
    }
    
    /* File input */
    .neuro-file {
        font-family: 'Poppins', sans-serif;
        margin-top: 0.25rem;
        display: block;
        width: 100%;
        font-size: 0.875rem;
        color: #6b6b6b;
    }
    
    .neuro-file::file-selector-button {
        margin-right: 1rem;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        border: none;
        font-size: 0.875rem;
        font-weight: 600;
        background: linear-gradient(135deg, rgba(224, 231, 255, 0.8), rgba(199, 210, 254, 0.8));
        color: #3730a3;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .neuro-file::file-selector-button:hover {
        background: linear-gradient(135deg, rgba(224, 231, 255, 1), rgba(199, 210, 254, 1));
        box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.15);
    }
    
    /* Action buttons */
    .action-buttons {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid rgba(232, 154, 60, 0.2);
    }
    
    .btn-cancel {
        font-family: 'Poppins', sans-serif;
        background: rgba(255, 255, 255, 0.5);
        color: #2c2c2c;
        font-weight: 500;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        transition: all 0.3s ease;
        border: none;
        backdrop-filter: blur(10px);
        text-decoration: none;
        display: inline-block;
    }
    
    .btn-cancel:hover {
        box-shadow: 6px 6px 12px #e6d5c9, -6px -6px 12px #ffffff;
        transform: translateY(-2px);
    }
    
    .btn-submit {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: #ffffff;
        font-weight: 600;
        padding: 0.5rem 1.5rem;
        border-radius: 0.375rem;
        box-shadow: 4px 4px 8px rgba(99, 102, 241, 0.3);
        transition: all 0.3s ease;
        border: none;
    }
    
    .btn-submit:hover {
        box-shadow: 6px 6px 12px rgba(99, 102, 241, 0.4);
        transform: translateY(-2px);
    }
</style>

<div class="editar-equipo-page py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('estudiante.equipo.show-detalle', $equipo) }}" class="back-link">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver a {{ $equipo->nombre }}
        </a>
        <div class="flex items-center mb-6">
            <h2 class="font-semibold text-xl ml-2">
                Editar Equipo: {{ $equipo->nombre }}
            </h2>
        </div>
        
        <div class="main-card">
            @if (session('error'))
                <div class="alert-error" role="alert">
                    <p class="font-bold">Error</p>
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert-error" role="alert">
                    <p class="font-bold">¡Ups! Hubo algunos problemas.</p>
                    <ul class="mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('estudiante.equipo.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Nombre del Equipo -->
                <div>
                    <label for="nombre" class="form-label">Nombre del Equipo</label>
                    <input type="text" name="nombre" id="nombre" class="neuro-input" value="{{ old('nombre', $equipo->nombre) }}" required autofocus>
                    <p class="help-text">Este es el nombre con el que tu equipo será identificado en el evento.</p>
                </div>

                <!-- Descripción del Equipo -->
                <div class="mt-4">
                    <label for="descripcion" class="form-label">Descripción del Equipo (Opcional)</label>
                    <textarea name="descripcion" id="descripcion" rows="4" class="neuro-textarea" placeholder="Describe tu equipo, proyecto o lo que buscan lograr...">{{ old('descripcion', $equipo->descripcion) }}</textarea>
                    <p class="help-text">Máximo 1000 caracteres. Esta descripción ayudará a otros estudiantes a conocer tu equipo.</p>
                </div>

                <!-- Imagen del Equipo -->
                <div class="mt-6">
                    <label for="ruta_imagen" class="form-label">
                        Cambiar Imagen del Equipo (Opcional)
                    </label>
                    
                    @if ($equipo->ruta_imagen)
                        <div class="my-4">
                            <p class="current-image-label">Imagen Actual:</p>
                            <img src="{{ asset('storage/' . $equipo->ruta_imagen) }}" alt="Imagen actual del equipo" class="current-image">
                        </div>
                    @else
                        <div class="no-image-placeholder">
                            <p>
                                <svg stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                No hay imagen cargada. Puedes subir una para personalizar tu equipo.
                            </p>
                        </div>
                    @endif

                    <input type="file" name="ruta_imagen" id="ruta_imagen" accept="image/jpeg,image/png,image/jpg,image/gif" class="neuro-file">
                    <p class="help-text">Formatos permitidos: JPG, PNG, GIF. Tamaño máximo: 2MB.</p>
                </div>

                <!-- Botones de Acción -->
                <div class="action-buttons">
                    <a href="{{ route('estudiante.equipo.index') }}" class="btn-cancel">
                        Cancelar
                    </a>
                    <button type="submit" class="btn-submit">
                        Actualizar Equipo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection