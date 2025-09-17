<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskManagerController;

Route::get('/', TaskManagerController::class)->name('app');
