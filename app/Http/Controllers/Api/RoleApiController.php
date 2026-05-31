<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleApiController extends Controller
{
    /**
     * Listar todos los roles con sus permisos.
     * GET /api/roles
     */
    public function index()
    {
        $roles = Role::with('permissions')->get();
        return response()->json([
            'success' => true,
            'data' => $roles,
        ]);
    }

    /**
     * Ver un rol específico.
     * GET /api/roles/{id}
     */
    public function show(Role $role)
    {
        $role->load('permissions');
        return response()->json([
            'success' => true,
            'data' => $role,
        ]);
    }

    /**
     * Crear un nuevo rol.
     * POST /api/roles
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name',
            'permissions' => 'nullable|array',
        ]);

        $role = Role::create(['name' => $request->name]);
        $role->syncPermissions($request->permissions ?? []);

        return response()->json([
            'success' => true,
            'message' => 'Rol creado correctamente.',
            'data' => $role->load('permissions'),
        ], 201);
    }

    /**
     * Actualizar un rol existente.
     * PUT /api/roles/{id}
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name,' . $role->id,
            'permissions' => 'nullable|array',
        ]);

        $role->name = $request->name;
        $role->save();
        $role->syncPermissions($request->permissions ?? []);

        return response()->json([
            'success' => true,
            'message' => 'Rol actualizado correctamente.',
            'data' => $role->load('permissions'),
        ]);
    }

    /**
     * Eliminar un rol.
     * DELETE /api/roles/{id}
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return response()->json([
            'success' => true,
            'message' => 'Rol eliminado correctamente.',
        ]);
    }
}