<?php

namespace App\Repositories;

use App\Models\Project;
use App\Interfaces\ProjectInterface;
use Illuminate\Database\Eloquent\Collection;

class ProjectRepository implements ProjectInterface
{
    public function all(): array
    {
        return Project::all()->toArray();
    }

    public function one(int $id): Collection
    {
        return Project::where('id', $id)->get();
    }

    public function create(array $data): Project
    {
        return Project::create($data);
    }

    public function update(array $data): bool
    {
        return Project::where('id', $data["id"])->update([
            "name" => $data["name"],
        ]);
    }

    public function delete(int $id): bool
    {
        return Project::where('id', $id)->delete();
    }
}
