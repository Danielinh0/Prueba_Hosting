<?php

namespace App\Http\Controllers\Estudiante;

use App\Http\Controllers\Controller;
use App\Models\InscripcionEvento;
use App\Models\CatRolEquipo;
use App\Models\SolicitudUnion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MiEquipoController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $user = Auth::user();

        // Buscar la inscripción activa del estudiante
        $miInscripcion = InscripcionEvento::whereHas('miembros', function ($query) use ($user) {
            $query->where('id_estudiante', $user->id_usuario);
        })->whereHas('evento', function ($query) {
            // Permitir Próximo, Activo y Cerrado (solo bloquear Finalizado)
            $query->whereIn('estado', ['Próximo', 'Activo', 'Cerrado']);
        })->with([
            'equipo.miembros.user.estudiante.carrera', 
            'equipo.miembros.rol', 
            'evento'
        ])->first();
        
        if (!$miInscripcion) {
            // Si no, lo mandamos a la página de eventos para que busque uno.
            return redirect()->route('estudiante.eventos.index')->with('info', 'No perteneces a ningún equipo activo. ¡Busca un evento y únete o crea un equipo!');
        }
        
        $esLider = $miInscripcion->equipo->miembros->firstWhere('id_estudiante', $user->id_usuario)->es_lider ?? false;
        $solicitudes = collect(); // Colección vacía por defecto
        $roles = collect();       // Colección vacía por defecto

        if ($esLider) {
            // Cargar solicitudes pendientes para el equipo
            $solicitudes = SolicitudUnion::where('equipo_id', $miInscripcion->id_equipo)
                ->where('status', 'pendiente')
                ->with('estudiante.user') // Cargar datos del solicitante
                ->get();
            
            // Cargar los roles de equipo disponibles
            $roles = CatRolEquipo::all();
        }

        return view('estudiante.equipo.show', [
            'inscripcion' => $miInscripcion,
            'esLider' => $esLider,
            'solicitudes' => $solicitudes,
            'roles' => $roles,
        ]);
    }
}
