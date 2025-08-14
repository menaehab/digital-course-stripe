<?php

namespace App\Livewire;

use App\Models\Cart;
use App\Models\Order;
use Livewire\Component;

class SuccessPage extends Component
{
    public $session_id;
    public $cart;
    public function mount()
    {
        $this->session_id = request()->query('session_id');

        if (!$this->session_id) {
            abort(404, 'Missing session id.');
        }

        $session = request()->user()->stripe()->checkout->sessions->retrieve($this->session_id);

        $this->cart = Cart::find($session->metadata->cart_id);

        $order = Order::create([
            'user_id' => auth()->id(),
        ]);

        $order->courses()->attach($this->cart->courses->pluck('id')->toArray());

        $this->cart->delete();
    }
    public function render()
    {
        return view('livewire.success-page');
    }
}
