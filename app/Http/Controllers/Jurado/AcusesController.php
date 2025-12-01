<?php

namespace App\Http\Controllers\Jurado;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AcusesController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $jurado = $user->jurado;
        $eventos = $jurado ? $jurado->eventos : collect();

        return view('jurado.acuses.Acuses', compact('eventos'));
    }
}
