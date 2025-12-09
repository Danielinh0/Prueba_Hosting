<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- Scripts -->
        @vite([
            'resources/css/app.css',
            'resources/css/admin/dashboard.css',
            'resources/css/admin/users/index.css',
            'resources/css/admin/users/edit.css',
            'resources/css/admin/proyectos-evaluaciones/index.css',
            'resources/css/admin/proyectos-evaluaciones/show.css',
            'resources/css/admin/proyectos-evento/edit.css',
            'resources/css/admin/proyectos-evento/asignar.css',
            'resources/css/admin/proyectos-evento/create-individual.css',
            'resources/css/admin/proyectos-evento/create.css',
            'resources/css/admin/eventos/index.css',
            'resources/css/admin/eventos/show.css',
            'resources/css/admin/eventos/asignar-jurados.css',
            'resources/css/admin/eventos/create.css',
            'resources/css/admin/eventos/edit.css',
            'resources/css/admin/eventos/resultados.css',
            'resources/css/admin/equipos/index.css',
            'resources/css/admin/equipos/show.css',
            'resources/css/admin/equipos/edit.css',
            'resources/css/admin/equipos/create.css',
            'resources/css/estudiante/dashboard.css',
            'resources/css/estudiante/tarea/index-especific.css',
            'resources/css/estudiante/stats/dashboard.css',
            'resources/css/estudiante/recursos/index.css',
            'resources/css/navigation.css',
            'resources/css/estudiante/proyecto-evento/show.css',
            'resources/css/estudiante/proyecto/tareas.css',
            'resources/css/estudiante/proyecto/show.css',
            'resources/css/estudiante/proyecto/show-especific.css',
            'resources/css/estudiante/proyecto/index.css',
            'resources/css/estudiante/proyecto/form.css',
            'resources/css/estudiante/proyecto/edit-specific.css',
            'resources/css/estudiante/proyecto/create-from-evento.css',
            'resources/css/estudiante/proyecto/avances/create.css',
            'resources/css/estudiante/proyecto/avances/index.css',
            'resources/css/estudiante/eventos/show.css',
            'resources/css/estudiante/eventos/posiciones.css',
            'resources/css/estudiante/eventos/index.css',
            'resources/css/estudiante/equipos/show.css',
            'resources/css/estudiante/equipos/select-existente.css',
            'resources/css/estudiante/equipos/preview.css',
            'resources/css/estudiante/equipos/index.css',
            'resources/css/estudiante/equipos/edit.css',
            'resources/css/estudiante/equipos/create.css',
            'resources/css/estudiante/equipos/create-sin-evento.css',
            'resources/css/estudiante/equipo/show.css',
            'resources/css/estudiante/equipo/index.css',
            'resources/css/estudiante/constancias/index.css',
            'resources/css/estudiante/avance/index-specific.css',
            'resources/css/estudiante/avance/create-specific.css',
            'resources/css/estudiante/actividades/index.css',
            'resources/js/app.js'])

        <!-- Alpine.js -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <!-- Custom Styles Stack -->
        @stack('styles')
    </head>
    <style>
        :root {
            --primary-color: #e89a3c;
            --primary-dark: #d98a2c;
            --secondary-color: #8b5cf6;
            --accent-color: #ec4899;
            --bg-base: #FFFDF4;
            --bg-secondary: #FFEEE2;
            --card-bg: #FFEEE2;
            --text-primary: #2c2c2c;
            --text-secondary: #6b6b6b;
            --shadow-light: #ffffff;
            --shadow-dark: #e6d5c9;
        }

        body {
            background: linear-gradient(to bottom, var(--bg-base), var(--bg-secondary)) !important;
            font-family: 'Figtree', sans-serif;
            min-height: 100vh;
        }

        .dashboard-container {
            display: grid;
            grid-template-columns: 400px 1fr;
            gap: 1.5rem;
            max-width: 1400px;
            margin: 0 auto;
            padding: 0;
        }

        @media (max-width: 1024px) {
            .dashboard-container {
                grid-template-columns: 1fr;
            }
        }

        .section-title {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        /* Neumorphic Card Style */
        .neu-card {
            background: var(--card-bg);
            border-radius: 16px;
            padding: 1rem;
            box-shadow: 6px 6px 12px var(--shadow-dark), -6px -6px 12px var(--shadow-light);
            transition: all 0.3s ease;
        }

        .neu-card:hover {
            box-shadow: 8px 8px 16px var(--shadow-dark), -8px -8px 16px var(--shadow-light);
            transform: translateY(-2px);
        }

        /* Event Cards */
        .event-card-container {
            margin-bottom: 1.25rem;
        }

        .event-card-header {
            background: linear-gradient(135deg, #2c2c2c, #1a1a1a);
            color: white;
            padding: 0.75rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 0.75rem;
        }

        .event-card-body {
            padding: 0.375rem;
        }

        .event-desc {
            color: var(--text-secondary);
            margin-bottom: 0.375rem;
            font-size: 0.8rem;
        }

        .event-date {
            color: var(--text-primary);
            font-weight: 600;
            margin-bottom: 0.375rem;
            font-size: 0.75rem;
        }

        .event-participants {
            color: var(--text-secondary);
            font-size: 0.75rem;
        }

        /* Progress Card */
        .progress-main-card {
            margin-bottom: 2rem;
            position: relative;
        }

        .progress-info-items {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }

        .info-item {
            background: rgba(255, 255, 255, 0.3);
            color: var(--text-primary);
            padding: 0.75rem 1rem;
            border-radius: 12px;
            font-weight: 500;
            font-size: 0.95rem;
            box-shadow: inset 4px 4px 8px var(--shadow-dark), inset -4px -4px 8px var(--shadow-light);
        }

        .progress-circle-container {
            position: relative;
            width: 150px;
            height: 150px;
            margin: 0 auto;
        }

        .progress-ring {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: conic-gradient(
                var(--primary-color) 0%,
                var(--primary-color) 50%,
                rgba(255, 255, 255, 0.3) 50%,
                rgba(255, 255, 255, 0.3) 100%
            );
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 4px 4px 8px var(--shadow-dark), -4px -4px 8px var(--shadow-light);
        }

        .progress-ring::before {
            content: '';
            width: 110px;
            height: 110px;
            background: var(--card-bg);
            border-radius: 50%;
            position: absolute;
        }

        .progress-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            z-index: 10;
        }

        .progress-text span {
            display: block;
            color: var(--text-secondary);
            font-size: 0.9rem;
            margin-bottom: 0.25rem;
        }

        .progress-text strong {
            font-size: 2rem;
            color: var(--primary-color);
            font-weight: 700;
        }

        /* Small Cards Grid */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
        }

        .small-card {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.875rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .small-card:hover {
            transform: translateY(-2px);
        }

        .card-icon-box {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            color: white;
            flex-shrink: 0;
            box-shadow: 3px 3px 6px var(--shadow-dark), -3px -3px 6px var(--shadow-light);
        }

        .icon-athena {
            background: linear-gradient(135deg, #6366f1, #4f46e5);
        }

        .icon-const {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        }

        .icon-projects {
            background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        }

        .icon-teams {
            background: linear-gradient(135deg, #10b981, #059669);
        }

        .card-content-box h4 {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
        }

        .card-content-box p {
            font-size: 0.75rem;
            color: var(--text-secondary);
        }

        /* Left and Right Columns */
        .left-col, .right-col {
            display: flex;
            flex-direction: column;
        }

        /* Contenedor principal sin fondo gris */
        .main-wrapper {
            min-height: 100vh;
            background: transparent;
        }
    </style>

    <body class="font-sans antialiased">
        <div class="min-h-screen" style="background: linear-gradient(to bottom, #FFFDF4, #FFEEE2);">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

             <!-- Page Content -->
    <main class="pt-24 @yield('main-class', '')">
        @hasSection('with-container')
            {{-- Vista con container --}}
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="dashboard-container">
                    @yield('content')
                </div>
            </div>
        @else
            {{-- Vista de ancho completo (por defecto) --}}
            @yield('content')
        @endif
    </main>
        </div>


        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Vista previa de foto de perfil
                const fotoInput = document.getElementById('foto_perfil');
                const profileImage = document.querySelector('img[alt="Profile photo"]');
                
                if (fotoInput && profileImage) {
                    fotoInput.addEventListener('change', function(e) {
                        if (this.files && this.files[0]) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                profileImage.src = e.target.result;
                            }
                            reader.readAsDataURL(this.files[0]);
                        }
                    });
                }
                
                // Validación de contraseña en tiempo real
                const passwordInput = document.getElementById('update_password_password');
                const confirmPasswordInput = document.getElementById('update_password_password_confirmation');
                
                if (passwordInput && confirmPasswordInput) {
                    function validatePasswords() {
                        if (passwordInput.value !== confirmPasswordInput.value) {
                            confirmPasswordInput.classList.add('border-red-500');
                        } else {
                            confirmPasswordInput.classList.remove('border-red-500');
                        }
                    }
                    
                    passwordInput.addEventListener('input', validatePasswords);
                    confirmPasswordInput.addEventListener('input', validatePasswords);
                }
            });
        </script>
        
        <!-- Custom Scripts Stack -->
        @stack('scripts')
    </body>
</html>
