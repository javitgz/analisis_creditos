<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

// Página de inicio
Route::get('/', function () {
    return redirect()->route('login');
});

// Rutas de autenticación (Breeze)
require __DIR__.'/auth.php';

// Rutas protegidas
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Perfil de usuario (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Módulo de Roles (CRUD completo con controlador)
    Route::resource('roles', RoleController::class);

    // Módulo de Usuarios (placeholder)
    Route::get('/users', function () {
        return view('users.index');
    })->name('users.index');

    // Módulo de Clientes (placeholder)
    Route::get('/clients', function () {
        return view('clients.index');
    })->name('clients.index');
});