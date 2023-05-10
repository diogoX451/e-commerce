<?php

namespace App\GraphQL\Types\Stock;

use App\Models\ProductVariationCat;
use GraphQL\Type\Definition\Type as DefinitionType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type;

class VariationCatType extends Type
{
    protected $attributes = [
        'name' => 'VariationCat',
        'description' => 'A type for variation category',
        'model' => ProductVariationCat::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => DefinitionType::nonNull(DefinitionType::string()),
                'description' => 'The id of the variation category',
            ],
            'itensCategory' => [
                'type' => DefinitionType::listOf(GraphQL::type('ItensCategory')),
                'description' => 'The itens of variation category',
            ],
            'productVariations' => [
                'type' => DefinitionType::listOf(GraphQL::type('ProductVariation')),
                'description' => 'The variation of variation category',
            ],
        ];
    }
}
