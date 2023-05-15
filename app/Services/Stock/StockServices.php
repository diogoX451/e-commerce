<?php


namespace App\Services\Stock;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductCategoryItens;
use App\Models\ProductVariations;
use App\Models\ProductWithCategory;
use Illuminate\Support\Facades\DB;
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

        // $teste = $this->generateVariations($categoryProduct->product_id);

        return $itensProduct;
    }

    public function generateVariations($variation)
    {
        $id = $variation['product_id'];
        $categoryProduct = ProductWithCategory::where('product_id', $id)->get();
        $variationCat = [];
        $itensVariation = $categoryProduct->each(function ($itens) {
            $itens->itensCategory;
        });

        $variations = [[]];
        foreach ($itensVariation as $itens) {
            $newVariation = [];
            foreach ($variations as $variation) {
                foreach ($itens->itensCategory as $item) {
                    $newVariation[] = array_merge($variation, [$item->id]);
                }
            }
            $variations = $newVariation;
        }


        DB::transaction(function () use ($id, $variationCat, $variations) {
            foreach ($variations as $var) {
                ProductVariations::create([
                    'id' => Str::uuid()->toString(),
                    'qtd_stock' => $var['qtd_stock'] ?? 0,
                    'price' => $var['price'] ?? 0,
                    'product_id' => $id,
                ]);
            }
            $variationCatOption = $this->createVariationCatOption($id, $variations);
            DB::table('variationCatOption')->insert($variationCatOption);
        }, 3);

        return $variationCat;
    }

    private function createVariationCatOption($variationCat, array $variation)
    {
        $index = 0;
        $indexExt = 0;
        $searchVariation = ProductVariations::where('product_id', $variationCat)->get();
        $variationCatOption = [];

        //montar todas as combinações

        foreach ($variation as $var) {
            foreach ($var as $v) {
                $variationCatOption[$index]['id'] = Str::uuid()->toString();
                $variationCatOption[$index]['variations_products_id'] = $searchVariation[$indexExt]->id;
                $variationCatOption[$index]['variations_products_category_items_id'] = $v;
                $index++;
            }
            $indexExt++;
        }

        return $variationCatOption;
    }
}
