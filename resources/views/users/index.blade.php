{{-- resources/views/users/index.blade.php --}}
{{-- Vista unificada de Usuarios y Roles con pestañas Bootstrap --}}
<x-app-layout>
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h3 class="card-title mb-0">Administración de Usuarios y Roles</h3>
        </div>
        <div class="card-body">
            {{-- Mensajes --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Navegación de pestañas --}}
            <ul class="nav nav-tabs mb-4" id="usuariosTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="usuarios-tab" data-bs-toggle="tab" 
                            data-bs-target="#usuarios" type="button" role="tab" 
                            aria-controls="usuarios" aria-selected="true">
                        👥 Usuarios
                    </button>
                </li>
                @can('gestionar roles')
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="roles-tab" data-bs-toggle="tab" 
                            data-bs-target="#roles" type="button" role="tab" 
                            aria-controls="roles" aria-selected="false">
                        🔑 Roles
                    </button>
                </li>
                @endcan
            </ul>

            {{-- Contenido de las pestañas --}}
            <div class="tab-content" id="usuariosTabsContent">
                {{-- Pestaña Usuarios --}}
                <div class="tab-pane fade show active" id="usuarios" role="tabpanel" aria-labelledby="usuarios-tab">
                    @can('ver usuarios')
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="mb-0">Listado de Usuarios</h4>
                            <a href="{{ route('users.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle"></i> Nuevo Usuario
                            </a>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Correo electrónico</th>
                                        <th>Rol</th>
                                        <th class="text-center">Estado</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($users as $user)
                                        <tr>
                                            <td class="fw-semibold">{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                @forelse($user->roles as $role)
                                                    <span class="badge bg-info text-dark">{{ $role->name }}</span>
                                                @empty
                                                    <span class="text-muted small">Sin rol</span>
                                                @endforelse
                                            </td>
                                            <td class="text-center">
                                                <form action="{{ route('users.toggle-estado', $user) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm border-0"
                                                            title="{{ $user->estado ? 'Desactivar' : 'Activar' }}">
                                                        @if($user->estado)
                                                            <span class="text-success fs-5">🔓</span>
                                                        @else
                                                            <span class="text-danger fs-5">🔒</span>
                                                        @endif
                                                    </button>
                                                </form>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-warning me-1">
                                                    <i class="bi bi-pencil"></i> Editar
                                                </a>
                                                <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline"
                                                      onsubmit="return confirm('¿Eliminar al usuario \'{{ $user->name }}\'?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="bi bi-trash"></i> Eliminar
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">
                                                No hay usuarios registrados.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            No tienes permisos para ver usuarios.
                        </div>
                    @endcan
                </div>

                {{-- Pestaña Roles --}}
                @can('gestionar roles')
                <div class="tab-pane fade" id="roles" role="tabpanel" aria-labelledby="roles-tab">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="mb-0">Listado de Roles</h4>
                        <a href="{{ route('roles.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Nuevo Rol
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Nombre</th>
                                    <th>Permisos</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($roles as $role)
                                    <tr>
                                        <td class="fw-semibold">{{ $role->name }}</td>
                                        <td>
                                            @forelse($role->permissions as $perm)
                                                <span class="badge bg-info text-dark me-1">{{ $perm->name }}</span>
                                            @empty
                                                <span class="text-muted">Sin permisos</span>
                                            @endforelse
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('roles.edit', $role) }}" class="btn btn-sm btn-warning me-1">
                                                <i class="bi bi-pencil"></i> Editar
                                            </a>
                                            <form action="{{ route('roles.destroy', $role) }}" method="POST" class="d-inline"
                                                  onsubmit="return confirm('¿Eliminar el rol \'{{ $role->name }}\'?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash"></i> Eliminar
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-4">
                                            No hay roles creados.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @endcan
            </div>
        </div>
        {{-- Script para activar la pestaña correcta según el parámetro URL --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const urlParams = new URLSearchParams(window.location.search);
        const tab = urlParams.get('tab');
        if (tab === 'roles') {
            // Activar pestaña Roles
            const rolesTab = document.getElementById('roles-tab');
            const usuariosTab = document.getElementById('usuarios-tab');
            const rolesPane = document.getElementById('roles');
            const usuariosPane = document.getElementById('usuarios');

            // Desactivar pestaña Usuarios
            usuariosTab.classList.remove('active');
            usuariosTab.setAttribute('aria-selected', 'false');
            usuariosPane.classList.remove('show', 'active');

            // Activar pestaña Roles
            rolesTab.classList.add('active');
            rolesTab.setAttribute('aria-selected', 'true');
            rolesPane.classList.add('show', 'active');
        }
    });
</script>
    </div>
</x-app-layout>