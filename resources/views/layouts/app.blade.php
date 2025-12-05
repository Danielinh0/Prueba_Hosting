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

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
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
            <main class="pt-24">
                @yield('content')
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
    </body>
</html>
