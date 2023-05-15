<?php

namespace App\Repository\Implements\Stock;

use App\Models\Category;
use App\Models\Product;
use App\Repository\StockRepositoryInterface;

class StockRepository implements StockRepositoryInterface
{
    protected $entities;

    public function __construct(Category $category)
    {
        $this->entities = $category;
    }

    public function all()
    {
        return Product::all();
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
