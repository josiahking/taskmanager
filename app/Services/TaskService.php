<?php

namespace App\Services;

use App\Repositories\TaskRepository;

class TaskService
{
    protected TaskRepository $taskRepository;
    /**
     * Create a new class instance.
     */
    public function __construct(TaskRepository $tasks)
    {
        $this->taskRepository = $tasks;
    }

    public function listTasks(): array
    {
        return $this->taskRepository->all();
    }

    public function getTask(int $id): array
    {
        return $this->taskRepository->one($id)->toArray();
    }

    public function createTask(array $data): bool
    {
        return $this->taskRepository->create($data) ? true : false;
    }

    public function deleteTask(int $id): bool
    {
        $task = $this->taskRepository->one($id);
        return $this->taskRepository->delete($task);
    }
}
