<?php

namespace App\Interfaces;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface TaskInterface
 *
 * Defines the contract for task-related operations.
 */
interface TaskInterface
{
    /**
     * Retrieve all tasks.
     *
     * @return array An array containing all tasks.
     */
    public function all(): array;

    /**
     * Retrieve a single task by its unique identifier.
     *
     * @param int $id The unique identifier of the task.
     * @return \Illuminate\Database\Eloquent\Collection The collection containing the task data.
     */
    public function one(int $id): Collection;

    /**
     * Create a new Task instance with the provided data.
     *
     * @param array $data The data to create the task with.
     * @return Task The newly created Task object.
     */
    public function create(array $data): Task;

    /**
     * Delete specified task
     * @param Task $task The task instance to be deleted.
     * @return bool Returns true if the task was successfully deleted, false otherwise.
     */
    public function delete(Collection $task): bool;
}
