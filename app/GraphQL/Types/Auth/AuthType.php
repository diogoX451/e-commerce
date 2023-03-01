<?php

declare(strict_types=1);

namespace App\GraphQL\Types\Auth;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class AuthType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Auth',
        'description' => 'A type'
    ];

    public function fields(): array
    {
        return [
            'acess_token' =>  [
                'type' => Type::string(),
                'description' => 'The acess token of user',
            ],
            'token_type' => [
                'type' => Type::string(),
                'description' => 'The token type of user',
            ],
            'expires_in' => [
                'type' => Type::string(),
                'description' => 'The expires in of user',
            ],
            'user' => [
                'type' => Type::listOf(GraphQL::type('User')),
                'description' => 'The user of auth',
            ],
        ];
    }
}
