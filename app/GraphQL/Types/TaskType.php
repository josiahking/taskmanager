<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class TaskType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Task',
        'description' => 'A task type'
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Task ID',
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Task name/description',
            ],
            'priority' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Task priority',
                'resolve' => fn ($task) => $task->priority->value,
            ],
            'project_id' => [
                'type' => Type::int(),
                'description' => 'Task assigned project ID',
            ],
            'order' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Task order',
            ]
        ];
    }
}
