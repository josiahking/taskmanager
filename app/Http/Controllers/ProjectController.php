<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Services\ProjectService;

class ProjectController extends Controller
{
    protected ProjectService $projectService;

    public function __construct(ProjectService $projectService) {
        $this->projectService = $projectService;
    }

    public function index()
    {
        return response([
            "projects" => $this->projectService->listProjects(),
        ]);
    }

    public function store(StoreProjectRequest $request)
    {
        $validated = $request->validated();
        $response = $this->projectService->createProject($validated);
        $statusCode = $response === true ? 200 : 422;
        return response([
            "message" => $response === true ? "Successful creating project" : "Failed to create project",
        ], $statusCode);
    }

    public function update(UpdateProjectRequest $request)
    {
        $validated = $request->validated();
        $response = $this->projectService->updateProject($validated);
        $statusCode = $response === true ? 200 : 422;
        return response([
            "message" => $response === true ? "Successful updating project" : "Failed to update project",
        ], $statusCode);
    }

    public function delete(int $id)
    {
        $response = $this->projectService->deleteProject($id);
        if(!$response){
            return response([], 422);
        }
        return response([], 204);
    }

}
