<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskManagerController;

Route::get('/', TaskManagerController::class)->name('app');

Route::get('/projects', [ProjectController::class, 'index'])->name('projects');
Route::post('/projects/store', [ProjectController::class, 'store'])->name('projects.store');
Route::put('/projects/update', [ProjectController::class, 'update'])->name('projects.update');
Route::delete('/projects/delete/{id}', [ProjectController::class, 'delete'])->name('projects.destroy');

Route::get('/tasks', [TaskController::class, 'index'])->name('tasks');
Route::post('/tasks/store', [TaskController::class, 'store'])->name('tasks.store');
Route::put('/tasks/update', [TaskController::class, 'update'])->name('tasks.update');
Route::delete('/tasks/delete/{id}', [TaskController::class, 'delete'])->name('tasks.destroy');
Route::put('/tasks/unlinkproject', [TaskController::class, 'unlinkProject'])->name('tasks.unlinkproject');