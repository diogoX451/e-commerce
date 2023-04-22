<?php

namespace App\Repository\Implements\Stock;

use App\Models\Category;
use App\Repository\StockRepositoryInterface;

class StockRepository implements StockRepositoryInterface
{
    protected $entities;

    public function __construct(Category $category){
        $this->entities = $category;
    }

    public function createCategory($category){
        $this->entities->create($category);
    }

    public function updateCategory($category){
        $this->entities->update($category);
    }

    public function deleteCategory($category){
        $this->entities->delete($category);
    }
}