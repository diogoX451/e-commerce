<?php

use Illuminate\Database\Eloquent\Model;

class ProductWithCategory extends Model {

    protected $table = 'variations_products_category_items';
    protected $fillable = [
        'id',
        'name',
        'product_id',
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }
}