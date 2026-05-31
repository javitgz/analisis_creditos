<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserApiController extends Controller
{
    /**
     * Listar todos los usuarios con sus roles.
     * GET /api/users
     */
    public function index()
    {
        $users = User::with('roles')->orderBy('created_at', 'desc')->get();
        return response()->json([
            'success' => true,
            'data' => $users,
        ]);
    }

    /**
     * Ver un usuario específico.
     * GET /api/users/{id}
     */
    public function show(User $user)
    {
        $user->load('roles');
        return response()->json([
            'success' => true,
            'data' => $user,
        ]);
    }

    /**
     * Crear un nuevo usuario.
     * POST /api/users
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'nullable|string|exists:roles,name',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'estado' => 0,
        ]);

        if ($request->role) {
            $user->syncRoles([$request->role]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Usuario creado correctamente.',
            'data' => $user->load('roles'),
        ], 201);
    }

    /**
     * Actualizar un usuario existente.
     * PUT /api/users/{id}
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => 'nullable|string|min:8',
            'role' => 'nullable|string|exists:roles,name',
            'estado' => 'nullable|boolean',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->has('estado')) {
            $user->estado = $request->estado;
        }

        $user->save();

        if ($request->has('role')) {
            $user->syncRoles($request->role ? [$request->role] : []);
        }

        return response()->json([
            'success' => true,
            'message' => 'Usuario actualizado correctamente.',
            'data' => $user->load('roles'),
        ]);
    }

    /**
     * Eliminar un usuario.
     * DELETE /api/users/{id}
     */
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'No puedes eliminar tu propio usuario.',
            ], 403);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Usuario eliminado correctamente.',
        ]);
    }

    /**
     * Activar/desactivar usuario.
     * PATCH /api/users/{id}/toggle-estado
     */
    public function toggleEstado(User $user)
    {
        if ($user->id === auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'No puedes cambiar tu propio estado.',
            ], 403);
        }

        $user->estado = !$user->estado;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Estado actualizado correctamente.',
            'data' => $user->load('roles'),
        ]);
    }
}