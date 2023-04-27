<?php


namespace App\Services\Stock;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;
use ProductWithCategory;

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

<<<<<<< HEAD
=======
       
        foreach($product['variation'] as $variation){
            ProductWithCategory::create([
                'id' => $this->uuid,
                'name' => $variation,
                'product_id' => $product->id
            ]);
        }

>>>>>>> 096edcd (MELHORIA NO LOGIN, ARRUMANDO OS ADDRESS ID E RETURNS)
        $product = Product::create([
            'id' => $this->uuid,
            'name' => $product['name'],
            'description' => $product['description'],
            'price' => $product['price'],
            'image' => $product['image'],
            'qtd' => $product['qtd'],
            'is_variation' => $product['is_variation'],
            'category_id' => $category->id
        ]);

<<<<<<< HEAD
        foreach ($product['variation'] as $variation) {
            ProductWithCategory::create([
                'id' => $this->uuid,
                'name' => $variation,
                'product_id' => $product->id
            ]);
        }



=======
>>>>>>> 096edcd (MELHORIA NO LOGIN, ARRUMANDO OS ADDRESS ID E RETURNS)
        return $product;
    }
}
