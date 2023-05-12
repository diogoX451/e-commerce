<?php

namespace App\GraphQL\Queries\Stock;

use App\Models\Product;
use App\Models\ProductVariationCat;
use App\Models\ProductVariations;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class ProductQuery extends Query
{
    protected $attributes = [
        'name' => 'product',
        'description' => 'A query'
    ];

    public function type(): Type
    {
        return GraphQL::type('Product');
    }

    public function args(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The id of the product'
            ]
        ];
    }

    public function resolve($root, $args)
    {

        $product = Product::where('id', $args['id'])->first();

        $productVariations = ProductVariations::where('product_id', $args['id'])->get();

        foreach ($productVariations as $key => $value) {
            $productVariationsCat = ProductVariationCat::where('variations_products_id', $value->id)->get();
            foreach ($productVariationsCat as $key2 => $value2) {
                $itensCategory = $value2->itensCategory()->get();
                $productVariations[$key]->productVariationsCat[$key2]->itensCategory = $itensCategory;
            }
            $product->productVariations = $productVariations;
        }
        return $product;
    }
}
