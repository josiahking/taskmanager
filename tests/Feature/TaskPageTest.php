<?php

use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;

uses(RefreshDatabase::class);

it('renders the task index page with tasks grouped by project', function () {
    $project = Project::factory()->create(['name' => 'Project A']);
    Task::factory()->create([
        'project_id' => $project->id,
        'name' => 'First Task',
        'priority' => 'High'
    ]);

    $response = $this->get('/');

    $response->assertInertia(fn (AssertableInertia $page) =>
        $page->component('App')
            ->has('projects', 1)
            ->where('projects.0.name', 'Project A')
            ->has('tasks', 1)
            ->where('tasks.0.name', 'First Task')
    );
});
