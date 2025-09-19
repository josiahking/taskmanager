<?php

namespace App\Services;

use App\Repositories\ProjectRepository;
use App\Repositories\TaskRepository;

class TaskService
{
    protected TaskRepository $taskRepository;
    protected ProjectRepository $projectRepository;
    /**
     * Create a new class instance.
     */
    public function __construct(TaskRepository $tasks, ProjectRepository $projects)
    {
        $this->taskRepository = $tasks;
        $this->projectRepository = $projects;
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

    public function updateTask(array $data): bool
    {
        return $this->taskRepository->update($data);
    }

    public function deleteTask(int $id): bool
    {
        return $this->taskRepository->delete($id);
    }

    public function unlinkProject(array $data): bool
    {
        if($data["project_id"]){
            $project = $this->projectRepository->exists($data["project_id"]);
            if(!$project){
                return $this->taskRepository->unlinkProject($data["tasks"]);
            }
        }
        return false;
    }
}
