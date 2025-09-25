<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use Closure;
use App\Models\Task;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\Facades\GraphQL;

class TaskQuery extends Query
{
    protected $attributes = [
        'name' => 'task',
        'description' => 'A query to get a task'
    ];

    public function type(): Type
    {
        return GraphQL::type('Task');
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::int(),
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return Task::findOrFail($args['id']);
    }
}
