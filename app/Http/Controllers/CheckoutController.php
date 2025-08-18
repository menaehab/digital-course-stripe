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
            'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.cancel') . '?session_id={CHECKOUT_SESSION_ID}',
            // 'billing_address_collection' => 'required',
            // "phone_number_collection" => [
            //     "enabled" => true,
            // ],
            "payment_method_types" => [
                "card"
            ],
            "metadata" => [
                "cart_id" => $cart->id
            ],
        ];

        $customerOption = [
            "name" => auth()->user()->name,
            "email" => auth()->user()->email,
            "code" => 123456,
        ];

        return auth()
            ->user()
            ->checkout($prices, $sessionOption, $customerOption);
    }

    public function enableCoupon()
    {
        $cart = Cart::where('user_id', Auth::id())->first();

        $prices = $cart->courses->pluck('stripe_price_id')->toArray();

        $sessionOption = [
            'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.cancel') . '?session_id={CHECKOUT_SESSION_ID}',
            // "allow_promotion_codes" => true,
            "payment_method_types" => [
                "card"
            ],
            "metadata" => [
                "cart_id" => $cart->id
            ],
        ];


        return auth()
            ->user()
            ->withPromotionCode("promo_1RxPhnJ4WnQ1QxbC18QLWnWz")
            ->checkout($prices, $sessionOption);
    }
}
