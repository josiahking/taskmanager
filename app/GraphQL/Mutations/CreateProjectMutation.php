<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\Project;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

class CreateProjectMutation extends Mutation
{
    protected $attributes = [
        'name' => 'createProject',
        'description' => 'A mutation to create project'
    ];

    public function type(): Type
    {
        return GraphQL::type('Project');
    }

    public function args(): array
    {
        return [
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'name' => 'name',
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {

        return Project::create($args);
    }
}
