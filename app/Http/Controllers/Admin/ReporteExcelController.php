<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EventosExport;
use App\Exports\ProyectosExport;
use App\Exports\EquiposExport;

class ReporteExcelController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.reportes.index');
    }

    public function exportarEventos(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio|before_or_equal:today',
        ]);

        $inicio = \Carbon\Carbon::parse($request->fecha_inicio);
        $fin = \Carbon\Carbon::parse($request->fecha_fin);

        if ($inicio->diffInDays($fin) < 7) {
            return back()->withErrors(['fecha_fin' => 'El rango de fechas debe ser de al menos una semana.']);
        }

        return Excel::download(new EventosExport($request->fecha_inicio, $request->fecha_fin), 'Reporte-eventos.xlsx');
    }

    public function exportarProyectos(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio|before_or_equal:today',
        ]);

        $inicio = \Carbon\Carbon::parse($request->fecha_inicio);
        $fin = \Carbon\Carbon::parse($request->fecha_fin);

        if ($inicio->diffInDays($fin) < 7) {
            return back()->withErrors(['fecha_fin' => 'El rango de fechas debe ser de al menos una semana.']);
        }

        return Excel::download(new ProyectosExport($request->fecha_inicio, $request->fecha_fin), 'Reporte-proyectos.xlsx');
    }

    public function exportarEquipos(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio|before_or_equal:today',
        ]);

        $inicio = \Carbon\Carbon::parse($request->fecha_inicio);
        $fin = \Carbon\Carbon::parse($request->fecha_fin);

        if ($inicio->diffInDays($fin) < 7) {
            return back()->withErrors(['fecha_fin' => 'El rango de fechas debe ser de al menos una semana.']);
        }

        return Excel::download(new EquiposExport($request->fecha_inicio, $request->fecha_fin), 'Reporte-equipos.xlsx');
    }

    public function exportarEventosPdf(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio|before_or_equal:today',
        ]);

        $inicio = \Carbon\Carbon::parse($request->fecha_inicio);
        $fin = \Carbon\Carbon::parse($request->fecha_fin);

        if ($inicio->diffInDays($fin) < 7) {
            return back()->withErrors(['fecha_fin' => 'El rango de fechas debe ser de al menos una semana.']);
        }

        $eventos = \App\Models\Evento::whereBetween('fecha_inicio', [$request->fecha_inicio, $request->fecha_fin])
            ->with(['inscripciones.equipo'])
            ->withCount('inscripciones')
            ->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.reportes.eventos', [
            'eventos' => $eventos,
            'fechaInicio' => $request->fecha_inicio,
            'fechaFin' => $request->fecha_fin,
        ]);

        return $pdf->download('Reporte-eventos.pdf');
    }

    public function exportarProyectosPdf(Request $request)
    {
       $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio|before_or_equal:today',
        ]);

        $inicio = \Carbon\Carbon::parse($request->fecha_inicio);
        $fin = \Carbon\Carbon::parse($request->fecha_fin);

        if ($inicio->diffInDays($fin) < 7) {
            return back()->withErrors(['fecha_fin' => 'El rango de fechas debe ser de al menos una semana.']);
        }

         $proyectos = \App\Models\Proyecto::whereBetween('created_at', [$request->fecha_inicio, $request->fecha_fin])
            ->with(['inscripcion.equipo', 'inscripcion.evento'])
            ->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.reportes.proyectos', [
            'proyectos' => $proyectos,
            'fechaInicio' => $request->fecha_inicio,
            'fechaFin' => $request->fecha_fin,
        ]);

        return $pdf->download('Reporte-proyectos.pdf');
    }

    public function exportarEquiposPdf(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio|before_or_equal:today',
        ]);

        $inicio = \Carbon\Carbon::parse($request->fecha_inicio);
        $fin = \Carbon\Carbon::parse($request->fecha_fin);

        if ($inicio->diffInDays($fin) < 7) {
            return back()->withErrors(['fecha_fin' => 'El rango de fechas debe ser de al menos una semana.']);
        }

         $equipos = \App\Models\Equipo::whereBetween('created_at', [$request->fecha_inicio, $request->fecha_fin])
            ->with('inscripciones.evento')
            ->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.reportes.equipos', [
            'equipos' => $equipos,
            'fechaInicio' => $request->fecha_inicio,
            'fechaFin' => $request->fecha_fin,
        ]);

        return $pdf->download('Reporte-equipos.pdf');
    }
}
