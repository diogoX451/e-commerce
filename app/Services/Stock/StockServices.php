<?php


namespace App\Services\Stock;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductCategoryItens;
use App\Models\ProductVariations;
use App\Models\ProductWithCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;


class StockServices
{
    private $uuid;

    public function __construct()
    {
        $this->uuid = Str::uuid()->toString();
    }

    public function findProduct(string $id)
    {
        $redis = Redis::connection();
        if ($redis->exists('products' . $id)) {
            $product = $redis->get('products' . $id);
            return json_decode($product);
        }

        $subQuery = DB::table('product as p')
            ->select(
                'p.name',
                'c.name as Categorias',
                DB::raw("json_build_object(
            'itens_category', json_agg(
                json_build_object(
                    'name', vpci.name
                )
            )
        ) as itens_category")
            )
            ->join('category as c', 'p.category_id', '=', 'c.id')
            ->join('variations_products as vp', 'p.id', '=', 'vp.product_id')
            ->join('variationCatOption as vco', 'vp.id', '=', 'vco.variations_products_id')
            ->join('variations_products_category_items as vpci', 'vco.variations_products_category_items_id', '=', 'vpci.id')
            ->where('p.id', '=', $id)
            ->groupBy('p.name', 'c.name', 'vp.id');

        $results = DB::table(DB::raw("({$subQuery->toSql()}) as subquery"))
            ->mergeBindings($subQuery)
            ->select(
                'name',
                'Categorias',
                DB::raw("json_build_object('product_variations', json_agg(itens_category)) as product_variations")
            )
            ->groupBy('name', 'Categorias')
            ->get();

        $results->map(function ($item) {
            $item->product_variations = json_decode($item->product_variations);
        });

        $redis->set('products' . $id, json_encode($results));
        $redis->expire('products' . $id, 60);

        return $results;
    }

    public function createCategory(array $category)
    {

        $category = Category::create([
            'name' => $category['name'],
            'description' => $category['description'],
            'id' =>  $this->uuid
        ]);

        return ['message' => 'Categoria cadastrada com sucesso'];
    }

    public function createProduct(array $product)
    {
        $category =  Category::find($product['category_id']);

        if (!$category) {
            throw new \Exception("Categoria não encontrada");
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
            $this->generateVariations($products->id);
            return $products;
        }

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

        foreach ($product['variation'] as $variation) {
            ProductWithCategory::create([
                'id' => Str::uuid()->toString(),
                'name' => $variation,
                'product_id' => $products->id
            ]);
        }

        return ['message' => 'Produto cadastrado com sucesso'];
    }

    public function createItensCategoryProduct(array $itens)
    {
        $categoryProduct = ProductWithCategory::find($itens['category_product_id']);
        $itensProduct = [];
        $index = 0;

        DB::transaction(function () use ($itens, $categoryProduct, $itensProduct, $index) {
            foreach ($itens['name'] as $name) {
                $itensProduct[$index]['id'] = Str::uuid()->toString();
                $itensProduct[$index]['name'] = $name;
                $itensProduct[$index]['description'] = $itens['description'][$index];
                $itensProduct[$index]['variations_category_id'] = $categoryProduct->id;
                $index++;
            }
            ProductCategoryItens::insert($itensProduct);
            $this->generateVariations($categoryProduct->product_id);
        }, 3);

        return ['message' => 'Itens cadastrados com sucesso'];
    }

    private function generateVariations($variation)
    {
        $categoryProduct = ProductWithCategory::where('product_id', $variation)->get();
        $idProduct = $categoryProduct->first()->product_id;
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

        DB::transaction(function () use ($idProduct, $variations) {
            foreach ($variations as $var) {
                ProductVariations::create([
                    'id' => Str::uuid()->toString(),
                    'qtd_stock' => $var['qtd_stock'] ?? 0,
                    'price' => $var['price'] ?? 0,
                    'product_id' => $idProduct,
                ]);
            }
            DB::table('variationCatOption')
                ->insert(
                    $this->createRelationProductVariation($idProduct, $variations)
                );
        }, 3);

        return;
    }

    private function createRelationProductVariation($id, array $variation)
    {
        $index = 0;
        $indexExt = 0;
        $searchVariation = ProductVariations::where('product_id', $id)->get();
        $variationCatOption = [];

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

    public function teste($id)
    {
        $id = $id['id'];
        $products = Product::with('productVariations')->find($id);
        $products->productVariations->each(function ($item) {
            $item->itensCategory;
        });


        $redis = Redis::connection();
        $redis->set('products' . $id, json_encode($products));

        if ($redis->exists('products' . $id)) {
            $product = $redis->get('products' . $id);
            return json_decode($product);
        }

        return $products;
    }
}
