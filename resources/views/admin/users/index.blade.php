@extends('layouts.app')

@section('content')

<div class="users-page py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('dashboard') }}" class="back-link">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver al Dashboard
        </a>
        <!-- Hero Section -->
        <div class="hero-section">
            <h1 class="hero-title">Gestión de Usuarios</h1>
            <p class="hero-subtitle">Administra los usuarios del sistema: administradores, jurados y estudiantes</p>
        </div>

        <!-- Contadores -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="counter-card">
                <h3>Administradores</h3>
                <p>{{ $totalAdmins }}</p>
            </div>
            <div class="counter-card">
                <h3>Jurados</h3>
                <p>{{ $totalJurados }}</p>
            </div>
            <div class="counter-card">
                <h3>Estudiantes</h3>
                <p>{{ $totalEstudiantes }}</p>
            </div>
        </div>

        <!-- Filtros y Búsqueda -->
        <div class="filter-card mb-8">
            <form action="{{ route('admin.users.index') }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="md:col-span-2">
                        <input type="text" name="search" placeholder="Buscar por nombre, apellido o email..." value="{{ request('search') }}" class="neuro-input block w-full rounded-md">
                    </div>
                    <div>
                        <select name="rol" class="neuro-select block w-full rounded-md">
                            <option value="">Todos los roles</option>
                            @foreach($roles as $rol)
                                <option value="{{ $rol->id_rol_sistema }}" {{ request('rol') == $rol->id_rol_sistema ? 'selected' : '' }}>
                                    {{ ucfirst($rol->nombre) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button type="submit" class="neuro-button-primary w-full justify-center px-4 py-2 rounded-md">Filtrar</button>
                        <a href="{{ route('admin.users.index') }}" class="neuro-button-secondary w-full text-center px-4 py-2 rounded-md">Limpiar</a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Tabla de Usuarios -->
        <div class="table-container">
            <div class="overflow-x-auto">
                <table class="neuro-table">
                    <thead>
                        <tr>
                            <th scope="col">Nombre</th>
                            <th scope="col">Email</th>
                            <th scope="col">Rol</th>
                            <th scope="col"><span class="sr-only">Editar</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($usuarios as $usuario)
                            <tr>
                                <td>
                                    <a href="{{ route('perfil.show', $usuario) }}" class="user-name" style="text-decoration: none; cursor: pointer;">
                                        {{ $usuario->nombre }} {{ $usuario->app_paterno }}
                                    </a>
                                </td>
                                <td class="user-email">{{ $usuario->email }}</td>
                                <td>
                                    <span class="role-badge 
                                        @if($usuario->rolSistema->nombre == 'admin') role-admin
                                        @elseif($usuario->rolSistema->nombre == 'jurado') role-jurado
                                        @else role-estudiante @endif">
                                        {{ ucfirst($usuario->rolSistema->nombre) }}
                                    </span>
                                </td>
                                <td class="text-right">
                                    <a href="{{ route('admin.users.edit', $usuario) }}" class="edit-link">Editar</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="empty-state">
                                    No se encontraron usuarios con los criterios seleccionados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="pagination-container">
                {{ $usuarios->appends(request()->query())->links() }}
            </div>
        </div>

    </div>
</div>
@endsection