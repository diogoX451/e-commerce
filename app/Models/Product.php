<?php

namespace App\Models;

class Product extends Model
{

    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'category_id',
    ];

    public function category()
    {
        return $this->hasMany(Category::class);
    }
}
