<?php

namespace App\GraphQL\Queries\Stock;

use App\Repository\StockRepositoryInterface;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Redis;
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
    
    public function resolve()
    {
        return $this->stockRepository->all();
    }
}
