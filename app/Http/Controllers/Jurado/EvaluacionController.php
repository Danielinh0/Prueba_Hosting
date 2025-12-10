<?php

namespace App\Http\Controllers\Jurado;

use App\Http\Controllers\Controller;
use App\Models\Evaluacion;
use App\Models\EvaluacionCriterio;
use App\Models\InscripcionEvento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\EmailNotificacionService;

class EvaluacionController extends Controller
{
    /**
     * Formulario para evaluar equipo
     */
    public function create(InscripcionEvento $inscripcion)
    {
        $jurado = Auth::user()->jurado;
        
        // Verificar que el jurado esté asignado al evento
        if (!$inscripcion->evento->jurados->contains('id_usuario', $jurado->id_usuario)) {
            return redirect()->route('jurado.dashboard')
                ->with('error', 'No tienes permiso para evaluar este equipo.');
        }

        // Obtener o crear evaluación en borrador
        $evaluacion = Evaluacion::firstOrCreate(
            [
                'id_inscripcion' => $inscripcion->id_inscripcion,
                'id_jurado' => $jurado->id_usuario,
            ],
            ['estado' => 'Borrador']
        );

        // Cargar criterios del evento
        $criterios = $inscripcion->evento->criteriosEvaluacion;
        
        // Cargar calificaciones existentes por criterio (usar colección vacía si no hay)
        $calificacionesCriterios = $evaluacion->criterios ? $evaluacion->criterios->keyBy('id_criterio') : collect();

        $proyecto = $inscripcion->proyecto;
        $equipo = $inscripcion->equipo;

        return view('jurado.evaluaciones.create', compact('inscripcion', 'evaluacion', 'proyecto', 'equipo', 'jurado', 'criterios', 'calificacionesCriterios'));
    }

    /**
     * Guardar evaluación (borrador o finalizar)
     */
    public function store(Request $request, InscripcionEvento $inscripcion)
    {
        $jurado = Auth::user()->jurado;
        
        // Obtener criterios del evento para validación dinámica
        $criterios = $inscripcion->evento->criteriosEvaluacion;
        
        // Construir reglas de validación dinámicas
        $rules = [
            'comentarios_fortalezas' => 'nullable|string',
            'comentarios_areas_mejora' => 'nullable|string',
            'comentarios_generales' => 'nullable|string',
            'finalizar' => 'nullable|boolean',
        ];
        
        // Añadir validación para cada criterio
        foreach ($criterios as $criterio) {
            $rules["criterio_{$criterio->id_criterio}"] = 'nullable|numeric|min:0|max:100';
        }

        $request->validate($rules);

        DB::beginTransaction();
        try {
            $evaluacion = Evaluacion::updateOrCreate(
                [
                    'id_inscripcion' => $inscripcion->id_inscripcion,
                    'id_jurado' => $jurado->id_usuario,
                ],
                [
                    'comentarios_fortalezas' => $request->comentarios_fortalezas,
                    'comentarios_areas_mejora' => $request->comentarios_areas_mejora,
                    'comentarios_generales' => $request->comentarios_generales,
                ]
            );

            // Guardar calificaciones por criterio
            foreach ($criterios as $criterio) {
                $calificacion = $request->input("criterio_{$criterio->id_criterio}");
                
                if ($calificacion !== null) {
                    EvaluacionCriterio::updateOrCreate(
                        [
                            'id_evaluacion' => $evaluacion->id_evaluacion,
                            'id_criterio' => $criterio->id_criterio,
                        ],
                        [
                            'calificacion' => $calificacion,
                        ]
                    );
                }
            }

            // Si se pidió finalizar la evaluación
            if ($request->finalizar) {
                // Recargar criterios para verificar si está completa
                $evaluacion->load('criterios');
                
                if ($evaluacion->estaCompleta()) {
                    $evaluacion->finalizar();

                    // Enviar email al estudiante
                    Log::info("=== INICIANDO ENVÍO EMAIL EVALUACIÓN FINAL ===");
                    Log::info("ID Líder del equipo: " . $inscripcion->equipo->id_lider);

                    // Cargar el líder del equipo con su usuario
                    $lider = $inscripcion->equipo->miembros()->where('es_lider', true)->with('user')->first();

                    if ($lider && $lider->user) {
                        Log::info("Líder encontrado: " . $lider->user->nombre);
                        Log::info("Email del líder: " . $lider->user->email);

                        $emailService = new EmailNotificacionService();
                        $proyecto = $inscripcion->proyecto;

                        $resultado = $emailService->notificarCalificacionFinal(
                            $lider->user->id_usuario,
                            [
                                'nombre' => $proyecto->nombre ?? 'Proyecto sin nombre',
                                'nombre_jurado' => Auth::user()->nombre,
                                'comentarios' => 'Tu proyecto ha sido evaluado. Revisa el sistema para más detalles.'
                            ],
                            $evaluacion->calificacion_final
                        );

                        if ($resultado) {
                            Log::info("✅ Email de evaluación final enviado a " . $lider->user->email);
                        } else {
                            Log::error("❌ Falló envío de email de evaluación final");
                        }
                    } else {
                        Log::error("❌ No se encontró líder o el líder no tiene usuario");
                    }

                    // Verificar si el evento debe finalizarse automáticamente
                    $evento = $inscripcion->evento;
                    if ($evento->estado === 'En Progreso' && $evento->todasEvaluacionesCompletas()) {
                        $evento->estado = 'Finalizado';
                        $evento->save();
                        
                        Log::info("🎉 Evento {$evento->id_evento} finalizado automáticamente - todas las evaluaciones completas");
                        
                        // Enviar notificaciones de finalización del evento
                        if ($evento->inscripciones()->whereNotNull('puesto_ganador')->exists()) {
                            \App\Jobs\EventoFinalizadoNotificationJob::dispatch($evento)->onConnection('sync');
                        }
                    }

                    DB::commit();
                    return redirect()->route('jurado.evaluaciones.show', $evaluacion)
                        ->with('success', '¡Evaluación finalizada exitosamente! Calificación final: ' . $evaluacion->calificacion_final . ' (Email enviado al estudiante)');
                } else {
                    DB::commit();
                    return redirect()->route('jurado.evaluaciones.create', $inscripcion)
                        ->with('error', 'Debes calificar todos los criterios antes de finalizar.');
                }
            }

            DB::commit();
            return redirect()->route('jurado.evaluaciones.create', $inscripcion)
                ->with('success', 'Evaluación guardada como borrador.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('jurado.evaluaciones.create', $inscripcion)
                ->with('error', 'Error al guardar la evaluación: ' . $e->getMessage());
        }
    }

    /**
     * Ver evaluación finalizada
     */
    public function show(Evaluacion $evaluacion)
    {
        $jurado = Auth::user()->jurado;

        // Verificar que sea la evaluación de este jurado
        if ($evaluacion->id_jurado != $jurado->id_usuario) {
            return redirect()->route('jurado.dashboard')
                ->with('error', 'No tienes permiso para ver esta evaluación.');
        }

        $inscripcion = $evaluacion->inscripcion;
        $proyecto = $inscripcion->proyecto;
        $equipo = $inscripcion->equipo;
        
        // Cargar criterios del evento y calificaciones
        $criterios = $inscripcion->evento->criteriosEvaluacion;
        $calificacionesCriterios = $evaluacion->criterios ? $evaluacion->criterios->keyBy('id_criterio') : collect();

        return view('jurado.evaluaciones.show', compact('evaluacion', 'inscripcion', 'proyecto', 'equipo', 'criterios', 'calificacionesCriterios'));
    }
}
