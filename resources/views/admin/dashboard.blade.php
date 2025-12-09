@extends('layouts.app')

@section('content')


<div class="admin-dashboard-page py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold" style="color: var(--admin-text-primary);">Panel de Administración</h2>
            <p style="color: var(--admin-text-muted); font-size: 0.9rem;">Bienvenido al centro de control del sistema</p>
        </div>
        
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
            <div class="stat-card stat-blue flex items-center justify-between">
                <div>
                    <h4>Estudiantes Activos</h4>
                    <p>{{ $totalEstudiantesActivos }}</p>
                </div>
                <svg class="w-10 h-10 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>

            <div class="stat-card stat-purple flex items-center justify-between">
                <div>
                    <h4>Eventos en Curso</h4>
                    <p>{{ $eventosEnCursoCount }}</p>
                </div>
                <svg class="w-10 h-10 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>

            <div class="stat-card stat-green flex items-center justify-between">
                <div>
                    <h4>Equipos Registrados</h4>
                    <p>{{ $equiposRegistradosCount }}</p>
                </div>
                <svg class="w-10 h-10 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>

            <div class="stat-card stat-orange flex items-center justify-between">
                <div>
                    <h4>Jurados Registrados</h4>
                    <p>{{ $juradosAsignadosCount }}</p>
                </div>
                <svg class="w-10 h-10 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
            </div>
        </div>

        <!-- Acciones Rápidas -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold mb-4" style="color: var(--admin-text-primary);">Acciones Rápidas</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('admin.eventos.create') }}" class="quick-action-card border-indigo flex flex-col items-center justify-center py-5">
                    <svg class="w-8 h-8 mb-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    <span>Crear Evento</span>
                </a>
                <a href="{{ route('admin.users.index') }}" class="quick-action-card border-green flex flex-col items-center justify-center py-5">
                    <svg class="w-8 h-8 mb-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                    <span>Gestionar Usuarios</span>
                </a>
                <a href="{{ route('admin.equipos.index') }}" class="quick-action-card border-purple flex flex-col items-center justify-center py-5">
                    <svg class="w-8 h-8 mb-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span>Ver Equipos</span>
                </a>
            </div>
        </div>

        <!-- Eventos que Requieren Atención -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold mb-4 flex items-center gap-2" style="color: var(--admin-text-primary);">
                <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                Eventos que Requieren Atención
            </h3>
            <div class="warning-box">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Eventos por Iniciar -->
                    <div>
                        <h4>Próximos a Iniciar</h4>
                        <ul class="space-y-2">
                            @forelse($eventosPorIniciar as $evento)
                                <li><a href="{{ route('admin.eventos.show', $evento) }}">{{ $evento->nombre }} <span class="text-xs">({{ $evento->fecha_inicio->diffForHumans() }})</span></a></li>
                            @empty
                                <li class="empty-text">No hay eventos iniciando pronto.</li>
                            @endforelse
                        </ul>
                    </div>
                    <!-- Eventos sin Jurados -->
                    <div>
                        <h4>Activos sin Jurados</h4>
                        <ul class="space-y-2">
                            @forelse($eventosSinJurados as $evento)
                                <li><a href="{{ route('admin.eventos.show', $evento) }}">{{ $evento->nombre }}</a></li>
                            @empty
                                <li class="empty-text">Todos los eventos activos tienen jurados.</li>
                            @endforelse
                        </ul>
                    </div>
                    <!-- Eventos con Equipos Incompletos -->
                    <div>
                        <h4>Con Equipos Incompletos</h4>
                        <ul class="space-y-2">
                            @forelse($eventosConEquiposIncompletos as $evento)
                                <li><a href="{{ route('admin.eventos.show', $evento) }}">{{ $evento->nombre }} <span class="font-bold">({{ $evento->inscripciones_count }})</span></a></li>
                            @empty
                                <li class="empty-text">No hay equipos incompletos en eventos activos.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tablas de Eventos -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-8">
            <!-- Eventos Activos -->
            <div>
                <div class="eventos-section-title">
                    <div class="icon-wrapper green">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    Eventos Activos
                </div>
                <div class="eventos-table-container">
                    <div class="eventos-table-wrapper">
                        <table class="eventos-table">
                            <thead>
                                <tr>
                                    <th>Evento</th>
                                    <th>Fechas</th>
                                    <th>Estado</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($eventosActivos as $evento)
                                    <tr>
                                        <td>
                                            <div class="evento-name-cell">
                                                <div class="evento-icon active">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                </div>
                                                <span class="evento-name-text">{{ $evento->nombre }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="evento-date-icon">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                <span class="evento-date-text">{{ $evento->fecha_inicio->format('d/m') }} - {{ $evento->fecha_fin->format('d/m/Y') }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="status-badge status-activo">Activo</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.eventos.show', $evento) }}" class="action-btn">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                Ver
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">
                                            <div class="empty-state">
                                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                <p>No hay eventos activos</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Eventos Próximos -->
            <div>
                <div class="eventos-section-title">
                    <div class="icon-wrapper blue">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    Eventos Próximos
                </div>
                <div class="eventos-table-container">
                    <div class="eventos-table-wrapper">
                        <table class="eventos-table">
                            <thead>
                                <tr>
                                    <th>Evento</th>
                                    <th>Inicia</th>
                                    <th>Estado</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($eventosProximos as $evento)
                                    <tr>
                                        <td>
                                            <div class="evento-name-cell">
                                                <div class="evento-icon upcoming">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                </div>
                                                <span class="evento-name-text">{{ $evento->nombre }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="evento-date-icon">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                <span class="evento-date-text">{{ $evento->fecha_inicio->format('d/m/Y') }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="status-badge status-proximo">Próximo</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.eventos.show', $evento) }}" class="action-btn">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                Ver
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">
                                            <div class="empty-state">
                                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                <p>No hay eventos próximos programados</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection