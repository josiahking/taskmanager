<?php

namespace App\Services;

use App\Models\Project;
use App\Repositories\ProjectRepository;

class ProjectService
{
    protected ProjectRepository $projectRepository;

    /**
     * Create a new class instance.
     */
    public function __construct(ProjectRepository $projects)
    {
        $this->projectRepository = $projects;
    }

    public function listProjects(): array
    {
        return $this->projectRepository->all();
    }

    public function getProject(int $id): array
    {
        return $this->projectRepository->one($id)->toArray();
    }

    public function createProject(array $data): bool
    {
        return $this->projectRepository->create($data) ? true : false;
    }

    public function updateProject(array $data): bool
    {
        return $this->projectRepository->update($data);
    }

    public function deleteProject(int $id): bool
    {
        return $this->projectRepository->delete($id);
    }

}
