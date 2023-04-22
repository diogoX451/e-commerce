<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations\Stock;

use App\Services\Stock\StockServices;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class CreateCategoryMutation extends Mutation{

    protected $stockService;

    public function __construct(StockServices $stockService)
    {
        $this->stockService = $stockService;
    }

    protected $attributes = [
        'name' => 'createCategory',
        'description' => 'A type for category',
    ];

    public function type(): Type
    {
        return GraphQL::type('Category');
    }

    public function args(): array
    {
        return [
            'name' => [
                'type' => Type::nonNull(Type::string()),
            ],
            'description' => [
                'type' => Type::nonNull(Type::string()),
            ]
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields ){
        
        return $this->stockService->createCategory($args); 
    }
}