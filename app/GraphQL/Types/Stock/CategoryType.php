<?php

namespace App\GraphQL\Types\Stock;

use GraphQL\Type\Definition\Type as DefinitionType;
use Rebing\GraphQL\Support\Type;

class CategoryType extends Type {

    protected $attributes = [
        'name' => 'Category',
        'description' => 'A type for category',
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => DefinitionType::nonNull(DefinitionType::string()),
                'description' => 'The id of the category',
            ],
            'name' => [
                'type' => DefinitionType::string(),
                'description' => 'The name of category',
            ],
            'description' => [
                'type' => DefinitionType::string(),
                'description' => 'The description of category',
            ],
        ];
    }

}