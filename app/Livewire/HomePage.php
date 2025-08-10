<?php

namespace App\Livewire;

use App\Models\Course;
use Livewire\Component;

class HomePage extends Component
{
    public function render()
    {
        $courses = Course::all();
        return view('livewire.home-page', compact('courses'));
    }
}
