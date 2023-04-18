<?php

namespace App\Models;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function products()
    {
        return $this->belongsTo(Product::class);
    }
}
