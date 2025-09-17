<?php

namespace App\Http\Controllers;

use App\Services\ProjectService;
use App\Services\TaskService;
use Inertia\Inertia;

class TaskManagerController extends Controller
{
    public function __invoke(ProjectService $projectService, TaskService $taskService) 
    {
        $projects = $projectService->listProjects();
        $tasks = $taskService->listTasks();

        return Inertia::render('App', [
            'projects' => $projects,
            'tasks' => $tasks,
        ]);
    }
    
}
