<?php

namespace App\Livewire;

use App\Models\Cart;
use App\Models\Course;
use Livewire\Component;

class HomePage extends Component
{
    public $cart;
    public function mount()
    {
        $this->cart = Cart::session()->first();
    }
    public function addToCart($id)
    {
        $course = Course::findOrFail($id);
        $cart = Cart::firstOrCreate([
            'session_id' => session()->getId(),
        ]);

        $cart->courses()->syncWithoutDetaching($course->id);
    }
    public function removeFromCart($id)
    {
        $this->cart->courses()->detach($id);
    }
    public function render()
    {
        $courses = Course::all();
        return view('livewire.home-page', compact('courses'));
    }
}