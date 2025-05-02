<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Address;
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

            return view('checkout', compact('cart', 'total'));
        } catch (\Exception $e) {
            Log::error('Checkout index error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error loading checkout page. Please try again.');
        }
    }

    public function store(Request $request)
    {
        try {
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

            if (auth()->check()) {
                foreach ($cart->cartProducts as $item) {
                    OrderProduct::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'qty' => $item->qty,
                        'price' => $item->product->price
                    ]);
                    $total += $item->product->price * $item->qty;
                }
            } else {
                foreach ($cart as $item) {
                    OrderProduct::create([
                        'order_id' => $order->id,
                        'product_id' => $item['product']->id,
                        'qty' => $item['quantity'],
                        'price' => $item['product']->price
                    ]);
                    $total += $item['product']->price * $item['quantity'];
                }
            }

            // Clear the cart after successful order
            $this->cartService->clearCart();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully',
                'redirect_url' => route('orders.index')
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
