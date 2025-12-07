<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Evento;
use App\Models\Jurado;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Services\EmailNotificacionService;
use Illuminate\Support\Facades\Log;

class JuradoAssignmentController extends Controller
{
    /**
     * Show the form for assigning jurors to an event.
     */
    public function edit(Request $request, Evento $evento)
    {
        // Obtener búsqueda
        $search = $request->input('search');
        
        // Obtener todos los jurados con su información de usuario con filtro
        $query = Jurado::with('user');
        
        if ($search) {
            $query->whereHas('user', function($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('app_paterno', 'like', "%{$search}%")
                  ->orWhere('app_materno', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        $juradosDisponibles = $query->paginate(12)->withQueryString();

        // Obtener los IDs de los jurados ya asignados a este evento
        $juradosAsignadosIds = $evento->jurados()->pluck('jurados.id_usuario')->toArray();

        return view('admin.eventos.asignar-jurados', compact('evento', 'juradosDisponibles', 'juradosAsignadosIds', 'search'));
    }

    /**
     * Update the specified event's juror assignments in storage.
     */
    public function update(Request $request, Evento $evento)
    {
        $request->validate([
            'jurados' => [
                'nullable',
                'array',
                'min:3',
                'max:5',
            ],
        ], [
            'jurados.min' => 'Debes asignar un mínimo de :min jurados.',
            'jurados.max' => 'Puedes asignar un máximo de :max jurados.',
        ]);

        // Obtener jurados antes de la actualización
        $juradosAntes = $evento->jurados()->pluck('jurados.id_usuario')->toArray();
        $juradosNuevos = $request->input('jurados', []);

        // Identificar jurados agregados y eliminados
        $juradosAgregados = array_diff($juradosNuevos, $juradosAntes);
        $juradosEliminados = array_diff($juradosAntes, $juradosNuevos);

        // Sincronizar los jurados con el evento
        $evento->jurados()->sync($juradosNuevos);

        $emailService = new EmailNotificacionService();

        // Enviar emails a los jurados NUEVAMENTE asignados
        Log::info("=== INICIO ENVÍO DE EMAILS DE JURADOS NUEVOS ===");
        Log::info("Evento: " . $evento->nombre);
        Log::info("Jurados agregados: " . json_encode($juradosAgregados));

        $emailsEnviados = 0;
        $emailsFallidos = 0;
        $nombresJuradosAgregados = [];
        $nombresJuradosEliminados = [];

        foreach ($juradosAgregados as $idJurado) {
            Log::info("Procesando jurado AGREGADO ID: " . $idJurado);
            $jurado = Jurado::with('user')->find($idJurado);

            if ($jurado && $jurado->user) {
                $nombresJuradosAgregados[] = $jurado->user->nombre;
                Log::info("Jurado encontrado: " . $jurado->user->nombre);

                // Contar proyectos asignados a este jurado
                $cantidadProyectos = $evento->inscripciones()->count();

                try {
                    $resultado = $emailService->notificarJuradoAsignado(
                        $idJurado,
                        [
                            'nombre' => $evento->nombre,
                            'fecha' => $evento->fecha_inicio ? $evento->fecha_inicio->format('d/m/Y') : 'Por definir',
                            'cantidad_proyectos' => $cantidadProyectos
                        ]
                    );

                    if ($resultado) {
                        Log::info("✅ Email enviado exitosamente a " . $jurado->user->email);
                        $emailsEnviados++;
                    } else {
                        Log::error("❌ Falló enviar email a " . $jurado->user->email);
                        $emailsFallidos++;
                    }
                } catch (\Exception $e) {
                    Log::error("❌ ERROR al enviar email a " . $jurado->user->email . ": " . $e->getMessage());
                    $emailsFallidos++;
                }
            }
        }

        // Enviar emails a los jurados ELIMINADOS
        Log::info("=== INICIO ENVÍO DE EMAILS DE JURADOS ELIMINADOS ===");
        Log::info("Jurados eliminados: " . json_encode($juradosEliminados));

        foreach ($juradosEliminados as $idJurado) {
            Log::info("Procesando jurado ELIMINADO ID: " . $idJurado);
            $jurado = Jurado::with('user')->find($idJurado);

            if ($jurado && $jurado->user) {
                $nombresJuradosEliminados[] = $jurado->user->nombre;
                Log::info("Jurado encontrado: " . $jurado->user->nombre);

                try {
                    $resultado = $emailService->notificarJuradoEliminado(
                        $idJurado,
                        [
                            'nombre' => $evento->nombre,
                            'fecha' => $evento->fecha_inicio ? $evento->fecha_inicio->format('d/m/Y') : 'Por definir',
                            'motivo' => 'Actualización de asignación de jurados'
                        ]
                    );

                    if ($resultado) {
                        Log::info("✅ Email de eliminación enviado a " . $jurado->user->email);
                    } else {
                        Log::error("❌ Falló enviar email de eliminación a " . $jurado->user->email);
                    }
                } catch (\Exception $e) {
                    Log::error("❌ ERROR al enviar email de eliminación a " . $jurado->user->email . ": " . $e->getMessage());
                }
            }
        }

        // Enviar email de resumen al administrador si hubo cambios
        if (!empty($juradosAgregados) || !empty($juradosEliminados)) {
            try {
                $emailService->notificarActualizacionJurados(
                    $evento->id,
                    [
                        'nombre' => $evento->nombre,
                        'fecha' => $evento->fecha_inicio ? $evento->fecha_inicio->format('d/m/Y') : 'Por definir',
                        'jurados_nuevos' => $nombresJuradosAgregados,
                        'jurados_eliminados' => $nombresJuradosEliminados
                    ]
                );
            } catch (\Exception $e) {
                Log::error("❌ ERROR al enviar email de actualización: " . $e->getMessage());
            }
        }

        Log::info("=== RESUMEN ENVÍO ===");
        Log::info("Jurados agregados: " . count($juradosAgregados));
        Log::info("Jurados eliminados: " . count($juradosEliminados));
        Log::info("Emails enviados: " . $emailsEnviados);
        Log::info("Emails fallidos: " . $emailsFallidos);
        Log::info("========================");

        $mensaje = 'Asignación de jurados actualizada exitosamente.';
        if (!empty($juradosAgregados)) {
            $mensaje .= ' Se han agregado ' . count($juradosAgregados) . ' jurados.';
        }
        if (!empty($juradosEliminados)) {
            $mensaje .= ' Se han removido ' . count($juradosEliminados) . ' jurados.';
        }

        return redirect()->route('admin.eventos.show', $evento)
            ->with('success', $mensaje);
    }
}
