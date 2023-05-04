<?php

namespace App\GraphQL\Mutations\Stock;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

class CreateCategoryItens extends  Mutation {
    protected $attributes = [
        'name' => 'createCategoryItens',
        'description' => 'Create Category Itens'
    ];

    public function type(): Type {
        return ;
    }
}