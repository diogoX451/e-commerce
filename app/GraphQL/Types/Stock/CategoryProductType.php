<?php

namespace App\GraphQL\Types\Stock;

use App\Models\ProductWithCategory;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class CategoryProductType extends GraphQLType
{

    protected $attributes = [
        'name' => 'CategoryProduct',
        'description' => 'A type for category',
        'model' => ProductWithCategory::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The id of the category',
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'The name of category',
            ],
            'description' => [
                'type' => Type::string(),
                'description' => 'The description of category',
            ],
            'product' => [
                'type' => GraphQL::type('Product'),
                'description' => 'The products of product',
            ],
            'itensCategory' => [
                'type' => Type::listOf(GraphQL::type('ItensCategory')),
                'description' => 'The itens of category',
            ],
        ];
    }
}
