<?php

namespace App\Livewire;

use Livewire\Component;

class CancelPage extends Component
{
    public $session_id;
    public function mount($session_id = null)
    {
        $this->session_id = $session_id;
    }
    public function render()
    {
        return view('livewire.cancel-page');
    }
}
