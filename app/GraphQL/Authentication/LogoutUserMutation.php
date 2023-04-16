<?php

namespace App\GraphQL\Authentication;

use App\Repository\AcessUserRepositoryInterface;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class LogoutUserMutation extends Mutation
{
    private AcessUserRepositoryInterface $acessUserRepository;

    public function __construct(AcessUserRepositoryInterface $acessUserRepository)
    {
        $this->acessUserRepository = $acessUserRepository;
    }

    protected $attributes = [
        'name' => 'logoutUser',
        'description' => 'A mutation what logout user'
    ];

    public function type(): Type
    {
        return GraphQL::type('Auth');
    }

    public function args():array{
        return [
            'id'=> [
                'type' => Type::int(),
                'description' => 'The id of user',
            ],
            'token_type' => [
                'type' => Type::string(),
                'description' => 'The token type of user',
            ],
            'expires_in' => [
                'type' => Type::string(),
                'description' => 'The expires in of user',
            ],
        ];
    }

    public function resolve($root, array $args)
    {
        return $this->acessUserRepository->logout();
    }

}