@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
    
    /* Fondo degradado */
    .habilidades-page {
        background: linear-gradient(to bottom, #FFFDF4, #FFEEE2);
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
    }
    
    /* Textos */
    .habilidades-page h2,
    .habilidades-page h3,
    .habilidades-page h4 {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
    }
    
    .habilidades-page p,
    .habilidades-page label {
        font-family: 'Poppins', sans-serif;
        color: #6b6b6b;
    }
    
    /* Cards neuromórficas */
    .neuro-card {
        background: #FFEEE2;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
    }
    
    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 3rem 0;
    }
    
    .empty-state svg {
        margin: 0 auto;
        color: #6b6b6b;
    }
    
    .empty-state p {
        font-family: 'Poppins', sans-serif;
        color: #6b6b6b;
    }
    
    /* Habilidad item */
    .habilidad-item {
        background: rgba(255, 255, 255, 0.5);
        border: 1px solid transparent;
        border-radius: 15px;
        padding: 1rem;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }
    
    .habilidad-item:hover {
        box-shadow: 6px 6px 12px #e6d5c9, -6px -6px 12px #ffffff;
        border-color: #e89a3c;
    }
    
    .habilidad-item h4 {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
        font-weight: 600;
    }
    
    .habilidad-item p {
        font-family: 'Poppins', sans-serif;
        color: #6b6b6b;
        font-size: 0.875rem;
    }
    
    /* Avatar habilidad */
    .habilidad-avatar {
        width: 3rem;
        height: 3rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        font-weight: 700;
        box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.15);
    }
    
    /* Selects neuromórficos */
    .neuro-select {
        font-family: 'Poppins', sans-serif;
        background: rgba(255, 255, 255, 0.5);
        border: none;
        box-shadow: inset 4px 4px 8px #e6d5c9, inset -4px -4px 8px #ffffff;
        transition: all 0.2s ease;
        backdrop-filter: blur(10px);
        color: #2c2c2c;
        font-size: 0.875rem;
    }
    
    .neuro-select:focus {
        outline: none;
        box-shadow: inset 6px 6px 12px #e6d5c9, inset -6px -6px 12px #ffffff;
    }
    
    /* Delete button */
    .delete-button {
        color: #ef4444;
        background: none;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .delete-button:hover {
        color: #dc2626;
        transform: scale(1.1);
    }
    
    /* Form labels */
    .form-label {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
        font-size: 0.875rem;
        font-weight: 500;
    }
    
    /* Radio buttons container */
    .radio-group {
        background: rgba(255, 255, 255, 0.3);
        border-radius: 12px;
        padding: 1rem;
        box-shadow: inset 2px 2px 4px #e6d5c9, inset -2px -2px 4px #ffffff;
    }
    
    .radio-label {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
        font-size: 0.875rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .radio-label:hover {
        color: #e89a3c;
    }
    
    /* Botón principal */
    .neuro-button {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #e89a3c, #f5a847);
        color: #ffffff;
        font-weight: 600;
        box-shadow: 4px 4px 8px rgba(232, 154, 60, 0.3);
        transition: all 0.3s ease;
        border: none;
    }
    
    .neuro-button:hover {
        box-shadow: 6px 6px 12px rgba(232, 154, 60, 0.4);
        transform: translateY(-2px);
    }
    
    /* Sticky sidebar */
    .sticky-sidebar {
        position: sticky;
        top: 1.5rem;
    }
</style>

<div class="habilidades-page py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold">Mis Habilidades</h2>
            <p class="mt-2">Gestiona tu perfil de habilidades técnicas</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Mis Habilidades -->
            <div class="lg:col-span-2">
                <div class="neuro-card rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-6">Mis Habilidades</h3>
                    
                    @if($misHabilidades->isEmpty())
                        <div class="empty-state">
                            <svg class="h-16 w-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p class="mt-4">Aún no has agregado habilidades a tu perfil</p>
                            <p class="text-sm">Agrega tus habilidades para que los equipos te encuentren</p>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($misHabilidades as $habilidad)
                                <div class="habilidad-item flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <div class="habilidad-avatar" style="background-color: {{ $habilidad->color }};">
                                            {{ strtoupper(substr($habilidad->nombre, 0, 2)) }}
                                        </div>
                                        <div>
                                            <h4>{{ $habilidad->nombre }}</h4>
                                            <p>{{ $habilidad->categoria }}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center space-x-3">
                                        <!-- Selector de Nivel -->
                                        <form action="{{ route('estudiante.habilidades.update', $habilidad->id_habilidad) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <select name="nivel" onchange="this.form.submit()" class="neuro-select rounded-md">
                                                <option value="Básico" {{ $habilidad->pivot->nivel == 'Básico' ? 'selected' : '' }}>Básico</option>
                                                <option value="Intermedio" {{ $habilidad->pivot->nivel == 'Intermedio' ? 'selected' : '' }}>Intermedio</option>
                                                <option value="Avanzado" {{ $habilidad->pivot->nivel == 'Avanzado' ? 'selected' : '' }}>Avanzado</option>
                                                <option value="Experto" {{ $habilidad->pivot->nivel == 'Experto' ? 'selected' : '' }}>Experto</option>
                                            </select>
                                        </form>
                                        
                                        <!-- Eliminar -->
                                        <form action="{{ route('estudiante.habilidades.destroy', $habilidad->id_habilidad) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="delete-button" onclick="return confirm('¿Eliminar esta habilidad?')">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Agregar Habilidad -->
            <div>
                <div class="neuro-card rounded-lg p-6 sticky-sidebar">
                    <h3 class="text-lg font-semibold mb-4">Agregar Habilidad</h3>
                    
                    <form action="{{ route('estudiante.habilidades.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="form-label block mb-2">Selecciona una habilidad</label>
                            <select name="id_habilidad" required class="neuro-select w-full rounded-md">
                                <option value="">-- Selecciona --</option>
                                @foreach($habilidadesDisponibles as $categoria => $habilidades)
                                    <optgroup label="{{ $categoria }}">
                                        @foreach($habilidades as $habilidad)
                                            <option value="{{ $habilidad->id_habilidad }}">{{ $habilidad->nombre }}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-6">
                            <label class="form-label block mb-2">Nivel de dominio</label>
                            <div class="radio-group space-y-2">
                                @foreach(['Básico', 'Intermedio', 'Avanzado', 'Experto'] as $nivel)
                                    <label class="radio-label flex items-center">
                                        <input type="radio" name="nivel" value="{{ $nivel }}" {{ $loop->first ? 'checked' : '' }} class="text-indigo-600 focus:ring-indigo-500">
                                        <span class="ml-2">{{ $nivel }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        
                        <button type="submit" class="neuro-button w-full px-4 py-2 rounded-md">
                            Agregar Habilidad
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection