@extends('layouts.app')

@section('content')

<div class="equipo-form-page-eqc">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('estudiante.eventos.show', $evento) }}" class="back-link-eqc">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver al Evento
            </a>
        <div class="header-container-eqc">
            @isset($evento)
            @endisset
            <h2>
                @isset($equipo)
                    Editar Equipo
                @else
                    Inscribir Nuevo Equipo para: {{ $evento->nombre }}
                @endisset
            </h2>
        </div>
        
        <div class="main-card-eqc">
            @if (session('error'))
                <div class="alert-error-eqc" role="alert">
                    <p class="font-bold">Error</p>
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert-error-eqc" role="alert">
                    <p class="font-bold">¡Ups! Hubo algunos problemas.</p>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ isset($equipo) ? route('estudiante.equipo.update') : route('estudiante.eventos.equipos.store', $evento) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @isset($equipo)
                    @method('PUT')
                @endisset

                <!-- Nombre del Equipo -->
                <div class="form-section-eqc">
                    <label for="nombre" class="form-label-eqc">Nombre del Equipo</label>
                    <input type="text" name="nombre" id="nombre" class="neuro-input-eqc" value="{{ old('nombre', $equipo->nombre ?? '') }}" required autofocus>
                </div>

                <!-- Descripción del Equipo -->
                <div class="form-section-eqc">
                    <label for="descripcion" class="form-label-eqc">Descripción del Equipo (Opcional)</label>
                    <textarea name="descripcion" id="descripcion" rows="4" class="neuro-textarea-eqc" placeholder="Describe tu equipo, proyecto o lo que buscan lograr...">{{ old('descripcion', $equipo->descripcion ?? '') }}</textarea>
                    <span class="help-text-eqc">Máximo 1000 caracteres. Esta descripción ayudará a otros estudiantes a conocer tu equipo.</span>
                </div>

                <!-- Imagen del Equipo -->
                <div class="form-section-eqc">
                    <label for="ruta_imagen" class="form-label-eqc">
                        @isset($equipo)
                            Cambiar Imagen del Equipo (Opcional)
                        @else
                            Imagen del Equipo (Opcional)
                        @endisset
                    </label>
                    
                    @isset($equipo)
                        @if ($equipo->ruta_imagen)
                            <div class="current-image-section-eqc">
                                <span class="current-image-label-eqc">Imagen Actual:</span>
                                <div class="current-image-wrapper-eqc">
                                    <img src="{{ asset('storage/' . $equipo->ruta_imagen) }}" alt="Imagen actual del equipo" class="current-image-eqc">
                                </div>
                            </div>
                        @endif
                    @endisset

                    <div class="file-input-wrapper-eqc">
                        <label for="ruta_imagen" class="file-input-label-eqc">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Seleccionar Imagen
                        </label>
                        <input type="file" name="ruta_imagen" id="ruta_imagen" class="neuro-file-eqc" accept="image/*" onchange="displayFileName(this)">
                        <div id="file-name-display" class="file-name-display-eqc"></div>
                    </div>
                </div>

                <!-- Botón de Envío -->
                <div class="button-container-eqc">
                    <button type="submit" class="btn-submit-eqc">
                        @isset($equipo)
                            Actualizar Equipo
                        @else
                            Crear e Inscribir Equipo
                        @endisset
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
            fileDisplay.textContent = '📁 ' + input.files[0].name;
            fileDisplay.classList.add('show-eqc');
        } else {
            fileDisplay.textContent = '';
            fileDisplay.classList.remove('show-eqc');
        }
    }
</script>


@endsection