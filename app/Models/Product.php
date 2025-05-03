<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'image',
        'price',
        'stock',
        'is_active',
        'slug'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    public function cart()
    {
        return $this->hasMany(CartProduct::class);
    }

    public function order()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('images/default-product.jpg');
    }

    public function uploadImage($image)
    {
        if ($image) {
            // Delete old image if exists
            if ($this->image) {
                if (Storage::disk('public')->exists($this->image)) {
                    Storage::disk('public')->delete($this->image);
                }
            }

            // Store new image
            $path = $image->store('products', 'public');
            $this->image = $path;
            $this->save();
            return $path;
        }
        return null;
    }
}
