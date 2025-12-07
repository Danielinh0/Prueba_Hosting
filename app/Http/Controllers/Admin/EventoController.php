<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Evento;
use App\Models\CriterioEvaluacion;
use App\Jobs\EventoFinalizadoNotificationJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class EventoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Evento::query();

        // Búsqueda por nombre
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function($q) use ($searchTerm) {
                $q->where('nombre', 'like', '%' . $searchTerm . '%')
                  ->orWhere('descripcion', 'like', '%' . $searchTerm . '%');
            });
        }

        // Filtro por estado
        if ($request->filled('status')) {
            $query->where('estado', $request->input('status'));
        } else {
            // Por defecto, mostrar todos los estados relevantes
            $query->whereIn('estado', ['En Progreso', 'Activo', 'Próximo', 'Cerrado', 'Finalizado']);
        }


        // Obtener todos los eventos que coincidan con los filtros y luego agruparlos por estado
        $eventosAgrupados = $query->orderBy('fecha_inicio', 'asc')->get()->groupBy('estado');

        return view('admin.eventos.index', [
            'eventosAgrupados' => $eventosAgrupados,
            'search' => $request->input('search'), // Mantener el término de búsqueda para la vista
            'status' => $request->input('status'), // Mantener el estado de filtro para la vista
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.eventos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $datosValidados = $request->validate([
            'nombre' => 'required|string|max:150',
            'descripcion' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'cupo_max_equipos' => 'required|integer|min:1',
            'ruta_imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'criterios' => 'required|array|min:1',
            'criterios.*.nombre' => 'required|string|max:100',
            'criterios.*.descripcion' => 'nullable|string|max:500',
            'criterios.*.ponderacion' => 'required|numeric|min:1|max:100',
        ]);

        // Validar que la suma de ponderaciones sea 100%
        $sumaPonderaciones = collect($request->criterios)->sum('ponderacion');
        if (abs($sumaPonderaciones - 100) > 0.01) {
            return back()->withInput()->withErrors([
                'criterios' => 'La suma de las ponderaciones debe ser exactamente 100%. Actualmente suma ' . $sumaPonderaciones . '%.'
            ]);
        }

        DB::beginTransaction();
        try {
            if ($request->hasFile('ruta_imagen')) {
                $rutaImagen = $request->file('ruta_imagen')->store('imagenes_eventos', 'public');
                $datosValidados['ruta_imagen'] = $rutaImagen;
            }

            // Eliminar criterios del array antes de crear el evento
            unset($datosValidados['criterios']);
            
            $evento = Evento::create($datosValidados);

            // Crear los criterios de evaluación
            foreach ($request->criterios as $criterio) {
                CriterioEvaluacion::create([
                    'id_evento' => $evento->id_evento,
                    'nombre' => $criterio['nombre'],
                    'descripcion' => $criterio['descripcion'] ?? null,
                    'ponderacion' => $criterio['ponderacion'],
                ]);
            }

            DB::commit();
            return redirect()->route('admin.eventos.index')->with('success', 'Evento creado exitosamente con ' . count($request->criterios) . ' criterios de evaluación.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Error al crear el evento: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Evento $evento)
    {
        $evento->load('jurados.user', 'inscripciones.equipo', 'criteriosEvaluacion');
        return view('admin.eventos.show', compact('evento'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Evento $evento)
    {
        $evento->load('criteriosEvaluacion');
        return view('admin.eventos.edit', compact('evento'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Evento $evento)
    {
        $validationRules = [
            'nombre' => 'required|string|max:150',
            'descripcion' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'cupo_max_equipos' => 'required|integer|min:1',
            'ruta_imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        // Solo validar criterios si el evento permite cambiarlos
        $puedeCambiarCriterios = $evento->puedeCambiarCriterios();
        if ($puedeCambiarCriterios && $request->has('criterios')) {
            $validationRules['criterios'] = 'required|array|min:1';
            $validationRules['criterios.*.nombre'] = 'required|string|max:100';
            $validationRules['criterios.*.descripcion'] = 'nullable|string|max:500';
            $validationRules['criterios.*.ponderacion'] = 'required|numeric|min:1|max:100';
        }

        $datosValidados = $request->validate($validationRules);

        // Validar suma de ponderaciones si hay criterios
        if ($puedeCambiarCriterios && $request->has('criterios')) {
            $sumaPonderaciones = collect($request->criterios)->sum('ponderacion');
            if (abs($sumaPonderaciones - 100) > 0.01) {
                return back()->withInput()->withErrors([
                    'criterios' => 'La suma de las ponderaciones debe ser exactamente 100%. Actualmente suma ' . $sumaPonderaciones . '%.'
                ]);
            }
        }

        DB::beginTransaction();
        try {
            if ($request->hasFile('ruta_imagen')) {
                // Eliminar la imagen anterior si existe
                if ($evento->ruta_imagen) {
                    Storage::disk('public')->delete($evento->ruta_imagen);
                }
                
                // Guardar la nueva imagen
                $rutaImagen = $request->file('ruta_imagen')->store('imagenes_eventos', 'public');
                $datosValidados['ruta_imagen'] = $rutaImagen;
            }

            // Eliminar criterios del array antes de actualizar el evento
            unset($datosValidados['criterios']);
            
            $evento->update($datosValidados);

            // Actualizar criterios solo si el evento lo permite
            if ($puedeCambiarCriterios && $request->has('criterios')) {
                // Eliminar criterios anteriores
                $evento->criteriosEvaluacion()->delete();

                // Crear nuevos criterios
                foreach ($request->criterios as $criterio) {
                    CriterioEvaluacion::create([
                        'id_evento' => $evento->id_evento,
                        'nombre' => $criterio['nombre'],
                        'descripcion' => $criterio['descripcion'] ?? null,
                        'ponderacion' => $criterio['ponderacion'],
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('admin.eventos.index')->with('success', 'Evento actualizado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Error al actualizar el evento: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Evento $evento)
    {
        $evento->delete();

        return redirect()->route('admin.eventos.index')->with('success', 'Evento archivado exitosamente.');
    }

    public function activar(Evento $evento)
    {
        $evento->estado = 'Activo';
        $evento->save();
        return redirect()->route('admin.eventos.show', $evento)->with('success', 'El evento ha sido activado.');
    }

    public function desactivar(Evento $evento)
    {
        $evento->estado = 'Próximo';
        $evento->save();
        return redirect()->route('admin.eventos.show', $evento)->with('success', 'El evento ha sido cambiado a Próximo.');
    }

    public function finalizar(Evento $evento)
    {
        $evento->estado = 'Finalizado';
        $evento->save();

        // Enviar correos sincrónicamente para entrega inmediata
        // Solo si hay posiciones asignadas
        if ($evento->inscripciones()->whereNotNull('puesto_ganador')->exists()) {
            // Opción 1: Usar Job pero procesarlo inmediatamente
            EventoFinalizadoNotificationJob::dispatch($evento)->onConnection('sync');

            // Opción 2: Enviar directamente (comentado por ahora)
            // $this->sendEventFinalizationNotifications($evento);
        }

        return redirect()->route('admin.eventos.show', $evento)->with('success', 'El evento ha sido finalizado y se han enviado las notificaciones.');
    }

    /**
     * Enviar notificaciones de finalización de evento
     */
    private function sendEventFinalizationNotifications(Evento $evento)
    {
        $inscripciones = $evento->inscripciones()
            ->with(['equipo', 'miembros.user'])
            ->whereNotNull('puesto_ganador')
            ->get();

        foreach ($inscripciones as $inscripcion) {
            foreach ($inscripcion->miembros as $miembro) {
                try {
                    Mail::to($miembro->user->email)->send(
                        new EventoFinalizadoNotification(
                            $miembro->user,
                            $evento,
                            $inscripcion->equipo->nombre,
                            $inscripcion->puesto_ganador
                        )
                    );
                } catch (\Exception $e) {
                    \Log::error('Error al enviar correo de finalización de evento: ' . $e->getMessage(), [
                        'usuario' => $miembro->user->id_usuario,
                        'evento' => $evento->id_evento,
                        'equipo' => $inscripcion->equipo->id_equipo
                    ]);
                }
            }
        }
    }

    public function cerrar(Evento $evento)
    {
        $evento->estado = 'Cerrado';
        $evento->save();
        return redirect()->route('admin.eventos.show', $evento)->with('success', 'El evento ha sido cerrado. Las inscripciones están bloqueadas.');
    }

    public function reactivar(Evento $evento)
    {
        $evento->estado = 'Activo';
        $evento->save();
        return redirect()->route('admin.eventos.show', $evento)->with('success', 'El evento ha sido reactivado.');
    }
}
