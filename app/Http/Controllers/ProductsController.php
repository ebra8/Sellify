<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::with('category')
            ->where('is_active', true)
            ->get();
            
        return view('products.index', compact('products'));
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $category = $request->input('category');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        $sort = $request->input('sort', 'relevance');
        
        $products = Product::with('category')
            ->where('is_active', true)
            ->when($query, function($q) use ($query) {
                $q->where(function($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%");
                });
            })
            ->when($category, function($q) use ($category) {
                $q->whereHas('category', function($q) use ($category) {
                    $q->where('slug', $category);
                });
            })
            ->when($minPrice, function($q) use ($minPrice) {
                $q->where('price', '>=', $minPrice);
            })
            ->when($maxPrice, function($q) use ($maxPrice) {
                $q->where('price', '<=', $maxPrice);
            })
            ->when($sort, function($q) use ($sort) {
                switch($sort) {
                    case 'price_asc':
                        $q->orderBy('price', 'asc');
                        break;
                    case 'price_desc':
                        $q->orderBy('price', 'desc');
                        break;
                    case 'newest':
                        $q->orderBy('created_at', 'desc');
                        break;
                    default:
                        $q->orderBy('created_at', 'desc');
                }
            })
            ->paginate(12);
            
        $categories = Category::all();
            
        return view('products.search', compact('products', 'query', 'categories', 'category', 'minPrice', 'maxPrice', 'sort'));
    }
}
