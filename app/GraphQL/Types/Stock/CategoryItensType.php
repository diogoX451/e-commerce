<?php

namespace App\GraphQL\Types\Stock;

use App\Models\ProductCategoryItens;
use GraphQL\Type\Definition\Type;

class CategoryItensType extends Type {
    
    protected $attributes = [
        'name' => 'CategoryItens',
        'description' => 'A type for category itens',
        'model' => ProductCategoryItens::class,
    ];
}