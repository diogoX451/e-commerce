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
        return $this->belongsTo(Product::class);
    }
    public function variationsItems()
    {
        return $this->belongsTo(ProductCategoryItens::class);
    }
    public function productVariationsCat()
    {
        return $this->belongsToMany(ProductVariationCat::class, 'variationCatOption', 'variations_products_id');
    }
}
