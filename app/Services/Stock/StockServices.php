<?php


namespace App\Services\Stock;

use App\Models\Category;
use App\Models\Product;
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

        // $categoryTypes = ProductWithCategory::where('id', $itens['category_product_id'])->first();
        // $itensCategory = [];
        // $itensTeste = [];
        // $index = 0;
        // foreach ($itens['name'] as $name) {
        //     $itensTeste[] = $name;
        //     $index++;
        // }
        // for ($i = 0; $i < $index; $i++) {
        //     $itensCategory[] = $itensTeste[$i] . ' ' . $categoryTypes->name;
        // }
        // return $itensCategory;
        $product = Product::findOrFail($itens['category_product_id']);
        $variation_options = $product->productWithCategory;
        $variations = [];
        $itensVariantons = [];
        $index = 0;
        foreach ($itens['name'] as $name) {
            $itensVariantons[] = $name;
            $index++;
        }

        foreach ($variation_options as $option) {
            $values = $option->pluck('name')->toArray();
            $variations[] = $values;
        }

        $combinations = $this->cartesianProduct($itensVariantons);
        foreach ($combinations as $combination) {
            return $combination;
        }
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

    private function create_variations()
    {
    }
}
