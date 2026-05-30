{{-- resources/views/users/index.blade.php --}}
{{-- Listado de usuarios con sus roles, estado y acciones --}}
<x-app-layout>
    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">Gestión de Usuarios</h3>
            <a href="{{ route('users.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Nuevo Usuario
            </a>
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

            {{-- Tabla de usuarios --}}
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
                                        <span class="badge bg-info text-dark me-1">{{ $role->name }}</span>
                                    @empty
                                        <span class="text-muted small">Sin rol asignado</span>
                                    @endforelse
                                </td>
                                <td class="text-center">
                                    {{-- Botón de toggle estado --}}
                                    <form action="{{ route('users.toggle-estado', $user) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm border-0" 
                                                title="{{ $user->estado ? 'Desactivar usuario' : 'Activar usuario' }}">
                                            @if($user->estado)
                                                {{-- Candado abierto verde --}}
                                                <span class="text-success fs-5">🔓</span>
                                            @else
                                                {{-- Candado cerrado rojo --}}
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
                                          onsubmit="return confirm('¿Eliminar al usuario \'{{ $user->name }}\'? Esta acción no se puede deshacer.')">
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
        </div>
    </div>
</x-app-layout>