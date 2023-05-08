<?php


namespace App\Services\Stock;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductCategoryItens;
use App\Models\ProductWithCategory;
use Illuminate\Support\Str;

class StockServices
{

    private $uuid;

    public function __construct()
    {
        $this->uuid = Str::uuid()->toString();
    }

    public function createCategory($category)
    {

        $category = Category::create([
            'name' => $category['name'],
            'description' => $category['description'],
            'id' =>  $this->uuid
        ]);

        return $category;
    }

    public function createProduct($product)
    {

        $category =  Category::where("name", "ilike", "%{$product['category']}%")->first();

        if (!$category) {
            return 'Category not found';
        }

        if (!$product['is_variation']) {
            $products = Product::create([
                'id' => $this->uuid,
                'name' => $product['name'],
                'description' => $product['description'],
                'price' => $product['price'],
                'image' => $product['image'],
                'qtd' => $product['qtd'],
                'is_variation' => $product['is_variation'],
                'category_id' => $category->id
            ]);
            return $products;
        }

        $create = Product::create([
            'id' => $this->uuid,
            'name' => $product['name'],
            'description' => $product['description'],
            'price' => $product['price'],
            'image' => $product['image'],
            'qtd' => $product['qtd'],
            'is_variation' => $product['is_variation'],
            'category_id' => $category->id
        ]);

        foreach ($product['variation'] as $variation) {
            ProductWithCategory::create([
                'id' => Str::uuid()->toString(),
                'name' => $variation,
                'product_id' => $create->id
            ]);
        }

        return $create;
    }


    public function createItensCategoryProduct($itens)
    {
        $categoryProduct = ProductWithCategory::find($itens['category_product_id']);
        $itensProduct = [];
        $index = 0;
        foreach ($itens['name'] as $name) {
            $itensProduct[$index]['id'] = Str::uuid()->toString();
            $itensProduct[$index]['name'] = $name;
            $itensProduct[$index]['description'] = $itens['description'][$index];
            $itensProduct[$index]['variations_category_id'] = $categoryProduct->id;
            $index++;
        }
        ProductCategoryItens::insert($itensProduct);
        return $itensProduct;
    }
    public function generateVariations($variation)
    {
        $product = ProductWithCategory::where('product_id', $variation['product_id'])->get();
        // $category = $product->ProductWithItens;
        // $categoryItens = $category->productWithCategory->items;

        $itensVariation = $product->each(function ($itens) {
            $itens->itensCategory;
        });
        $itensVariation = [];
        foreach ($itensVariation as $itens) {
            foreach ($itens->itensCategory as $item) {
                $itensVariation = $item->name;
            }
        }
        return  $itensVariation;
    }

    public function cartesianProduct($arrays)
    {
        $result = array();
        $arrays = array_values($arrays);
        $sizeIn = sizeof($arrays);
        $size = $sizeIn > 0 ? 1 : 0;
        foreach ($arrays as $array) {
            $size = $size * sizeof($array);
        }
        for ($i = 0; $i < $size; $i++) {
            $result[$i] = array();
            for ($j = 0; $j < $sizeIn; $j++) {
                array_push($result[$i], current($arrays[$j]));
            }
            for ($j = ($sizeIn - 1); $j >= 0; $j--) {
                if (next($arrays[$j])) {
                    break;
                } elseif (isset($arrays[$j])) {
                    reset($arrays[$j]);
                }
            }
        }
        return $result;
    }
}
