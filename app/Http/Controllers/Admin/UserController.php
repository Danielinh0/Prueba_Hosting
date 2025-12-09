<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\CatRolSistema;
use App\Models\Estudiante;
use App\Models\Jurado;
use App\Models\MiembroEquipo;
use App\Services\UserValidationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    protected $validationService;

    public function __construct(UserValidationService $validationService)
    {
        $this->validationService = $validationService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Estadísticas
        $totalAdmins = User::where('id_rol_sistema', 1)->count();
        $totalJurados = User::where('id_rol_sistema', 2)->count();
        $totalEstudiantes = User::where('id_rol_sistema', 3)->count();

        // Query para usuarios
        $query = User::with('rolSistema');

        // Búsqueda
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nombre', 'like', '%' . $searchTerm . '%')
                  ->orWhere('app_paterno', 'like', '%' . $searchTerm . '%')
                  ->orWhere('app_materno', 'like', '%' . $searchTerm . '%')
                  ->orWhere('email', 'like', '%' . $searchTerm . '%');
            });
        }

        // Filtro por rol
        if ($request->filled('rol')) {
            $query->where('id_rol_sistema', $request->input('rol'));
        }

        $usuarios = $query->orderBy('nombre')->paginate(15);
        $roles = CatRolSistema::all();

        return view('admin.users.index', compact(
            'usuarios', 
            'roles',
            'totalAdmins',
            'totalJurados',
            'totalEstudiantes'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $user->load('estudiante.carrera', 'jurado');
        $roles = CatRolSistema::all();
        
        // Obtener tipo de rol actual
        $currentRoleType = $this->validationService->getCurrentRoleType($user);
        
        return view('admin.users.edit', compact('user', 'roles', 'currentRoleType'));
    }

    /**
     * Validar cambio de rol via AJAX
     */
    public function checkRoleChange(Request $request, User $user)
    {
        $newRoleId = $request->input('new_role_id');
        $newRole = CatRolSistema::find($newRoleId);
        
        if (!$newRole) {
            return response()->json(['error' => 'Rol no encontrado'], 404);
        }

        $currentRoleType = $this->validationService->getCurrentRoleType($user);
        $newRoleType = strtolower($newRole->nombre);

        // Si el rol no cambia, no hay problema
        if ($user->id_rol_sistema == $newRoleId) {
            return response()->json(['canChange' => true, 'reasons' => []]);
        }

        // Validar según el tipo de cambio
        if ($currentRoleType === 'estudiante' && in_array($newRoleType, ['jurado', 'admin'])) {
            $result = $this->validationService->canChangeStudentRole($user);
        } elseif ($currentRoleType === 'jurado' && $newRoleType === 'estudiante') {
            $result = $this->validationService->canChangeJuradoToStudent($user);
        } else {
            // Otros cambios permitidos sin restricción
            $result = ['canChange' => true, 'reasons' => []];
        }

        return response()->json($result);
    }

    /**
     * Validar eliminación de usuario via AJAX
     */
    public function checkDelete(User $user)
    {
        $currentRoleType = $this->validationService->getCurrentRoleType($user);

        if ($currentRoleType === 'estudiante') {
            $result = $this->validationService->canDeleteStudent($user);
        } elseif ($currentRoleType === 'jurado') {
            $result = $this->validationService->canDeleteJurado($user);
        } else {
            // Admin puede eliminarse si no es el último
            $adminCount = User::where('id_rol_sistema', 1)->where('activo', true)->count();
            if ($adminCount <= 1) {
                $result = [
                    'canDelete' => false,
                    'reasons' => [[
                        'type' => 'ultimo_admin',
                        'message' => 'No se puede eliminar el único administrador del sistema',
                        'icon' => 'shield-alt',
                        'severity' => 'error'
                    ]]
                ];
            } else {
                $result = ['canDelete' => true, 'reasons' => []];
            }
        }

        return response()->json($result);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'app_paterno' => 'required|string|max:100',
            'app_materno' => 'nullable|string|max:100',
            'email' => 'required|email|max:150|unique:users,email,' . $user->id_usuario . ',id_usuario',
            'id_rol_sistema' => 'required|exists:cat_roles_sistema,id_rol_sistema',
            'numero_control' => 'nullable|string|max:20',
            'semestre' => 'nullable|integer|min:1',
            'especialidad' => 'nullable|string|max:100',
        ]);

        $oldRoleId = $user->id_rol_sistema;
        $newRoleId = $validated['id_rol_sistema'];

        // Validar cambio de rol si aplica
        if ($oldRoleId != $newRoleId) {
            $currentRoleType = $this->validationService->getCurrentRoleType($user);
            $newRole = CatRolSistema::find($newRoleId);
            $newRoleType = strtolower($newRole->nombre);

            if ($currentRoleType === 'estudiante' && in_array($newRoleType, ['jurado', 'admin'])) {
                $validation = $this->validationService->canChangeStudentRole($user);
                if (!$validation['canChange']) {
                    return back()->withErrors(['id_rol_sistema' => 'No se puede cambiar el rol. Revise las restricciones activas.']);
                }
            } elseif ($currentRoleType === 'jurado' && $newRoleType === 'estudiante') {
                $validation = $this->validationService->canChangeJuradoToStudent($user);
                if (!$validation['canChange']) {
                    return back()->withErrors(['id_rol_sistema' => 'No se puede cambiar el rol. Revise las restricciones activas.']);
                }
            }
        }

        DB::beginTransaction();
        try {
            // Manejar cambio de subclase si el rol cambió
            if ($oldRoleId != $newRoleId) {
                $currentRoleType = $this->validationService->getCurrentRoleType($user);
                $newRole = CatRolSistema::find($newRoleId);
                $newRoleName = strtolower($newRole->nombre);

                // Eliminar registro de subclase anterior
                if ($currentRoleType === 'estudiante' && $user->estudiante) {
                    // Eliminar de miembros_equipo primero (si hay alguno en eventos finalizados)
                    MiembroEquipo::where('id_estudiante', $user->id_usuario)->delete();
                    $user->estudiante->delete();
                } elseif ($currentRoleType === 'jurado' && $user->jurado) {
                    $user->jurado->delete();
                }

                // Crear registro de nueva subclase
                if ($newRoleName === 'estudiante') {
                    Estudiante::create([
                        'id_usuario' => $user->id_usuario,
                        'numero_control' => $validated['numero_control'] ?? 'PENDIENTE',
                        'semestre' => $validated['semestre'] ?? 1,
                        'id_carrera' => 1, // Carrera por defecto, debe editarse después
                    ]);
                } elseif ($newRoleName === 'jurado') {
                    Jurado::create([
                        'id_usuario' => $user->id_usuario,
                        'especialidad' => $validated['especialidad'] ?? null,
                        'empresa_institucion' => null,
                        'cedula_profesional' => null,
                    ]);
                }
                // Si es Admin, no necesita registro de subclase
            } else {
                // Si el rol no cambió, actualizar datos de subclase existente
                if ($user->estudiante && $request->filled('numero_control')) {
                    $user->estudiante->update([
                        'numero_control' => $validated['numero_control'],
                        'semestre' => $validated['semestre'],
                    ]);
                } elseif ($user->jurado && $request->filled('especialidad')) {
                    $user->jurado->update([
                        'especialidad' => $validated['especialidad'],
                    ]);
                }
            }

            // Actualizar el modelo User
            $user->update([
                'nombre' => $validated['nombre'],
                'app_paterno' => $validated['app_paterno'],
                'app_materno' => $validated['app_materno'],
                'email' => $validated['email'],
                'id_rol_sistema' => $validated['id_rol_sistema'],
            ]);

            DB::commit();
            return redirect()->route('admin.users.edit', $user)->with('success', 'Usuario actualizado exitosamente. ' . ($oldRoleId != $newRoleId ? 'Rol cambiado correctamente.' : ''));
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al actualizar: ' . $e->getMessage()]);
        }
    }

    /**
     * Transferir liderazgo antes de eliminar
     */
    public function transferLeadership(Request $request, User $user)
    {
        $validated = $request->validate([
            'transfers' => 'required|array',
            'transfers.*.inscripcion_id' => 'required|integer',
            'transfers.*.nuevo_lider_id' => 'required|integer',
        ]);

        DB::beginTransaction();
        try {
            foreach ($validated['transfers'] as $transfer) {
                $this->validationService->transferLeadership(
                    $transfer['inscripcion_id'],
                    $transfer['nuevo_lider_id']
                );
            }
            
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Liderazgos transferidos correctamente.']);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage (Soft Delete).
     */
    public function destroy(User $user)
    {
        $currentRoleType = $this->validationService->getCurrentRoleType($user);

        // Validar antes de eliminar
        if ($currentRoleType === 'estudiante') {
            $validation = $this->validationService->canDeleteStudent($user);
            if (!$validation['canDelete']) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede eliminar el usuario.',
                    'reasons' => $validation['reasons']
                ], 422);
            }
            
            // Si requiere transferencia y no se ha hecho, bloquear
            if ($validation['requiresLeadershipTransfer']) {
                return response()->json([
                    'success' => false,
                    'message' => 'Debe transferir los liderazgos antes de eliminar.',
                    'requiresLeadershipTransfer' => true,
                    'leadershipInfo' => $validation['leadershipInfo']
                ], 422);
            }
        } elseif ($currentRoleType === 'jurado') {
            $validation = $this->validationService->canDeleteJurado($user);
            if (!$validation['canDelete']) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede eliminar el jurado.',
                    'reasons' => $validation['reasons']
                ], 422);
            }
        } else {
            // Verificar que no sea el último admin
            $adminCount = User::where('id_rol_sistema', 1)->where('activo', true)->count();
            if ($adminCount <= 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede eliminar el único administrador.'
                ], 422);
            }
        }

        // Soft delete: marcar como inactivo
        $user->update(['activo' => false]);

        return response()->json([
            'success' => true,
            'message' => 'Usuario desactivado correctamente.'
        ]);
    }
}

