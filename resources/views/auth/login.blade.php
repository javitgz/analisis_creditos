<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('images/icon.png') }}">
    <title>Iniciar sesión - {{ config('app.name', 'SIACRE') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="d-flex align-items-center justify-content-center vh-100" style="background-color: #0a1f44;">
    <div class="card shadow" style="width: 100%; max-width: 420px;">
        <div class="card-body p-4">
            {{-- Logo y nombre de la app --}}
            <div class="text-center">
                <img src="{{ asset('images/logo-oscuro.png') }}" alt="Logo" 
                     style="width: 200px; height: 200px; object-fit: contain;">
                <p class="text-muted small">Iniciar sesión</p>
            </div>

            {{-- Errores de validación --}}
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error:</strong> Credenciales incorrectas.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Estado de sesión --}}
            @if(session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Formulario de inicio de sesión --}}
            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email --}}
                <div class="mb-3">
                    <label for="email" class="form-label">Correo electrónico</label>
                    <input type="email" name="email" id="email" 
                           value="{{ old('email') }}" 
                           class="form-control @error('email') is-invalid @enderror" 
                           placeholder="ejemplo@correo.com" required autofocus>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Contraseña --}}
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" name="password" id="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           placeholder="••••••••" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Recordarme --}}
                <div class="mb-3 form-check">
                    <input type="checkbox" name="remember" id="remember" class="form-check-input">
                    <label for="remember" class="form-check-label">Mantener sesión iniciada</label>
                </div>

                {{-- Botón de inicio de sesión --}}
                <button type="submit" class="btn btn-primary w-100 mb-3">
                    <i class="bi bi-box-arrow-in-right"></i> Iniciar sesión
                </button>

                {{-- Enlace a registro --}}
                @if(Route::has('register'))
                    <div class="text-center">
                        <span class="text-muted small">¿No tienes cuenta?</span>
                        <a href="{{ route('register') }}" class="small ms-1">Registrarse</a>
                    </div>
                @endif
            </form>
        </div>
    </div>
</body>
</html>