<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthApiController extends Controller
{
    /**
     * Iniciar sesión y obtener token.
     * POST /api/login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        // Verificar credenciales
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Las credenciales son incorrectas.'],
            ]);
        }

        // Verificar si el usuario está activo
        if (!$user->estado) {
            return response()->json([
                'success' => false,
                'message' => 'Tu cuenta está inactiva. Contacta al administrador.',
            ], 403);
        }

        // Eliminar tokens anteriores (opcional, para tener uno solo por sesión)
        $user->tokens()->delete();

        // Crear nuevo token
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Inicio de sesión exitoso.',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'estado' => $user->estado,
                    'roles' => $user->roles->pluck('name'),
                ],
                'token' => $token,
            ],
        ]);
    }

    /**
     * Cerrar sesión (revocar token actual).
     * POST /api/logout
     */
    public function logout(Request $request)
    {
        // Revocar el token actual
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Sesión cerrada correctamente.',
        ]);
    }

    /**
     * Obtener datos del usuario autenticado.
     * GET /api/me
     */
    public function me(Request $request)
    {
        $user = $request->user();
        $user->load('roles.permissions');

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'estado' => $user->estado,
                'roles' => $user->roles->pluck('name'),
                'permissions' => $user->getAllPermissions()->pluck('name'),
            ],
        ]);
    }
}