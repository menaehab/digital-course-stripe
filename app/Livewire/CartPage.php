<?php

namespace App\Livewire;

use Livewire\Component;

class CartPage extends Component
{
    public $courses;
    public function mount()
    {
        $this->courses = session()->get('cart', []);
    }
    public function render()
    {
        return view('livewire.cart-page');
    }
}
