{{-- resources/views/users/edit.blade.php --}}
{{-- Formulario para editar datos y rol de un usuario --}}
<x-app-layout>
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h3 class="card-title mb-0">
                Editar usuario: <span class="text-primary">{{ $user->name }}</span>
            </h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('users.update', $user) }}">
                @csrf
                @method('PUT')

                {{-- Nombre --}}
                <div class="mb-3">
                    <label for="name" class="form-label fw-bold">Nombre completo</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                           class="form-control @error('name') is-invalid @enderror" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Correo --}}
                <div class="mb-3">
                    <label for="email" class="form-label fw-bold">Correo electrónico</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                           class="form-control @error('email') is-invalid @enderror" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Contraseña (opcional) con botón mostrar/ocultar --}}
                <div class="mb-3">
                    <label for="password" class="form-label fw-bold">Nueva contraseña</label>
                    <div class="input-group">
                        <input type="password" name="password" id="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="Dejar en blanco para no cambiar">
                        <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password')">
                            👁️
                        </button>
                    </div>
                    @error('password')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Confirmar contraseña con botón mostrar/ocultar --}}
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label fw-bold">Confirmar nueva contraseña</label>
                    <div class="input-group">
                        <input type="password" name="password_confirmation" id="password_confirmation"
                               class="form-control"
                               placeholder="Dejar en blanco para no cambiar">
                        <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password_confirmation')">
                            👁️
                        </button>
                    </div>
                </div>

                {{-- Selector de rol --}}
                <div class="mb-4">
                    <label for="role" class="form-label fw-bold">Rol asignado</label>
                    <select name="role" id="role" class="form-select @error('role') is-invalid @enderror">
                        <option value="">-- Sin rol --</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}"
                                    @if($user->hasRole($role->name)) selected @endif>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Botones --}}
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Guardar cambios
                    </button>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Script para mostrar/ocultar contraseña --}}
    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            if (input.type === 'password') {
                input.type = 'text';
            } else {
                input.type = 'password';
            }
        }
    </script>
</x-app-layout>