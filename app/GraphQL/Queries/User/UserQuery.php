<?php

namespace App\GraphQL\Queries\User;

use App\Repository\UserRepositoryInterface;
use GraphQL\Type\Definition\ResolveInfo;
use Closure;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserQuery extends Query {
    
    private UserRepositoryInterface $userRepository;
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function authorize($root, array $args, $ctx, ?ResolveInfo $resolveInfo = null, ?Closure $getSelectFields = null): bool
    {
        try {
            JWTAuth::parseToken()->authenticate();
            } catch (\Exception $e) {
                if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                    return false;
                } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                    return false;
                } else {
                    return false;
                }
            }
            return true;
    }

    public function getAuthorizationMessage(): string
    {
        return "Você não tem autorização";
    }
    
    protected $attributes = [
        'name' => 'user',
        'description' => 'Query para buscar um user'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('User'));
    }

    public function args(): array
    {
        return [
            'id' =>
            [
                'name' => 'id',
                'type' => Type::int(),
            ],
            'name' =>
            [
                'name' => 'name',
                'type' => Type::string(),
            ],
            'email' =>
            [
                'name' => 'email',
                'type' => Type::string(),
            ],
            'cpf' =>
            [
                'name' => 'cpf',
                'type' => Type::string(),
            ],

        ];
        
    }

    public function resolve($root, $args)
    {
        return $this->userRepository->getUSer($args);
    }
}