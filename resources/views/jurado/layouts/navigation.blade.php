<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
    
    /* Header naranja */
    .header-neuro {
        background: linear-gradient(135deg, #e89a3c, #f5a847);
        box-shadow: 0 4px 12px rgba(232, 154, 60, 0.3);
        font-family: 'Poppins', sans-serif;
        position: relative;
        z-index: 40;
        padding: 15px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    /* Hamburger button */
    .hamburger-button {
        background: rgba(255, 253, 244, 0.9);
        border-radius: 12px;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
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
        color: #333;
        width: 24px;
        height: 24px;
    }
    
    /* Page title en header */
    .page-title {
        font-family: 'Poppins', sans-serif;
        color: #ffffff;
        font-size: 1.5rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
    }
    
    /* Logo en header */
    .header-logo img {
        height: 60px;
        width: 60px;
        object-fit: contain;
        filter: drop-shadow(2px 2px 4px rgba(0, 0, 0, 0.2));
    }
    
    /* Sidebar overlay */
    .sidebar-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
        z-index: 50;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s ease;
    }
    
    .sidebar-overlay.active {
        opacity: 1;
        pointer-events: all;
    }
    
    /* Sidebar */
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100%;
        width: 17.5%;
        min-width: 280px;
        background: linear-gradient(180deg, #f5a847 0%, #ea9c4a 20%, #e89a3c 50%, #ea9c4a 80%, #f5a847 100%);
        box-shadow: 4px 0 20px rgba(0, 0, 0, 0.3);
        z-index: 51;
        transform: translateX(-100%);
        transition: transform 0.3s ease-in-out;
        display: flex;
        flex-direction: column;
        padding: 20px;
        font-family: 'Poppins', sans-serif;
        overflow-y: auto;
    }
    
    .sidebar.active {
        transform: translateX(0);
    }
    
    /* Sidebar header */
    .sidebar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 40px;
    }
    
    .sidebar-logo {
        height: 60px;
        width: 60px;
        object-fit: contain;
        filter: drop-shadow(2px 2px 4px rgba(0, 0, 0, 0.2));
    }
    
    .sidebar-close {
        background: rgba(255, 253, 244, 0.9);
        border-radius: 12px;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
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
        color: #333;
        width: 24px;
        height: 24px;
    }
    
    /* Menu items */
    .menu-items {
        display: flex;
        flex-direction: column;
        gap: 20px;
        flex-grow: 1;
    }
    
    .menu-item {
        display: flex;
        align-items: center;
        padding: 15px 20px;
        color: #000000;
        text-decoration: none;
        font-size: 1.2rem;
        font-weight: 600;
        border-radius: 0;
        transition: background-color 0.2s;
        border-left: 4px solid transparent;
    }
    
    .menu-item:hover,
    .menu-item.active {
        background-color: rgba(255, 255, 255, 0.33);
        border-left-color: #ffffff;
    }
    
    .menu-item svg {
        margin-right: 15px;
        width: 24px;
        height: 24px;
    }
    
    /* Logout container */
    .logout-container {
        margin-top: auto;
        padding-top: 20px;
    }
    
    .logout-btn {
        background: rgba(252, 252, 252, 0.95);
        color: #000000;
        width: 100%;
        padding: 15px;
        border-radius: 15px;
        border: none;
        font-size: 1.1rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        text-decoration: none;
        box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease;
    }
    
    .logout-btn:hover {
        box-shadow: 6px 6px 12px rgba(0, 0, 0, 0.2);
        transform: translateY(-2px);
    }
    
    .logout-btn svg {
        margin-right: 10px;
        width: 24px;
        height: 24px;
    }
</style>

<!-- Header Visible -->
<div class="header-neuro">
    <button class="hamburger-button" onclick="toggleMenu()">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
            <path fill-rule="evenodd" d="M2.25 4.5A.75.75 0 0 1 3 3.75h14.25a.75.75 0 0 1 0 1.5H3a.75.75 0 0 1-.75-.75Zm0 4.5A.75.75 0 0 1 3 8.25h9.75a.75.75 0 0 1 0 1.5H3A.75.75 0 0 1 2.25 9Zm15-.75A.75.75 0 0 1 18 9v10.19l2.47-2.47a.75.75 0 1 1 1.06 1.06l-3.75 3.75a.75.75 0 0 1-1.06 0l-3.75-3.75a.75.75 0 1 1 1.06-1.06l2.47 2.47V9a.75.75 0 0 1 .75-.75Zm-15 5.25a.75.75 0 0 1 .75-.75h9.75a.75.75 0 0 1 0 1.5H3a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd" />
        </svg>
    </button>
    <div class="page-title">Inicio</div>
    <div class="header-logo">
        <img src="{{ asset('images/logito.png') }}" alt="Logo">
    </div>
</div>

<!-- Sidebar Overlay -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleMenu()"></div>

<!-- Menú Desplegable -->
<div class="sidebar" id="mobileMenu">
    <div class="sidebar-header">
        <div class="header-logo">
            <img src="{{ asset('images/logito.png') }}" alt="Logo" class="sidebar-logo">
        </div>
        <button class="sidebar-close" onclick="toggleMenu()">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
            </svg>
        </button>
    </div>

    <div class="menu-items">
        <a href="{{ route('jurado.dashboard') }}" class="menu-item {{ request()->routeIs('jurado.dashboard') ? 'active' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path d="M11.584 2.376a.75.75 0 0 1 .832 0l9 6a.75.75 0 1 1-.832 1.248L12 3.901 3.416 9.624a.75.75 0 0 1-.832-1.248l9-6Z" />
                <path fill-rule="evenodd" d="M20.25 10.332v9.918H21a.75.75 0 0 1 0 1.5H3a.75.75 0 0 1 0-1.5h.75v-9.918a.75.75 0 0 1 .634-.74A49.109 49.109 0 0 1 12 9c2.59 0 5.134.202 7.616.592a.75.75 0 0 1 .634.74Zm-7.5 2.418a.75.75 0 0 0-1.5 0v6.75a.75.75 0 0 0 1.5 0v-6.75Zm3-.75a.75.75 0 0 1 .75.75v6.75a.75.75 0 0 1-1.5 0v-6.75a.75.75 0 0 1 .75-.75ZM9 12.75a.75.75 0 0 0-1.5 0v6.75a.75.75 0 0 0 1.5 0v-6.75Z" clip-rule="evenodd" />
                <path d="M12 7.875a1.125 1.125 0 1 0 0-2.25 1.125 1.125 0 0 0 0 2.25Z" />
            </svg>
            Inicio
        </a>
        <a href="{{ route('jurado.proyectos.index') }}" class="menu-item {{ request()->routeIs('jurado.proyectos.*') ? 'active' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0016.5 9h-1.875a1.875 1.875 0 01-1.875-1.875V5.25A3.75 3.75 0 009 1.5H5.625zM7.5 15a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5A.75.75 0 017.5 15zm.75 2.25a.75.75 0 000 1.5H12a.75.75 0 000-1.5H8.25z" clip-rule="evenodd" />
                <path d="M12.971 1.816A5.23 5.23 0 0114.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 013.434 1.279 9.768 9.768 0 00-3.234-1.279 7.5 7.5 0 00-7.5-7.5c-1.43 0-2.796.402-3.957 1.088a9.768 9.768 0 012.957-1.088z" />
            </svg>
            Proyectos
        </a>
        <a href="{{ route('jurado.eventos.index') }}" class="menu-item {{ request()->routeIs('jurado.eventos.*') ? 'active' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3A.75.75 0 0 1 18 3v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z" clip-rule="evenodd" />
            </svg>
            Eventos
        </a>
        <a href="{{ route('jurado.acuses.index') }}" class="menu-item {{ request()->routeIs('jurado.acuses.*') ? 'active' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path d="M11.7 2.805a.75.75 0 0 1 .6 0A60.65 60.65 0 0 1 22.83 8.72a.75.75 0 0 1-.231 1.337 49.948 49.948 0 0 0-9.902 3.912l-.003.002c-.114.06-.227.119-.34.18a.75.75 0 0 1-.707 0A50.88 50.88 0 0 0 7.5 12.173v-.224c0-.131.067-.248.172-.311a54.615 54.615 0 0 1 4.653-2.52.75.75 0 0 0-.65-1.352 56.123 56.123 0 0 0-4.78 2.589 1.858 1.858 0 0 0-.859 1.228 49.803 49.803 0 0 0-4.634-1.527.75.75 0 0 1-.231-1.337A60.653 60.653 0 0 1 11.7 2.805Z" />
                <path d="M13.06 15.473a48.45 48.45 0 0 1 7.666-3.282c.134 1.414.22 2.843.255 4.284a.75.75 0 0 1-.46.711 47.87 47.87 0 0 0-8.105 4.342.75.75 0 0 1-.832 0 47.87 47.87 0 0 0-8.104-4.342.75.75 0 0 1-.461-.71c.035-1.442.121-2.87.255-4.286.921.304 1.83.634 2.726.99v1.27a1.5 1.5 0 0 0-.14 2.508c-.09.38-.222.753-.397 1.11.452.213.901.434 1.346.66a6.727 6.727 0 0 0 .551-1.607 1.5 1.5 0 0 0 .14-2.67v-.645a48.549 48.549 0 0 1 3.44 1.667 2.25 2.25 0 0 0 2.12 0Z" />
                <path d="M4.462 19.462c.42-.419.753-.89 1-1.395.453.214.902.435 1.347.662a6.742 6.742 0 0 1-1.286 1.794.75.75 0 0 1-1.06-1.06Z" />
            </svg>
            Acuses
        </a>
    </div>

    <div class="logout-container">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.5 3.75a1.5 1.5 0 0 1 1.5 1.5v13.5a1.5 1.5 0 0 1-1.5 1.5h-6a1.5 1.5 0 0 1-1.5-1.5V15a.75.75 0 0 0-1.5 0v3.75a3 3 0 0 0 3 3h6a3 3 0 0 0 3-3V5.25a3 3 0 0 0-3-3h-6a3 3 0 0 0-3 3V9A.75.75 0 1 0 9 9V5.25a1.5 1.5 0 0 1 1.5-1.5h6ZM5.78 8.47a.75.75 0 0 0-1.06 0l-3 3a.75.75 0 0 0 0 1.06l3 3a.75.75 0 0 0 1.06-1.06l-1.72-1.72H15a.75.75 0 0 0 0-1.5H4.06l1.72-1.72a.75.75 0 0 0 0-1.06Z" clip-rule="evenodd" />
                </svg>
                Cerrar Sesión
            </button>
        </form>
    </div>
</div>

<script>
    function toggleMenu() {
        const menu = document.getElementById('mobileMenu');
        const overlay = document.getElementById('sidebarOverlay');
        menu.classList.toggle('active');
        overlay.classList.toggle('active');
    }
</script>