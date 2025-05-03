<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image',
        'slug',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($category) {
            // Set all related products' category_id to null
            $category->products()->update(['category_id' => null]);
        });
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
