<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Services\TaskService;

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

    public function store(StoreTaskRequest $request)
    {
        $validated = $request->validated();
        $response = $this->taskService->createTask($validated);
        $statusCode = $response === true ? 200 : 422;
        return response([
            "message" => $response === true ? "Successful creating task" : "Failed to create task",
        ], $statusCode);
    }

    public function update(UpdateTaskRequest $request)
    {
        $validated = $request->validated();
        $response = $this->taskService->updateTask($validated);
        $statusCode = $response === true ? 200 : 422;
        return response([
            "message" => $response === true ? "Successful updating task" : "Failed to update task",
        ], $statusCode);
    }

    public function delete(int $id)
    {
        $response = $this->taskService->deleteTask($id);
        if(!$response){
            return response([], 422);
        }
        return response([], 204);
    }
}
