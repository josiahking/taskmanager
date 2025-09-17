<?php

namespace Database\Factories;

use App\Enums\PriorityEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $priorities = array_map(fn(PriorityEnum $p) => $p->value, PriorityEnum::cases());

        shuffle($priorities);
        return [
            'name' => fake()->sentence(),
            'priority' => $priorities[0],
            'project_id' => 1,
        ];
    }
}
