<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\Project;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class ProjectQuery extends Query
{
    protected $attributes = [
        'name' => 'project',
        'description' => 'A query to get one project using the ID'
    ];

    public function type(): Type
    {
        return GraphQL::type('Project');
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
        return Project::findOrFail($args['id']);
    }
}
