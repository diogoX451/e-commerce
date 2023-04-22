<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations\Stock;

use App\Services\Stock\StockServices;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class CreateProductMutation extends Mutation{


    protected $attributes = [
        'name' => 'createProduct',
        'description' => 'A type for Product',
    ];

    public function type(): Type
    {
        return GraphQL::type('Products');
    }

    public function args(): array
    {
        return [
            'name' => [
                'type' => Type::nonNull(Type::string()),
            ],
            'description' => [
                'type' => Type::nonNull(Type::string()),
            ],
            'price' => [
                'type' => Type::nonNull(Type::string()),
            ],
            'image' => [
                'type' => Type::nonNull(Type::string()),
            ],
            'is_variation' => [
                'type' => Type::nonNull(Type::boolean()),
            ],
            'category'=> [
                'type' => Type::nonNull(Type::string()),
            ]
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields ){
        return (new StockServices())->createProduct($args);
    }
}