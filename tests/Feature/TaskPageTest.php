<?php

use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use Inertia\Testing\AssertableInertia;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('renders the task index page with tasks grouped by project', function () {
    $project = Project::factory()->create(['name' => 'Project A']);
    Task::factory()->create([
        'project_id' => $project->id,
        'name' => 'First Task',
        'priority' => 'High'
    ]);
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get('/app');

    $response->assertInertia(
        fn(AssertableInertia $page) =>
        $page->component('App')
            ->has('projects', 1)
            ->where('projects.0.name', 'Project A')
            ->has('tasks', 1)
            ->where('tasks.0.name', 'First Task')
    );
});

it('return all projects', function () {
    Project::factory()->create(['name' => 'Project A']);
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/projects');
    $this->assertArrayHasKey('projects', $response->json());
    $response->assertJson(function ($json) {
        $json->has('projects.0')
            ->where('projects.0.name', 'Project A');
    });
});

it('can create project', function () {
    $user = User::factory()->create();
    $response = $this->actingAs($user)->post('/projects/store', [
        'name' => "Project B",
    ]);
    $response->assertSessionHas([
        'message' => "Successful creating project",
    ]);
    $this->assertDatabaseHas('projects', ["name" => "Project B"]);
});

it('can update project', function () {
    $user = User::factory()->create();
    $project = Project::factory()->create(['name' => 'Project A']);
    $response = $this->actingAs($user)->put('/projects/update', [
        "id" => $project->id,
        'name' => "Project B",
    ]);
    $response->assertSessionHas([
        'message' => "Successful updating project",
    ]);
});

it('can delete project', function () {
    $project = Project::factory()->create(['name' => 'Project A']);
    $user = User::factory()->create();
    $this->actingAs($user)->delete("/projects/delete/{$project->id}");
    $this->assertDatabaseMissing('projects', ['id' => $project->id]);
});

it('return all tasks', function () {
    $project = Project::factory()->create(['name' => 'Project A']);
    $user = User::factory()->create();
    Task::factory()->create([
        'project_id' => $project->id,
        'name' => 'First Task',
        'priority' => 'High'
    ]);
    $response = $this->actingAs($user)->get('/tasks');
    $this->assertArrayHasKey('tasks', $response->json());
    $response->assertJson(function ($json) {
        $json->has('tasks.0')
            ->where('tasks.0.name', 'First Task')
            ->where('tasks.0.project_id', 1);
    });
});

$data = [
    "name" => "Second Task",
    'project_id' => null,
    'priority' => 'High',
];

it('can create task', function () use ($data){
    $user = User::factory()->create();
    $response = $this->actingAs($user)->post('/tasks/store', $data);
    $response->assertSessionHas([
        'message' => "Successful creating task",
    ]);
    $this->assertDatabaseHas('tasks', $data);
});

it('can update task', function () use ($data) {
    $task = Task::factory()->create($data);
    $user = User::factory()->create();
    $response = $this->actingAs($user)->put('/tasks/update', [
        "id" => $task->id,
        "order" => 2,
    ]);
    $response->assertSessionHas([
        'message' => "Successful updating task",
    ]);
});

it('can delete task', function () use ($data) {
    $task = Task::factory()->create($data);
    $user = User::factory()->create();
    $this->actingAs($user)->delete("/tasks/delete/{$task->id}");
    $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
});

it("can unlink task from project", function(){
    $project = Project::factory()->create(['name' => 'Project A']);
    $tasks = Task::factory()->count(5)->create();
    $user = User::factory()->create();
    $taskIds = $tasks->pluck('id')->toArray();
    $this->actingAs($user)->delete("/projects/delete/{$project->id}");
    $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    $this->put("/tasks/unlinkproject", [
        "project_id" => $project->id,
        "tasks" => $taskIds,
    ]);
    foreach($taskIds as $task){
        $this->assertDatabaseMissing('tasks', ['id', $task, 'project_id' => null]);
    }
});