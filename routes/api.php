<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TechnologyController;
use Illuminate\Support\Facades\Route;

Route::middleware('throttle:api')->group(function (): void {
    Route::get('/projects', [ProjectController::class, 'index']);
    Route::get('/projects/{slug}', [ProjectController::class, 'show']);
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/technologies', [TechnologyController::class, 'index']);
    Route::middleware(['auth:sanctum', 'can:admin'])->prefix('admin')->group(function (): void {
        Route::post('/projects', [ProjectController::class, 'store']);
        Route::patch('/projects/{project}', [ProjectController::class, 'update']);
        Route::delete('/projects/{project}', [ProjectController::class, 'destroy']);
        Route::post('/projects/{project}/publish', [ProjectController::class, 'publish']);
    });
});
