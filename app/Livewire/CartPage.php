<?php

namespace App\Livewire;

use App\Models\Cart;
use Livewire\Component;

class CartPage extends Component
{
    public $cart;
    protected $listeners = ['refreshCart' => 'loadCart'];
    public function mount()
    {
        $this->loadCart();
    }

    public function loadCart()
    {
        // First try to find cart by user ID if user is logged in
        if (auth()->check()) {
            $this->cart = Cart::where('user_id', auth()->id())->first();
        }
        
        // If no cart found by user ID, try by session ID
        if (!isset($this->cart)) {
            $this->cart = Cart::where('session_id', session()->getId())->first();
        }

        // If still no cart exists, create a new one
        if (!isset($this->cart)) {
            $this->cart = Cart::create([
                'session_id' => session()->getId(),
                'user_id' => auth()->id()
            ]);
        } else if (auth()->check() && !$this->cart->user_id) {
            // If user is logged in but cart doesn't have user_id, update it
            $this->cart->update(['user_id' => auth()->id()]);
        }
    }

    public function removeFromCart($id)
    {
        $this->cart->courses()->detach($id);
        $this->dispatch('refreshCart');
    }

    public function render()
    {
        return view('livewire.cart-page');
    }
}