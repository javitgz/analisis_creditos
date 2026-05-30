{{-- resources/views/roles/edit.blade.php --}}
<x-app-layout>
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h3 class="card-title mb-0">Editar Rol: <span class="text-primary">{{ $role->name }}</span></h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('roles.update', $role) }}">
                @csrf @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Nombre del rol</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $role->name) }}" 
                           class="form-control" required>
                    @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Permisos</label>
                    <div class="row">
                        @foreach($permissions as $permiso)
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[]" value="{{ $permiso->name }}" 
                                           class="form-check-input" id="perm_{{ $loop->index }}"
                                           @if($role->permissions->contains('name', $permiso->name)) checked @endif>
                                    <label class="form-check-label" for="perm_{{ $loop->index }}">
                                        {{ $permiso->name }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @error('permissions') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Actualizar Rol
                    </button>
                    <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>