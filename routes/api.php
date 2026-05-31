<?php

use App\Http\Controllers\Api\RoleApiController;
use App\Http\Controllers\Api\UserApiController;
use Illuminate\Support\Facades\Route;

// Rutas protegidas por Sanctum (token)
Route::middleware('auth:sanctum')->group(function () {

    // Roles API
    Route::apiResource('roles', RoleApiController::class);

    // Usuarios API
    Route::apiResource('users', UserApiController::class);
    Route::patch('users/{user}/toggle-estado', [UserApiController::class, 'toggleEstado'])
         ->name('api.users.toggle-estado');
});