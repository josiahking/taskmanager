<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Services\ProjectService;
use Illuminate\Http\RedirectResponse;

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

    public function store(StoreProjectRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $response = $this->projectService->createProject($validated);
        if(!$response){
            return redirect()->back()->withErrors([
                "message" => "Failed to create project",
            ]);
        }
        return redirect()->back()->with([
            "message" => "Successful creating project",
        ]);
    }

    public function update(UpdateProjectRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $response = $this->projectService->updateProject($validated);
        if(!$response){
            return redirect()->back()->withErrors([
                "message" => "Failed to update project",
            ]);
        }
        return redirect()->back()->with([
            "message" => "Successful updating project",
        ]);
    }

    public function delete(int $id): RedirectResponse
    {
        $response = $this->projectService->deleteProject($id);
        if (! $response) {
            return redirect()->back()->withErrors([
                'message' => 'Failed to project task.'
            ]);
        }

        return redirect()->back()->with('message', 'Project deleted successfully.');
    }

}
