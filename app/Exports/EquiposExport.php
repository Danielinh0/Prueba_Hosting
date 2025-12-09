<?php

namespace App\Exports;

use App\Models\Equipo;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class EquiposExport implements FromView
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
        return view('admin.reportes.equipos', [
            'equipos' => Equipo::whereBetween('created_at', [$this->fechaInicio, $this->fechaFin])
                ->with('inscripciones.evento')
                ->get(),
            'fechaInicio' => $this->fechaInicio,
            'fechaFin' => $this->fechaFin,
        ]);
    }
}