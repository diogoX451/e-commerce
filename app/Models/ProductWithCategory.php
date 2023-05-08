<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class ProductWithCategory extends Model
{
    use HasUuids;
    protected $table = 'variations_products_with_category';
    protected $fillable = [
        'id',
        'name',
        'product_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function itensCategory()
    {
        return $this->hasMany(ProductCategoryItens::class, 'variations_category_id');
    }
}
