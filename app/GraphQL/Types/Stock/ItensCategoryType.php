<?php

namespace App\GraphQL\Types\Stock;

use App\Models\ProductCategoryItens;
use GraphQL\Type\Definition\Type;

use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as SupportType;

class ItensCategoryType extends SupportType
{

    protected $attributes = [
        'name' => 'ItensCategory',
        'description' => 'A type for category itens',
        'model' => ProductCategoryItens::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The id of the category itens',
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'The name of category itens',
            ],
            'description' => [
                'type' => Type::string(),
                'description' => 'The description of category itens',
            ],
            'productWithCategory' => [
                'type' => Type::listOf(GraphQL::type('CategoryProduct')),
                'description' => 'The category of category itens',
            ],
            'productVariationCat' => [
                'type' => Type::listOf(GraphQL::type('VariationCat')),
                'description' => 'The variation of category itens'
            ],
            'productVariations' => [
                'type' => Type::listOf(GraphQL::type('ProductVariations')),
                'description' => 'The variation of category itens'
            ],
        ];
    }
}
