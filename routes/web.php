<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\InvoiceController;

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

Route::get('/projects/{project}', [ProjectController::class, 'show'])
    ->name('projects.show');

Route::put('/tasks/{task}', [ProjectController::class, 'updateTask'])
    ->name('tasks.update');

Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])
    ->name('tasks.updateStatus');

Route::get('/search', [SearchController::class, 'index'])
    ->name('search');

Route::get('/search-live', [SearchController::class, 'live'])
    ->name('search.live');

Route::post('/projects/{project}/invoices', [InvoiceController::class, 'store'])
    ->name('invoices.store');

Route::patch('/invoices/{invoice}/status', [InvoiceController::class, 'updateStatus'])
    ->name('invoices.updateStatus');

Route::get('/invoices/{invoice}/download', [InvoiceController::class, 'download'])
    ->name('invoices.download');

require __DIR__.'/auth.php';
