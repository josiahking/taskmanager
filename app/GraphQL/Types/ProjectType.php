<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class ProjectType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Project',
        'description' => 'A project type'
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Project ID',
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Project name',
            ],
            'tasks' => [
                'type' => Type::listOf(GraphQL::type('Task')),
                'description' => 'Task assigned to project'
            ],
        ];
    }
}
