{{-- resources/views/auth/register.blade.php --}}
{{-- Página de registro con Bootstrap 5 --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('images/icon.png') }}">
    <title>Registro - {{ config('app.name', 'SIACRE') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="d-flex align-items-center justify-content-center vh-100" style="background-color: #0a1f44;">
    <div class="card shadow" style="width: 100%; max-width: 420px;">
        <div class="card-body p-4">
            {{-- Logo --}}
            <div class="text-center">
                <img src="{{ asset('images/logo-oscuro.png') }}" alt="Logo" 
                     style="width: 200px; height: 200px; object-fit: contain;">
                <p class="text-muted small">Crear nueva cuenta</p>
            </div>

            {{-- Errores --}}
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Nombre completo</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" 
                           class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Correo electrónico</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" 
                           class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirmar contraseña</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" 
                           class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-3">Crear cuenta</button>

                <div class="text-center">
                    <span class="text-muted small">¿Ya tienes cuenta?</span>
                    <a href="{{ route('login') }}" class="small ms-1">Iniciar sesión</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>