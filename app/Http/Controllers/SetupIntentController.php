<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;

class SetupIntentController extends Controller
{
    public function store(Request $request)
    {
        $cart = Cart::where('user_id', auth()->id())->first();

        $amount = $cart->courses->sum('price');

        try {
            auth()->user()->charge($amount, auth()->user()->defaultPaymentMethod()->id, [
                'return_url' => route('checkout.success'),
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        $order = Order::create([
            'user_id' => auth()->id(),
        ]);

        $order->courses()->attach($cart->courses->pluck('id')->toArray());

        $cart->delete();

        return to_route('home')->with('success','Payment successful');
    }
}
