<?php

namespace App\Repository;

interface StockRepositoryInterface
{
    public function all();
    public function updateCategory($category);
    public function deleteCategory($category);
}
