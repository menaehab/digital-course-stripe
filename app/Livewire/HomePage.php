<?php

namespace App\Livewire;

use App\Models\Cart;
use App\Models\Course;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class HomePage extends Component
{
    public $cart;

    public function mount()
    {
        $this->initializeCart();
    }

    protected function initializeCart()
    {
        if (Auth::check()) {
            $this->cart = Cart::where('user_id', Auth::id())->first();
        }

        if (!isset($this->cart)) {
            $this->cart = Cart::where('session_id', session()->getId())->first();
        }

        if (!isset($this->cart)) {
            $this->cart = Cart::create([
                'session_id' => session()->getId(),
                'user_id' => Auth::id() ?? null,
            ]);
        } else if (Auth::check() && !$this->cart->user_id) {
            $this->cart->update(['user_id' => Auth::id()]);
        }
    }
    public function addToCart($id)
    {
        $course = Course::findOrFail($id);
        if (!$this->cart) {
            $this->initializeCart();
        }
        $this->cart->courses()->syncWithoutDetaching($course->id);
        $this->cart->load('courses');
    }
    public function removeFromCart($id)
    {
        if ($this->cart) {
            $this->cart->courses()->detach($id);
            $this->cart->load('courses');
        }
    }
    public function render()
    {
        $courses = Course::all();
        return view('livewire.home-page', compact('courses'));
    }
}
