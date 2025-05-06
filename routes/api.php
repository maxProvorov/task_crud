<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth.api')->group(function () {
    Route::apiResource('/tags', TaskController::class);
});
    Route::apiResource('/tasks', TaskController::class);
