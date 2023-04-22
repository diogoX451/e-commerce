<?php

namespace App\GraphQL\Types\Stock;

use App\Models\Category;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class CategoryType extends GraphQLType {

    protected $attributes = [
        'name' => 'Category',
        'description' => 'A type for category',
        'model' => Category::class,
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
            // 'product' => [
            //     'type' => Type::listOf(GraphQL::type('Products')),
            //     'description' => 'The products of product',
            // ],
        ];
    }

}