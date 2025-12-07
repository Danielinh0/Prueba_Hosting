<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Evento;
use App\Models\ProyectoEvento;
use App\Models\InscripcionEvento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Services\EmailNotificacionService;

class ProyectoEventoController extends Controller
{
    /**
     * Configurar tipo de proyecto del evento
     */
    public function configurarTipo(Request $request, Evento $evento)
    {
        $request->validate([
            'tipo_proyecto' => 'required|in:general,individual'
        ]);

        $evento->tipo_proyecto = $request->tipo_proyecto;
        $evento->save();

        return redirect()->route('admin.eventos.show', $evento)
            ->with('success', 'Tipo de proyecto configurado exitosamente.');
    }

    /**
     * Mostrar formulario para crear proyecto general
     */
    public function create(Evento $evento)
    {
        // Verificar que sea tipo general
        if ($evento->tipo_proyecto != 'general') {
            return redirect()->route('admin.eventos.show', $evento)
                ->with('error', 'Este evento no está configurado para proyecto general.');
        }

        // Verificar si ya existe un proyecto
        $proyectoEvento = $evento->proyectoGeneral;

        return view('admin.proyectos-evento.create', compact('evento', 'proyectoEvento'));
    }

    /**
     * Guardar proyecto general del evento
     */
    public function store(Request $request, Evento $evento)
    {
        $request->validate([
            'titulo' => 'required|string|max:200',
            'descripcion_completa' => 'nullable|string',
            'objetivo' => 'nullable|string',
            'requisitos' => 'nullable|string',
            'premios' => 'nullable|string',
            'archivo_bases' => 'nullable|file|mimes:pdf,doc,docx|max:20480',
            'archivo_recursos' => 'nullable|file|mimes:zip,rar,pdf|max:51200',
            'url_externa' => 'nullable|url',
        ]);

        $data = $request->except(['archivo_bases', 'archivo_recursos']);
        $data['id_evento'] = $evento->id_evento;
        $data['id_inscripcion'] = null; // General

        // Manejo de archivos
        if ($request->hasFile('archivo_bases')) {
            $data['archivo_bases'] = $request->file('archivo_bases')
                ->store('proyectos-evento/bases', 'public');
        }

        if ($request->hasFile('archivo_recursos')) {
            $data['archivo_recursos'] = $request->file('archivo_recursos')
                ->store('proyectos-evento/recursos', 'public');
        }

        $proyecto = ProyectoEvento::create($data);

        return redirect()->route('admin.eventos.show', $evento)
            ->with('success', 'Proyecto creado exitosamente.');
    }

    /**
     * Mostrar formulario para editar proyecto
     */
    public function edit(ProyectoEvento $proyectoEvento)
    {
        $evento = $proyectoEvento->evento;
        return view('admin.proyectos-evento.edit', compact('proyectoEvento', 'evento'));
    }

    /**
     * Actualizar proyecto
     */
    public function update(Request $request, ProyectoEvento $proyectoEvento)
    {
        $request->validate([
            'titulo' => 'required|string|max:200',
            'descripcion_completa' => 'nullable|string',
            'objetivo' => 'nullable|string',
            'requisitos' => 'nullable|string',
            'premios' => 'nullable|string',
            'archivo_bases' => 'nullable|file|mimes:pdf,doc,docx|max:20480',
            'archivo_recursos' => 'nullable|file|mimes:zip,rar,pdf|max:51200',
            'url_externa' => 'nullable|url',
        ]);

        $data = $request->except(['archivo_bases', 'archivo_recursos']);

        // Manejo de archivos
        if ($request->hasFile('archivo_bases')) {
            // Eliminar archivo anterior
            if ($proyectoEvento->archivo_bases) {
                Storage::disk('public')->delete($proyectoEvento->archivo_bases);
            }
            $data['archivo_bases'] = $request->file('archivo_bases')
                ->store('proyectos-evento/bases', 'public');
        }

        if ($request->hasFile('archivo_recursos')) {
            // Eliminar archivo anterior
            if ($proyectoEvento->archivo_recursos) {
                Storage::disk('public')->delete($proyectoEvento->archivo_recursos);
            }
            $data['archivo_recursos'] = $request->file('archivo_recursos')
                ->store('proyectos-evento/recursos', 'public');
        }

        $proyectoEvento->update($data);

        return redirect()->route('admin.eventos.show', $proyectoEvento->evento)
            ->with('success', 'Proyecto actualizado exitosamente.');
    }

    /**
     * Publicar proyecto
     */
    public function publicar(ProyectoEvento $proyectoEvento)
    {
        $proyectoEvento->publicar();
        $evento = $proyectoEvento->evento;
        $mensaje = 'Proyecto publicado exitosamente.';

        // Si es proyecto GENERAL, cambiar evento a "En Progreso" automáticamente
        if ($proyectoEvento->esGeneral()) {
            if ($evento->cambiarAEnProgreso()) {
                $mensaje .= ' El evento ahora está en progreso y visible para los estudiantes.';
            }
        }
        
        // Si es proyecto INDIVIDUAL, verificar si todos están publicados
        if ($proyectoEvento->esIndividual()) {
            if ($evento->todosProyectosIndividualesPublicados()) {
                if ($evento->cambiarAEnProgreso()) {
                    $mensaje .= ' ¡Todos los proyectos han sido publicados! El evento ahora está en progreso.';
                }
            } else {
                $totalEquipos = $evento->inscripciones()->where('status_registro', 'Completo')->count();
                $publicados = $evento->proyectosEventoIndividuales()->where('publicado', true)->count();
                $mensaje .= " Proyectos publicados: {$publicados}/{$totalEquipos}";
            }
        }

        return redirect()->back()->with('success', $mensaje);
    }

    /**
     * Despublicar proyecto
     */
    public function despublicar(ProyectoEvento $proyectoEvento)
    {
        $proyectoEvento->despublicar();

        return redirect()->back()
            ->with('success', 'Proyecto despublicado.');
    }

    /**
     * Mostrar vista para asignar proyectos individuales
     */
    public function asignar(Evento $evento)
    {
        if ($evento->tipo_proyecto != 'individual') {
            return redirect()->route('admin.eventos.show', $evento)
                ->with('error', 'Este evento no está configurado para proyectos individuales.');
        }

        $inscripciones = $evento->inscripciones()
            ->with(['equipo.miembros', 'proyectoEvento'])
            ->where('status_registro', 'Completo')
            ->get();

        return view('admin.proyectos-evento.asignar', compact('evento', 'inscripciones'));
    }

    /**
     * Crear proyecto para equipo específico
     */
    public function createIndividual(Evento $evento, InscripcionEvento $inscripcion)
    {
        if ($evento->tipo_proyecto != 'individual') {
            return redirect()->route('admin.eventos.show', $evento)
                ->with('error', 'Este evento no está configurado para proyectos individuales.');
        }

        // Cargar relaciones necesarias
        $inscripcion->load('equipo.miembros.user.estudiante', 'equipo.miembros.rol');

        return view('admin.proyectos-evento.create-individual', compact('evento', 'inscripcion'));
    }

    /**
     * Guardar proyecto individual
     */
    public function storeIndividual(Request $request, Evento $evento, InscripcionEvento $inscripcion)
    {
        $request->validate([
            'titulo' => 'required|string|max:200',
            'descripcion_completa' => 'nullable|string',
            'objetivo' => 'nullable|string',
            'requisitos' => 'nullable|string',
            'premios' => 'nullable|string',
            'archivo_bases' => 'nullable|file|mimes:pdf,doc,docx|max:20480',
            'archivo_recursos' => 'nullable|file|mimes:zip,rar,pdf|max:51200',
            'url_externa' => 'nullable|url',
        ]);

        $data = $request->except(['archivo_bases', 'archivo_recursos']);

        // Manejo de archivos
        if ($request->hasFile('archivo_bases')) {
            $data['archivo_bases'] = $request->file('archivo_bases')
                ->store('proyectos-evento/bases', 'public');
        }

        if ($request->hasFile('archivo_recursos')) {
            $data['archivo_recursos'] = $request->file('archivo_recursos')
                ->store('proyectos-evento/recursos', 'public');
        }

        // Usar updateOrCreate para evitar error de llave duplicada
        $proyecto = ProyectoEvento::updateOrCreate(
            [
                'id_evento' => $evento->id_evento,
                'id_inscripcion' => $inscripcion->id_inscripcion
            ],
            $data
        );

        // Enviar email al líder del equipo (solo si es un proyecto nuevo)
        if ($proyecto->wasRecentlyCreated) {
            Log::info("Enviando email de proyecto asignado al líder del equipo");

            // Buscar al líder del equipo
            $lider = $inscripcion->equipo->miembros()
                ->where('es_lider', true)
                ->with('user')
                ->first();

            if ($lider && $lider->user) {
                Log::info("Líder encontrado: " . $lider->user->nombre);

                $emailService = new EmailNotificacionService();
                $emailService->notificarProyectoAsignado(
                    $lider->user->id_usuario,
                    [
                        'nombre_equipo' => $inscripcion->equipo->nombre,
                        'nombre_evento' => $evento->nombre,
                        'nombre_proyecto' => $request->titulo,
                        'descripcion' => $request->descripcion_completa ?? 'Sin descripción',
                        'objetivo' => $request->objetivo ?? 'Sin objetivo específico'
                    ]
                );
            } else {
                Log::warning("No se encontró líder para el equipo " . $inscripcion->equipo->nombre);
            }
        }

        return redirect()->route('admin.proyectos-evento.asignar', $evento)
            ->with('success', 'Proyecto asignado exitosamente' . ($proyecto->wasRecentlyCreated ? '. Email enviado al líder del equipo.' : '.'));
    }
}
