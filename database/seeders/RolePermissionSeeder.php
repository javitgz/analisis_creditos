<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lista de permisos del sistema
        $permisos = [
            'ver dashboard',
            'crear usuarios',
            'editar usuarios',
            'eliminar usuarios',
            'ver usuarios',
            'crear clientes',
            'editar clientes',
            'eliminar clientes',
            'ver clientes',
            'gestionar roles',
        ];

        // Crear permisos si no existen
        foreach ($permisos as $permiso) {
            Permission::firstOrCreate(['name' => $permiso]);
        }

        // Crear rol administrador y asignarle todos los permisos
        $adminRole = Role::firstOrCreate(['name' => 'administrador']);
        $adminRole->syncPermissions(Permission::all());
    }
}