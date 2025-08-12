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

        $sessionOption = [
            'success_url' => route('home', ['message' => 'Course purchased successfully!']),
            'cancel_url' => route('cart', ['message' => 'Course purchase cancelled!']),
            'billing_address_collection' => 'required',
            "phone_number_collection" => [
                "enabled" => true,
            ],
            "payment_method_types" => [
                "card"
            ],
        ];

        return auth()->user()->checkout($prices, $sessionOption);
    }
}
