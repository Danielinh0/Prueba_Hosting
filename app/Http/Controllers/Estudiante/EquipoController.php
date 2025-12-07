<?php

namespace App\Http\Controllers\Estudiante;

use App\Http\Controllers\Controller;
use App\Models\Evento;
use App\Models\Equipo;
use App\Models\InscripcionEvento;
use App\Models\MiembroEquipo;
use App\Models\SolicitudUnion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class EquipoController extends Controller
{
    public function index(Request $request, Evento $evento)
    {
        $user = Auth::user();
        $miInscripcion = MiembroEquipo::where('id_estudiante', $user->id_usuario)
            ->whereHas('inscripcion', function ($query) use ($evento) {
                $query->where('id_evento', $evento->id_evento);
            })
            ->with('inscripcion:id_inscripcion,id_equipo')
            ->first();
        $miInscripcionDeEquipoId = $miInscripcion ? $miInscripcion->inscripcion->id_equipo : null;
        $solicitudesDelEstudiante = SolicitudUnion::where('estudiante_id', $user->id_usuario)
            ->whereHas('equipo.inscripciones', function ($query) use ($evento) {
                $query->where('id_evento', $evento->id_evento);
            })
            ->get()
            ->keyBy('equipo_id');
        $query = $evento->inscripciones()->with('equipo.miembros');
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->whereHas('equipo', function ($q) use ($searchTerm) {
                $q->where('nombre', 'like', '%' . $searchTerm . '%');
            });
        }
        if ($request->filled('status')) {
            if ($request->input('status') == 'Completo') {
                // Equipos con 5 o más miembros (llenos)
                $query->whereRaw('(SELECT COUNT(*) FROM miembros_equipo me WHERE me.id_inscripcion = inscripciones_evento.id_inscripcion) >= 5');
            } else {
                // Equipos con menos de 5 miembros (con lugares disponibles)
                $query->whereRaw('(SELECT COUNT(*) FROM miembros_equipo me WHERE me.id_inscripcion = inscripciones_evento.id_inscripcion) < 5');
            }
        }
        $inscripciones = $query->paginate(12);
        return view('estudiante.equipos.index', compact('evento', 'inscripciones', 'user', 'miInscripcionDeEquipoId', 'solicitudesDelEstudiante'));
    }

    /**
     * Mostrar formulario para crear equipo SIN evento (con anticipación)
     */
    public function createSinEvento()
    {
        return view('estudiante.equipos.create-sin-evento');
    }

    /**
     * Guardar equipo SIN evento
     */
    public function storeSinEvento(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:equipos,nombre',
            'descripcion' => 'nullable|string|max:1000',
            'ruta_imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $user = Auth::user();
                $rutaImagen = null;

                if ($request->hasFile('ruta_imagen')) {
                    $rutaImagen = $request->file('ruta_imagen')->store('imagenes_equipos', 'public');
                }

                // 1. Crear equipo
                $equipo = Equipo::create([
                    'nombre' => $request->nombre,
                    'descripcion' => $request->descripcion,
                    'ruta_imagen' => $rutaImagen,
                ]);

                // 2. Crear inscripción SIN evento (id_evento = null)
                $inscripcion = InscripcionEvento::create([
                    'id_equipo' => $equipo->id_equipo,
                    'id_evento' => null, // Sin evento por ahora
                    'status_registro' => 'Incompleto',
                ]);

                // 3. Crear miembro (el creador es líder)
                MiembroEquipo::create([
                    'id_inscripcion' => $inscripcion->id_inscripcion,
                    'id_estudiante' => $user->id_usuario,
                    'id_rol_equipo' => 1, // Rol por defecto
                    'es_lider' => true,
                ]);
            });

            return redirect()->route('estudiante.equipo.index')
                ->with('success', '¡Equipo creado exitosamente! Ya puedes registrarlo a un evento cuando esté disponible.');

        } catch (\Exception $e) {
            return back()->with('error', 'Ocurrió un error al crear el equipo: ' . $e->getMessage())->withInput();
        }
    }

    public function create(Evento $evento)
    {
        $user = Auth::user();
        $inscripcionExistente = InscripcionEvento::whereHas('miembros', function ($query) use ($user) {
            $query->where('id_estudiante', $user->id_usuario);
        })->whereHas('evento', function ($query) {
            $query->where('estado', 'Activo');
        })->first();
        if ($inscripcionExistente) {
            return redirect()->route('estudiante.dashboard')->with('error', 'Ya estás participando en un evento activo.');
        }
        return view('estudiante.equipos.create', compact('evento'));
    }

    public function store(Request $request, Evento $evento)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:equipos,nombre',
            'descripcion' => 'nullable|string|max:1000',
            'ruta_imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Validar conflicto de fechas
        $user = Auth::user();
        $conflicto = \App\Helpers\EventoHelper::verificarConflictoFechas($user->id_usuario, $evento->id_evento);
        
        if ($conflicto['conflicto']) {
            return back()->with('error', $conflicto['mensaje'])->withInput();
        }

        try {
            DB::transaction(function () use ($request, $evento) {
                $user = Auth::user();
                $rutaImagen = null;
                if ($request->hasFile('ruta_imagen')) {
                    $rutaImagen = $request->file('ruta_imagen')->store('imagenes_equipos', 'public');
                }
                $equipo = Equipo::create([
                    'nombre' => $request->nombre,
                    'descripcion' => $request->descripcion,
                    'ruta_imagen' => $rutaImagen,
                ]);
                $inscripcion = InscripcionEvento::create([
                    'id_equipo' => $equipo->id_equipo,
                    'id_evento' => $evento->id_evento,
                    'status_registro' => 'Incompleto',
                ]);
                MiembroEquipo::create([
                    'id_inscripcion' => $inscripcion->id_inscripcion,
                    'id_estudiante' => $user->id_usuario,
                    'id_rol_equipo' => 1,
                    'es_lider' => true,
                ]);
            });
        } catch (\Exception $e) {
            return back()->with('error', 'Ocurrió un error al crear el equipo: ' . $e->getMessage())->withInput();
        }
        return redirect()->route('estudiante.dashboard')->with('success', '¡Equipo creado e inscrito exitosamente!');
    }

    public function edit()
    {
        $user = Auth::user();
        $miembro = MiembroEquipo::where('id_estudiante', $user->id_usuario)
            ->where('es_lider', true)
            ->whereHas('inscripcion.evento', function ($query) {
                $query->where('estado', 'Activo');
            })
            ->with('inscripcion.equipo')
            ->firstOrFail(); 
        $equipo = $miembro->inscripcion->equipo;
        return view('estudiante.equipos.edit', compact('equipo'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $miembro = MiembroEquipo::where('id_estudiante', $user->id_usuario)
            ->where('es_lider', true)
            ->whereHas('inscripcion.evento', function ($query) {
                $query->where('estado', 'Activo');
            })
            ->with('inscripcion.equipo')
            ->firstOrFail();
        $equipo = $miembro->inscripcion->equipo;
        $inscripcion = $miembro->inscripcion;
        
        $request->validate([
            'nombre' => ['required', 'string', 'max:100', Rule::unique('equipos')->ignore($equipo->id_equipo, 'id_equipo')],
            'descripcion' => 'nullable|string|max:1000',
            'ruta_imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $data = $request->only('nombre', 'descripcion');
        if ($request->hasFile('ruta_imagen')) {
            if ($equipo->ruta_imagen) {
                Storage::disk('public')->delete($equipo->ruta_imagen);
            }
            $data['ruta_imagen'] = $request->file('ruta_imagen')->store('imagenes_equipos', 'public');
        }
        $equipo->update($data);
        return redirect()->route('estudiante.equipo.show-detalle', $inscripcion)->with('success', 'Equipo actualizado correctamente.');
    }

    public function show(Evento $evento, Equipo $equipo)
    {
        $user = Auth::user();
        
        // Obtener la inscripción del equipo para este evento
        $inscripcion = InscripcionEvento::where('id_equipo', $equipo->id_equipo)
            ->where('id_evento', $evento->id_evento)
            ->with(['equipo', 'miembros.user.estudiante.carrera', 'miembros.rol', 'evento'])
            ->firstOrFail();

            
        // Verificar si el usuario ya es miembro de un equipo en este evento
        $miInscripcion = MiembroEquipo::where('id_estudiante', $user->id_usuario)
            ->whereHas('inscripcion', function ($query) use ($evento) {
                $query->where('id_evento', $evento->id_evento);
            })
            ->with('inscripcion:id_inscripcion,id_equipo')
            ->first();
        $miInscripcionDeEquipoId = $miInscripcion ? $miInscripcion->inscripcion->id_equipo : null;
        
        // Verificar si hay solicitud pendiente
        $solicitudActual = SolicitudUnion::where('estudiante_id', $user->id_usuario)
            ->where('equipo_id', $equipo->id_equipo)
            ->first();
        
        return view('estudiante.equipos.show', compact('inscripcion', 'evento', 'miInscripcionDeEquipoId', 'solicitudActual'));
    }

    /**
     * Mostrar lista de equipos existentes del usuario para registrar a un evento
     */
    public function selectEquipoExistente(Evento $evento)
    {
        $user = Auth::user();

        // Obtener equipos del usuario SIN evento (id_evento = null)
        $equiposDisponibles = InscripcionEvento::whereHas('miembros', function ($query) use ($user) {
            $query->where('id_estudiante', $user->id_usuario)
                  ->where('es_lider', true); // Solo equipos donde es líder
        })
        ->whereNull('id_evento') // Solo equipos sin evento
        ->with(['equipo', 'miembros'])
        ->get();

        // Filtrar equipos sin conflicto de fechas (verificar TODOS los miembros)
        $equiposFiltrados = $equiposDisponibles->filter(function ($inscripcion) use ($evento) {
            // Verificar que NINGÚN miembro tenga conflicto de fechas
            foreach ($inscripcion->miembros as $miembro) {
                $conflicto = \App\Helpers\EventoHelper::verificarConflictoFechas(
                    $miembro->id_estudiante,
                    $evento->id_evento
                );
                if ($conflicto['conflicto']) {
                    return false; // Si algún miembro tiene conflicto, excluir el equipo
                }
            }
            return true; // Solo incluir si NINGÚN miembro tiene conflicto
        });

        return view('estudiante.equipos.select-existente', compact('evento', 'equiposFiltrados'));
    }

    /**
     * Registrar un equipo existente a un evento
     */
    public function registrarEquipoExistente(Request $request, Evento $evento)
    {
        $request->validate([
            'inscripcion_id' => 'required|exists:inscripciones_evento,id_inscripcion'
        ]);

        $user = Auth::user();
        $inscripcion = InscripcionEvento::findOrFail($request->inscripcion_id);

        // Verificar que el usuario es líder del equipo
        $esLider = $inscripcion->miembros()
            ->where('id_estudiante', $user->id_usuario)
            ->where('es_lider', true)
            ->exists();

        if (!$esLider) {
            return back()->with('error', 'Solo el líder puede registrar el equipo a un evento.');
        }

        // Verificar que la inscripción no tiene evento
        if ($inscripcion->id_evento !== null) {
            return back()->with('error', 'Este equipo ya está registrado en un evento.');
        }

        // Validar conflicto de fechas para TODOS los miembros
        foreach ($inscripcion->miembros as $miembro) {
            $conflicto = \App\Helpers\EventoHelper::verificarConflictoFechas(
                $miembro->id_estudiante,
                $evento->id_evento
            );

            if ($conflicto['conflicto']) {
                return back()->with('error', 'Uno de los miembros tiene conflicto de fechas: ' . $conflicto['mensaje']);
            }
        }

        try {
            // Actualizar la inscripción para asociarla al evento
            $inscripcion->update([
                'id_evento' => $evento->id_evento,
                'status_registro' => 'Incompleto',
                'fecha_inscripcion' => now(),
            ]);

            return redirect()->route('estudiante.eventos.equipos.index', $evento)
                ->with('success', '¡Equipo "' . $inscripcion->equipo->nombre . '" registrado exitosamente al evento!');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al registrar el equipo: ' . $e->getMessage());
        }
    }
    public function destroy(string $id)
    {
        //
    }
}