<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UnlinkProjectRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Services\TaskService;
use Illuminate\Http\RedirectResponse;

class TaskController extends Controller
{
    protected TaskService $taskService;

    public function __construct(TaskService $taskService) {
        $this->taskService = $taskService;
    }

    public function index()
    {
        return response([
            "tasks" => $this->taskService->listTasks(),
        ]);
    }

    public function store(StoreTaskRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $response = $this->taskService->createTask($validated);
        if(!$response){
            redirect()->back()->withErrors([
                "message" => "Failed to create task",
            ]);
        }
        return redirect()->back()->with([
            "message" => "Successful creating task",
        ]);
    }

    public function update(UpdateTaskRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $response = $this->taskService->updateTask($validated);
        if(!$response){
            return redirect()->back()->withErrors([
                "message" => "Failed to update task",
            ]);
        }
        return redirect()->back()->with([
            "message" => "Successful updating task",
        ]);
    }

    public function delete(int $id): RedirectResponse
    {
        $response = $this->taskService->deleteTask($id);
        if (! $response) {
            return redirect()->back()->withErrors([
                'message' => 'Failed to delete task.'
            ]);
        }

        return redirect()->back()->with('message', 'Task deleted successfully.');
    }

    public function unlinkProject(UnlinkProjectRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $response = $this->taskService->unlinkProject($validated);
        if(!$response){
            return redirect()->back()->withErrors([
                "message" => "Failed to unlink task from project",
            ]);
        }
        return redirect()->back()->with([
            "message" => "Successful unlinking project",
        ]);
    }
}
