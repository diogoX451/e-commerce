<?php

namespace App\GraphQL\Types\User;

use GraphQL\Type\Definition\Type;
use \App\Models\User;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class UserType extends GraphQLType
{
    protected $attributes = [
        'name' => 'User',
        'description' => 'A type for user',
        'model' => User::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The id of the user',
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'The name of user',
            ],
            'last_name' => [
                'type' => Type::string(),
                'description' => 'The last name of user',
            ],
            'email' => [
                'type' => Type::string(),
                'description' => 'The email of user',
            ],
            'phone' => [
                'type' => Type::string(),
                'description' => 'The phone of user',
            ],
            'address' => [
                'type' => Type::listOf(GraphQL::type('Endereco')),
                'description' => 'The addresses of user',
            ],
        ];
    }
}
