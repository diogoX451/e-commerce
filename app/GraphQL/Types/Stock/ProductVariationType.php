<?php

namespace App\GraphQL\Types\Stock;

use App\Models\ProductVariations;
use GraphQL\Type\Definition\Type as DefinitionType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type;

class ProductVariationType extends Type
{

    protected $attributes = [
        'name' => 'ProductVariations',
        'description' => 'A type for product variation',
        'model' => ProductVariations::class,
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
            'itens_category' => [
                'type' => DefinitionType::listOf(GraphQL::type('ItensCategory')),
                'description' => 'The itens of product variation',
            ],
        ];
    }
}
