<?php

namespace App\GraphQL\Queries\Stock;

use App\Repository\StockRepositoryInterface;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class ProductsQuery extends Query
{
    private StockRepositoryInterface $stockRepository;

    public function __construct(StockRepositoryInterface $stockRepository)
    {
        $this->stockRepository = $stockRepository;
    }

    protected $attributes = [
        'name' => 'products',
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
                'type' => Type::string(),
                'description' => 'The id of the product'
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'The name of the product'
            ],
            'description' => [
                'type' => Type::string(),
                'description' => 'The description of the product'
            ],
            'price' => [
                'type' => Type::string(),
                'description' => 'The price of the product'
            ],
            'image' => [
                'type' => Type::string(),
                'description' => 'The image of the product'
            ],
        ];
    }

    public function resolve()
    {
        return $this->stockRepository->all();
    }
}
