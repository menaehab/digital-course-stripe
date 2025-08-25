<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentMethodCheckoutController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'payment_method' => 'required',
        ]);

        $user = auth()->user();

        if (!$user->hasStripeId()) {
            $user->createAsStripeCustomer();
        }

        if ($request->payment_method) {
            auth()->user()->addPaymentMethod($request->payment_method);
        }

        $cart = Cart::where('user_id', Auth::id())->first();

        $amount = $cart->courses->sum('price');

        try {
            auth()->user()->charge($amount, $request->payment_method, [
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

        return to_route('home');
    }
}
