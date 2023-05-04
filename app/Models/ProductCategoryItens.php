<?php

namespace  App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class ProductCategoryItens extends Model
{
    use HasUuids;

    protected $table = 'variations_products_category_items';

    protected $fillable = [
        'id',
        'name',
        'variations_category_id'
    ];

    public function ProductWithCategory()
    {
        return $this->belongsTo(ProductWithCategory::class);
    }
}