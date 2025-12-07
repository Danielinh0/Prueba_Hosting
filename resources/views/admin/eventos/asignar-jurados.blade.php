@extends('layouts.app')

@section('content')


<div class="asignar-jurados-page py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('admin.eventos.show', $evento) }}" class="back-link">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Regresar al Evento
    </a>
        <div class="flex items-center justify-between mb-6">
            <h2 class="font-semibold text-xl ml-2">
                Asignar Jurados a: {{ $evento->nombre }}
            </h2>
            <div class="counter-card">
                <h3>Jurados Asignados:</h3>
                <span class="count">{{ count($juradosAsignadosIds) }}/5</span>
            </div>
        </div>
        
        <!-- Filtro de Búsqueda -->
        <div class="filter-card">
            <form action="{{ route('admin.eventos.asignar', $evento) }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="md:col-span-3">
                        <input type="text" name="search" placeholder="Buscar por nombre, apellido o email..." value="{{ $search ?? '' }}" class="neuro-input block w-full">
                    </div>
                    <div class="flex items-center space-x-2">
                        <button type="submit" class="neuro-button-primary w-full">Buscar</button>
                        <a href="{{ route('admin.eventos.asignar', $evento) }}" class="neuro-button-secondary text-center">Limpiar</a>
                    </div>
                </div>
            </form>
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
                    <p class="font-bold">¡Ups!</p>
                    <ul class="mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.eventos.actualizar_asignacion', $evento) }}" method="POST">
                @csrf
                @method('PATCH')

                <p class="instruction-text">Selecciona los jurados para este evento (mínimo 3, máximo 5).</p>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse ($juradosDisponibles as $jurado)
                        <label class="checkbox-card flex items-center space-x-3">
                            <input type="checkbox" name="jurados[]" value="{{ $jurado->id_usuario }}" 
                                {{ in_array($jurado->id_usuario, $juradosAsignadosIds) ? 'checked' : '' }}>
                            <div>
                                <span>
                                    {{ $jurado->user->nombre }} {{ $jurado->user->app_paterno }}
                                </span>
                                <p style="font-size: 0.75rem; color: #6b6b6b; margin: 0;">{{ $jurado->user->email }}</p>
                            </div>
                        </label>
                    @empty
                        <p class="empty-state">No hay jurados disponibles en el sistema.</p>
                    @endforelse
                </div>
                
                <!-- Paginación -->
                @if($juradosDisponibles->hasPages())
                <div class="pagination-container">
                    {{ $juradosDisponibles->links() }}
                </div>
                @endif

                <div class="flex items-center justify-end mt-6">
                    <button type="submit" class="submit-button">
                        Guardar Asignación
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection