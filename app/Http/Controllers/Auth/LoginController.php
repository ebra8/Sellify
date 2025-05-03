<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Services\CartService;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    protected $cartService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CartService $cartService)
    {
        $this->middleware('guest')->except('logout');
        $this->cartService = $cartService;
    }

    protected function authenticated(Request $request, $user)
    {
        // Migrate guest cart to user cart
        $this->cartService->migrateGuestCartToUserCart();

        // Handle redirect
        if ($request->session()->has('intended_url')) {
            $redirectTo = $request->session()->get('intended_url');
            $request->session()->forget('intended_url');
            return redirect($redirectTo);
        }

        // If there's a guest cart, redirect to cart/checkout
        if (session()->has('guest_cart') && !empty(session('guest_cart'))) {
            return redirect()->route('cart.index');
        }

        return redirect()->intended($this->redirectPath());
    }
}
