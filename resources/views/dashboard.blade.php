{{-- resources/views/dashboard.blade.php --}}
{{-- Vista del dashboard después de iniciar sesión --}}
<x-app-layout>
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Dashboard</h2>
        <p class="text-gray-600">Bienvenido, {{ auth()->user()->name }}.</p>
        <p class="text-gray-600 mt-2">Aquí se mostrarán las estadísticas y accesos rápidos del sistema de análisis de crédito.</p>
    </div>
</x-app-layout>