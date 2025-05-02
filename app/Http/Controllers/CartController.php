<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $cart = $this->cartService->getCart();
        $total = 0;

        if (auth()->check()) {
            foreach ($cart->cartProducts as $item) {
                $total += $item->product->price * $item->qty;
            }
        } else {
            foreach ($cart as $item) {
                $total += $item['product']->price * $item['quantity'];
            }
        }

        return view('cart', compact('cart', 'total'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);
        $this->cartService->addToCart($product, $request->quantity);

        if ($request->ajax()) {
            return response()->json([
                'message' => 'Product added to cart successfully',
                'cart_count' => $this->getCartCount()
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart successfully');
    }

    public function updateQuantity(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);
        $this->cartService->updateCartItem($product, $request->quantity);

        return response()->json([
            'message' => 'Cart updated successfully',
            'cart_count' => $this->getCartCount()
        ]);
    }

    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $product = Product::findOrFail($request->product_id);
        $this->cartService->removeFromCart($product);

        return response()->json([
            'message' => 'Product removed from cart successfully',
            'cart_count' => $this->getCartCount()
        ]);
    }

    public function clear()
    {
        $this->cartService->clearCart();
        return response()->json([
            'message' => 'Cart cleared successfully',
            'cart_count' => 0
        ]);
    }

    public function count()
    {
        return response()->json([
            'count' => $this->getCartCount()
        ]);
    }

    private function getCartCount()
    {
        $cart = $this->cartService->getCart();
        if (auth()->check()) {
            return $cart->cartProducts->sum('qty');
        }
        return array_sum(array_column($cart, 'quantity'));
    }
}
