<?php

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;


uses(RefreshDatabase::class);

it('can create a project', function () {
    $project = Project::factory()->create(['name' => 'My Project']);

    expect($project->name)->toBe('My Project');
});
