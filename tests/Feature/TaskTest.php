<?php

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Project;

uses(RefreshDatabase::class);

it('can add task without project', function () {
    $task = Task::factory()->create([
        'name' => 'Test Task',
        'project_id' => null,
    ]);

    expect($task->first()->name)->toBe('Test Task');
});

it('can add tasks with project', function () {
    $project = Project::factory()->create();
    Task::factory()->create([
        'project_id' => $project->id,
        'name' => 'Test Task',
        'priority' => 'High',
    ]);

    expect($project->tasks)->toHaveCount(1)
        ->and($project->tasks->first()->name)->toBe('Test Task');
});
