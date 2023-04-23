<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    use HasFactory, HasUuids;

    protected $table = 'product';

    protected $fillable = [
        'id',
        'name',
        'description',
        'price',
        'image',
        'qtd',
        'is_variation',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
