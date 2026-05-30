{{-- resources/views/roles/create.blade.php --}}
<x-app-layout>
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h3 class="card-title mb-0">Crear Nuevo Rol</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('roles.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nombre del rol</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control" required>
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
                                           @if(is_array(old('permissions')) && in_array($permiso->name, old('permissions'))) checked @endif>
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
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle"></i> Guardar Rol
                    </button>
                    {{-- CORREGIDO: Cancelar redirige a users.index con tab=roles --}}
                    <a href="{{ route('users.index', ['tab' => 'roles']) }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>