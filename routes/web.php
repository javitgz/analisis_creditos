<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Página de inicio: siempre redirige a login
Route::get('/', function () {
    return redirect()->route('login');
});

// Rutas de autenticación (Breeze)
require __DIR__.'/auth.php';

// Rutas protegidas por autenticación
Route::middleware('auth')->group(function () {

    // Dashboard (todos los usuarios autenticados pueden verlo)
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Perfil de usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Módulo de Roles: solo quien tenga permiso 'gestionar roles'
    Route::middleware('can:gestionar roles')->group(function () {
        Route::resource('roles', RoleController::class);
    });

    // Módulo de Usuarios: solo quien tenga permiso 'ver usuarios'
    Route::middleware('can:ver usuarios')->group(function () {
        Route::resource('users', UserController::class)->except(['show']);
        Route::patch('/users/{user}/toggle-estado', [UserController::class, 'toggleEstado'])
             ->name('users.toggle-estado');
    });

    // Módulo de Clientes (placeholder): solo quien tenga permiso 'ver clientes'
    Route::middleware('can:ver clientes')->group(function () {
        Route::get('/clients', function () {
            return view('clients.index');
        })->name('clients.index');
    });
});