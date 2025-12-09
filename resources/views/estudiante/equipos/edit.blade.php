@extends('layouts.app')

@section('content')

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