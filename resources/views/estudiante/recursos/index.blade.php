@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
    
    
    /* Fondo degradado */
    .recursos-page {
        background: linear-gradient(to bottom, #FFFDF4, #FFEEE2);
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
    }
    
    /* Textos */
    .recursos-page h2,
    .recursos-page h3,
    .recursos-page h4 {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
    }
    
    .recursos-page p {
        font-family: 'Poppins', sans-serif;
        color: #6b6b6b;
    }
    
    .recursos-page a {
        font-family: 'Poppins', sans-serif;
        transition: all 0.2s ease;
    }
    
    .recursos-page a:hover {
        opacity: 0.8;
    }
    
    /* Cards neuromórficas */
    .neuro-card {
        background: #FFEEE2;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
        transition: all 0.3s ease;
    }
    
    .neuro-card:hover {
        box-shadow: 10px 10px 20px #e6d5c9, -10px -10px 20px #ffffff;
    }
    
    /* Inputs y selects neuromórficos */
    .neuro-input,
    .neuro-select,
    .neuro-textarea {
        font-family: 'Poppins', sans-serif;
        background: rgba(255, 255, 255, 0.5);
        border: none;
        box-shadow: inset 4px 4px 8px #e6d5c9, inset -4px -4px 8px #ffffff;
        transition: all 0.2s ease;
        backdrop-filter: blur(10px);
    }
    
    .neuro-input:focus,
    .neuro-select:focus,
    .neuro-textarea:focus {
        outline: none;
        box-shadow: inset 6px 6px 12px #e6d5c9, inset -6px -6px 12px #ffffff;
    }
    
    /* Labels */
    .neuro-label {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
        font-size: 0.875rem;
        font-weight: 500;
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
    
    /* Recursos items */
    .recurso-item {
        background: rgba(255, 255, 255, 0.5);
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }
    
    .recurso-item:hover {
        box-shadow: 6px 6px 12px #e6d5c9, -6px -6px 12px #ffffff;
        transform: translateY(-3px);
    }
    
    .recurso-item h4 {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
        font-weight: 600;
    }
    
    .recurso-item p {
        font-family: 'Poppins', sans-serif;
        color: #6b6b6b;
    }
    
    .recurso-item a {
        font-family: 'Poppins', sans-serif;
        color: #e89a3c;
        font-weight: 600;
    }
    
    /* Botón delete */
    .delete-button {
        color: #ef4444;
        transition: all 0.2s ease;
    }
    
    .delete-button:hover {
        color: #dc2626;
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
        margin-top: 1rem;
        color: #6b6b6b;
    }

    /* Hero Section Negro */
    .hero-section {
        background: linear-gradient(135deg, #0e0e0eff 0%, #434343ff 50%, #1d1d1dff 100%);
        border-radius: 24px;
        padding: 2.5rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: 8px 8px 16px rgba(200, 200, 200, 0.4), -8px -8px 16px rgba(255, 255, 255, 0.9);
    }

    .hero-content {
        position: relative;
        z-index: 1;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .hero-text h1 {
        color: #c1c1c1ff;
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
    }

    .hero-text h1 span {
        color: #e89a3c;
    }

    .hero-text p {
        color: #cfcfcfff;
        font-size: 1rem;
    }

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
    
</style>

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