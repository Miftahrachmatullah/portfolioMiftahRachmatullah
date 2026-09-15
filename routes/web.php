<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\ProjectAdminController;

// Public
Route::get('/', function () {
    return view('pages.home');
});

// Auth
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login.post')->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin (protected)
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [ProjectAdminController::class, 'index'])->name('dashboard');
    Route::post('/projects', [ProjectAdminController::class, 'store'])->name('projects.store');
    Route::put('/projects/{project}', [ProjectAdminController::class, 'update'])->name('projects.update');
    Route::delete('/projects/{project}', [ProjectAdminController::class, 'destroy'])->name('projects.destroy');
});

// Legacy redirect
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware('auth')->name('dashboard');
