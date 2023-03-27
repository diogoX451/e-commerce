<?php

namespace App\GraphQL\Queries\Address;

use App\Models\Endereco;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class EnderecoQuery extends Query
{
    protected $attributes = [
        'name' => 'addresses',
        'description' => 'A query',
        'model' => Endereco::class,
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Endereco'));
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::int(),
            ],
            'street' => [
                'name' => 'street',
                'type' => Type::string(),
            ],
            'number' => [
                'name' => 'number',
                'type' => Type::string(),
            ],
            'city' => [
                'name' => 'city',
                'type' => Type::string(),
            ],
            'country' => [
                'name' => 'country',
                'type' => Type::string(),
            ],
            'zip_code' => [
                'name' => 'zip_code',
                'type' => Type::string(),
            ],
            'complement' => [
                'name' => 'complement',
                'type' => Type::string(),
            ],
            
        ];
    }
    
    public function resolve($root, $args)
    {
        return Endereco::all();
    }
}