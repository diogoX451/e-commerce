<?php

namespace App\GraphQL\Queries\Stock;

use App\Models\Product;
use App\Models\ProductVariationCat;
use App\Models\ProductVariations;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Redis;
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

    public function resolve($root, array $args)
    {
        $id = $args['id'];
        $redis = Redis::connection();
        if ($redis->exists('products' . $id)) {
            $product = $redis->get('products' . $id);
            return json_decode($product);
        }

        $products = Product::with('productVariations')->find($id);
        $products->productVariations->each(function ($item) {
            $item->itensCategory;
        });

        $redis->set('products' . $id, json_encode($products));
        $redis->expire('products' . $id, 60);
    }
}
