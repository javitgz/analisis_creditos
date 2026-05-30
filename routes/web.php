<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Rutas de autenticacion
require __DIR__.'/auth.php';

// Pagina de inicio (se puede cambiar por la que quiera)
Route::get('/', function () {
    return redirect()->route('login');
});

// Rutas protegidas que requieren iniciar session
Route::middleware('auth')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', function () {
    return view('dashboard');
    })->name('dashboard');

    // Perfil de usuario (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Modulo roles (placeholder)
    Route::get('roles', function(){
        return view('roles.index');
    })->name('roles.index');

    // Modulo de usuarios (placeholder)
    Route::get('users', function(){
        return view('users.index');
    })->name('users.index');

    // Modulo clientes (placeholder)
    Route::get('clients', function(){
        return view('clients.index');
    })->name('clients.index');

});
