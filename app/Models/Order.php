<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address_id',
        'status',
        'total'
    ];

    protected $casts = [
        'total' => 'decimal:2'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (!isset($order->status)) {
                $order->status = 'pending';
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function history()
    {
        return $this->hasMany(OrderHistory::class)->latest();
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_products')
                    ->withPivot('qty', 'price')
                    ->withTimestamps();
    }

    public function calculateTotal()
    {
        try {
            DB::beginTransaction();

            $total = $this->orderProducts->sum(function ($item) {
                if (!$item->price || !$item->qty) {
                    return 0;
                }
                return $item->price * $item->qty;
            });
            
            $this->total = $total;
            $this->save();

            DB::commit();
            return $total;
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error calculating order total: ' . $e->getMessage());
            return 0;
        }
    }

    public function getStatusColorAttribute()
    {
        switch($this->status) {
            case 'pending':
                return 'warning';
            case 'processing':
                return 'info';
            case 'completed':
                return 'success';
            case 'cancelled':
                return 'danger';
            default:
                return 'secondary';
        }
    }

    public function validateOrder()
    {
        if ($this->orderProducts->isEmpty()) {
            return false;
        }

        foreach ($this->orderProducts as $item) {
            if (!$item->price || !$item->qty || $item->qty <= 0) {
                return false;
            }
        }

        return true;
    }
}
