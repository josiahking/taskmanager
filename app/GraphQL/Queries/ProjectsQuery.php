<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\Project;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class ProjectsQuery extends Query
{
    protected $attributes = [
        'name' => 'projects',
        'description' => 'A query for retrieve all the available projects'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Project'));
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return Project::with('tasks')->get();
    }
}
