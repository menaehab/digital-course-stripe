<?php

namespace App\Livewire;

use App\Models\Cart;
use Livewire\Component;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class PaymentIntentPage extends Component
{

    public function render()
    {
        $amount = Cart::where('user_id', auth()->id())
            ->first()
            ->courses
            ->sum('price');


        $payment = auth()->user()->pay($amount);

        return view('livewire.payment-intent-page', compact('payment'));
    }
}
