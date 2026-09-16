<?php

use App\Http\Controllers\Admin\ProjectAdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PortfolioController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PortfolioController::class, 'index'])->name('home');
Route::get('/projects', [PortfolioController::class, 'index'])->name('projects.index');
Route::get('/projects/fragment', [PortfolioController::class, 'fragment'])->middleware('throttle:api')->name('projects.fragment');
Route::get('/projects/{slug}', [PortfolioController::class, 'show'])->name('projects.show');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login.post')->middleware(['guest', 'throttle:login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware(['auth', 'can:admin'])->prefix('admin')->name('admin.')->group(function (): void {
    Route::get('/dashboard', [ProjectAdminController::class, 'index'])->name('dashboard');
    Route::resource('projects', ProjectAdminController::class)->except('index');
    Route::post('/projects/{project}/restore', [ProjectAdminController::class, 'restore'])->withTrashed()->name('projects.restore');
});
Route::redirect('/dashboard', '/admin/dashboard')->middleware('auth')->name('dashboard');
