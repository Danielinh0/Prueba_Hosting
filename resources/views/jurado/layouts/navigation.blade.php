<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
    
    /* Header naranja */
    .header-neuro {
        background: linear-gradient(135deg, #e89a3c, #f5a847);
        box-shadow: 0 4px 12px rgba(232, 154, 60, 0.3);
        font-family: 'Poppins', sans-serif;
        position: relative;
        z-index: 40;
    }
    
    /* Hamburger button */
    .hamburger-button {
        background: rgba(255, 253, 244, 0.9);
        border-radius: 15px;
        padding: 0.75rem;
        box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.15), -2px -2px 6px rgba(255, 255, 255, 0.7);
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }
    
    .hamburger-button:hover {
        box-shadow: 6px 6px 12px rgba(0, 0, 0, 0.2), -3px -3px 8px rgba(255, 255, 255, 0.8);
        transform: scale(1.05);
    }
    
    .hamburger-button svg {
        color: #e89a3c;
    }
    
    /* Logo en header */
    .header-logo {
        height: 3.5rem;
        width: auto;
    }
    
    /* Page title en header */
    .page-title {
        font-family: 'Poppins', sans-serif;
        color: #ffffff;
        font-size: 1.5rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
    }
    
    /* Sidebar overlay */
    .sidebar-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
        z-index: 50;
        transition: opacity 0.3s ease;
    }
    
    .sidebar-overlay.hidden {
        opacity: 0;
        pointer-events: none;
    }
    
    /* Sidebar */
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        width: 20rem;
        background: linear-gradient(180deg, #f5a847 0%, #ea9c4a 20%, #e89a3c 50%, #ea9c4a 80%, #f5a847 100%);
        box-shadow: 4px 0 20px rgba(0, 0, 0, 0.3);
        z-index: 51;
        transform: translateX(-100%);
        transition: transform 0.3s ease;
        overflow-y: auto;
        font-family: 'Poppins', sans-serif;
    }
    
    .sidebar.open {
        transform: translateX(0);
    }
    
    /* Sidebar header */
    .sidebar-header {
        padding: 2rem 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .sidebar-logo {
        height: 4rem;
        width: auto;
        filter: drop-shadow(2px 2px 4px rgba(0, 0, 0, 0.2));
    }
    
    .sidebar-close {
        background: rgba(255, 253, 244, 0.9);
        border-radius: 12px;
        padding: 0.5rem;
        box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }
    
    .sidebar-close:hover {
        box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.2);
        transform: rotate(90deg);
    }
    
    .sidebar-close svg {
        color: #e89a3c;
    }
    
    /* Sidebar menu */
    .sidebar-menu {
        padding: 1rem 0;
    }
    
    /* Menu item */
    .menu-item {
        display: flex;
        align-items: center;
        padding: 1rem 1.5rem;
        color: #000000;
        font-weight: 600;
        font-size: 1.25rem;
        transition: all 0.3s ease;
        text-decoration: none;
        border-left: 4px solid transparent;
        margin: 0.25rem 0;
    }
    
    .menu-item:hover {
        background: rgba(255, 253, 244, 0.3);
        border-left-color: #ffffff;
    }
    
    .menu-item.active {
        background: rgba(255, 253, 244, 0.5);
        border-left-color: #ffffff;
        box-shadow: inset 2px 2px 6px rgba(0, 0, 0, 0.1);
    }
    
    .menu-item svg {
        width: 2rem;
        height: 2rem;
        margin-right: 1rem;
    }
    
    /* Logout button */
    .logout-button {
        position: absolute;
        bottom: 2rem;
        left: 1.5rem;
        right: 1.5rem;
        background: rgba(255, 253, 244, 0.9);
        border-radius: 15px;
        padding: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 1.125rem;
        color: #000000;
        box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }
    
    .logout-button:hover {
        box-shadow: 6px 6px 12px rgba(0, 0, 0, 0.2);
        transform: translateY(-2px);
    }
    
    .logout-button svg {
        margin-right: 0.5rem;
    }
    
    /* User info en dropdown (mantener para desktop) */
    .dropdown-button-neuro {
        font-family: 'Poppins', sans-serif;
        background: rgba(255, 253, 244, 0.9);
        border: none;
        border-radius: 25px;
        padding: 0.5rem 1rem;
        color: #2c2c2c;
        box-shadow: 4px 4px 8px rgba(200, 130, 50, 0.4), -2px -2px 6px rgba(255, 200, 150, 0.6);
        transition: all 0.3s ease;
    }
    
    .dropdown-button-neuro:hover {
        box-shadow: 6px 6px 12px rgba(200, 130, 50, 0.5), -3px -3px 8px rgba(255, 200, 150, 0.7);
        color: #2c2c2c;
        transform: translateY(-1px);
    }
    
    .dropdown-button-neuro img {
        border: 2px solid #ffffff;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }
    
    /* Dropdown menu - glassmorphism */
    .dropdown-menu-neuro {
        background: rgba(255, 255, 255, 0.7);
        border-radius: 15px;
        box-shadow: 8px 8px 16px rgba(230, 213, 201, 0.4), -8px -8px 16px rgba(255, 255, 255, 0.4);
        border: 1px solid rgba(255, 255, 255, 0.3);
        margin-top: 0.5rem;
        overflow: hidden;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }
    
    .dropdown-item-neuro {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
        padding: 0.75rem 1rem;
        transition: all 0.2s ease;
    }
    
    .dropdown-item-neuro:hover {
        background: rgba(232, 154, 60, 0.1);
        color: #e89a3c;
    }
</style>

<nav x-data="{ sidebarOpen: false }" class="header-neuro border-b border-gray-100">
    <!-- Header Principal -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <!-- Hamburger Button + Logo -->
            <div class="flex items-center space-x-4">
                <button @click="sidebarOpen = true" class="hamburger-button">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                
                <x-application-logo class="header-logo" />
            </div>

            <!-- Page Title (Center) - Dinámico según la ruta -->
            <div class="hidden sm:block">
                <h1 class="page-title">
                    @if(request()->routeIs('jurado.dashboard'))
                        INICIO
                    @elseif(request()->routeIs('jurado.eventos.*'))
                        EVENTOS
                    @elseif(request()->routeIs('jurado.equipos.*'))
                        EQUIPOS
                    @elseif(request()->routeIs('jurado.evaluaciones.*'))
                        EVALUACIONES
                    @elseif(request()->routeIs('jurado.acuses.*'))
                        ACUSES
                    @elseif(request()->routeIs('jurado.constancias.*'))
                        CONSTANCIAS
                    @elseif(request()->routeIs('profile.*'))
                        PERFIL
                    @else
                        PANEL JURADO
                    @endif
                </h1>
            </div>

            <!-- User Dropdown (Desktop only) -->
            <div class="hidden sm:flex sm:items-center">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="dropdown-button-neuro inline-flex items-center">
                            <img src="{{ Auth::user()->foto_perfil_url }}" 
                                 alt="{{ Auth::user()->nombre }}" 
                                 class="w-8 h-8 rounded-full object-cover me-2">
                            <div class="font-medium">{{ Auth::user()->nombre }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="dropdown-menu-neuro">
                            <x-dropdown-link :href="route('profile.edit')" class="dropdown-item-neuro">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();" 
                                        class="dropdown-item-neuro">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" 
         :class="{ 'hidden': !sidebarOpen }"
         @click="sidebarOpen = false"
         x-show="sidebarOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
    </div>

    <!-- Sidebar -->
    <div class="sidebar" 
         :class="{ 'open': sidebarOpen }"
         x-show="sidebarOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="transform -translate-x-full"
         x-transition:enter-end="transform translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="transform translate-x-0"
         x-transition:leave-end="transform -translate-x-full">
        
        <!-- Sidebar Header -->
        <div class="sidebar-header">
            <x-application-logo class="sidebar-logo" />
            <button @click="sidebarOpen = false" class="sidebar-close">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Menu Items -->
        <div class="sidebar-menu">
            <a href="{{ route('jurado.dashboard') }}" class="menu-item {{ request()->routeIs('jurado.dashboard') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Inicio
            </a>

            <a href="{{ route('jurado.eventos.index') }}" class="menu-item {{ request()->routeIs('jurado.eventos.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Eventos
            </a>

            <a href="{{ route('jurado.equipos.index') }}" class="menu-item {{ request()->routeIs('jurado.equipos.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                Equipos
            </a>

            <a href="{{ route('jurado.constancias.index') }}" class="menu-item {{ request()->routeIs('jurado.constancias.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Constancias
            </a>

            <a href="{{ route('profile.edit') }}" class="menu-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Mi Perfil
            </a>
        </div>

        <!-- Logout Button -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-button" onclick="return confirm('¿Cerrar sesión?');">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Cerrar Sesión
            </button>
        </form>
    </div>
</nav>