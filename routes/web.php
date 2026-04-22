<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
    Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
    Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');

    Route::get('/clients/{client}/edit', [ClientController::class, 'edit'])->name('clients.edit');
    Route::put('/clients/{client}', [ClientController::class, 'update'])->name('clients.update');
    Route::delete('/clients/{client}', [ClientController::class, 'destroy'])->name('clients.destroy');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::post('/clients/{client}/projects', [ClientController::class, 'storeProject'])
    ->name('clients.projects.store');

Route::get('/projects/{project}', [ProjectController::class, 'show'])
    ->name('projects.show');

Route::patch('/projects/{project}/status', [ProjectController::class, 'updateStatus'])
    ->name('projects.updateStatus');

Route::post('/projects/{project}/tasks', [ProjectController::class, 'storeTask'])
    ->name('projects.tasks.store');

Route::patch('/tasks/{task}/toggle', [ProjectController::class, 'toggleTask'])
    ->name('tasks.toggle');

Route::post('/clients/{client}/projects', [ProjectController::class, 'store'])
    ->name('projects.store');

require __DIR__.'/auth.php';
