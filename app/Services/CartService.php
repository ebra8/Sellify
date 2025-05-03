<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartService
{
    private const GUEST_CART_KEY = 'guest_cart';

    public function getCart()
    {
        if (Auth::check()) {
            return $this->getUserCart();
        }
        return $this->getGuestCartWithProducts();
    }

    public function addToCart(Product $product, int $quantity = 1)
    {
        if (Auth::check()) {
            return $this->addToUserCart($product, $quantity);
        }
        return $this->addToGuestCart($product, $quantity);
    }

    public function updateCartItem(Product $product, int $quantity)
    {
        if (Auth::check()) {
            return $this->updateUserCartItem($product, $quantity);
        }
        return $this->updateGuestCartItem($product, $quantity);
    }

    public function removeFromCart(Product $product)
    {
        if (Auth::check()) {
            return $this->removeFromUserCart($product);
        }
        return $this->removeFromGuestCart($product);
    }

    public function clearCart()
    {
        if (Auth::check()) {
            return $this->clearUserCart();
        }
        return $this->clearGuestCart();
    }

    public function migrateGuestCartToUserCart()
    {
        if (!Auth::check()) {
            return false;
        }

        $guestCart = $this->getGuestCart();
        if (empty($guestCart)) {
            return false;
        }

        foreach ($guestCart as $productId => $item) {
            $product = Product::find($productId);
            if ($product) {
                $this->addToUserCart($product, $item['quantity']);
            }
        }

        $this->clearGuestCart();
        return true;
    }

    private function getUserCart()
    {
        $user = Auth::user();
        $cart = $user->cart()->firstOrCreate();
        return $cart->load('cartProducts.product');
    }

    private function getGuestCart()
    {
        return Session::get(self::GUEST_CART_KEY, []);
    }

    private function getGuestCartWithProducts()
    {
        $cart = $this->getGuestCart();
        $cartWithProducts = [];

        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);
            if ($product) {
                $cartWithProducts[$productId] = [
                    'product' => $product,
                    'quantity' => $item['quantity']
                ];
            }
        }

        return $cartWithProducts;
    }

    private function addToUserCart(Product $product, int $quantity)
    {
        $cart = Auth::user()->cart()->firstOrCreate();
        
        $cartProduct = $cart->cartProducts()->where('product_id', $product->id)->first();
        
        if ($cartProduct) {
            $cartProduct->qty += $quantity;
            $cartProduct->save();
        } else {
            $cart->cartProducts()->create([
                'product_id' => $product->id,
                'qty' => $quantity
            ]);
        }
        
        return $cart->load('cartProducts.product');
    }

    private function addToGuestCart(Product $product, int $quantity)
    {
        $cart = $this->getGuestCart();
        
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            $cart[$product->id] = [
                'product_id' => $product->id,
                'quantity' => $quantity
            ];
        }
        
        Session::put(self::GUEST_CART_KEY, $cart);
        return $this->getGuestCartWithProducts();
    }

    private function updateUserCartItem(Product $product, int $quantity)
    {
        $cart = Auth::user()->cart()->first();
        
        if ($cart) {
            $cartProduct = $cart->cartProducts()->where('product_id', $product->id)->first();
            
            if ($cartProduct) {
                if ($quantity > 0) {
                    $cartProduct->qty = $quantity;
                    $cartProduct->save();
                } else {
                    $cartProduct->delete();
                }
            }
        }
        
        return $cart->load('cartProducts.product');
    }

    private function updateGuestCartItem(Product $product, int $quantity)
    {
        $cart = $this->getGuestCart();
        
        if (isset($cart[$product->id])) {
            if ($quantity > 0) {
                $cart[$product->id]['quantity'] = $quantity;
            } else {
                unset($cart[$product->id]);
            }
        }
        
        Session::put(self::GUEST_CART_KEY, $cart);
        return $this->getGuestCartWithProducts();
    }

    private function removeFromUserCart(Product $product)
    {
        $cart = Auth::user()->cart()->first();
        
        if ($cart) {
            $cart->cartProducts()->where('product_id', $product->id)->delete();
        }
        
        return $cart->load('cartProducts.product');
    }

    private function removeFromGuestCart(Product $product)
    {
        $cart = $this->getGuestCart();
        
        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
        }
        
        Session::put(self::GUEST_CART_KEY, $cart);
        return $this->getGuestCartWithProducts();
    }

    private function clearUserCart()
    {
        $cart = Auth::user()->cart()->first();
        
        if ($cart) {
            $cart->cartProducts()->delete();
        }
        
        return $cart->load('cartProducts.product');
    }

    private function clearGuestCart()
    {
        Session::forget(self::GUEST_CART_KEY);
        return [];
    }
} 