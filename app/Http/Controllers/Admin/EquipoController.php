<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Equipo;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class EquipoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $equipos = Equipo::with('miembros.user', 'inscripciones.evento')->get();
        return view('admin.equipos.index', compact('equipos'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Equipo $equipo)
    {
        $equipo->load('miembros.user.estudiante.carrera', 'miembros.rol', 'inscripciones.evento');

        return view('admin.equipos.show', compact('equipo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Equipo $equipo)
    {
        return view('estudiante.equipos.create', compact('equipo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Equipo $equipo)
    {
        $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:100',
                Rule::unique('equipos')->ignore($equipo->id_equipo, 'id_equipo'),
            ],
            'ruta_imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only('nombre');
        if ($request->hasFile('ruta_imagen')) {
            // Borrar imagen anterior si existe
            if ($equipo->ruta_imagen) {
                Storage::disk('public')->delete($equipo->ruta_imagen);
            }
            $data['ruta_imagen'] = $request->file('ruta_imagen')->store('imagenes_equipos', 'public');
        }

        $equipo->update($data);

        return redirect()->route('admin.equipos.show', $equipo)->with('success', 'Equipo actualizado correctamente.');
    } // Added missing brace
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Equipo $equipo)
    {
        $eventoId = null;
        if ($equipo->inscripciones->first()) {
            $eventoId = $equipo->inscripciones->first()->id_evento;
        }

        $equipo->delete();

        if ($eventoId) {
            return redirect()->route('admin.eventos.show', $eventoId)->with('success', 'Equipo eliminado correctamente.');
        }

        return redirect()->route('admin.dashboard')->with('success', 'Equipo eliminado correctamente.');
    }

    /**
     * Remove team from specific event (without deleting the team)
     */
    public function removeFromEvent(Request $request, Equipo $equipo)
    {
        $eventoId = $request->input('evento_id');
        $equipoNombre = $equipo->nombre;
        
        // Buscar la inscripción del equipo en este evento
        $inscripcion = $equipo->inscripciones()->where('id_evento', $eventoId)->first();
        
        if (!$inscripcion) {
            return redirect()->back()->with('error', 'Este equipo no está inscrito en el evento especificado.');
        }

        // NO eliminar la inscripción, solo quitar el evento
        // Esto mantiene el equipo y sus miembros intactos
        $inscripcion->id_evento = null;
        $inscripcion->status_registro = 'Incompleto';
        $inscripcion->puesto_ganador = null;
        $inscripcion->save();

        return redirect()->route('admin.eventos.show', $eventoId)
            ->with('success', "Equipo '{$equipoNombre}' excluido del evento. El equipo y sus miembros se mantienen sin evento.");
    }
}
