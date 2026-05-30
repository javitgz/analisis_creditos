<x-app-layout>
    <div class="card shadow-sm">
        <div class="card-body">
            <h3 class="card-title">Dashboard</h3>
            <p class="text-muted">Bienvenido, {{ auth()->user()->name }}.</p>
            <p>Aquí se mostrarán las estadísticas del sistema de análisis de crédito.</p>
        </div>
    </div>
</x-app-layout>