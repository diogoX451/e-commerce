<?php


namespace App\Services\Stock;

use App\Models\Category;
use App\Models\Product;
use App\Repository\StockRepositoryInterface;
use Illuminate\Support\Str;

class StockServices {

    private $uuid;

    public function __construct(){
        $this->uuid = Str::uuid()->toString();
    }

    public function createCategory($category){

        $category = Category::create([
            'name' => $category['name'],
            'description' => $category['description'],
            'id' =>  $this->uuid
        ]);

        return $category;
    }
    
    public function createProduct($product){
        
        $category =  Category::where("name", "ilike", "%{$product['category']}%")->first();

        if(!$category){
            return 'Category not found';
        }
        
        if(!$product['is_variation']){
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

    }
}