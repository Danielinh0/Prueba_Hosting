@extends('layouts.app')

@section('content')


<div class="recursos-page py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <a href="{{ route('estudiante.equipo.show-detalle', $equipo) }}" class="back-link">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver a {{ $equipo->nombre }}
        </a>
        <a href="{{ route('estudiante.dashboard') }}" class="back-link">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver al Dashboard
        </a>
        <!-- Hero Section -->
        <div class="hero-section">
            <div class="hero-content">
                <div class="hero-text">
                    <h1>Recursos de <span>{{ $equipo->nombre }}</span></h1>
                    <p>Biblioteca de recursos compartidos del equipo.</p>
                </div>
            </div>
        </div>

        <!-- Formulario para Agregar Recurso -->
        <div class="neuro-card rounded-lg p-6 mb-8">
            <h3 class="text-lg font-semibold mb-4">Compartir Nuevo Recurso</h3>
            
            <form action="{{ route('estudiante.recursos.store', $equipo) }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @csrf
                
                <div class="md:col-span-2">
                    <label class="neuro-label block mb-2">Nombre del Recurso</label>
                    <input type="text" name="nombre" required class="neuro-input w-full rounded-md" placeholder="Ej: Documentación de la API">
                </div>
                
                <div>
                    <label class="neuro-label block mb-2">Tipo</label>
                    <select name="tipo" required class="neuro-select w-full rounded-md">
                        <option value="link">🔗 Link</option>
                        <option value="documento">📄 Documento</option>
                        <option value="video">🎥 Video</option>
                        <option value="imagen">🖼️ Imagen</option>
                        <option value="otro">📎 Otro</option>
                    </select>
                </div>
                
                <div>
                    <label class="neuro-label block mb-2">URL</label>
                    <input type="url" name="url" required class="neuro-input w-full rounded-md" placeholder="https://...">
                </div>
                
                <div class="md:col-span-2">
                    <label class="neuro-label block mb-2">Descripción (Opcional)</label>
                    <textarea name="descripcion" rows="2" class="neuro-textarea w-full rounded-md" placeholder="Breve descripción del recurso"></textarea>
                </div>
                
                <div class="md:col-span-2">
                    <button type="submit" class="neuro-button px-6 py-2 rounded-md">
                        Compartir Recurso
                    </button>
                </div>
            </form>
        </div>

        <!-- Lista de Recursos -->
        <div class="neuro-card rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-6">Recursos Compartidos ({{ $recursos->count() }})</h3>
            
            @if($recursos->isEmpty())
                <div class="empty-state">
                    <svg class="h-16 w-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                    <p class="mt-4">Aún no hay recursos compartidos</p>
                    <p class="text-sm">Comparte links, documentos y más con tu equipo</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($recursos as $recurso)
                        <div class="recurso-item rounded-lg p-4">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center space-x-3">
                                    <span class="text-2xl">{{ $recurso->icono }}</span>
                                    <div>
                                        <h4 class="line-clamp-1">{{ $recurso->nombre }}</h4>
                                        <p class="text-xs">{{ $recurso->tipo }}</p>
                                    </div>
                                </div>
                                
                                <form action="{{ route('estudiante.recursos.destroy', $recurso) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-button" onclick="return confirm('¿Eliminar este recurso?')">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                            
                            @if($recurso->descripcion)
                                <p class="text-sm mb-3 line-clamp-2">{{ $recurso->descripcion }}</p>
                            @endif
                            
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <img src="{{ $recurso->subidoPor->foto_perfil_url }}" alt="{{ $recurso->subidoPor->nombre }}" class="w-6 h-6 rounded-full">
                                    <p class="text-xs">{{ $recurso->subidoPor->nombre }}</p>
                                </div>
                                
                                <a href="{{ $recurso->url }}" target="_blank" class="text-sm font-semibold">
                                    Abrir →
                                </a>
                            </div>
                            
                            <p class="text-xs mt-2" style="color: #9ca3af;">{{ $recurso->created_at->diffForHumans() }}</p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection