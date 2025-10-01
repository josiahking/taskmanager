<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\Task;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class TasksQuery extends Query
{
    protected $attributes = [
        'name' => 'tasks',
        'description' => 'A query to retrieve all tasks',
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Task'));
    }

    public function args(): array
    {
        return [

        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {

        return Task::all();
    }
}
