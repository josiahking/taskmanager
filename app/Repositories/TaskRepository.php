<?php

namespace App\Repositories;

use App\Models\Task;
use App\Interfaces\TaskInterface;
use Illuminate\Database\Eloquent\Collection;

class TaskRepository implements TaskInterface
{
    public function all(): array
    {
        return Task::all()->toArray();
    }

    public function one(int $id): Collection
    {
        return Task::where('id', $id)->get();
    }

    public function create(array $data): Task
    {
        return Task::create($data);
    }

    public function update(array $data): bool
    {
        $id = $data['id'];
        unset($data["id"]);
        return Task::where('id', $id)->update($data);
    }

    public function delete(int $id): bool
    {
        return Task::where("id", $id)->delete();
    }
}
