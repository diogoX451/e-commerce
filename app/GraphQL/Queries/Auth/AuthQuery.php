<?php

declare(strict_types=1);

namespace App\GraphQL\Queries\Auth;

use App\Repository\AcessUserRepositoryInterface;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\SelectFields;

class AuthQuery extends Query
{
    private AcessUserRepositoryInterface $acessUserRepository;

    public function __construct(AcessUserRepositoryInterface $acessUserRepository)
    {
        $this->acessUserRepository = $acessUserRepository;
    }

    protected $attributes = [
        'name' => 'auth',
        'description' => 'A query'
    ];

    public function type(): Type
    {
        return GraphQL::type('Auth');
    }

    public function args(): array
    {
        return [
            'acess_token' => [
                'name' => 'acess_token',
                'type' => Type::string(),
            ],
            'token_type' => [
                'name' => 'token_type',
                'type' => Type::string(),
            ],
            'expires_in' => [
                'name' => 'expires_in',
                'type' => Type::string(),
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return $this->acessUserRepository->login($args);
    }
}
