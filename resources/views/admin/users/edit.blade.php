@extends('layouts.app')

@section('content')

<div class="user-edit-page py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('admin.users.index') }}" class="back-link">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver a Usuarios
            </a>
        <div class="flex items-center mb-6">
            <h2 class="font-semibold text-xl ml-2">
                Editar Usuario: {{ $user->nombre }}
            </h2>
        </div>
        
        <div class="main-card">
            @if (session('success'))
                <div class="alert-success" role="alert">
                    <p class="font-bold">Éxito</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert-error" role="alert">
                    <p class="font-bold">¡Ups! Hubo algunos problemas con tus datos.</p>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PATCH')

                <h3 class="section-header">Datos Personales</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="nombre" class="form-label">Nombre(s)</label>
                        <input type="text" name="nombre" id="nombre" class="neuro-input" value="{{ old('nombre', $user->nombre) }}" required>
                    </div>
                    <div>
                        <label for="app_paterno" class="form-label">Apellido Paterno</label>
                        <input type="text" name="app_paterno" id="app_paterno" class="neuro-input" value="{{ old('app_paterno', $user->app_paterno) }}" required>
                    </div>
                    <div>
                        <label for="app_materno" class="form-label">Apellido Materno</label>
                        <input type="text" name="app_materno" id="app_materno" class="neuro-input" value="{{ old('app_materno', $user->app_materno) }}">
                    </div>
                    <div>
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" name="email" id="email" class="neuro-input" value="{{ old('email', $user->email) }}" required>
                    </div>
                </div>

                <h3 class="section-header">Rol del Sistema</h3>
                <div>
                    <label for="id_rol_sistema" class="form-label">Rol</label>
                    <select name="id_rol_sistema" id="id_rol_sistema" class="neuro-select">
                        @foreach($roles as $rol)
                            <option value="{{ $rol->id_rol_sistema }}" {{ $user->id_rol_sistema == $rol->id_rol_sistema ? 'selected' : '' }}>
                                {{ ucfirst($rol->nombre) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                @if($user->estudiante)
                    <h3 class="section-header">Datos de Estudiante</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="numero_control" class="form-label">Número de Control</label>
                            <input type="text" name="numero_control" id="numero_control" class="neuro-input" value="{{ old('numero_control', $user->estudiante->numero_control) }}">
                        </div>
                        <div>
                            <label for="semestre" class="form-label">Semestre</label>
                            <input type="number" name="semestre" id="semestre" class="neuro-input" value="{{ old('semestre', $user->estudiante->semestre) }}">
                        </div>
                        <div>
                            <label for="carrera" class="form-label">Carrera</label>
                            <input type="text" id="carrera" class="neuro-input" value="{{ $user->estudiante->carrera->nombre ?? 'N/A' }}" readonly>
                        </div>
                    </div>
                @elseif($user->jurado)
                     <h3 class="section-header">Datos de Jurado</h3>
                     <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="especialidad" class="form-label">Especialidad</label>
                            <input type="text" name="especialidad" id="especialidad" class="neuro-input" value="{{ old('especialidad', $user->jurado->especialidad) }}">
                        </div>
                     </div>
                @endif

                <div class="flex items-center justify-end mt-8">
                    <button type="submit" class="submit-button">
                        Actualizar Usuario
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection