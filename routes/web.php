<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskManagerController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/app', TaskManagerController::class)->name('app');

    Route::get('/projects', [ProjectController::class, 'index'])->name('projects');
    Route::post('/projects/store', [ProjectController::class, 'store'])->name('projects.store');
    Route::put('/projects/update', [ProjectController::class, 'update'])->name('projects.update');
    Route::delete('/projects/delete/{id}', [ProjectController::class, 'delete'])->name('projects.destroy');

    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks');
    Route::post('/tasks/store', [TaskController::class, 'store'])->name('tasks.store');
    Route::put('/tasks/update', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/delete/{id}', [TaskController::class, 'delete'])->name('tasks.destroy');
    Route::put('/tasks/unlinkproject', [TaskController::class, 'unlinkProject'])->name('tasks.unlinkproject');

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/token', [ProfileController::class, 'generateToken'])->name('profile.token');
});

require __DIR__.'/auth.php';
