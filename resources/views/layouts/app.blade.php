{{-- resources/views/layouts/app.blade.php --}}
{{-- Layout principal con sidebar usando Bootstrap 5 --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('images/icon.png') }}">
    <title>@yield('title', config('app.name', 'SIACRE'))</title>
    {{-- Bootstrap via Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="d-flex vh-100">
        {{-- SIDEBAR --}}
        <aside class="d-flex flex-column flex-shrink-0 text-white bg-dark" style="width: 260px;">
            {{-- Cabecera --}}
            <div class="text-center py-4 border-bottom border-secondary">
                <span class="fs-5 fw-bold">{{ config('app.name', 'SIACRE') }}</span>
            </div>

            {{-- Navegación --}}
            <nav class="flex-grow-1 px-3 py-3">
                <ul class="nav nav-pills flex-column">
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" 
                           class="nav-link text-white {{ request()->routeIs('dashboard') ? 'active bg-primary' : '' }}">
                            📊 Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('roles.index') }}" 
                           class="nav-link text-white {{ request()->routeIs('roles.*') ? 'active bg-primary' : '' }}">
                            🔑 Roles
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('users.index') }}" 
                           class="nav-link text-white {{ request()->routeIs('users.*') ? 'active bg-primary' : '' }}">
                            👥 Usuarios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('clients.index') }}" 
                           class="nav-link text-white {{ request()->routeIs('clients.*') ? 'active bg-primary' : '' }}">
                            🏢 Clientes
                        </a>
                    </li>
                </ul>
            </nav>

            {{-- Footer con usuario --}}
            <div class="border-top border-secondary p-3 mt-auto">
                <div class="d-flex align-items-center text-white mb-2">
                    <div class="flex-shrink-0">
                        <svg class="bi bi-person-circle" width="32" height="32" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                            <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                        </svg>
                    </div>
                    <div class="ms-2">
                        <div class="fw-semibold small">{{ auth()->user()->name }}</div>
                        <div class="small text-secondary">{{ auth()->user()->email }}</div>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm w-100">
                        Cerrar sesión
                    </button>
                </form>
            </div>
        </aside>

        {{-- CONTENIDO PRINCIPAL --}}
        <main class="flex-grow-1 overflow-auto p-4 bg-light">
            {{ $slot }}
        </main>
    </div>
</body>
</html>