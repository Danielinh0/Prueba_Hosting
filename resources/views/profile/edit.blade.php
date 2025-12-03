@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-amber-50 to-orange-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Encabezado -->
        <div class="mb-12 text-center">
            <p class="text-gray-600 text-lg">Gestiona tu información personal y configuraciones</p>
        </div>

        <!-- Información básica del usuario -->
        <div class="neuromorphic-card mb-8">
            <div class="p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-6 h-6 text-orange-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Información Personal
                </h2>
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <!-- Información específica por rol -->
        @if($user->esEstudiante() && $user->estudiante)
        <div class="neuromorphic-card mb-8">
            <div class="p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Información de Estudiante
                </h2>
                @include('profile.partials.update-student-information-form')
            </div>
        </div>
        @endif

        @if($user->jurado)
        <div class="neuromorphic-card mb-8">
            <div class="p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-6 h-6 text-orange-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    Información de Jurado
                </h2>
                @include('profile.partials.update-jury-information-form')
            </div>
        </div>
        @endif

        <!-- Cambio de contraseña -->
        <div class="neuromorphic-card mb-8">
            <div class="p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-6 h-6 text-orange-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                    </svg>
                    Seguridad
                </h2>
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <!-- Eliminar cuenta -->
        <div class="neuromorphic-card bg-gradient-to-r from-red-50 to-orange-50 border-l-4 border-red-500 eliminar-cuenta">
            <div class="p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-6 h-6 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Zona de Peligro
                </h2>
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</div>

<style>
    .neuromorphic-card {
        background: linear-gradient(145deg, #FFEEE2, #f0f0f0);
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .neuromorphic-card:hover {
        box-shadow: 25px 25px 50px rgba(232, 154, 60, 0.15),
                    -25px -25px 50px rgba(255, 255, 255, 0.9);
        transform: translateY(-2px);
    }
    
    .neuromorphic-input {
        background: linear-gradient(145deg, #FFEEE2, #f8f8f8);
        border-radius: 12px;
        box-shadow: inset 4px 4px 8px rgba(236, 169, 87, 0.1),
                    inset -4px -4px 8px rgba(255, 255, 255, 0.8);
        border: 1px solid rgba(251, 184, 103, 0.2);
        transition: all 0.3s ease;
        padding: 0.75rem 1rem;
    }
    
    .neuromorphic-input:focus {
        outline: none;
        box-shadow: inset 6px 6px 12px rgba(232, 154, 60, 0.15),
                    inset -6px -6px 12px rgba(255, 255, 255, 0.9),
                    0 0 0 3px rgba(232, 154, 60, 0.1);
        border-color: rgba(253, 184, 100, 0.4);
    }
    
    .neuromorphic-button {
        background: linear-gradient(145deg, #febb68ff, #d59342ff);
        border-radius: 12px;
        box-shadow: 8px 8px 16px rgba(232, 154, 60, 0.3),
                    -8px -8px 16px rgba(255, 220, 180, 0.4);
        color: white;
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    .neuromorphic-button:hover {
        background: linear-gradient(145deg, #e89a3c, #f5a847);
        box-shadow: 12px 12px 24px rgba(232, 154, 60, 0.4),
                    -12px -12px 24px rgba(255, 220, 180, 0.5);
        transform: translateY(-2px);
    }
    
    .neuromorphic-button:active {
        box-shadow: inset 4px 4px 8px rgba(200, 130, 50, 0.3),
                    inset -4px -4px 8px rgba(255, 200, 150, 0.4);
        transform: translateY(1px);
    }
    
    .neuromorphic-danger-button {
        background: linear-gradient(145deg, #ef4444, #dc2626);
        box-shadow: 8px 8px 16px rgba(239, 68, 68, 0.3),
                    -8px -8px 16px rgba(255, 180, 180, 0.4);
    }
    
    .neuromorphic-danger-button:hover {
        background: linear-gradient(145deg, #dc2626, #ef4444);
        box-shadow: 12px 12px 24px rgba(239, 68, 68, 0.4),
                    -12px -12px 24px rgba(255, 180, 180, 0.5);
    }
    
    .profile-photo-container {
        position: relative;
        display: inline-block;
    }
    
    .profile-photo {
        width: 160px;
        height: 160px;
        border-radius: 50%;
        object-fit: cover;
        border: 6px solid white;
        box-shadow: 8px 8px 20px rgba(232, 154, 60, 0.3),
                    -8px -8px 20px rgba(255, 255, 255, 0.8);
    }

    .photo-upload-button {
        position: absolute;
        bottom: 10px;
        right: 10px;
        background: linear-gradient(145deg, #f5a847, #e89a3c);
        color: white;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 4px 4px 8px rgba(200, 130, 50, 0.3);
        transition: all 0.3s ease;
        border: none;
    }

    .photo-upload-button:hover {
        transform: scale(1.1);
        box-shadow: 6px 6px 12px rgba(200, 130, 50, 0.4);
    }

    .status-badge {
        background: linear-gradient(145deg, #10b981, #059669);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        box-shadow: 4px 4px 8px rgba(16, 185, 129, 0.2);
    }

    .status-badge.bg-blue-500 {
        background: linear-gradient(145deg, #3b82f6, #1d4ed8);
    }
    
    /* Animaciones */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .neuromorphic-card {
        animation: fadeIn 0.5s ease-out forwards;
    }
    
    .neuromorphic-card:nth-child(2) { animation-delay: 0.1s; }
    .neuromorphic-card:nth-child(3) { animation-delay: 0.2s; }
    .neuromorphic-card:nth-child(4) { animation-delay: 0.3s; }
    .neuromorphic-card:nth-child(5) { animation-delay: 0.4s; }

    .profile-photo-container {
    position: relative;
    display: inline-block;
    }

</style>
@endsection