<?php


namespace App\Services\Stock;

use App\Models\Category;
use App\Models\Product;
use App\Repository\StockRepositoryInterface;
use Illuminate\Support\Str;

class StockServices {
    //use transations em caso do stock
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
        
        $category =  Category::where('name', '=', $product['name'])->first();
        
        if(!$category){
            return 'Category not found';
        }
        
        $variationProduct = $product['is_variation'];

        if(!$variationProduct){
            $product = Product::create([
                'name' => $product['name'],
                'description' => $product['description'],
                'price' => $product['price'],
                'image' => $product['image'],
                'is_variation' => $product['is_variation'],
                'category_id' => $category->id,
                'id' => $this->uuid
            ]);
            return $product;
        }
        
    }
}