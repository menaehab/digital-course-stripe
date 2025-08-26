<?php

namespace App\Livewire;

use App\Models\Cart;
use Livewire\Component;

class SetupIntentPage extends Component
{
    public function render()
    {
        $setupIntent = auth()->user()->createSetupIntent();


        return view('livewire.setup-intent-page', compact('setupIntent'));
    }
}
