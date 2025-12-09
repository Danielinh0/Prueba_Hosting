<?php

namespace App\Http\Controllers\Jurado;

use App\Http\Controllers\Controller;
use App\Models\Evento;
use App\Models\Jurado;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConstanciaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $jurado = Jurado::where('id_usuario', $user->id_usuario)->first();

        // Obtener eventos donde el jurado está asignado
       $eventosInscritosIds = Evento::whereHas('jurados', function ($query) use ($user) {
            $query->where('id_jurado', $user->id_usuario);
        })->pluck('id_evento');

        $eventosTotalesInscritos = Evento::whereIn('id_evento', $eventosInscritosIds)
            ->where('estado', 'Finalizado')
            ->orderBy('fecha_inicio', 'desc')
            ->get();

        return view('jurado.constancias.index', compact('jurado', 'eventosTotalesInscritos'));
    }

    public function generarPdf(Evento $evento)
    {
        $user = Auth::user();
        $jurado = Jurado::where('id_usuario', $user->id_usuario)->first();

        // Verificar que el jurado esté asignado al evento
        if (!$evento->jurados->contains('id_usuario', $jurado->id_usuario)) {
            abort(403, 'No tienes permiso para generar la constancia de este evento o el evento no ha finalizado.');
        }

        $pdf = PDF::loadView('jurado.constancias.constancia-jurado', compact('evento', 'jurado', 'user'));
        return $pdf->stream();
    }
}