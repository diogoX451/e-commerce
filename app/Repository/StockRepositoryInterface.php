<?php

namespace App\Repository;

interface StockRepositoryInterface
{
    public function createCategory($category);
    public function updateCategory($category);
    public function deleteCategory($category);
}