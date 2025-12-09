<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
//? modelos que cree
use Illuminate\Support\Facades\DB;
use App\Models\Estudiante;
use App\Models\TokenJurado;
use App\Models\Jurado;
use App\Models\CatCarrera;
use App\Models\CatRolSistema;
use App\Providers\RouteServiceProvider;
use Illuminate\Validation\ValidationException;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        //? Aqui jalo las carrera de la BD 
        $carreras = CatCarrera::all();
       return view('auth.register', compact('carreras'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nombre' => ['required', 'string', 'max:100', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/'],
            'app_paterno' => ['required', 'string', 'max:100', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/'],
            'app_materno' => ['nullable', 'string', 'max:100', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/'],
            'email' => ['required', 'string', 'email', 'max:150', 'unique:' . User::class, 'regex:/^[a-zA-Z0-9._%+-]+@(gmail\.com|hotmail\.com|outlook\.com|live\.com|yahoo\.com|edu\.mx|tec\.mx|itoaxaca\.edu\.mx)$/i'],
            'password' => ['required', 'confirmed', 'min:8', 'max:16', 'regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*#?&]{8,16}$/'],
            'tipo_registro' => ['required', 'in:estudiante,jurado'],
        ]);
        //? inicio de la trancción para nuestra validación que es especifica

        try {
            DB::beginTransaction(); // Inicia la transacción

            // A. Lógica para ESTUDIANTES
            if ($request->tipo_registro === 'estudiante') {
                // Validar datos extra del estudiante
                $request->validate([
                    'numero_control' => [
                        'required',
                        'string',
                        'max:20',
                        'unique:estudiantes',
                        'regex:/^[BC]?\d{8}$/', // Letra C o B opcional + exactamente 8 dígitos
                        function ($attribute, $value, $fail) use ($request) {
                            // Quitar letras para análisis
                            $numeros = preg_replace('/[^\d]/', '', $value);

                            if (strlen($numeros) !== 8) {
                                $fail($attribute . ' debe tener exactamente 8 dígitos (ej: 22161210 o B22161210).');
                                return;
                            }

                            // Validar año de inscripción (2 primeros dígitos)
                            $añoInscripcion = substr($numeros, 0, 2);
                            $añoActual = date('y');

                            // Convertir a año completo
                            $añoCompleto = ($añoInscripcion > $añoActual) ? '19' . $añoInscripcion : '20' . $añoInscripcion;
                            $añoCompletoActual = '20' . $añoActual;

                            // Validar que no sea un año futuro
                            if ($añoCompleto > $añoCompletoActual) {
                                $fail($attribute . ' contiene un año de inscripción inválido.');
                                return;
                            }

                            // Validar que no sea muy antiguo (ej: anterior a 2000)
                            if ($añoCompleto < 2000) {
                                $fail($attribute . ' contiene un año de inscripción muy antiguo (mínimo 2000).');
                                return;
                            }

                            // Validar código de plantel (dígitos 3-4 o 3-4)
                            $codigoPlantel = substr($numeros, 2, 2);
                            $codigoPlantelValido = in_array($codigoPlantel, ['10', '11', '12', '13', '14', '15', '16', '17', '18', '19']);

                            if (!$codigoPlantelValido) {
                                $fail($attribute . ' contiene un código de plantel inválido. Los códigos válidos son 10-19.');
                                return;
                            }

                            // Validar letra inicial (si tiene)
                            if (preg_match('/^[CB]/', $value)) {
                                $letra = strtoupper(substr($value, 0, 1));
                                if ($letra === 'C') {
                                    // Estudiante con convalidación
                                    // Aquí podrías agregar validaciones adicionales para convalidación
                                }
                            }
                        }
                    ],
                    'id_carrera' => ['required', 'exists:cat_carreras,id_carrera'],
                    'semestre' => ['required', 'integer', 'min:1', 'max:14'],
                ]);

                // Crear Usuario Padre
                $user = User::create([
                    'nombre' => $request->nombre,
                    'app_paterno' => $request->app_paterno,
                    'app_materno' => $request->app_materno, // Opcional
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'id_rol_sistema' => 3, // ID 3 = Estudiante (Hardcodeado por seguridad)
                    'activo' => true,
                ]);

                // Crear Estudiante Hijo
                Estudiante::create([
                    'id_usuario' => $user->id_usuario,
                    'numero_control' => $request->numero_control,
                    'id_carrera' => $request->id_carrera,
                    'semestre' => $request->semestre,
                ]);
            }

            // B. Lógica para JURADOS (Seguridad Máxima)
            elseif ($request->tipo_registro === 'jurado') {
                // Validar token
                $request->validate([
                    'token_acceso' => ['required', 'string'],
                    'especialidad' => ['required', 'string'],
                ]);

                // Verificar si el token es válido en la BD
                $tokenDb = TokenJurado::where('token', $request->token_acceso)
                    ->where('usado', false)
                    ->where('fecha_expiracion', '>', now())
                    ->first();

                if (!$tokenDb) {
                    throw ValidationException::withMessages([
                        'token_acceso' => 'El token de jurado es inválido, ha expirado o ya fue usado.',
                    ]);
                }

                // Si pasa, creamos el Usuario
                $user = User::create([
                    'nombre' => $request->nombre,
                    'app_paterno' => $request->app_paterno,
                    'app_materno' => $request->app_materno,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'id_rol_sistema' => 2, // ID 2 = Jurado
                    'activo' => true,
                ]);

                // Crear Jurado Hijo
                Jurado::create([
                    'id_usuario' => $user->id_usuario,
                    'especialidad' => $request->especialidad,
                    'empresa_institucion' => $request->empresa_institucion ?? 'Independiente',
                    'cedula_profesional' => $request->cedula_profesional,
                ]);

                // QUEMAR EL TOKEN (Para que no se pueda reusar)
                $tokenDb->update(['usado' => true]);
            }

            DB::commit(); // Si todo salió bien, guardamos cambios en BD

        } catch (\Exception $e) {
            DB::rollBack(); // Si algo falló, deshacemos TODO (incluso la creación del usuario)
            throw $e; // Re-lanzamos el error para que Laravel lo muestre
        }

        // $user = User::create([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'password' => Hash::make($request->password),
        // ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
