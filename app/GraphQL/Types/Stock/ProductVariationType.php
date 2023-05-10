<?php

namespace App\GraphQL\Types\Stock;

use GraphQL\Type\Definition\Type as DefinitionType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type;

class ProductVariationType extends Type
{

    protected $attributes = [
        'name' => 'ProductVariation',
        'description' => 'A type for product variation',
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => DefinitionType::nonNull(DefinitionType::string()),
                'description' => 'The id of the product variation',
            ],
            'qtd_stock' => [
                'type' => DefinitionType::int(),
                'description' => 'The name of product variation',
            ],
            'price' => [
                'type' => DefinitionType::string(),
                'description' => 'The description of product variation',
            ],
            'productVariationsCat' => [
                'type' => DefinitionType::listOf(GraphQL::type('VariationCat')),
                'description' => 'The variation of product variation',
            ],
            'itensCategory' => [
                'type' => DefinitionType::listOf(GraphQL::type('ItensCategory')),
                'description' => 'The itens of product variation',
            ],
        ];
    }
}
