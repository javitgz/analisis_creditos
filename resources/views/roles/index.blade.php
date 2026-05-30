{{-- resources/views/roles/index.blade.php --}}
<x-app-layout>
    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">Gestión de Roles</h3>
            <a href="{{ route('roles.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Nuevo Rol
            </a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

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
                                        Editar
                                    </a>
                                    <form action="{{ route('roles.destroy', $role) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('¿Eliminar el rol \'{{ $role->name }}\'?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-4">
                                    No hay roles creados.
                                    <a href="{{ route('roles.create') }}" class="ms-1">Crear el primero</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>