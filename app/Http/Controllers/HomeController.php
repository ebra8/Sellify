<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories = Category::withCount(['products' => function($query) {
            $query->where('is_active', true);
        }])->get();

        $featuredProducts = Product::where('is_active', true)
            ->inRandomOrder()
            ->take(8)
            ->get();

        return view('home', compact('categories', 'featuredProducts'));
    }
}
