<?php

namespace App\GraphQL\Mutations\Stock;

use App\Services\Stock\StockServices;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class CreateCategoryItens extends  Mutation {
    protected $attributes = [
        'name' => 'createCategoryItens',
        'description' => 'Create Category Itens'
    ];

    public function type(): Type {
        return GraphQL::type('ItensCategory');
    }

    public function args (): array {
        return [
            'name' => [
                'type' => Type::nonNull(Type::listOf(Type::string())),
                'description' => 'Name of Category'
            ],
            'description' => [
                'type' => Type::nonNull(Type::listOf(Type::string())),
                'description' => 'Description of Category'
            ],
            'category_product_id' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Category ID'
            ],
        ];
    }
    public function resolve($root, array $args)
    {
        return (new StockServices())->createItensCategoryProduct($args);
    }
}