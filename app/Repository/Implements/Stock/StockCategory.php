<?php

namespace App\Repository\Implements\Stock;

use App\Models\Category;
use App\Repository\StockRepositoryInterface;

class StockCategory implements StockRepositoryInterface
{
    protected $entities;

    public function __construct(Category $product)
    {
        $this->entities = $product;
    }

    public function all()
    {
       return $this->entities->all();
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
