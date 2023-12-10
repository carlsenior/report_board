<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'quantity',
        'price',
        'discount'
    ];

    public function order(): BelongsTo {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function product(): BelongsTo {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function category(): \Illuminate\Database\Eloquent\Relations\HasOneThrough
    {
        return $this->hasOneThrough(Category::class, Product::class, 'id', 'id', 'product_id', 'category_id');
    }

    public function owner(): \Illuminate\Database\Eloquent\Relations\HasOneThrough
    {
        return $this->hasOneThrough(Customer::class, Order::class, 'id', 'id', 'order_id', 'customer_id');
    }
}
