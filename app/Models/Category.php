<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Category extends Model
{
    use HasFactory;


    protected $fillable = [
        'name'
    ];

    public function products(): HasMany {
        return $this->hasMany(Product::class, 'category_id');
    }

    public function orderItems(): HasManyThrough {
        return $this->hasManyThrough(OrderItem::class, Product::class, 'category_id', 'product_id', 'id', 'id');
    }
}
