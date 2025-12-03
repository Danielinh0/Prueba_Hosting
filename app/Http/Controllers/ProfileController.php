<?php

namespace App\Http\Controllers;

use App\Models\CatCarrera;
use App\Models\Estudiante;
use App\Models\Jurado;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        $user = $request->user();
        $carreras = CatCarrera::all();
        
        return view('profile.edit', compact('user', 'carreras'));
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'app_paterno' => ['required', 'string', 'max:255'],
            'app_materno' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id_usuario . ',id_usuario'],
            'foto_perfil' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        if ($request->hasFile('foto_perfil')) {
            if ($user->foto_perfil) {
                Storage::disk('public')->delete($user->foto_perfil);
            }
            $validated['foto_perfil'] = $request->file('foto_perfil')->store('profile-photos', 'public');
        }

        $user->update($validated);

        return back()->with('status', 'profile-updated');
    }

    public function updateStudentInfo(Request $request)
    {
        $user = $request->user();
        
        if (!$user->estudiante) {
            return back()->withErrors(['error' => 'User is not a student']);
        }

        $validated = $request->validate([
            'numero_control' => ['required', 'string', 'max:20'],
            'id_carrera' => ['required', 'exists:cat_carreras,id_carrera'],
            'semestre' => ['required', 'integer', 'min:1', 'max:12'],
        ]);

        $user->estudiante()->update($validated);

        return back()->with('status', 'student-info-updated');
    }

    public function updateJuryInfo(Request $request)
    {
        $user = $request->user();
        
        if (!$user->jurado) {
            return back()->withErrors(['error' => 'User is not a jury']);
        }

        $validated = $request->validate([
            'especialidad' => ['nullable', 'string', 'max:255'],
            'empresa_institucion' => ['nullable', 'string', 'max:255'],
            'cedula_profesional' => ['nullable', 'string', 'max:50'],
        ]);

        $user->jurado()->update($validated);

        return back()->with('status', 'jury-info-updated');
    }

    public function destroy(Request $request)
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}