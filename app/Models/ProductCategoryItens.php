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
        'description',
        'variations_category_id'
    ];

    public function categoryItens()
    {
        return $this->belongsTo(ProductWithCategory::class, 'variations_category_id');
    }
}
