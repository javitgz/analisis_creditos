<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear o actualizar el usuario administrador
        $admin = User::firstOrCreate(
            ['email' => 'admin@siacre.com'],
            [
                'name' => 'Administrador del Sistema',
                'password' => bcrypt('Admin1234'),
                'estado' => 1,
            ]
        );

        // Asignar el rol administrador (ya debe existir por el RolePermissionSeeder)
        $adminRole = Role::where('name', 'administrador')->first();
        if ($adminRole && !$admin->hasRole('administrador')) {
            $admin->assignRole('administrador');
        }
    }
}