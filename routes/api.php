<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TaskController;
use App\Http\Middleware\EnsureTokenIsValid;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(EnsureTokenIsValid::class)->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::apiResource('/tags', TagController::class);
    Route::apiResource('/tasks', TaskController::class);
});
