<?php

namespace App\Repository\Implements\Stock;

use App\Models\Category;
use App\Models\Product;
use App\Repository\StockRepositoryInterface;
use Illuminate\Support\Facades\Redis;

class StockRepository implements StockRepositoryInterface
{
    protected $entities;

    public function __construct(Product $product)
    {
        $this->entities = $product;
    }

    public function all()
    {
        $redis = Redis::get('products', function () {
            return $this->entities->all();
        });
        if (isset($redis)) {
            $teste = json_decode($redis);
            return $teste;
        }
    }

    public function updateCategory($category)
    {
        $this->entities->update($category);
    }

    public function deleteCategory($category)
    {
        $this->entities->delete($category);
    }
}
