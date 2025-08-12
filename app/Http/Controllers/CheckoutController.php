<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function checkout()
    {
        $cart = Cart::where('user_id', Auth::id())->first();

        $prices = $cart->courses->pluck('stripe_price_id')->toArray();

        return auth()->user()->checkout($prices);
    }
}
