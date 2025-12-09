<?php

namespace App\Exports;

use App\Models\Evento;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class EventosExport implements FromView
{
    protected $fechaInicio;
    protected $fechaFin;

    public function __construct($fechaInicio, $fechaFin)
    {
        $this->fechaInicio = $fechaInicio;
        $this->fechaFin = $fechaFin;
    }

    public function view(): View
    {
        return view('admin.reportes.eventos', [
            'eventos' => Evento::whereBetween('fecha_inicio', [$this->fechaInicio, $this->fechaFin])
                ->with(['inscripciones.equipo'])
                ->withCount('inscripciones')
                ->get(),
            'fechaInicio' => $this->fechaInicio,
            'fechaFin' => $this->fechaFin,
        ]);
    }
}