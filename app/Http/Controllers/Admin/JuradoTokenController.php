<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TokenJurado;
use App\Mail\JuradoInvitacionToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class JuradoTokenController extends Controller
{
    /**
     * Muestra el formulario para generar y enviar tokens de jurado
     */
    public function create()
    {
        $tokens = TokenJurado::orderBy('id_token', 'desc')->get();
        return view('admin.jurado-tokens.create', compact('tokens'));
    }

    /**
     * Genera el token y envía el correo de invitación
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre_destinatario' => [
                'required',
                'string',
                'max:100',
                'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/'
            ],
            'apellido_paterno' => [
                'required',
                'string',
                'max:100',
                'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/'
            ],
            'apellido_materno' => [
                'nullable',
                'string',
                'max:100',
                'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/'
            ],
            'email' => [
                'required',
                'email',
                'max:150'
            ],
            'dias_vigencia' => [
                'required',
                'integer',
                'min:1',
                'max:90'
            ]
        ], [
            'nombre_destinatario.required' => 'El nombre es obligatorio.',
            'nombre_destinatario.regex' => 'El nombre solo puede contener letras y acentos.',
            'apellido_paterno.required' => 'El apellido paterno es obligatorio.',
            'apellido_paterno.regex' => 'El apellido paterno solo puede contener letras y acentos.',
            'apellido_materno.regex' => 'El apellido materno solo puede contener letras y acentos.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Ingrese un correo electrónico válido.',
            'dias_vigencia.required' => 'Los días de vigencia son obligatorios.',
            'dias_vigencia.min' => 'La vigencia mínima es de 1 día.',
            'dias_vigencia.max' => 'La vigencia máxima es de 90 días.'
        ]);

        try {
            DB::beginTransaction();

            // Generar token único
            $token = $this->generarTokenUnico();

            // Calcular fecha de expiración
            $diasVigencia = (int) $request->dias_vigencia;
            $fechaExpiracion = now()->addDays($diasVigencia);

            // Guardar token en la base de datos
            $tokenJurado = TokenJurado::create([
                'token' => $token,
                'fecha_expiracion' => $fechaExpiracion,
                'usado' => false,
                'email_invitado' => $request->email,
                'nombre_destinatario' => $request->nombre_destinatario,
                'apellido_paterno' => $request->apellido_paterno,
                'apellido_materno' => $request->apellido_materno,
                'creado_por' => auth()->id()
            ]);

            // Preparar datos para el correo
            $nombreCompleto = trim($request->nombre_destinatario . ' ' . $request->apellido_paterno . ' ' . $request->apellido_materno);
            $nombreCorto = trim($request->nombre_destinatario . ' ' . $request->apellido_paterno);
            $datosCorreo = [
                'nombre_completo' => $nombreCompleto,
                'nombre_corto' => $nombreCorto,
                'email' => $request->email,
                'especialidad' => 'Por definir',
                'empresa' => 'Por definir',
                'mensaje' => 'Bienvenido al sistema de evaluación.',
                'token' => $token,
                'fecha_expiracion' => $fechaExpiracion->format('d/m/Y'),
                'dias_vigencia' => $request->dias_vigencia,
                'eventos' => '',
                'url_registro' => route('register') . '?tipo=jurado&token=' . $token
            ];

            // Enviar correo
            Mail::to($request->email)
                ->send(new JuradoInvitacionToken($datosCorreo));

            DB::commit();

            return redirect()
                ->route('admin.jurado-tokens.create')
                ->with('success', 'Token generado y enviado correctamente a ' . $request->email)
                ->with('token', $token);

        } catch (\Exception $e) {
            DB::rollBack();

            // Log del error para debugging
            Log::error('Error al generar token de jurado: ' . $e->getMessage(), [
                'request_data' => $request->except(['password']),
                'exception' => $e
            ]);

            throw ValidationException::withMessages([
                'general' => 'Ocurrió un error al generar el token. Por favor, inténtelo nuevamente. Error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Genera un token único asegurándose que no exista en la BD
     */
    private function generarTokenUnico(): string
    {
        do {
            // Generar token con formato: JUR-XXXXXXXXXXXX
            $token = 'JUR-' . strtoupper(Str::random(12));
        } while (TokenJurado::where('token', $token)->exists());

        return $token;
    }

    /**
     * Muestra el listado de tokens generados
     */
    public function index(Request $request)
    {
        $tokens = TokenJurado::with(['creador'])
            ->orderBy('created_at', 'desc')
            ->when($request->search, function($query, $search) {
                $query->where(function($q) use ($search) {
                    $q->where('nombre_destinatario', 'like', "%{$search}%")
                      ->orWhere('apellido_paterno', 'like', "%{$search}%")
                      ->orWhere('email_destinatario', 'like', "%{$search}%")
                      ->orWhere('token', 'like', "%{$search}%");
                });
            })
            ->when($request->estado, function($query, $estado) {
                if ($estado === 'usados') {
                    $query->where('usado', true);
                } elseif ($estado === 'vigentes') {
                    $query->where('usado', false)
                          ->where('fecha_expiracion', '>', now());
                } elseif ($estado === 'expirados') {
                    $query->where('fecha_expiracion', '<', now())
                          ->where('usado', false);
                }
            })
            ->paginate(15);

        return view('admin.jurado-tokens.index', compact('tokens'));
    }

    /**
     * Revoca un token (lo marca como usado)
     */
    public function revocar(TokenJurado $token)
    {
        if ($token->usado) {
            return back()->with('error', 'Este token ya ha sido utilizado.');
        }

        $token->update(['usado' => true]);

        return back()->with('success', 'Token revocado correctamente.');
    }

    /**
     * Extiende la vigencia de un token
     */
    public function extender(Request $request, TokenJurado $token)
    {
        $request->validate([
            'dias_adicionales' => 'required|integer|min:1|max:90'
        ]);

        if ($token->usado) {
            return back()->with('error', 'No se puede extender la vigencia de un token ya utilizado.');
        }

        $diasAdicionales = (int) $request->dias_adicionales;
        $nuevaFecha = $token->fecha_expiracion->addDays($diasAdicionales);
        $token->update(['fecha_expiracion' => $nuevaFecha]);

        return back()->with('success', 'Vigencia del token extendida hasta el ' . $nuevaFecha->format('d/m/Y'));
    }

    /**
     * Reenvía el correo del token
     */
    public function reenviar(TokenJurado $token)
    {
        if ($token->usado) {
            return back()->with('error', 'No se puede reenviar un token ya utilizado.');
        }

        if ($token->fecha_expiracion < now()) {
            return back()->with('error', 'No se puede reenviar un token expirado.');
        }

        try {
            $datosCorreo = [
                'nombre_completo' => trim($token->nombre_destinatario . ' ' . $token->apellido_paterno . ' ' . $token->apellido_materno),
                'email' => $token->email_destinatario,
                'especialidad' => $token->especialidad_sugerida,
                'empresa' => $token->empresa_institucion,
                'mensaje' => $token->mensaje_personalizado,
                'token' => $token->token,
                'fecha_expiracion' => $token->fecha_expiracion->format('d/m/Y'),
                'dias_vigencia' => now()->diffInDays($token->fecha_expiracion),
                'eventos' => $token->eventos_asignar,
                'url_registro' => route('register') . '?tipo=jurado&token=' . $token->token
            ];

            Mail::to($token->email_invitado)
                ->send(new JuradoInvitacionToken($datosCorreo));

            return back()->with('success', 'Correo reenviado correctamente a ' . $token->email_invitado);

        } catch (\Exception $e) {
            Log::error('Error al reenviar token: ' . $e->getMessage());
            return back()->with('error', 'Error al reenviar el correo: ' . $e->getMessage());
        }
    }
}