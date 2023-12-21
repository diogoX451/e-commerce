<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{

    use HasFactory, HasUuids;

    protected $table = 'product';

    protected $fillable = [
        'id',
        'name',
        'description',
        'price',
        'image',
        'qtd',
        'variation',
        'is_variation',
        'category_id',
    ];

    public function category()
    {
        return $this->hasMany(Category::class);
    }

    public function product_with_variations()
    {
        return $this->hasMany(ProductWithCategory::class);
    }
    public function productVariations()
    {
        return $this->hasMany(ProductVariations::class);
    }

    public function getRelationProduct(string $id){

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

        $consult = DB::table(DB::raw("({$subQuery->toSql()}) as subquery"))
        ->mergeBindings($subQuery)
        ->select(
            'name',
            'Categorias',
            DB::raw("json_build_object('product_variations', json_agg(itens_category)) as product_variations")
        )
        ->groupBy('name', 'Categorias')
        ->get();

        return $consult;
        
    }
}
