<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to view your orders');
        }

        $orders = Auth::user()->orders()
            ->with(['orderProducts.product', 'address'])
            ->latest()
            ->get();

        return view('orders.index', compact('orders'));
    }
}
