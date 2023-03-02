<?php

namespace App\GraphQL\Authentication;

use App\Repository\AcessUserRepositoryInterface;
use Closure;
use Exception;
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
        return GraphQL::type('Auth');
    }

    public function args(): array
    {
        return [
            'email' => [
                'name' => 'email',
                'type' => Type::string(),
                'rules' => 'required'
            ],
            'password' => [
                'name' => 'password',
                'type' => Type::string(),
                'rules' => 'required'
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return $this->acessUserRepository->login($args);
    }
}
