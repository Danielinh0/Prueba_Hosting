<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
    
    /* Navbar neuromórfico */
    .navbar-neuro {
        background: #FFEEE2;
        border-bottom: none;
        box-shadow: 0 4px 12px #e6d5c9, 0 -2px 8px #ffffff;
        font-family: 'Poppins', sans-serif;
    }
    
    /* Logo y links */
    .nav-link-neuro {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
        font-weight: 500;
        transition: all 0.2s ease;
        border-bottom: 2px solid transparent;
        padding-bottom: 0.25rem;
    }
    
    .nav-link-neuro:hover {
        color: #e89a3c;
        border-bottom-color: #e89a3c;
    }
    
    .nav-link-neuro.active {
        color: #e89a3c;
        border-bottom-color: #e89a3c;
        font-weight: 600;
    }
    
    /* Dropdown button */
    .dropdown-button-neuro {
        font-family: 'Poppins', sans-serif;
        background: #FFEEE2;
        border: none;
        border-radius: 25px;
        padding: 0.5rem 1rem;
        color: #2c2c2c;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        transition: all 0.3s ease;
    }
    
    .dropdown-button-neuro:hover {
        box-shadow: 6px 6px 12px #e6d5c9, -6px -6px 12px #ffffff;
        color: #e89a3c;
    }
    
    .dropdown-button-neuro img {
        border: 2px solid #e89a3c;
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
    
    /* Hamburger menu */
    .hamburger-neuro {
        background: rgba(255, 255, 255, 0.5);
        border-radius: 10px;
        padding: 0.5rem;
        color: #2c2c2c;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        transition: all 0.2s ease;
    }
    
    .hamburger-neuro:hover {
        color: #e89a3c;
        box-shadow: 6px 6px 12px #e6d5c9, -6px -6px 12px #ffffff;
    }
    
    /* Responsive menu */
    .responsive-menu-neuro {
        background: #FFEEE2;
        border-top: 1px solid rgba(232, 154, 60, 0.2);
    }
    
    .responsive-link-neuro {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
        padding: 0.75rem 1rem;
        transition: all 0.2s ease;
        border-left: 3px solid transparent;
    }
    
    .responsive-link-neuro:hover {
        background: rgba(232, 154, 60, 0.1);
        color: #e89a3c;
        border-left-color: #e89a3c;
    }
    
    .responsive-link-neuro.active {
        background: rgba(232, 154, 60, 0.1);
        color: #e89a3c;
        border-left-color: #e89a3c;
        font-weight: 600;
    }
    
    /* User info responsive */
    .user-info-responsive {
        border-top: 1px solid rgba(232, 154, 60, 0.2);
        background: rgba(255, 255, 255, 0.3);
    }
    
    .user-info-responsive img {
        border: 2px solid #e89a3c;
    }
    
    .user-name {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
        font-weight: 600;
    }
    
    .user-email {
        font-family: 'Poppins', sans-serif;
        color: #6b6b6b;
    }
</style>

<nav x-data="{ open: false }" class="navbar-neuro border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-100" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="nav-link-neuro {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    @if(Auth::user()->rolSistema->nombre === 'admin')
                        <x-nav-link :href="route('admin.eventos.index')" :active="request()->routeIs('admin.eventos.*')" class="nav-link-neuro {{ request()->routeIs('admin.eventos.*') ? 'active' : '' }}">
                            {{ __('Gestión de Eventos') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')" class="nav-link-neuro {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            {{ __('Usuarios') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.equipos.index')" :active="request()->routeIs('admin.equipos.*')" class="nav-link-neuro {{ request()->routeIs('admin.equipos.*') ? 'active' : '' }}">
                            {{ __('Equipos') }}
                        </x-nav-link>
                    @elseif(Auth::user()->rolSistema->nombre === 'estudiante')
                        <x-nav-link :href="route('estudiante.dashboard')" :active="request()->routeIs('estudiante.dashboard')" class="nav-link-neuro {{ request()->routeIs('estudiante.dashboard') ? 'active' : '' }}">
                            {{ __('Inicio') }}
                        </x-nav-link>
                        <x-nav-link :href="route('estudiante.stats.dashboard')" :active="request()->routeIs('estudiante.stats.*')" class="nav-link-neuro {{ request()->routeIs('estudiante.stats.*') ? 'active' : '' }}">
                            {{ __('Mi Progreso') }}
                        </x-nav-link>
                
                        <x-nav-link :href="route('estudiante.habilidades.index')" :active="request()->routeIs('estudiante.habilidades.*')" class="nav-link-neuro {{ request()->routeIs('estudiante.habilidades.*') ? 'active' : '' }}">
                            {{ __('Mis Habilidades') }}
                        </x-nav-link>
                        
                        <x-nav-link :href="route('estudiante.eventos.index')" :active="request()->routeIs('estudiante.eventos.*')" class="nav-link-neuro {{ request()->routeIs('estudiante.eventos.*') ? 'active' : '' }}">
                            {{ __('Eventos') }}
                        </x-nav-link>
                        
                        <x-nav-link :href="route('estudiante.equipo.index')" :active="request()->routeIs('estudiante.equipo.*')" class="nav-link-neuro {{ request()->routeIs('estudiante.equipo.*') ? 'active' : '' }}">
                            {{ __('Mi Equipo') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="dropdown-button-neuro inline-flex items-center">
                            <!-- Foto de Perfil -->
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

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();" class="dropdown-item-neuro">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="hamburger-neuro inline-flex items-center justify-center">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden responsive-menu-neuro">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="responsive-link-neuro {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            
            @if(Auth::user()->rolSistema->nombre === 'admin')
                <x-responsive-nav-link :href="route('admin.eventos.index')" :active="request()->routeIs('admin.eventos.*')" class="responsive-link-neuro {{ request()->routeIs('admin.eventos.*') ? 'active' : '' }}">
                    {{ __('Gestión de Eventos') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')" class="responsive-link-neuro {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    {{ __('Usuarios') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.equipos.index')" :active="request()->routeIs('admin.equipos.*')" class="responsive-link-neuro {{ request()->routeIs('admin.equipos.*') ? 'active' : '' }}">
                    {{ __('Equipos') }}
                </x-responsive-nav-link>
            @elseif(Auth::user()->rolSistema->nombre === 'estudiante')
                <x-responsive-nav-link :href="route('estudiante.eventos.index')" :active="request()->routeIs('estudiante.eventos.*')" class="responsive-link-neuro {{ request()->routeIs('estudiante.eventos.*') ? 'active' : '' }}">
                    {{ __('Eventos') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('estudiante.equipo.index')" :active="request()->routeIs('estudiante.equipo.*')" class="responsive-link-neuro {{ request()->routeIs('estudiante.equipo.*') ? 'active' : '' }}">
                    {{ __('Mi Equipo') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="user-info-responsive pt-4 pb-1">
            <div class="px-4 flex items-center space-x-3">
                <!-- Foto de Perfil -->
                <img src="{{ Auth::user()->foto_perfil_url }}" 
                     alt="{{ Auth::user()->nombre }}" 
                     class="w-10 h-10 rounded-full object-cover">
                
                <div>
                    <div class="user-name text-base">{{ Auth::user()->nombre }}</div>
                    <div class="user-email text-sm">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="responsive-link-neuro">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();" class="responsive-link-neuro">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>