<?php

declare(strict_types=1);

namespace App\GraphQL\Types\Address;

use App\Models\Endereco;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class EnderecoType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Endereco',
        'description' => 'A type',
        'model' => Endereco::class,
    ];

    public function fields(): array
    {
        return [
            "id" => [
                "type" => Type::nonNull(Type::int()),
                "description" => "The id of the address"
            ],
            "street" => [
                "type" => Type::nonNull(Type::string()),
                "description" => "The street of the address"
            ],
            "number" => [
                "type" => Type::nonNull(Type::string()),
                "description" => "The number of the address"
            ],
            "city" => [
                "type" => Type::nonNull(Type::string()),
                "description" => "The city of the address"
            ],
            "state" => [
                "type" => Type::nonNull(Type::string()),
                "description" => "The state of the address"
            ],
            "country" => [
                "type" => Type::nonNull(Type::string()),
                "description" => "The country of the address"
            ],
            "zip_code" => [
                "type" => Type::nonNull(Type::string()),
                "description" => "The postal code of the address"
            ],
            "complement" => [
                "type" => Type::string(),
                "description" => "The complement of the address"
            ],
            'users' => [
                'type' => Type::listOf(GraphQL::type('User')),
                'description' => 'The users of address',
            ],
        ];
    }
}
