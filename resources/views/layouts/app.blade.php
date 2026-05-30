{{-- resources/views/layouts/app.blade.php --}}
{{-- Layout principal con sidebar vertical para usuarios autenticados --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- Favicon independiente del logo --}}
    <link rel="icon" type="image/png" href="{{ asset('images/icon.png') }}">
    <title>@yield('title', config('app.name', 'SIACRE'))</title>
    {{-- Tailwind y scripts de Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- ESTILO CRÍTICO: Forzar altura completa en sidebar --}}
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }
        .app-container {
            display: flex;
            height: 100vh;
            width: 100%;
        }
        .app-sidebar {
            width: 256px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
        }
        .app-sidebar nav {
            flex: 1;
            overflow-y: auto;
        }
        .app-sidebar footer {
            margin-top: auto;
        }
        .app-main {
            flex: 1;
            overflow-y: auto;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="app-container">
        {{-- SIDEBAR FIJO A IZQUIERDA --}}
        <aside class="app-sidebar bg-gray-800 text-white">
            {{-- Cabecera sin logo, solo nombre de la app --}}
            <div class="px-4 py-5 border-b border-gray-700 text-center">
                <span class="text-lg font-bold tracking-wide">{{ config('app.name', 'SIACRE') }}</span>
            </div>

            {{-- Navegación (ocupa el espacio restante) --}}
            <nav class="px-4 py-4 space-y-1">
                <a href="{{ route('dashboard') }}"
                   class="flex items-center px-3 py-2 text-gray-300 rounded-md hover:bg-gray-700 hover:text-white transition-colors {{ request()->routeIs('dashboard') ? 'bg-gray-700 text-white' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('users.index') }}"
                   class="flex items-center px-3 py-2 text-gray-300 rounded-md hover:bg-gray-700 hover:text-white transition-colors {{ request()->routeIs('users.*') ? 'bg-gray-700 text-white' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    Usuarios
                </a>

                <a href="{{ route('clients.index') }}"
                   class="flex items-center px-3 py-2 text-gray-300 rounded-md hover:bg-gray-700 hover:text-white transition-colors {{ request()->routeIs('clients.*') ? 'bg-gray-700 text-white' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Clientes
                </a>

                <a href="{{ route('roles.index') }}"
                   class="flex items-center px-3 py-2 text-gray-300 rounded-md hover:bg-gray-700 hover:text-white transition-colors {{ request()->routeIs('roles.*') ? 'bg-gray-700 text-white' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    Roles
                </a>
            </nav>

            {{-- Footer: usuario y cierre de sesión (siempre al fondo) --}}
            <footer class="px-4 py-4 border-t border-gray-700">
                <div class="flex items-center mb-3">
                    <div class="flex-shrink-0">
                        <svg class="h-8 w-8 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v1.2h19.2v-1.2c0-3.2-6.4-4.8-9.6-4.8z"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-white">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-400">{{ auth()->user()->email }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-3 py-2 text-gray-300 rounded-md hover:bg-gray-700 hover:text-white transition-colors">
                        Cerrar sesión
                    </button>
                </form>
            </footer>
        </aside>

        {{-- CONTENIDO PRINCIPAL --}}
        <main class="app-main p-6">
            {{ $slot }}
        </main>
    </div>
</body>
</html>