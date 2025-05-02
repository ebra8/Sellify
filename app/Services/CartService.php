<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartService
{
    public function getCart()
    {
        if (Auth::check()) {
            return $this->getUserCart();
        }
        return $this->getGuestCart();
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

    private function getUserCart()
    {
        $user = Auth::user();
        $cart = $user->cart()->firstOrCreate();
        return $cart->load('cartProducts.product');
    }

    private function getGuestCart()
    {
        return Session::get('cart', []);
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
        $cart = Session::get('cart', []);
        
        if (isset($cart[$product->id])) {
            $cart[$product->id]['qty'] += $quantity;
        } else {
            $cart[$product->id] = [
                'product' => $product,
                'qty' => $quantity
            ];
        }
        
        Session::put('cart', $cart);
        return $cart;
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
        $cart = Session::get('cart', []);
        
        if (isset($cart[$product->id])) {
            if ($quantity > 0) {
                $cart[$product->id]['qty'] = $quantity;
            } else {
                unset($cart[$product->id]);
            }
        }
        
        Session::put('cart', $cart);
        return $cart;
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
        $cart = Session::get('cart', []);
        
        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
        }
        
        Session::put('cart', $cart);
        return $cart;
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
        Session::forget('cart');
        return [];
    }
} 