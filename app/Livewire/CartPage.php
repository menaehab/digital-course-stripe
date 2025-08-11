<?php

namespace App\Livewire;

use App\Models\Cart;
use Livewire\Component;

class CartPage extends Component
{
    public $cart;
    public function mount()
    {
        $this->cart = Cart::where('session_id', session()->getId())->first();
    }

    public function removeFromCart($id)
    {
        $this->cart->courses()->detach($id);
    }

    public function render()
    {
        return view('livewire.cart-page');
    }
}
