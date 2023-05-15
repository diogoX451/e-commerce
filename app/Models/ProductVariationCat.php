<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class ProductVariationCat extends Model
{
    use HasUuids;

    protected $table = 'variationCatOption';
    protected $fillable = [
        'id',
        'variations_products_id',
        'variations_products_category_items_id',
    ];
}
