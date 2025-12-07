@extends('layouts.app')

@section('content')


<div class="equipo-show-page py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if($equipo->inscripciones->first() && $equipo->inscripciones->first()->evento)
                <a href="{{ route('admin.equipos.index') }}" class="back-link">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Volver al Equipos
                </a>
            @endif
        <div class="flex items-center mb-6">
            <h2 class="font-semibold text-xl ml-2">
                Gestión de Equipo: {{ $equipo->nombre }}
            </h2>
        </div>
        
        <div class="main-card">
            <!-- Detalles del Equipo -->
            <div class="team-header">
                @if ($equipo->ruta_imagen)
                    <img class="team-image" src="{{ asset('storage/' . $equipo->ruta_imagen) }}" alt="Imagen del equipo">
                @else
                    <div class="team-placeholder">
                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                @endif
                <div>
                    <h1 class="team-name">{{ $equipo->nombre }}</h1>
                    @if($inscripcion = $equipo->inscripciones->first())
                        @if($inscripcion->evento)
                            <p class="text-sm mt-2" style="color: #6b6b6b;">
                                Inscrito en: 
                                <a href="{{ route('admin.eventos.show', $inscripcion->evento) }}" class="team-evento-link">
                                    {{ $inscripcion->evento->nombre }}
                                </a>
                            </p>
                        @else
                            <p class="text-sm mt-2" style="color: #9ca3af;">
                                Este equipo no está inscrito en ningún evento actualmente.
                            </p>
                        @endif
                    @else
                        <p class="text-sm mt-2" style="color: #9ca3af;">
                            Este equipo no tiene inscripciones.
                        </p>
                    @endif
                </div>
            </div>

            <!-- Lista de Miembros -->
            <div class="members-section">
                <h3>
                    Miembros del Equipo ({{ $equipo->miembros->count() }}/5)
                </h3>
                <div class="member-list">
                    <ul>
                        @forelse($equipo->miembros as $miembro)
                            <li class="member-item">
                                <div class="flex items-center space-x-4">
                                    <div>
                                        <p class="member-name">{{ $miembro->user->nombre_completo }}</p>
                                        <p class="member-carrera">{{ optional($miembro->user->estudiante)->carrera->nombre ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="member-controls">
                                    <!-- Formulario para Cambiar Rol -->
                                    <form action="{{ route('admin.miembros.update-role', $miembro) }}" method="POST" class="flex items-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <select name="id_rol_equipo" class="role-select">
                                            @foreach($roles as $rol)
                                                <option value="{{ $rol->id_rol_equipo }}" @if($rol->id_rol_equipo == $miembro->id_rol_equipo) selected @endif>
                                                    {{ $rol->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="btn-update">Cambiar</button>
                                    </form>
                                    
                                    @if($miembro->es_lider)
                                        <span class="badge badge-lider">Líder</span>
                                    @else
                                        <!-- Botón para hacer Líder -->
                                        <form action="{{ route('admin.miembros.toggle-leader', $miembro) }}" method="POST" onsubmit="return confirm('¿Hacer a este miembro el nuevo líder del equipo?');">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn-make-leader">👑 Hacer Líder</button>
                                        </form>
                                    @endif
                                    
                                    <!-- Botón para Eliminar Miembro -->
                                    <form action="{{ route('admin.miembros.destroy', $miembro) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar a este miembro del equipo?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-remove">Quitar</button>
                                    </form>
                                </div>
                            </li>
                        @empty
                            <li class="empty-state">Este equipo no tiene miembros.</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <!-- Acciones de Administrador -->
            <div class="actions-section">
                <h3>Acciones de Administrador</h3>
                <div class="mt-4 flex flex-wrap gap-3">
                    <a href="{{ route('admin.equipos.edit', $equipo) }}" class="btn-edit">
                        Editar Equipo
                    </a>
                    
                    @if($inscripcion = $equipo->inscripciones->first())
                        <!-- Botón para Excluir del Evento (sin eliminar equipo) -->
                        <form action="{{ route('admin.equipos.remove-from-event', $equipo) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres excluir este equipo del evento? El equipo NO se eliminará, solo se quitará su inscripción a este evento.');">
                            @csrf
                            <input type="hidden" name="evento_id" value="{{ $inscripcion->id_evento }}">
                            <button type="submit" class="btn-exclude">
                                Excluir del Evento
                            </button>
                        </form>
                    @endif
                    
                    <!-- Botón para Eliminar Equipo Completamente (cascada) -->
                    <form action="{{ route('admin.equipos.destroy', $equipo) }}" method="POST" onsubmit="return confirm('¡Acción irreversible! ¿Estás seguro de que quieres eliminar este equipo por completo? Se eliminará la inscripción y todos sus miembros quedarán libres.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete-team">
                            Eliminar Equipo Completamente
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection