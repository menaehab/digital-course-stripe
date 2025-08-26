<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;

class PaymentIntentController extends Controller
{
    public function store(Request $request)
    {
        $paymentIntentId = $request->input("payment_intent_id");

        $payment = auth()->user()->findPayment($paymentIntentId);

        if ($payment->status == "succeeded") {

            $cart = Cart::where('user_id', auth()->id())->first();

            $order = Order::create([
                'user_id' => auth()->id(),
            ]);

            $order->courses()->attach($cart->courses->pluck('id')->toArray());

            $cart->delete();

        }

        return to_route('home');
    }
}
