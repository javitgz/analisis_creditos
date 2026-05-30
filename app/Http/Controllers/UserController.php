<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Lista todos los usuarios con sus roles.
     */
    public function index()
    {
        $users = User::with('roles')->orderBy('created_at', 'desc')->get();
        $roles = \Spatie\Permission\Models\Role::with('permissions')->get();
        return view('users.index', compact('users', 'roles'));
    }

    /**
     * Muestra el formulario para crear un nuevo usuario.
     */
    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    /**
     * Guarda un nuevo usuario en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'nullable|string|exists:roles,name',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'estado' => 0, // <-- siempre se crea inactivo
        ]);

        // Asignar rol si se seleccionó uno
        if ($request->role) {
            $user->syncRoles([$request->role]);
        }

        return redirect()->route('users.index')
                         ->with('success', "Usuario {$user->name} creado correctamente. Estado: Inactivo.");
    }

    /**
     * Muestra el formulario para editar un usuario.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Actualiza los datos y el rol de un usuario.
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
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'nullable|string|exists:roles,name',
        ]);

        // Actualizar datos básicos
        $user->name = $request->name;
        $user->email = $request->email;

        // Solo actualizar contraseña si se ingresó una nueva
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Sincronizar rol
        $user->syncRoles($request->role ? [$request->role] : []);

        return redirect()->route('users.index')
                         ->with('success', "Usuario {$user->name} actualizado correctamente.");
    }

    /**
     * Activa o desactiva un usuario.
     */
    public function toggleEstado(User $user)
    {
        // Evitar que un usuario se desactive a sí mismo
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')
                             ->with('error', 'No puedes cambiar tu propio estado.');
        }

        $user->estado = !$user->estado;
        $user->save();

        $estadoTexto = $user->estado ? 'activado' : 'desactivado';

        return redirect()->route('users.index')
                         ->with('success', "Usuario {$user->name} {$estadoTexto} correctamente.");
    }

    /**
     * Elimina un usuario del sistema.
     */
    public function destroy(User $user)
    {
        // Evitar que un usuario se elimine a sí mismo
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')
                             ->with('error', 'No puedes eliminar tu propio usuario.');
        }

        $user->delete();

        return redirect()->route('users.index')
                         ->with('success', "Usuario {$user->name} eliminado correctamente.");
    }
}