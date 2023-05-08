<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class ProductVariations extends Model
{
    use HasUuids;

    protected $fillable = [
        'id',
        'name',
        'description',
        'price',
        'image',
        'qtd',
        'is_variation',
        'category_id',
        'product_id'
    ];
}
