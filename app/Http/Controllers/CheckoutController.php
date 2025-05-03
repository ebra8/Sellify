<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Address;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        try {
            if (!auth()->check()) {
                // Store current cart in session
                $cart = $this->cartService->getCart();
                session()->put('guest_cart', $cart);
                
                // Store the intended URL (checkout) in the session
                session()->put('intended_url', route('checkout'));
                
                return redirect()->route('login');
            }

            // If user was redirected from login, check for guest cart
            if (session()->has('guest_cart')) {
                $guestCart = session()->get('guest_cart');
                $this->migrateGuestCartToUserCart($guestCart);
                session()->forget('guest_cart');
            }

            $cart = $this->cartService->getCart();
            $total = 0;

            foreach ($cart->cartProducts as $item) {
                $total += $item->product->price * $item->qty;
            }

            return view('checkout', compact('cart', 'total'));
        } catch (\Exception $e) {
            Log::error('Checkout index error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error loading checkout page. Please try again.');
        }
    }

    private function migrateGuestCartToUserCart($guestCart)
    {
        foreach ($guestCart as $productId => $item) {
            $product = Product::find($productId);
            if ($product) {
                $this->cartService->addToCart($product, $item['quantity']);
            }
        }
    }

    public function store(Request $request)
    {
        try {
            if (!auth()->check()) {
                // Store current cart in session
                $cart = $this->cartService->getCart();
                session()->put('guest_cart', $cart);
                
                // Store the intended URL (checkout) in the session
                session()->put('intended_url', route('checkout'));
                
                return response()->json([
                    'success' => false,
                    'redirect' => route('login')
                ], 401);
            }

            $request->validate([
                'first_name' => 'required_if:address_id,null|string|max:255',
                'last_name' => 'required_if:address_id,null|string|max:255',
                'address' => 'required_if:address_id,null|string|max:255',
                'city' => 'required_if:address_id,null|string|max:255',
                'state' => 'required_if:address_id,null|string|max:255',
                'zip_code' => 'required_if:address_id,null|string|max:255',
                'address_id' => 'required_if:first_name,null|exists:addresses,id',
                'card_number' => 'required|string|size:19',
                'expiry' => 'required|string|size:5',
                'cvv' => 'required|string|size:3'
            ]);

            DB::beginTransaction();

            // Get or create address
            if ($request->address_id) {
                $address = Address::findOrFail($request->address_id);
            } else {
                $address = Address::create([
                    'user_id' => auth()->id(),
                    'details' => json_encode([
                        'first_name' => $request->first_name,
                        'last_name' => $request->last_name,
                        'address' => $request->address,
                        'city' => $request->city,
                        'state' => $request->state,
                        'zip_code' => $request->zip_code
                    ])
                ]);
            }

            // Create order
            $order = Order::create([
                'user_id' => auth()->id(),
                'address_id' => $address->id,
                'status' => 'pending'
            ]);

            // Get cart items
            $cart = $this->cartService->getCart();
            $total = 0;

            foreach ($cart->cartProducts as $item) {
                OrderProduct::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'qty' => $item->qty,
                    'price' => $item->product->price
                ]);
                $total += $item->product->price * $item->qty;
            }

            // Clear the cart after successful order
            $this->cartService->clearCart();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully',
                'redirect_url' => route('orders.index'),
                'notification' => [
                    'type' => 'success',
                    'message' => 'Your order has been placed successfully!'
                ]
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error processing order: ' . $e->getMessage()
            ], 500);
        }
    }
}
