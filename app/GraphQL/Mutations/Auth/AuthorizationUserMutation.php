<?php

namespace App\GraphQL\Mutations\Auth;

use App\Repository\AcessUserRepositoryInterface;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class AuthorizationUserMutation extends Mutation
{
    private AcessUserRepositoryInterface $acessUserRepository;

    public function __construct(AcessUserRepositoryInterface $acessUserRepository)
    {
        $this->acessUserRepository = $acessUserRepository;
    }
    protected $attributes = [
        'name' => 'authorizationUser',
        'description' => 'A mutation what authorization user'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('User'));
    }

    public function args(): array
    {
        return [
            'email' => [
                'name' => 'email',
                'type' => Type::string(),
            ],
            'password' => [
                'name' => 'password',
                'type' => Type::string(),
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return $this->acessUserRepository->login($args);
    }
}
