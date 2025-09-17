<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;

class TaskManagerController extends Controller
{
    public function __invoke() {
        return Inertia::render('App', [
            'projects' => [['name' => 'Project A']],
            'tasks' => [['name' => 'First Task']],
        ]);
    }
    
}
