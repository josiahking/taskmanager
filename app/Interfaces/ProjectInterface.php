<?php

namespace App\Interfaces;

use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface ProjectInterface
 *
 * Defines the contract for project-related operations.
 */
interface ProjectInterface
{
    /**
     * Retrieve all projects.
     *
     * @return array An array containing all project records.
     */
    public function all(): array;

    /**
     * Retrieve a single project by its unique identifier.
     *
     * @param int $id The unique identifier of the project.
     * @return \Illuminate\Database\Eloquent\Collection The collection containing the project's data.
     */
    public function one(int $id): Collection;

    /**
     * Create a new project with the provided data.
     *
     * @param array $data The data to create the project with.
     * @return Project The newly created project instance.
     */
    public function create(array $data): Project;

    /**
     * Update project with provided data
     * 
     * @param array $data The data to update the project
     * @return bool
     */
    public function update(array $data): bool;

    /**
     * Delete the specified project.
     *
     * @param int $id The project instance to be deleted.
     * @return bool Returns true if the project was successfully deleted, false otherwise.
     */
    public function delete(int $id): bool;
}
