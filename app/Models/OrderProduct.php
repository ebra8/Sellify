<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'qty',
        'price'
    ];

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($orderProduct) {
            $orderProduct->order->calculateTotal();
        });

        static::deleted(function ($orderProduct) {
            $orderProduct->order->calculateTotal();
        });
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getTotalAttribute()
    {
        return $this->price * $this->qty;
    }
}
