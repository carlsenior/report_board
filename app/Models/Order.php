<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_method',
    ];

    public function owner(): BelongsTo {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function payment(): BelongsTo {
        return $this->belongsTo(PaymentMethod::class, 'payment_id');
    }

    public function orderItems(): HasMany {
        return $this->hasMany(OrderItem::class, 'order_id');
    }
}
