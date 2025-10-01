<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\Task;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

class CreateTaskMutation extends Mutation
{
    protected $attributes = [
        'name' => 'createTask',
        'description' => 'A mutation to create task'
    ];

    public function type(): Type
    {
        return GraphQL::type('Task');
    }

    public function args(): array
    {
        return [
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Task name/description',
            ],
            'priority' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Task priority (Backlog, Low, Medium, High, Urgent)',
            ],
            'project_id' => [
                'type' => Type::int(),
                'description' => 'Task assigned project ID',
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $order = Task::count() + 1;
        return Task::create([
            'name' => $args['name'],
            'priority' => $args['priority'],
            'project_id' => $args['project_id'],
            'order' => $order,
        ]);
    }
}
