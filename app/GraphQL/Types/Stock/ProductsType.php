<?php

namespace App\GraphQL\Types\Stock;

use App\Models\Product;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class ProductsType extends GraphQLType
{

    protected $attributes = [
        'name' => 'Product',
        'description' => 'A type for product',
        'model' => Product::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The id of the product',
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'The name of product',
            ],
            'description' => [
                'type' => Type::string(),
                'description' => 'The description of product',
            ],
            'price' => [
                'type' => Type::string(),
                'description' => 'The price of product',
            ],
            'image' => [
                'type' => Type::string(),
                'description' => 'The image of product',
            ],
            'qtd' => [
                'type' => Type::int(),
                'description' => 'The qtd of product',
            ],
            'is_variation' => [
                'type' => Type::boolean(),
                'description' => 'The is_variation of product',
            ],
            'variation' => [
                'type' => Type::listOf(Type::string()),
                'description' => 'The variation of product',
            ],
            'message' => [
                'type' => Type::string(),
                'description' => 'The message of product',
            ],
            'category' => [
                'type' => GraphQL::type('Category'),
                'description' => 'The product of product',
            ],
            'product_with_variations' => [
                'type' => Type::listOf(GraphQL::type('CategoryProduct')),
                'description' => 'The product of product',
            ],
            'product_variations' => [
                'type' => Type::listOf(GraphQL::type('ProductVariations')),
                'description' => 'The product of product',
            ],

        ];
    }
}
