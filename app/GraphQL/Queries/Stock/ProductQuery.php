<?php

namespace App\GraphQL\Queries\Stock;

use App\Models\Product;
use App\Models\ProductVariationCat;
use App\Models\ProductVariations;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class ProductQuery extends Query
{
    protected $attributes = [
        'name' => 'product',
        'description' => 'A query'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Product'));
    }

    public function args(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The id of the product'
            ]
        ];
    }

    public function resolve($root, array $args)
    {
        return Product::find($args);
    }
}
