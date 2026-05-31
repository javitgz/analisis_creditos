<?php

use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\RoleApiController;
use App\Http\Controllers\Api\UserApiController;
use Illuminate\Support\Facades\Route;

// Rutas públicas (sin token)
Route::post('/login', [AuthApiController::class, 'login'])->name('api.login');

// Rutas protegidas por Sanctum (token)
Route::middleware('auth:sanctum')->group(function () {

    // Logout
    Route::post('/logout', [AuthApiController::class, 'logout'])->name('api.logout');

    // Usuario autenticado
    Route::get('/me', [AuthApiController::class, 'me'])->name('api.me');

    // Roles API
    Route::apiResource('roles', RoleApiController::class)->names('api.roles');

    // Usuarios API
    Route::apiResource('users', UserApiController::class)->names('api.users');
    Route::patch('users/{user}/toggle-estado', [UserApiController::class, 'toggleEstado'])
         ->name('api.users.toggle-estado');
});