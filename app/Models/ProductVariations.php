<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class ProductVariations extends Model
{
    use HasUuids;

    protected $table = 'variations_products';

    protected $fillable = [
        'id',
        'qtd_stock',
        'price',
        'product_id',
        'variations_products_category_items_id',
        'created_at',
        'updated_at'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function itensCategory()
    {
        return $this->belongsToMany(ProductCategoryItens::class, 'variationCatOption', 'variations_products_id', 'variations_products_category_items_id')
            ->using(PivotVariations::class);
    }
   
    public function variationCatOption()
    {
        return $this->hasMany(ProductVariationCat::class);
    }
}
