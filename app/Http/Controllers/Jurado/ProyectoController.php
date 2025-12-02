<?php

namespace App\Http\Controllers\Jurado;

use App\Http\Controllers\Controller;
use App\Models\Evento;
use App\Models\ProyectoEvento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProyectoController extends Controller
{
    /**
     * Mostrar lista de proyectos de los eventos asignados al jurado
     */
    public function index()
    {
        $user = Auth::user();
        $jurado = $user->jurado;

        if (!$jurado) {
            return redirect()->route('jurado.dashboard')
                ->with('error', 'No tienes acceso como jurado.');
        }

        // Obtener eventos en progreso asignados al jurado
        $eventosEnProgreso = $jurado->eventos()
            ->where('estado', 'En Progreso')
            ->withCount('inscripciones')
            ->with(['proyectoGeneral', 'proyectosEventoIndividuales.inscripcion.equipo'])
            ->orderBy('fecha_inicio', 'desc')
            ->get();

        return view('jurado.proyectos.index', compact('eventosEnProgreso'));
    }

    /**
     * Mostrar detalle de un proyecto específico
     */
    public function show(ProyectoEvento $proyectoEvento)
    {
        $user = Auth::user();
        $jurado = $user->jurado;

        if (!$jurado) {
            return redirect()->route('jurado.dashboard')
                ->with('error', 'No tienes acceso como jurado.');
        }

        // Verificar que el jurado esté asignado al evento de este proyecto
        $evento = $proyectoEvento->evento;
        
        if (!$jurado->eventos->contains($evento)) {
            return redirect()->route('jurado.proyectos.index')
                ->with('error', 'No tienes acceso a este proyecto.');
        }

        // Cargar relaciones necesarias
        $proyectoEvento->load([
            'evento',
            'inscripcion.equipo.miembros.user.estudiante',
            'inscripcion.equipo.miembros.rol',
            'inscripcion.proyecto.avances',
            'inscripcion.proyecto.tareas'
        ]);

        // Si es proyecto general, obtener todos los equipos del evento
        if ($proyectoEvento->esGeneral()) {
            $equipos = $evento->inscripciones()
                ->where('status_registro', 'Completo')
                ->with(['equipo', 'proyecto.avances'])
                ->get();
        } else {
            $equipos = collect([$proyectoEvento->inscripcion]);
        }

        return view('jurado.proyectos.show', compact('proyectoEvento', 'equipos', 'evento'));
    }

    /**
     * Ver todos los proyectos de un evento específico
     */
    public function evento(Evento $evento)
    {
        $user = Auth::user();
        $jurado = $user->jurado;

        if (!$jurado) {
            return redirect()->route('jurado.dashboard')
                ->with('error', 'No tienes acceso como jurado.');
        }

        // Verificar que el jurado esté asignado a este evento
        if (!$jurado->eventos->contains($evento)) {
            return redirect()->route('jurado.proyectos.index')
                ->with('error', 'No tienes acceso a este evento.');
        }

        // Verificar que el evento esté en progreso
        if ($evento->estado !== 'En Progreso') {
            return redirect()->route('jurado.proyectos.index')
                ->with('info', 'Este evento aún no está en progreso.');
        }

        if ($evento->tipo_proyecto === 'general') {
            // Proyecto general - redirigir al proyecto único
            $proyectoGeneral = $evento->proyectoGeneral;
            
            if (!$proyectoGeneral) {
                return redirect()->route('jurado.proyectos.index')
                    ->with('error', 'Este evento no tiene proyecto asignado.');
            }
            
            return redirect()->route('jurado.proyectos.show', $proyectoGeneral);
        } else {
            // Proyectos individuales - mostrar lista
            $proyectos = $evento->proyectosEventoIndividuales()
                ->where('publicado', true)
                ->with(['inscripcion.equipo', 'inscripcion.proyecto.avances'])
                ->get();

            return view('jurado.proyectos.evento', compact('evento', 'proyectos'));
        }
    }
}
