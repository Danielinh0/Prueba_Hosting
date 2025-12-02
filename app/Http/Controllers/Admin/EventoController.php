<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        ]);

        if ($request->hasFile('ruta_imagen')) {
            $rutaImagen = $request->file('ruta_imagen')->store('imagenes_eventos', 'public');
            $datosValidados['ruta_imagen'] = $rutaImagen;
        }

        Evento::create($datosValidados);

        return redirect()->route('admin.eventos.index')->with('success', 'Evento creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Evento $evento)
    {
        $evento->load('jurados.user', 'inscripciones.equipo');
        return view('admin.eventos.show', compact('evento'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Evento $evento)
    {
        
        return view('admin.eventos.edit', compact('evento'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Evento $evento)
    {
        $datosValidados = $request->validate([
            'nombre' => 'required|string|max:150',
            'descripcion' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'cupo_max_equipos' => 'required|integer|min:1',
            'ruta_imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('ruta_imagen')) {
            // Eliminar la imagen anterior si existe
            if ($evento->ruta_imagen) {
                Storage::disk('public')->delete($evento->ruta_imagen);
            }
            
            // Guardar la nueva imagen
            $rutaImagen = $request->file('ruta_imagen')->store('imagenes_eventos', 'public');
            $datosValidados['ruta_imagen'] = $rutaImagen;
        }

        $evento->update($datosValidados);

        return redirect()->route('admin.eventos.index')->with('success', 'Evento actualizado exitosamente.');
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
        return redirect()->route('admin.eventos.show', $evento)->with('success', 'El evento ha sido finalizado.');
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
